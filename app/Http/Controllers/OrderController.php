<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CalcRevenues;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function trackForm()
    {
        return view('front.orders.track');
    }

    public function trackLookup(Request $request)
    {
        $data = $request->validate([
            'order_number' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:255'],
        ]);

        $order = Order::with(['items.product', 'address'])
            ->where('order_number', trim($data['order_number']))
            ->first();

        if (! $order || ! $this->matchesTrackingContact($order, $data['contact'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'order_number' => 'We could not find an order matching those tracking details.',
                ]);
        }

        return view('front.orders.track', [
            'order' => $order,
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $orders = Order::with('user')->latest();

        if ($search) {
            $orders->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($statusFilter) {
            $orders->where('status', $statusFilter);
        }

        $orders = $orders->paginate(10)->withQueryString();

        return view('admin-dashboard.orders.index', get_defined_vars());
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'address']);
        return view('admin-dashboard.orders.show', get_defined_vars());
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    protected function matchesTrackingContact(Order $order, string $contact): bool
    {
        $normalizedInput = $this->normalizeTrackingValue($contact);
        $normalizedEmail = $this->normalizeTrackingValue((string) $order->email);
        $normalizedPhone = $this->normalizePhone((string) optional($order->address)->phone);

        return $normalizedInput !== '' && (
            $normalizedInput === $normalizedEmail ||
            $normalizedInput === $normalizedPhone
        );
    }

    protected function normalizeTrackingValue(string $value): string
    {
        $trimmed = trim(mb_strtolower($value));

        if (filter_var($trimmed, FILTER_VALIDATE_EMAIL)) {
            return $trimmed;
        }

        return $this->normalizePhone($trimmed);
    }

    protected function normalizePhone(string $value): string
    {
        return preg_replace('/\D+/', '', $value) ?? '';
    }
}

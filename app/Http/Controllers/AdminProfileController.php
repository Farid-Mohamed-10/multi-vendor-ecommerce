<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
  public function edit()
  {
    $user = Auth::user();
    return view('admin-dashboard.profile.edit', compact('user'));
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $data = $request->validate([
      'name'  => 'required|string|max:255',
      'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
      'phone' => 'nullable|string|max:20',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('avatar')) {
      if ($user->profile_photo_path) {
        Storage::disk('public')->delete($user->profile_photo_path);
      }
      $data['profile_photo_path'] = $request->file('avatar')->store('avatars', 'public');
    }
    unset($data['avatar']);

    $user->update($data);

    return redirect()->back()->with('success', 'Profile updated successfully.');
  }
}

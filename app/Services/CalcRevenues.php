<?php

namespace App\Services;

class CalcRevenues
{
  protected $taxes = 0.14;
  protected $shipping = 0.1;

  public function getTaxAmount(float $subtotal): float
  {
    return $subtotal * $this->taxes;
  }

  public function getShippingAmount(float $subtotal): float
  {
    return $subtotal * $this->shipping;
  }

  public function getTotalAmount(float $subtotal): float
  {
    return $subtotal + $this->getTaxAmount($subtotal) + $this->getShippingAmount($subtotal);
  }

  public function adminRevenue(float $subtotal): float
  {
    return $this->getTaxAmount($subtotal) + $this->getShippingAmount($subtotal);
  }
}
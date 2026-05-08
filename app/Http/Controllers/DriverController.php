<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;

class DriverController extends Controller
{
    public function dashboard()
    {
        $totalToday = DeliveryOrder::whereDate('created_at', now())->count();

        return view('driver.dashboard', compact('totalToday'));
    }
}
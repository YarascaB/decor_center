<?php

namespace App\Http\Controllers;
use App\Models\InventoryLog;

use Illuminate\Http\Request;

class InventoryLogController extends Controller
{
    public function index()
    {
        $logs = InventoryLog::with('product', 'user')->latest()->paginate(10);
        return view('inventory.logs', compact('logs'));
    }
}


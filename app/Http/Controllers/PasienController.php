<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PasienController extends Controller
{
    public function index()
{
    $user = auth()->user();

    return view('pasien.dashboard', [
        'myOrdersCount'    => $user->orders()->count(),
        'latestOrder'      => $user->orders()->latest()->first(),
        'myLatestOrders'   => $user->orders()->latest()->take(5)->get(),
    ]);
}
}

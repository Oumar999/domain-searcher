<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Winkelwagen is leeg.');
        }

        $subtotal = array_sum(array_column($cart, 'price'));
        $vat = round($subtotal * 0.21, 2);
        $total = $subtotal + $vat;

        return view('domains.checkout', compact('cart', 'subtotal', 'vat', 'total'));
    }

public function store(Request $request)
{
    $cart = Session::get('cart', []);

    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Winkelwagen is leeg.');
    }

    $subtotal = array_sum(array_column($cart, 'price'));
    $vat = round($subtotal * 0.21, 2);
    $total = $subtotal + $vat;

    try {
        DB::beginTransaction();

        // Zorg ervoor dat we alleen de benodigde gegevens opslaan
        $domains = array_map(function($item) {
            return [
                'domain' => $item['domain'],
                'price' => $item['price']
            ];
        }, $cart);

        Order::create([
            'domains' => $domains, // Laravel zal dit automatisch omzetten naar JSON door de $casts
            'subtotal' => $subtotal,
            'vat' => $vat,
            'total' => $total,
        ]);

        DB::commit();

        Session::forget('cart');

        return redirect()->route('orders.index')->with('success', 'Bestelling geplaatst!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Fout bij het plaatsen van de bestelling: ' . $e->getMessage());
    }
}

public function index()
{
    $orders = Order::latest()->paginate(10); // Toon 10 bestellingen per pagina
    return view('orders.index', compact('orders'));
}
}
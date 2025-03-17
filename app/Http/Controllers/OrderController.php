<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Controleer of de winkelwagen leeg is
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Je winkelwagen is leeg!');
        }

        // Maak een nieuwe bestelling aan
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'verzonden', // Of naar 'in afwachting' als je dat wilt
            'completed_at' => now(),
        ]);

        // Voeg de producten uit de winkelwagen toe als order lines
        foreach ($cart as $productId => $item) {
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
            ]);
        }

        // Leeg de winkelwagen na bestelling
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)->with('success', 'Bestelling succesvol geplaatst!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('orderLines.product')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

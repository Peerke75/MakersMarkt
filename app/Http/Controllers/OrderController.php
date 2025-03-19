<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Bestellingen die de gebruiker heeft geplaatst
        $ordersAsBuyer = Order::where('user_id', $user->id)->get();

        // Bestellingen waarbij de gebruiker de maker is van een product
        $ordersAsMaker = Order::whereHas('orderLines.product', function ($query) use ($user) {
            $query->where('maker_id', $user->id); // Alleen bestellingen van producten die de maker heeft
        })->get();

        return view('orders.index', compact('ordersAsBuyer', 'ordersAsMaker'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Dit kan gebruikt worden om een formulier te tonen voor het maken van een bestelling
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check of de winkelwagen leeg is
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Je winkelwagen is leeg!');
        }

        // Maak de bestelling aan
        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'geplaatst', // default status
            'completed_at' => now(),
        ]);

        // Voeg orderregels toe voor elk product in de winkelwagen
        foreach ($cart as $productId => $item) {
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
            ]);
        }

        // Stuur een notificatie naar de maker van de bestelling indien van toepassing
        if ($order->maker) {
            $order->maker->notify(new OrderPlacedNotification($order));
        }

        // Leeg de winkelwagen
        session()->forget('cart');

        return redirect()->route('orders.show', $order->id)->with('success', 'Bestelling succesvol geplaatst!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Haal de orderdetails op inclusief de producten en hun hoeveelheden
        $order = Order::with('orderLines.product')->findOrFail($order->id);
        return view('orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $user = auth()->user();

        // Controleer of de gebruiker de maker is van een product in de bestelling
        $canUpdate = $order->orderLines->some(function ($line) use ($user) {
            return $line->product->maker_id == $user->id; // Maker moet de bestelling kunnen bewerken
        });

        if (!$canUpdate) {
            return redirect()->route('orders.index')->with('error', 'Je hebt geen toegang om deze bestelling te bewerken.');
        }

        // Als de gebruiker de maker is, pas de status aan
        $order->update([
            'status' => $request->status,
            'status_description' => $request->status_description,
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Bestellingsstatus bijgewerkt!');
    }
}
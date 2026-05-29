<?php

namespace App\Http\Controllers\Repartidor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()
            ->deliveryOrders()
            ->with(['user', 'items.product.commerce'])
            ->latest()
            ->paginate(10);

        return view('repartidor.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorizeDeliveryOrder($order);

        $order->load(['user', 'items.product.commerce']);

        return view('repartidor.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeDeliveryOrder($order);

        $validated = $request->validate([
            'delivery_status' => ['required', 'in:asignado,recogido,en_camino,entregado'],
        ]);

        $order->update([
            'delivery_status' => $validated['delivery_status'],
            'status' => $validated['delivery_status'] === 'entregado' ? 'entregado' : $order->status,
        ]);

        return redirect()
            ->route('repartidor.orders.show', $order)
            ->with('success', 'Estado de entrega actualizado.');
    }

    private function authorizeDeliveryOrder(Order $order): void
    {
        if ($order->repartidor_id !== auth()->id()) {
            abort(403, 'Este pedido no esta asignado a tu usuario.');
        }
    }
}

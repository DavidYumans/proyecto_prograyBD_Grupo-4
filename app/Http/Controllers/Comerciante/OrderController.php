<?php

namespace App\Http\Controllers\Comerciante;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce) {
            return redirect()
                ->route('comerciante.commerce.create')
                ->with('error', 'Primero debes crear tu comercio.');
        }

        $orders = Order::whereHas('items', function ($query) use ($commerce) {
            $query->where('commerce_id', $commerce->id);
        })
            ->with([
                'user',
                'deliveryUser',
                'items' => function ($query) use ($commerce) {
                    $query->where('commerce_id', $commerce->id)
                        ->with(['product', 'commerce']);
                },
            ])
            ->latest()
            ->paginate(10);

        return view('comerciante.orders.index', compact('commerce', 'orders'));
    }

    public function show(Order $order)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce) {
            return redirect()
                ->route('comerciante.commerce.create')
                ->with('error', 'Primero debes crear tu comercio.');
        }

        $belongsToCommerce = $order->items()
            ->where('commerce_id', $commerce->id)
            ->exists();

        if (!$belongsToCommerce) {
            abort(403, 'No tienes permiso para ver este pedido.');
        }

        $order->load([
            'user',
            'deliveryUser',
            'items' => function ($query) use ($commerce) {
                $query->where('commerce_id', $commerce->id)
                    ->with(['product', 'commerce']);
            },
        ]);

        $activeRepartidores = User::where('role', 'repartidor')
            ->where('status', 'activo')
            ->orderBy('name')
            ->get();

        return view('comerciante.orders.show', compact('commerce', 'order', 'activeRepartidores'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce) {
            return redirect()
                ->route('comerciante.commerce.create')
                ->with('error', 'Primero debes crear tu comercio.');
        }

        $belongsToCommerce = $order->items()
            ->where('commerce_id', $commerce->id)
            ->exists();

        if (!$belongsToCommerce) {
            abort(403, 'No tienes permiso para actualizar este pedido.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:pendiente,confirmado,en_preparacion,en_camino,entregado,cancelado'],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('comerciante.orders.show', $order)
            ->with('success', 'Estado del pedido actualizado correctamente.');
    }

    public function assignDelivery(Request $request, Order $order)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce) {
            return redirect()
                ->route('comerciante.commerce.create')
                ->with('error', 'Primero debes crear tu comercio.');
        }

        $belongsToCommerce = $order->items()
            ->where('commerce_id', $commerce->id)
            ->exists();

        if (!$belongsToCommerce) {
            abort(403, 'No tienes permiso para asignar repartidor a este pedido.');
        }

        $validated = $request->validate([
            'repartidor_id' => ['nullable', 'exists:users,id'],
        ]);

        $repartidorId = $validated['repartidor_id'] ?? null;

        if ($repartidorId) {
            $repartidor = User::where('role', 'repartidor')
                ->where('status', 'activo')
                ->findOrFail($repartidorId);

            $order->update([
                'repartidor_id' => $repartidor->id,
                'delivery_status' => $order->delivery_status === 'sin_asignar' ? 'asignado' : $order->delivery_status,
            ]);
        } else {
            $order->update([
                'repartidor_id' => null,
                'delivery_status' => 'sin_asignar',
            ]);
        }

        return redirect()
            ->route('comerciante.orders.show', $order)
            ->with('success', 'Repartidor asignado correctamente.');
    }
}

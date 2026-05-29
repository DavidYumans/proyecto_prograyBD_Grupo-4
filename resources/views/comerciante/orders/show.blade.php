<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido recibido #{{ $order->id }} - LocalMarket 24hrs</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Pedido recibido #{{ $order->id }}
            </h1>

            <p class="text-sm text-gray-500">
                Productos vendidos por {{ $commerce->name }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('comerciante.orders.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Pedidos recibidos
            </a>

            <a href="{{ route('comerciante.dashboard') }}"
               class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-slate-800">
                Dashboard
            </a>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-8">

    @if (session('success'))
        <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <section class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Comprador</p>
            <h2 class="text-lg font-bold text-slate-900 mt-2">
                {{ $order->user->name ?? 'Sin comprador' }}
            </h2>
            <p class="text-xs text-gray-500">
                {{ $order->user->email ?? 'Sin correo' }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Estado actual</p>
            <h2 class="text-lg font-bold text-slate-900 mt-2">
                {{ $order->statusLabel() }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Fecha</p>
            <h2 class="text-lg font-bold text-slate-900 mt-2">
                {{ $order->created_at->format('d/m/Y H:i') }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Total de tu comercio</p>
            <h2 class="text-lg font-bold text-slate-900 mt-2">
                Q{{ number_format($order->items->sum('subtotal'), 2) }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Entrega</p>
            <h2 class="text-lg font-bold text-slate-900 mt-2">
                {{ $order->deliveryStatusLabel() }}
            </h2>
            <p class="text-xs text-gray-500">
                {{ $order->deliveryUser->name ?? 'Sin repartidor asignado' }}
            </p>
        </div>
    </section>

    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-bold text-slate-900 mb-4">
            Cambiar estado del pedido
        </h2>

        <form method="POST"
              action="{{ route('comerciante.orders.update-status', $order) }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            @method('PATCH')

            <div class="md:col-span-2">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Estado
                </label>

                <select id="status"
                        name="status"
                        class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">
                    <option value="pendiente" {{ $order->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="confirmado" {{ $order->status === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                    <option value="en_preparacion" {{ $order->status === 'en_preparacion' ? 'selected' : '' }}>En preparación</option>
                    <option value="en_camino" {{ $order->status === 'en_camino' ? 'selected' : '' }}>En camino</option>
                    <option value="entregado" {{ $order->status === 'entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="cancelado" {{ $order->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>

                @error('status')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800">
                    Actualizar estado
                </button>
            </div>
        </form>
    </section>

    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
        <h2 class="text-lg font-bold text-slate-900 mb-4">
            Servicio a domicilio
        </h2>

        <form method="POST"
              action="{{ route('comerciante.orders.assign-delivery', $order) }}"
              class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @csrf
            @method('PATCH')

            <div class="md:col-span-2">
                <label for="repartidor_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Repartidor asignado
                </label>

                <select id="repartidor_id"
                        name="repartidor_id"
                        class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">
                    <option value="">Sin repartidor</option>
                    @foreach ($activeRepartidores as $repartidor)
                        <option value="{{ $repartidor->id }}" {{ $order->repartidor_id === $repartidor->id ? 'selected' : '' }}>
                            {{ $repartidor->name }}
                        </option>
                    @endforeach
                </select>

                @error('repartidor_id')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="w-full px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800">
                    Guardar repartidor
                </button>
            </div>
        </form>
    </section>

    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-bold text-slate-900">
                Productos vendidos de tu comercio
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600 border-b">
                <tr>
                    <th class="px-6 py-3">Producto</th>
                    <th class="px-6 py-3">Cantidad</th>
                    <th class="px-6 py-3">Precio unitario</th>
                    <th class="px-6 py-3">Subtotal</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                @foreach ($order->items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">
                                {{ $item->product->name ?? 'Producto eliminado' }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ $item->product->description ?? 'Sin descripción' }}
                            </p>
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $item->quantity }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            Q{{ number_format($item->unit_price, 2) }}
                        </td>

                        <td class="px-6 py-4 font-bold text-gray-800">
                            Q{{ number_format($item->subtotal, 2) }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

</main>

</body>
</html>

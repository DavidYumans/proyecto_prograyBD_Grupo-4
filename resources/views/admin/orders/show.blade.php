@extends('admin.layouts.app')

@section('title', 'Pedido #' . $order->id)

@section('content')
<div class="space-y-6" x-data="{ dispatchModal: false }">

@php
    $scMap = [
        'pendiente'      => ['label' => 'Pendiente',      'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200',  'dot' => 'bg-yellow-400'],
        'confirmado'     => ['label' => 'Confirmado',     'class' => 'bg-blue-50 text-blue-700 border-blue-200',        'dot' => 'bg-blue-400'],
        'en_preparacion' => ['label' => 'En preparación', 'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200',  'dot' => 'bg-indigo-400'],
        'en_camino'      => ['label' => 'En camino',      'class' => 'bg-purple-50 text-purple-700 border-purple-200',  'dot' => 'bg-purple-400'],
        'entregado'      => ['label' => 'Entregado',      'class' => 'bg-green-50 text-green-700 border-green-200',     'dot' => 'bg-green-400'],
        'cancelado'      => ['label' => 'Cancelado',      'class' => 'bg-red-50 text-red-700 border-red-200',           'dot' => 'bg-red-400'],
    ];
    $sc = $scMap[$order->status] ?? ['label' => $order->statusLabel(), 'class' => 'bg-gray-50 text-gray-600 border-gray-200', 'dot' => 'bg-gray-400'];

    $nextStep = match($order->status) {
        'pendiente'      => ['status' => 'confirmado',     'label' => 'Confirmar pedido',     'color' => 'from-blue-500 to-blue-600',   'shadow' => 'shadow-blue-500/25'],
        'confirmado'     => ['status' => 'en_preparacion', 'label' => 'Iniciar preparación',  'color' => 'from-indigo-500 to-indigo-600','shadow' => 'shadow-indigo-500/25'],
        'en_preparacion' => ['status' => 'en_camino',      'label' => 'Enviar con repartidor','color' => 'from-purple-500 to-purple-600','shadow' => 'shadow-purple-500/25'],
        'en_camino'      => ['status' => 'entregado',      'label' => 'Marcar como entregado','color' => 'from-green-500 to-green-600', 'shadow' => 'shadow-green-500/25'],
        default          => null,
    };

    $grouped = $order->items->groupBy(fn($i) => $i->product?->commerce_id ?? 0);
@endphp

    {{-- HEADER --}}
    <div class="reveal relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 via-orange-600 to-amber-600 p-6 text-white">
        <div class="absolute -top-8 -right-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2 text-orange-200 text-xs font-medium mb-0.5">
                        <a href="{{ route('admin.orders.index') }}" class="hover:text-white transition-colors">Pedidos</a>
                        <span>/</span>
                        <span>#{{ $order->id }}</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black">Pedido #{{ $order->id }}</h1>
                    <p class="text-orange-100 text-sm mt-0.5">
                        {{ $order->created_at->format('d/m/Y') }} · {{ $order->created_at->format('H:i') }} ·
                        {{ $order->user->name ?? 'Sin comprador' }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold border bg-white/20 border-white/30 text-white">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    {{ $sc['label'] }}
                </span>
                <a href="{{ route('admin.orders.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold bg-white/20 hover:bg-white/30 transition-all">
                    ← Volver
                </a>
            </div>
        </div>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- COLUMNA IZQUIERDA: Items --}}
        <div class="lg:col-span-2 space-y-4">

            @foreach($grouped as $commerceId => $items)
                @php $commerce = $items->first()->product?->commerce; @endphp
                <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white font-black text-sm">
                            {{ strtoupper(substr($commerce->name ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">{{ $commerce->name ?? 'Comercio eliminado' }}</p>
                            @if($commerce?->category)
                                <p class="text-xs text-gray-400">{{ $commerce->category->name }}</p>
                            @endif
                        </div>
                        <span class="ml-auto text-xs font-semibold text-gray-500">
                            {{ $items->count() }} {{ $items->count() === 1 ? 'producto' : 'productos' }}
                        </span>
                    </div>

                    <div class="divide-y divide-gray-50">
                        @foreach($items as $item)
                            <div class="flex items-center gap-4 px-6 py-4">
                                {{-- Imagen --}}
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-100 flex items-center justify-center shrink-0">
                                    @if($item->product?->image_url)
                                        <img src="{{ $item->product->image_url }}"
                                             class="w-12 h-12 rounded-xl object-cover" alt="{{ $item->product->name }}">
                                    @else
                                        <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    @endif
                                </div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">
                                        {{ $item->product->name ?? 'Producto eliminado' }}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        {{ $item->quantity }} × Q{{ number_format($item->unit_price, 2) }}
                                    </p>
                                </div>
                                {{-- Subtotal --}}
                                <p class="font-black text-gray-900 shrink-0">Q{{ number_format($item->subtotal, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/30 flex justify-end">
                        <p class="text-sm font-bold text-gray-700">
                            Subtotal: <span class="text-gray-900">Q{{ number_format($items->sum('subtotal'), 2) }}</span>
                        </p>
                    </div>
                </div>
            @endforeach

            {{-- Info del comprador --}}
            <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Datos del comprador
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nombre</p>
                        <p class="font-semibold text-gray-900">{{ $order->user->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Correo</p>
                        <p class="font-semibold text-gray-900">{{ $order->user->email ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Fecha del pedido</p>
                        <p class="font-semibold text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">ID del pedido</p>
                        <p class="font-semibold text-gray-900">#{{ $order->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: Acciones --}}
        <div class="space-y-4">

            {{-- Resumen --}}
            <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Resumen del pedido</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Artículos</span>
                        <span class="font-semibold text-gray-900">{{ $order->items->sum('quantity') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Comercios</span>
                        <span class="font-semibold text-gray-900">{{ $grouped->count() }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-black text-xl text-orange-500">Q{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Estado actual + acciones rápidas --}}
            <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado actual</p>

                <span class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-sm font-bold border {{ $sc['class'] }}">
                    <span class="w-2 h-2 rounded-full {{ $sc['dot'] }} animate-pulse"></span>
                    {{ $sc['label'] }}
                </span>

                {{-- Progreso visual --}}
                @php
                    $steps = [
                        'pendiente'      => 'Pendiente',
                        'confirmado'     => 'Confirmado',
                        'en_preparacion' => 'En preparación',
                        'en_camino'      => 'En camino',
                        'entregado'      => 'Entregado',
                    ];
                    $stepKeys = array_keys($steps);
                    $currentIdx = array_search($order->status, $stepKeys);
                @endphp
                @if($order->status !== 'cancelado')
                    <div class="space-y-1.5">
                        @foreach($steps as $key => $label)
                            @php
                                $idx = array_search($key, $stepKeys);
                                $done = $currentIdx !== false && $idx <= $currentIdx;
                            @endphp
                            <div class="flex items-center gap-2.5">
                                <div class="w-5 h-5 rounded-full flex items-center justify-center shrink-0
                                    {{ $done ? 'bg-orange-500' : 'bg-gray-100 border border-gray-200' }}">
                                    @if($done)
                                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @endif
                                </div>
                                <span class="text-xs {{ $done ? 'font-semibold text-gray-800' : 'text-gray-400' }}">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Botón acción rápida al siguiente paso --}}
                @if($nextStep)
                    @if($nextStep['status'] === 'en_camino')
                        {{-- Abre el modal de asignación de repartidor --}}
                        <button type="button" @click="dispatchModal = true"
                                class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r {{ $nextStep['color'] }} shadow-lg {{ $nextStep['shadow'] }} hover:opacity-90 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                            {{ $nextStep['label'] }}
                        </button>
                    @else
                        <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="{{ $nextStep['status'] }}">
                            <button type="submit"
                                    class="w-full py-3 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r {{ $nextStep['color'] }} shadow-lg {{ $nextStep['shadow'] }} hover:opacity-90 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                {{ $nextStep['label'] }}
                            </button>
                        </form>
                    @endif
                @endif

                {{-- Cancelar (si aplica) --}}
                @if(!in_array($order->status, ['entregado', 'cancelado']))
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}"
                          x-data="{}"
                          @submit.prevent="if(confirm('¿Seguro que deseas cancelar este pedido?')) $el.submit()">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelado">
                        <button type="submit"
                                class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-red-600 border-2 border-red-100 hover:bg-red-50 transition-all">
                            Cancelar pedido
                        </button>
                    </form>
                @endif
            </div>

            {{-- Cambio de estado manual --}}
            <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Cambiar estado</p>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="status"
                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-200 text-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none transition-all bg-white">
                        <option value="pendiente"      {{ $order->status === 'pendiente'      ? 'selected' : '' }}>Pendiente</option>
                        <option value="confirmado"     {{ $order->status === 'confirmado'     ? 'selected' : '' }}>Confirmado</option>
                        <option value="en_preparacion" {{ $order->status === 'en_preparacion' ? 'selected' : '' }}>En preparación</option>
                        <option value="en_camino"      {{ $order->status === 'en_camino'      ? 'selected' : '' }}>En camino</option>
                        <option value="entregado"      {{ $order->status === 'entregado'      ? 'selected' : '' }}>Entregado</option>
                        <option value="cancelado"      {{ $order->status === 'cancelado'      ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    <button type="submit"
                            class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg shadow-orange-500/25 transition-all">
                        Aplicar estado
                    </button>
                </form>
            </div>

            {{-- Asignar repartidor --}}
            <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Repartidor asignado</p>

                @if($order->repartidor)
                    <div class="flex items-center gap-3 mb-3 p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                            {{ strtoupper(substr($order->repartidor->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $order->repartidor->name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->repartidor->email }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-400 mb-3">Sin repartidor asignado.</p>
                @endif

                <form method="POST" action="{{ route('admin.orders.assign-repartidor', $order) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <select name="repartidor_id"
                            class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-200 text-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none transition-all bg-white">
                        <option value="">— Sin repartidor —</option>
                        @forelse($repartidores as $rep)
                            <option value="{{ $rep->id }}" {{ $order->repartidor_id == $rep->id ? 'selected' : '' }}>
                                {{ $rep->name }}
                            </option>
                        @empty
                            <option disabled>No hay repartidores registrados</option>
                        @endforelse
                    </select>

                    @if($repartidores->isEmpty())
                        <p class="text-xs text-gray-400">
                            <a href="{{ route('admin.admin-users.create') }}" class="text-orange-500 hover:underline">
                                Crear un repartidor →
                            </a>
                        </p>
                    @endif

                    <button type="submit"
                            class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-lg shadow-emerald-500/25 transition-all">
                        Asignar repartidor
                    </button>
                </form>
            </div>

            {{-- Notas internas del admin --}}
            <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Notas internas</p>
                <form method="POST" action="{{ route('admin.orders.save-note', $order) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <textarea name="admin_notes" rows="3"
                              placeholder="Agregar notas internas sobre este pedido…"
                              class="w-full px-3 py-2.5 rounded-xl border-2 border-gray-200 text-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none transition-all resize-none">{{ $order->admin_notes }}</textarea>
                    <button type="submit"
                            class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all">
                        Guardar nota
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- ══════════════ MODAL: ENVIAR CON REPARTIDOR ══════════════ --}}
    <div x-show="dispatchModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/60 backdrop-blur-sm p-4"
         @click.self="dispatchModal = false"
         style="display: none;">

        <div x-show="dispatchModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-6 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-6 sm:translate-y-0 sm:scale-95"
             class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">

            {{-- Header del modal --}}
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-5 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-lg leading-tight">Enviar pedido #{{ $order->id }}</h3>
                            <p class="text-purple-200 text-xs mt-0.5">Asigna un repartidor para continuar</p>
                        </div>
                    </div>
                    <button @click="dispatchModal = false"
                            class="p-2 rounded-xl hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="p-6">
                @if($repartidores->isEmpty())
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-amber-50 border border-amber-200 mb-4">
                        <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-amber-800">No hay repartidores disponibles</p>
                            <p class="text-xs text-amber-600 mt-0.5">
                                Primero debes
                                <a href="{{ route('admin.admin-users.create') }}" class="font-bold underline">
                                    crear un repartidor
                                </a>
                                para poder enviar el pedido.
                            </p>
                        </div>
                    </div>
                    <button @click="dispatchModal = false"
                            class="w-full py-3 rounded-2xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all">
                        Cerrar
                    </button>
                @else
                    <form method="POST" action="{{ route('admin.orders.dispatch', $order) }}" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Seleccionar repartidor
                            </label>
                            <select name="repartidor_id" required
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 text-sm font-medium focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 focus:outline-none transition-all bg-white">
                                <option value="">— Elige un repartidor —</option>
                                @foreach($repartidores as $rep)
                                    <option value="{{ $rep->id }}" {{ $order->repartidor_id == $rep->id ? 'selected' : '' }}>
                                        {{ $rep->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if($order->repartidor)
                                <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Repartidor actual: <span class="font-semibold text-gray-600">{{ $order->repartidor->name }}</span>
                                </p>
                            @endif
                        </div>

                        {{-- Resumen del pedido en el modal --}}
                        <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 space-y-1.5 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Comprador</span>
                                <span class="font-semibold text-gray-800">{{ $order->user->name ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Artículos</span>
                                <span class="font-semibold text-gray-800">{{ $order->items->sum('quantity') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Total</span>
                                <span class="font-black text-orange-500">Q{{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="button" @click="dispatchModal = false"
                                    class="flex-1 py-3 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="flex-1 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 shadow-lg shadow-purple-500/25 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Confirmar envío
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

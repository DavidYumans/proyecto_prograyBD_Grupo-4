<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrito de compras — LocalMarket 24hrs</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

{{-- ══════════════ NAVBAR ══════════════ --}}
<nav x-data="{ scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 8 })"
     :class="scrolled ? 'shadow-lg shadow-gray-200/50' : ''"
     class="sticky top-0 z-50 glass border-b border-gray-100/80 transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <a href="{{ route('marketplace.home') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center shadow-md shadow-orange-500/30 group-hover:scale-105 transition-transform duration-200">
                    <span class="text-white font-black text-sm">L</span>
                </div>
                <span class="font-extrabold text-gray-900 text-lg leading-none">
                    Local<span class="text-orange-500">Market</span>
                    <span class="text-xs font-medium text-gray-400 ml-0.5">24hrs</span>
                </span>
            </a>

            {{-- Breadcrumb --}}
            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('marketplace.home') }}" class="hover:text-gray-600 transition-colors">Inicio</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-orange-500 font-semibold">Mi carrito</span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('marketplace.home') }}"
                   class="hidden sm:flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Seguir comprando
                </a>
                <a href="{{ route('marketplace.orders.index') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span class="hidden sm:inline">Mis pedidos</span>
                </a>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-gray-200 bg-white">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden sm:block max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════════ HERO HEADER ══════════════ --}}
<div class="relative overflow-hidden bg-gradient-to-br from-orange-50 via-amber-50/40 to-white border-b border-gray-100">
    <div class="absolute inset-0 opacity-[0.04]" style="background-image:radial-gradient(circle,#f97316 1.5px,transparent 1.5px);background-size:28px 28px"></div>
    <div class="absolute top-0 right-0 w-72 h-72 bg-orange-100/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4 animate-fade-in-up">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center shadow-xl shadow-orange-500/30 shrink-0">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                        Mi <span class="gradient-text">carrito</span>
                    </h1>
                    <p class="text-gray-500 mt-1">
                        @if($cart->items->count() > 0)
                            {{ $cart->items->sum('quantity') }} {{ $cart->items->sum('quantity') === 1 ? 'producto' : 'productos' }} · Total: <span class="font-bold text-gray-700">Q{{ number_format($cart->total(), 2) }}</span>
                        @else
                            Revisa y confirma tus productos antes de pedir.
                        @endif
                    </p>
                </div>
            </div>

            @if($cart->items->count() > 0)
                <div class="flex items-center gap-2 animate-fade-in">
                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-white border border-gray-200 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                        {{ $cart->items->groupBy('product.commerce_id')->count() }} {{ $cart->items->groupBy('product.commerce_id')->count() === 1 ? 'comercio' : 'comercios' }}
                    </div>
                    <div class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-orange-50 border border-orange-100 text-sm font-semibold text-orange-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        {{ $cart->items->count() }} {{ $cart->items->count() === 1 ? 'artículo' : 'artículos' }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ══════════════ MAIN ══════════════ --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Alertas --}}
    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 p-4 rounded-2xl bg-green-50 border border-green-200 animate-fade-in">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 flex items-center gap-3 p-4 rounded-2xl bg-red-50 border border-red-200 animate-fade-in">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    @if ($cart->items->count() > 0)

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- ── PRODUCTOS (2 cols) ────────────────────── --}}
            <div class="lg:col-span-2 space-y-4">

                {{-- Agrupar por comercio --}}
                @php $grouped = $cart->items->groupBy(fn($item) => $item->product->commerce_id); @endphp

                @foreach($grouped as $commerceId => $items)
                    @php $commerce = $items->first()->product->commerce; $stagger = $loop->index + 1; @endphp

                    <div class="reveal stagger-{{ min($stagger, 6) }} bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

                        {{-- Cabecera del comercio --}}
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3 bg-gray-50/50">
                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center text-white font-black text-sm shadow-md shadow-orange-500/20">
                                {{ strtoupper(substr($commerce->name ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <span class="text-sm font-bold text-gray-900">{{ $commerce->name ?? 'Comercio' }}</span>
                                <span class="ml-2 text-xs text-gray-400">· {{ $items->count() }} {{ $items->count() === 1 ? 'producto' : 'productos' }}</span>
                            </div>
                            @if($commerce->category)
                                <span class="ml-auto inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                    {{ $commerce->category->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Items del comercio --}}
                        <div class="divide-y divide-gray-50">
                            @foreach($items as $item)
                                <div class="p-5 sm:p-6 flex flex-col sm:flex-row gap-5 group hover:bg-gray-50/40 transition-colors duration-150">

                                    {{-- Imagen --}}
                                    <div class="shrink-0">
                                        @if($item->product->image_url)
                                            <img src="{{ $item->product->image_url }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-2xl border border-gray-100 shadow-sm group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-gradient-to-br from-orange-50 to-amber-50 border border-gray-100 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Info + controles --}}
                                    <div class="flex-1 flex flex-col sm:flex-row gap-4 min-w-0">

                                        {{-- Nombre y precio --}}
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-bold text-gray-900 text-base leading-snug">{{ $item->product->name }}</h3>
                                            <p class="text-sm text-gray-400 mt-0.5">{{ $item->product->commerce->name ?? 'Sin comercio' }}</p>

                                            {{-- Precio --}}
                                            <div class="flex items-center gap-2 mt-2">
                                                @if($item->product->discount_percentage > 0)
                                                    <span class="text-sm text-gray-400 line-through">Q{{ number_format($item->product->price, 2) }}</span>
                                                    <span class="font-bold text-green-600 text-base">Q{{ number_format($item->product->finalPrice(), 2) }}</span>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                        -{{ $item->product->discount_percentage }}%
                                                    </span>
                                                @else
                                                    <span class="font-bold text-gray-900 text-base">Q{{ number_format($item->product->price, 2) }}</span>
                                                @endif
                                            </div>

                                            {{-- Stock --}}
                                            <div class="flex items-center gap-1.5 mt-2">
                                                <div class="w-2 h-2 rounded-full {{ $item->product->stock > 5 ? 'bg-green-400' : ($item->product->stock > 0 ? 'bg-amber-400' : 'bg-red-400') }}"></div>
                                                <span class="text-xs text-gray-400">
                                                    {{ $item->product->stock > 5 ? 'En stock' : ($item->product->stock > 0 ? "Solo {$item->product->stock} disponibles" : 'Sin stock') }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Cantidad + subtotal + eliminar --}}
                                        <div class="flex sm:flex-col items-center sm:items-end justify-between gap-4 shrink-0">

                                            {{-- Subtotal --}}
                                            <div class="text-right order-2 sm:order-1">
                                                <p class="text-xs text-gray-400 mb-0.5">Subtotal</p>
                                                <p class="text-xl font-black text-gray-900">Q{{ number_format($item->subtotal(), 2) }}</p>
                                            </div>

                                            {{-- Controles de cantidad --}}
                                            <div class="order-1 sm:order-2">
                                                <form method="POST" action="{{ route('marketplace.cart.update', $item) }}"
                                                      class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="flex items-center rounded-xl border-2 border-gray-200 overflow-hidden bg-white hover:border-orange-300 transition-colors duration-150">
                                                        <button type="button"
                                                                onclick="let i=this.closest('form').querySelector('input[name=quantity]');if(+i.value>1){i.value=+i.value-1;this.closest('form').submit()}"
                                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-150">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                                        </button>

                                                        <input type="number" name="quantity"
                                                               value="{{ $item->quantity }}"
                                                               min="1" max="{{ $item->product->stock }}"
                                                               onchange="this.closest('form').submit()"
                                                               class="w-10 h-9 text-center text-sm font-bold text-gray-900 border-x border-gray-200 focus:outline-none bg-white">

                                                        <button type="button"
                                                                onclick="let i=this.closest('form').querySelector('input[name=quantity]');if(+i.value<{{ $item->product->stock }}){i.value=+i.value+1;this.closest('form').submit()}"
                                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-orange-50 hover:text-orange-600 transition-colors duration-150">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Eliminar --}}
                                            <form method="POST" action="{{ route('marketplace.cart.destroy', $item) }}"
                                                  class="order-3"
                                                  x-data="{}"
                                                  @submit.prevent="if(confirm('¿Quitar {{ addslashes($item->product->name) }} del carrito?')) $el.submit()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-400 hover:text-red-500 hover:bg-red-50 border-2 border-transparent hover:border-red-100 transition-all duration-150">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                {{-- Botón vaciar carrito --}}
                <div class="flex items-center justify-between reveal">
                    <a href="{{ route('marketplace.home') }}"
                       class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-orange-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Seguir comprando
                    </a>

                    <form method="POST" action="{{ route('marketplace.cart.clear') }}"
                          x-data="{}"
                          @submit.prevent="if(confirm('¿Vaciar todo el carrito? Esta acción no se puede deshacer.')) $el.submit()">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 text-sm font-medium text-red-400 hover:text-red-600 hover:bg-red-50 px-4 py-2 rounded-xl transition-all duration-150">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Vaciar carrito
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── RESUMEN (1 col, sticky) ───────────────── --}}
            <aside class="lg:col-span-1">
                <div class="sticky top-24 space-y-4">

                    {{-- Resumen del pedido --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden reveal-right">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h2 class="font-bold text-gray-900 text-lg">Resumen del pedido</h2>
                        </div>

                        <div class="p-6 space-y-4">

                            {{-- Desglose --}}
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Artículos ({{ $cart->items->sum('quantity') }})</span>
                                    <span class="font-medium text-gray-700">Q{{ number_format($cart->total(), 2) }}</span>
                                </div>

                                @php
                                    $totalDescuento = $cart->items->sum(function($item) {
                                        return ($item->product->price - $item->product->finalPrice()) * $item->quantity;
                                    });
                                @endphp

                                @if($totalDescuento > 0)
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-green-600 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            Descuentos aplicados
                                        </span>
                                        <span class="font-medium text-green-600">-Q{{ number_format($totalDescuento, 2) }}</span>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Envío</span>
                                    <span class="font-medium text-green-600">A coordinar con el comercio</span>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-gray-900">Total</span>
                                    <div class="text-right">
                                        @if($totalDescuento > 0)
                                            <p class="text-xs text-gray-400 line-through">Q{{ number_format($cart->total() + $totalDescuento, 2) }}</p>
                                        @endif
                                        <p class="text-2xl font-black text-gray-900">Q{{ number_format($cart->total(), 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Confirmar pedido --}}
                            <form method="POST" action="{{ route('marketplace.orders.store') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-2.5 px-6 py-4 rounded-2xl text-base font-semibold text-white
                                               bg-gradient-to-r from-orange-500 to-orange-600
                                               hover:from-orange-600 hover:to-orange-700 active:scale-[0.98]
                                               shadow-xl shadow-orange-500/30 hover:shadow-orange-500/40
                                               focus:outline-none focus:ring-4 focus:ring-orange-500/30
                                               transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Confirmar pedido
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Garantías / trust badges --}}
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-5 reveal-right stagger-2">
                        <ul class="space-y-3.5">
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <span>Compra segura y protegida</span>
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                                </div>
                                <span>Comercios locales verificados</span>
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600">
                                <div class="w-8 h-8 rounded-xl bg-orange-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <span>Soporte disponible 24/7</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Cupón (placeholder visual) --}}
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-3xl border border-orange-100 p-5 reveal-right stagger-3">
                        <p class="text-xs font-bold text-orange-700 uppercase tracking-wider mb-3">¿Tienes un cupón?</p>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Código de descuento"
                                   disabled
                                   class="flex-1 px-3 py-2.5 rounded-xl border-2 border-orange-200 bg-white/70 text-sm text-gray-500 placeholder-gray-400 focus:outline-none cursor-not-allowed">
                            <button disabled class="px-4 py-2.5 rounded-xl text-sm font-semibold text-orange-600 border-2 border-orange-200 bg-white/70 cursor-not-allowed opacity-70">
                                Aplicar
                            </button>
                        </div>
                        <p class="text-xs text-orange-400 mt-2">Próximamente disponible</p>
                    </div>
                </div>
            </aside>
        </div>

    @else

        {{-- ══ ESTADO VACÍO ══ --}}
        <div class="flex flex-col items-center justify-center py-24 text-center reveal">
            <div class="relative mb-8">
                <div class="w-32 h-32 rounded-3xl bg-gradient-to-br from-orange-50 to-amber-50 border-2 border-dashed border-orange-200 flex items-center justify-center">
                    <svg class="w-16 h-16 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                {{-- Floating emoji --}}
                <div class="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-2xl shadow-lg border border-gray-100 flex items-center justify-center text-xl animate-float">
                    🛍️
                </div>
            </div>

            <h2 class="text-3xl font-black text-gray-900 mb-3">Tu carrito está vacío</h2>
            <p class="text-gray-500 max-w-sm mx-auto leading-relaxed mb-8">
                Aún no has agregado ningún producto. Explora los comercios locales y encuentra algo que te guste.
            </p>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('marketplace.home') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold text-white
                          bg-gradient-to-r from-orange-500 to-orange-600
                          hover:from-orange-600 hover:to-orange-700
                          shadow-xl shadow-orange-500/30 hover:shadow-orange-500/40
                          transition-all duration-200 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    Explorar comercios
                </a>
                <a href="{{ route('marketplace.orders.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold
                          text-gray-700 bg-white border-2 border-gray-200 hover:border-orange-200 hover:text-orange-600 hover:bg-orange-50
                          transition-all duration-200">
                    Ver mis pedidos
                </a>
            </div>

            {{-- Sugerencias --}}
            <div class="mt-16 grid grid-cols-3 gap-6 max-w-sm w-full">
                @php $hints = [['🍕','Comida'],['👗','Ropa'],['💻','Tecnología']]; @endphp
                @foreach($hints as $h)
                    <a href="{{ route('marketplace.home') }}"
                       class="flex flex-col items-center gap-2 p-4 rounded-2xl bg-white border-2 border-gray-100 hover:border-orange-200 hover:bg-orange-50 transition-all duration-200 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform duration-200">{{ $h[0] }}</span>
                        <span class="text-xs font-semibold text-gray-600 group-hover:text-orange-600 transition-colors">{{ $h[1] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

    @endif
</main>

</body>
</html>

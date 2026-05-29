<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LocalMarket 24hrs — Compra en comercios locales</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .float-delay-0 { animation: float 4s ease-in-out infinite; }
        .float-delay-1 { animation: float 4s ease-in-out 1s   infinite; }
        .float-delay-2 { animation: float 4s ease-in-out 2s   infinite; }
        .float-delay-3 { animation: float 4s ease-in-out 0.5s infinite; }

        @keyframes float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-12px); }
        }
        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .step-line::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #f97316, #fbbf24);
            opacity: 0.3;
        }
        @media (max-width: 1024px) { .step-line::after { display: none; } }
    </style>
</head>
<body class="font-sans antialiased bg-white text-gray-900 overflow-x-hidden">

{{-- ══════════════════════ NAVBAR ══════════════════════ --}}
<nav x-data="{ open: false, userMenu: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'shadow-md shadow-gray-200/60' : ''"
     class="sticky top-0 z-50 glass border-b border-white/80 transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('marketplace.home') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-105 transition-transform duration-200">
                    <span class="text-white font-black text-sm">L</span>
                </div>
                <div class="leading-none">
                    <span class="font-extrabold text-gray-900 text-lg">Local</span><span class="font-extrabold text-orange-500 text-lg">Market</span>
                    <span class="text-gray-400 text-xs font-medium ml-1">24hrs</span>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-1.5">
                @auth
                    @if (auth()->user()->role === 'comerciante')
                        <a href="{{ route('comerciante.dashboard') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Mi comercio
                        </a>
                    @else
                        <a href="{{ route('comerciante.commerce.create') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors">Vender aquí</a>
                    @endif
                    <a href="{{ route('marketplace.orders.index') }}" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Mis pedidos
                    </a>
                    <a href="{{ route('marketplace.conversations.index') }}" class="relative p-2.5 rounded-xl text-gray-500 hover:text-orange-500 hover:bg-orange-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        @if(!empty($unreadBuyerChats) && $unreadBuyerChats > 0)
                            <span class="absolute -top-1.5 -right-1.5 flex">
                                <span class="animate-ping absolute inline-flex h-3.5 w-3.5 rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative min-w-[14px] h-3.5 px-0.5 rounded-full bg-orange-500 text-white text-[9px] font-bold flex items-center justify-center leading-none ring-2 ring-white">{{ $unreadBuyerChats > 9 ? '9+' : $unreadBuyerChats }}</span>
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('marketplace.cart.index') }}" class="relative flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-sm font-semibold text-orange-600 bg-orange-50 hover:bg-orange-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Carrito
                        @if(!empty($cartItemCount) && $cartItemCount > 0)
                            <span class="absolute -top-1 -right-1 flex">
                                <span class="animate-ping absolute inline-flex h-4 w-4 rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative min-w-[16px] h-4 px-0.5 rounded-full bg-orange-500 text-white text-[9px] font-bold flex items-center justify-center leading-none ring-2 ring-white">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
                            </span>
                        @endif
                    </a>
                    <div class="relative" x-data="{ userMenu: false }">
                        <button @click="userMenu = !userMenu" class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-gray-200 hover:border-orange-200 bg-white hover:bg-orange-50 transition-all duration-150">
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            <span class="text-sm font-medium text-gray-700 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="userMenu" @click.away="userMenu = false" x-cloak
                             x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Mi cuenta
                            </a>
                            <a href="{{ route('marketplace.conversations.index') }}" class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Mis chats
                                @if(!empty($unreadBuyerChats) && $unreadBuyerChats > 0)
                                    <span class="ml-auto min-w-[18px] h-[18px] px-1 rounded-full bg-orange-500 text-white text-[10px] font-bold flex items-center justify-center leading-none">{{ $unreadBuyerChats > 9 ? '9+' : $unreadBuyerChats }}</span>
                                @endif
                            </a>
                            <div class="border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">@csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg shadow-orange-500/25 transition-all duration-200">Regístrate gratis</a>
                @endauth
            </div>

            <button @click="open = !open" class="md:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden':open,'inline-flex':!open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden':!open,'inline-flex':open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    <div :class="{'block':open,'hidden':!open}" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1.5">
        @auth
            <a href="{{ route('marketplace.cart.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-orange-600 bg-orange-50">
                Carrito
                @if(!empty($cartItemCount) && $cartItemCount > 0)
                    <span class="ml-auto min-w-[18px] h-[18px] px-1 rounded-full bg-orange-600 text-white text-[10px] font-bold flex items-center justify-center leading-none">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
                @endif
            </a>
            <a href="{{ route('marketplace.orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">Mis pedidos</a>
            <a href="{{ route('marketplace.conversations.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">
                Mis chats
                @if(!empty($unreadBuyerChats) && $unreadBuyerChats > 0)
                    <span class="ml-auto min-w-[18px] h-[18px] px-1 rounded-full bg-orange-500 text-white text-[10px] font-bold flex items-center justify-center leading-none">{{ $unreadBuyerChats > 9 ? '9+' : $unreadBuyerChats }}</span>
                @endif
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">Mi cuenta</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-red-600 hover:bg-red-50">Cerrar sesión</button>
            </form>
        @else
            <a href="{{ route('login') }}"    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600">Regístrate gratis</a>
        @endauth
    </div>
</nav>

{{-- ══════════════════════ HERO ══════════════════════ --}}
<section class="relative overflow-hidden min-h-[92vh] flex items-center">
    {{-- Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-orange-50 via-amber-50/30 to-white"></div>
    <div class="absolute top-0 right-0 w-[900px] h-[900px] bg-orange-100/40 rounded-full blur-3xl -translate-y-1/3 translate-x-1/4"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-amber-100/40 rounded-full blur-3xl translate-y-1/3 -translate-x-1/4"></div>
    <div class="absolute inset-0 opacity-[0.035]" style="background-image:radial-gradient(circle,#f97316 1.5px,transparent 1.5px);background-size:30px 30px"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- LEFT: Text --}}
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-orange-100 shadow-sm text-sm font-semibold text-orange-700 mb-8 animate-fade-in">
                    <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                    Marketplace local · Disponible las 24 horas
                </div>

                <h1 class="text-5xl sm:text-6xl xl:text-7xl font-black tracking-tight leading-[0.92] mb-7 animate-fade-in-up">
                    Tu mercado<br>local,<br>
                    <span class="gradient-text">en un clic</span>
                </h1>

                <p class="text-xl text-gray-500 leading-relaxed max-w-lg mb-10 animate-fade-in-up" style="animation-delay:0.1s">
                    Descubre cientos de comercios locales, compra sus productos y apoya a los negocios de tu comunidad. Todo desde una sola plataforma.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 mb-12 animate-fade-in-up" style="animation-delay:0.2s">
                    <a href="#comercios"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold text-white
                              bg-gradient-to-r from-orange-500 to-orange-600
                              hover:from-orange-600 hover:to-orange-700
                              shadow-xl shadow-orange-500/30 hover:shadow-orange-500/40
                              transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        Explorar comercios
                    </a>
                    @guest
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold
                                  text-gray-700 bg-white border-2 border-gray-200 hover:border-orange-200 hover:text-orange-600 hover:bg-orange-50
                                  transition-all duration-200">
                            Regístrate gratis →
                        </a>
                    @endguest
                </div>

                {{-- Social proof --}}
                <div class="flex flex-wrap items-center gap-6 animate-fade-in-up" style="animation-delay:0.3s">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            @foreach(['F','C','A','M'] as $l)
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-orange-{{ $loop->index % 2 === 0 ? '400' : '500' }} to-amber-{{ $loop->index % 2 === 0 ? '500' : '600' }} border-2 border-white flex items-center justify-center text-white text-xs font-bold shadow-sm">{{ $l }}</div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-500 font-medium">+1,000 compradores activos</p>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="flex gap-0.5">
                            @for($i=0;$i<5;$i++)
                                <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-sm font-semibold text-gray-700">4.9</span>
                        <span class="text-sm text-gray-400">/ calificación</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Floating preview cards --}}
            <div class="hidden lg:block relative h-[520px]">
                {{-- Central glow --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-72 h-72 rounded-full bg-gradient-to-br from-orange-200/50 to-amber-100/50 blur-2xl"></div>
                </div>

                {{-- Main commerce preview card --}}
                <div class="absolute top-6 left-1/2 -translate-x-1/2 w-64 float-delay-0
                            bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                    <div class="h-24 bg-gradient-to-br from-orange-400 to-amber-500 flex items-center justify-center">
                        <span class="text-4xl">🍕</span>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-gray-900 text-sm">Pizzería Don Mario</span>
                            <span class="ml-auto flex items-center gap-1 text-xs text-amber-500 font-semibold">
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                4.9
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mb-3">Comida · 45 productos</p>
                        <div class="h-8 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                            <span class="text-white text-xs font-semibold">Ver comercio →</span>
                        </div>
                    </div>
                </div>

                {{-- Order confirmed card --}}
                <div class="absolute top-32 right-0 w-52 float-delay-2
                            bg-white rounded-2xl shadow-xl border border-gray-100 p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">¡Pedido confirmado!</p>
                            <p class="text-xs text-gray-400">Tu pedido está en camino</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-1.5 bg-green-50 rounded-lg p-2">
                        <svg class="w-3.5 h-3.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs text-green-700 font-medium">Llega en ~25 minutos</span>
                    </div>
                </div>

                {{-- Cart mini card --}}
                <div class="absolute bottom-28 left-0 w-48 float-delay-1
                            bg-white rounded-2xl shadow-xl border border-gray-100 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold text-gray-900">Mi carrito</span>
                        <div class="w-5 h-5 rounded-full bg-orange-500 flex items-center justify-center">
                            <span class="text-white text-xs font-bold">3</span>
                        </div>
                    </div>
                    <div class="space-y-1.5 mb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md bg-orange-100 flex items-center justify-center text-xs">🍕</div>
                            <div class="flex-1 h-2 bg-gray-100 rounded-full"></div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md bg-amber-100 flex items-center justify-center text-xs">🥤</div>
                            <div class="flex-1 h-2 bg-gray-100 rounded-full w-3/4"></div>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex items-center justify-between">
                        <span class="text-xs text-gray-500">Total</span>
                        <span class="text-sm font-black text-gray-900">Q48.50</span>
                    </div>
                </div>

                {{-- Commerce count chip --}}
                <div class="absolute bottom-16 right-4 float-delay-3
                            bg-white rounded-xl shadow-lg border border-gray-100 px-3 py-2 flex items-center gap-2">
                    <div class="w-6 h-6 rounded-lg bg-orange-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-gray-900 leading-none">100+</p>
                        <p class="text-xs text-gray-400 leading-none">Comercios</p>
                    </div>
                </div>

                {{-- Floating emoji decorations --}}
                <div class="absolute top-0 left-8 w-12 h-12 bg-white rounded-2xl shadow-lg flex items-center justify-center text-2xl float-delay-1 border border-gray-100">🛍️</div>
                <div class="absolute bottom-8 right-16 w-10 h-10 bg-amber-50 rounded-xl shadow flex items-center justify-center text-xl float-delay-2 border border-amber-100">⭐</div>
                <div class="absolute top-1/2 right-2 w-10 h-10 bg-green-50 rounded-xl shadow flex items-center justify-center text-xl float-delay-0 border border-green-100">✅</div>
            </div>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 60L60 51.5C120 43 240 26 360 20C480 14 600 18 720 24.5C840 31 960 39 1080 40.5C1200 42 1320 37 1380 34.5L1440 32V60H1380C1320 60 1200 60 1080 60C960 60 840 60 720 60C600 60 480 60 360 60C240 60 120 60 60 60H0Z" fill="white"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════ STATS BAR ══════════════════════ --}}
<section class="bg-white py-12 border-b border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="reveal">
                <div class="text-4xl font-black text-gray-900 mb-1">100+</div>
                <div class="text-sm text-gray-400 font-medium">Comercios activos</div>
            </div>
            <div class="reveal stagger-2">
                <div class="text-4xl font-black text-orange-500 mb-1">500+</div>
                <div class="text-sm text-gray-400 font-medium">Productos disponibles</div>
            </div>
            <div class="reveal stagger-3">
                <div class="text-4xl font-black text-gray-900 mb-1">1k+</div>
                <div class="text-sm text-gray-400 font-medium">Compradores felices</div>
            </div>
            <div class="reveal stagger-4">
                <div class="text-4xl font-black text-orange-500 mb-1">24/7</div>
                <div class="text-sm text-gray-400 font-medium">Siempre disponible</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════ FEATURES ══════════════════════ --}}
<section class="py-24 bg-gray-50/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-widest mb-4">¿Por qué LocalMarket?</span>
            <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">Todo lo que necesitas,<br>en un solo lugar</h2>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">Diseñado para conectar compradores y vendedores locales de la manera más sencilla.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $features = [
                    ['emoji'=>'🛍️','color'=>'orange','title'=>'Compra fácil','desc'=>'Encuentra lo que buscas en segundos. Sin complicaciones, sin pasos innecesarios.'],
                    ['emoji'=>'📍','color'=>'blue','title'=>'Comercios cercanos','desc'=>'Descubre negocios de tu barrio y comunidad. Apoya a quienes están cerca de ti.'],
                    ['emoji'=>'⚡','color'=>'amber','title'=>'Rápido y seguro','desc'=>'Proceso de compra ágil y confiable. Tu información siempre protegida.'],
                    ['emoji'=>'🌟','color'=>'green','title'=>'Apoya lo local','desc'=>'Cada compra ayuda a un emprendedor local a crecer y mantener su negocio.'],
                ];
                $colorMap = [
                    'orange'=>['bg'=>'bg-orange-50','icon'=>'bg-orange-100','border'=>'hover:border-orange-200'],
                    'blue'  =>['bg'=>'bg-blue-50',  'icon'=>'bg-blue-100',  'border'=>'hover:border-blue-200'],
                    'amber' =>['bg'=>'bg-amber-50', 'icon'=>'bg-amber-100', 'border'=>'hover:border-amber-200'],
                    'green' =>['bg'=>'bg-green-50', 'icon'=>'bg-green-100', 'border'=>'hover:border-green-200'],
                ];
            @endphp

            @foreach($features as $f)
                @php $stagger = $loop->index + 1; $c = $colorMap[$f['color']]; @endphp
                <div class="reveal stagger-{{ $stagger }}
                            bg-white rounded-3xl p-7 border-2 border-gray-100 {{ $c['border'] }}
                            hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group">
                    <div class="w-16 h-16 {{ $c['icon'] }} rounded-2xl flex items-center justify-center text-3xl mb-5 group-hover:scale-110 transition-transform duration-300">
                        {{ $f['emoji'] }}
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $f['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════ HOW IT WORKS ══════════════════════ --}}
<section class="py-24 bg-slate-900 relative overflow-hidden">
    {{-- Decorative --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"></div>
    <div class="absolute inset-0 opacity-[0.04]" style="background-image:radial-gradient(circle,#fff 1px,transparent 1px);background-size:28px 28px"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span class="inline-block px-4 py-1.5 rounded-full bg-orange-500/20 text-orange-400 text-xs font-bold uppercase tracking-widest mb-4">Simple y rápido</span>
            <h2 class="text-4xl sm:text-5xl font-black text-white mb-4">¿Cómo funciona?</h2>
            <p class="text-slate-400 text-lg max-w-xl mx-auto">En tres pasos sencillos puedes empezar a comprar en los mejores comercios locales.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8 relative">
            @php
                $steps = [
                    ['num'=>'01','emoji'=>'👤','title'=>'Crea tu cuenta','desc'=>'Regístrate gratis en menos de un minuto. Solo necesitas tu correo electrónico.','cta'=>'Registrarme','href'=>route('register')],
                    ['num'=>'02','emoji'=>'🔍','title'=>'Explora comercios','desc'=>'Navega por el directorio de comercios locales, filtra por categoría y descubre negocios increíbles.','cta'=>null,'href'=>null],
                    ['num'=>'03','emoji'=>'🛒','title'=>'Realiza tu pedido','desc'=>'Añade productos al carrito, confirma tu pedido y recibe la atención directa del comerciante.','cta'=>null,'href'=>null],
                ];
            @endphp

            @foreach($steps as $step)
                @php $stagger = $loop->index + 1; $isLast = $loop->last; @endphp
                <div class="reveal stagger-{{ $stagger }} relative {{ !$isLast ? 'step-line' : '' }}">
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 hover:border-white/20 transition-all duration-300 h-full">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="text-5xl">{{ $step['emoji'] }}</div>
                            <div class="text-right ml-auto">
                                <span class="text-5xl font-black text-white/10">{{ $step['num'] }}</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">{{ $step['title'] }}</h3>
                        <p class="text-slate-400 leading-relaxed mb-5">{{ $step['desc'] }}</p>
                        @if($step['cta'])
                            <a href="{{ $step['href'] }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white
                                      bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/25
                                      hover:from-orange-600 hover:to-orange-700 transition-all duration-200">
                                {{ $step['cta'] }} →
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════ CATEGORÍAS ══════════════════════ --}}
@if($categories->count() > 0)
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12 reveal">
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-widest mb-4">Categorías</span>
                <h2 class="text-4xl font-black text-gray-900">Encuentra lo que buscas</h2>
            </div>
        </div>

        @php
        $catIconMap = [
            ['keys' => ['comida','restaurante','pizza','burger','pollo','carne','mariscos','sushi','café','cafe','panadería','panaderia','pastelería','pasteleria','dulces','almuerzo','desayuno','cocina','bebida'],
             'gradient'=>'bg-gradient-to-br from-red-500 to-orange-500','shadow'=>'shadow-red-500/30',
             'card_hover'=>'hover:border-red-200 hover:bg-red-50/50','text_hover'=>'group-hover:text-red-600',
             'path'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
            ['keys' => ['ropa','moda','calzado','textil','boutique','zapatos','vestido','dama','caballero','tela'],
             'gradient'=>'bg-gradient-to-br from-purple-500 to-pink-500','shadow'=>'shadow-purple-500/30',
             'card_hover'=>'hover:border-purple-200 hover:bg-purple-50/50','text_hover'=>'group-hover:text-purple-600',
             'path'=>'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
            ['keys' => ['tecnología','tecnologia','electrónica','electronica','celular','computadora','teléfono','telefono','gadget','informática','informatica','internet'],
             'gradient'=>'bg-gradient-to-br from-blue-500 to-cyan-500','shadow'=>'shadow-blue-500/30',
             'card_hover'=>'hover:border-blue-200 hover:bg-blue-50/50','text_hover'=>'group-hover:text-blue-600',
             'path'=>'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['keys' => ['hogar','muebles','decoración','decoracion','electrodoméstico','electrodomestico'],
             'gradient'=>'bg-gradient-to-br from-teal-500 to-emerald-500','shadow'=>'shadow-teal-500/30',
             'card_hover'=>'hover:border-teal-200 hover:bg-teal-50/50','text_hover'=>'group-hover:text-teal-600',
             'path'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['keys' => ['salud','farmacia','medicina','médico','medico','clínica','clinica','bienestar','dental','dentista','hospital'],
             'gradient'=>'bg-gradient-to-br from-green-500 to-emerald-400','shadow'=>'shadow-green-500/30',
             'card_hover'=>'hover:border-green-200 hover:bg-green-50/50','text_hover'=>'group-hover:text-green-600',
             'path'=>'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ['keys' => ['libros','libro','educación','educacion','papelería','papeleria','escolar','academia','cursos','tutorías','tutorias'],
             'gradient'=>'bg-gradient-to-br from-indigo-500 to-blue-500','shadow'=>'shadow-indigo-500/30',
             'card_hover'=>'hover:border-indigo-200 hover:bg-indigo-50/50','text_hover'=>'group-hover:text-indigo-600',
             'path'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
            ['keys' => ['deportes','deporte','sport','fitness','gym','gimnasio','ejercicio','yoga','fútbol','futbol','running','natación','natacion'],
             'gradient'=>'bg-gradient-to-br from-emerald-500 to-lime-500','shadow'=>'shadow-emerald-500/30',
             'card_hover'=>'hover:border-emerald-200 hover:bg-emerald-50/50','text_hover'=>'group-hover:text-emerald-600',
             'path'=>'M13 10V3L4 14h7v7l9-11h-7z'],
            ['keys' => ['belleza','peluquería','peluqueria','estética','estetica','spa','salón','salon','barbería','barberia','cosméticos','cosmeticos','maquillaje'],
             'gradient'=>'bg-gradient-to-br from-rose-500 to-pink-500','shadow'=>'shadow-rose-500/30',
             'card_hover'=>'hover:border-rose-200 hover:bg-rose-50/50','text_hover'=>'group-hover:text-rose-600',
             'path'=>'M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z'],
            ['keys' => ['mascotas','mascota','veterinaria','veterinario','animales','animal','perros','gatos','pet'],
             'gradient'=>'bg-gradient-to-br from-amber-500 to-yellow-400','shadow'=>'shadow-amber-500/30',
             'card_hover'=>'hover:border-amber-200 hover:bg-amber-50/50','text_hover'=>'group-hover:text-amber-600',
             'path'=>'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['keys' => ['música','musica','audio','instrumentos','instrumento','discos','concierto'],
             'gradient'=>'bg-gradient-to-br from-violet-500 to-purple-500','shadow'=>'shadow-violet-500/30',
             'card_hover'=>'hover:border-violet-200 hover:bg-violet-50/50','text_hover'=>'group-hover:text-violet-600',
             'path'=>'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
            ['keys' => ['arte','artesanías','artesania','manualidades','pintura','galería','galeria','diseño','fotografía','fotografia'],
             'gradient'=>'bg-gradient-to-br from-fuchsia-500 to-rose-500','shadow'=>'shadow-fuchsia-500/30',
             'card_hover'=>'hover:border-fuchsia-200 hover:bg-fuchsia-50/50','text_hover'=>'group-hover:text-fuchsia-600',
             'path'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
            ['keys' => ['ferretería','ferreteria','herramientas','construcción','construccion','materiales','mecánica','reparación','reparacion'],
             'gradient'=>'bg-gradient-to-br from-slate-600 to-gray-700','shadow'=>'shadow-slate-500/30',
             'card_hover'=>'hover:border-slate-200 hover:bg-slate-50/50','text_hover'=>'group-hover:text-slate-600',
             'path'=>'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ['keys' => ['plantas','planta','naturaleza','flores','flor','jardín','jardin','vivero','orgánico','organico'],
             'gradient'=>'bg-gradient-to-br from-lime-500 to-green-500','shadow'=>'shadow-lime-500/30',
             'card_hover'=>'hover:border-lime-200 hover:bg-lime-50/50','text_hover'=>'group-hover:text-lime-600',
             'path'=>'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['keys' => ['joyería','joyeria','joyas','accesorios','bisutería','bisuteria','relojes','reloj','anillos','aretes'],
             'gradient'=>'bg-gradient-to-br from-sky-500 to-blue-600','shadow'=>'shadow-sky-500/30',
             'card_hover'=>'hover:border-sky-200 hover:bg-sky-50/50','text_hover'=>'group-hover:text-sky-600',
             'path'=>'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'],
            ['keys' => ['auto','autos','vehículos','vehiculos','repuestos','transporte','automotriz','taller','mecánica','mecanica'],
             'gradient'=>'bg-gradient-to-br from-zinc-500 to-slate-600','shadow'=>'shadow-zinc-500/30',
             'card_hover'=>'hover:border-zinc-200 hover:bg-zinc-50/50','text_hover'=>'group-hover:text-zinc-600',
             'path'=>'M8 7h12m0 0l-4-4m4 4l-4 4m0 5H4m0 0l4 4m-4-4l4-4'],
            ['keys' => ['juguetes','juguete','juguetería','jugueteria','niños','infantil','bebés','bebes','bebe'],
             'gradient'=>'bg-gradient-to-br from-yellow-400 to-orange-400','shadow'=>'shadow-yellow-400/30',
             'card_hover'=>'hover:border-yellow-200 hover:bg-yellow-50/50','text_hover'=>'group-hover:text-yellow-600',
             'path'=>'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7'],
            ['keys' => ['videojuegos','videojuego','gaming','gamer','consola','xbox','playstation','nintendo','juegos'],
             'gradient'=>'bg-gradient-to-br from-violet-600 to-indigo-600','shadow'=>'shadow-violet-500/30',
             'card_hover'=>'hover:border-violet-200 hover:bg-violet-50/50','text_hover'=>'group-hover:text-violet-600',
             'path'=>'M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z'],
            ['keys' => ['supermercado','mercado','abarrotes','abarrotería','abarroteria','víveres','viveres','almacén','almacen'],
             'gradient'=>'bg-gradient-to-br from-orange-400 to-amber-400','shadow'=>'shadow-orange-400/30',
             'card_hover'=>'hover:border-orange-200 hover:bg-orange-50/50','text_hover'=>'group-hover:text-orange-600',
             'path'=>'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
        ];
        $defaultIcon = ['gradient'=>'bg-gradient-to-br from-orange-500 to-amber-500','shadow'=>'shadow-orange-500/30',
                        'card_hover'=>'hover:border-orange-200 hover:bg-orange-50/50','text_hover'=>'group-hover:text-orange-600',
                        'path'=>'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'];
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($categories->take(10) as $cat)
                @php
                    $stagger = ($loop->index % 5) + 1;
                    $icon = $defaultIcon;
                    $lowerName = strtolower($cat->name);
                    foreach ($catIconMap as $cfg) {
                        foreach ($cfg['keys'] as $kw) {
                            if (str_contains($lowerName, $kw)) { $icon = $cfg; break 2; }
                        }
                    }
                @endphp
                <a href="{{ route('marketplace.home', ['category_id' => $cat->id]) }}"
                   class="reveal stagger-{{ $stagger }} group flex flex-col items-center gap-3 p-6 rounded-2xl border-2 border-gray-100 {{ $icon['card_hover'] }} hover:-translate-y-1 hover:shadow-lg transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl {{ $icon['gradient'] }} shadow-lg {{ $icon['shadow'] }} flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon['path'] }}"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 {{ $icon['text_hover'] }} text-center transition-colors leading-snug">{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════ SEARCH ══════════════════════ --}}
<section class="py-6 bg-gray-50/60 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-6 reveal">
            <form method="GET" action="{{ route('marketplace.home') }}"
                  class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Buscar comercio</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Comida, ropa, tecnología..."
                               class="w-full pl-11 pr-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50
                                      focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none
                                      transition-all duration-200 text-gray-900 placeholder-gray-400">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Categoría</label>
                    <select name="category_id"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 bg-gray-50
                                   focus:bg-white focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none
                                   transition-all duration-200 text-gray-900">
                        <option value="">Todas las categorías</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ (string) $categoryId === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl text-sm font-semibold text-white
                                   bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700
                                   shadow-lg shadow-orange-500/25 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filtrar
                    </button>
                    @if($search || $categoryId)
                        <a href="{{ route('marketplace.home') }}"
                           class="flex items-center justify-center px-4 rounded-xl border-2 border-gray-100 text-gray-400 hover:border-red-200 hover:text-red-500 hover:bg-red-50 transition-all duration-150" title="Limpiar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ══════════════════════ COMMERCE GRID ══════════════════════ --}}
<section id="comercios" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-12 reveal">
            <div>
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-widest mb-4">Directorio</span>
                <h2 class="text-4xl font-black text-gray-900">Comercios disponibles</h2>
                <p class="text-gray-500 mt-2">Explora los negocios activos en la plataforma.</p>
            </div>
            @if($commerces->count() > 0)
                <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-orange-50 border border-orange-100 text-sm text-orange-700 font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
                    {{ $commerces->total() }} {{ $commerces->total() === 1 ? 'comercio' : 'comercios' }}
                </div>
            @endif
        </div>

        @if ($commerces->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($commerces as $commerce)
                    @php $stagger = ($loop->index % 6) + 1; @endphp
                    <article class="reveal stagger-{{ $stagger }}
                                    bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden
                                    hover:-translate-y-2 hover:shadow-2xl hover:shadow-gray-200/80 hover:border-gray-200
                                    transition-all duration-300 group">
                        <div class="h-48 relative overflow-hidden bg-gradient-to-br from-orange-50 via-amber-50 to-orange-100">
                            @if ($commerce->banner_url)
                                <img src="{{ $commerce->banner_url }}" alt="{{ $commerce->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                            @endif
                            <div class="w-full h-full flex items-center justify-center {{ $commerce->banner_url ? 'hidden' : '' }}" style="{{ $commerce->banner_url ? 'display:none' : '' }}">
                                <div class="text-center">
                                    <div class="w-20 h-20 rounded-3xl bg-orange-200/50 flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-10 h-10 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                </div>
                            </div>
                            {{-- Overlay gradient on hover --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            @if($commerce->category)
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 backdrop-blur-sm text-gray-700 shadow-sm border border-white/50">
                                        {{ $commerce->category->name }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-12 h-12 rounded-2xl overflow-hidden shadow-lg shadow-orange-500/20 shrink-0 group-hover:scale-110 transition-transform duration-300 bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center text-white font-black text-xl">
                                    @if ($commerce->logo_url)
                                        <img src="{{ $commerce->logo_url }}" alt="{{ $commerce->name }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                                        <span style="display:none" class="w-full h-full flex items-center justify-center text-white font-black text-xl">{{ strtoupper(substr($commerce->name, 0, 1)) }}</span>
                                    @else
                                        {{ strtoupper(substr($commerce->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1 pt-1">
                                    <h3 class="font-bold text-gray-900 text-lg leading-tight truncate">{{ $commerce->name }}</h3>
                                    <p class="text-sm text-gray-400 mt-0.5">{{ $commerce->category->name ?? 'Sin categoría' }}</p>
                                </div>
                            </div>

                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-5">
                                {{ $commerce->description ?? 'Este comercio aún no tiene descripción.' }}
                            </p>

                            <a href="{{ route('marketplace.commerces.show', $commerce) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl text-sm font-semibold
                                      text-orange-600 bg-orange-50 border-2 border-orange-100
                                      group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-orange-600
                                      group-hover:text-white group-hover:border-transparent group-hover:shadow-lg group-hover:shadow-orange-500/25
                                      transition-all duration-300">
                                Ver comercio
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12 reveal">{{ $commerces->links() }}</div>

        @else
            <div class="reveal text-center py-28">
                <div class="inline-flex items-center justify-center w-28 h-28 rounded-3xl bg-orange-50 mb-6">
                    <svg class="w-14 h-14 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    @if($search || $categoryId) Sin resultados para tu búsqueda @else Todavía no hay comercios @endif
                </h3>
                <p class="text-gray-400 max-w-sm mx-auto mb-8 leading-relaxed">
                    @if($search || $categoryId) Intenta con otros términos o categoría. @else ¡Sé el primero en crear un comercio! @endif
                </p>
                @if($search || $categoryId)
                    <a href="{{ route('marketplace.home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/25 transition-all duration-200">Ver todos los comercios</a>
                @else
                    <a href="{{ route('comerciante.commerce.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/25 transition-all duration-200">Crear mi comercio →</a>
                @endif
            </div>
        @endif
    </div>
</section>

{{-- ══════════════════════ SELL CTA ══════════════════════ --}}
<section class="relative overflow-hidden py-24">
    <div class="absolute inset-0 bg-gradient-to-br from-orange-500 via-orange-600 to-amber-600"></div>
    <div class="absolute inset-0 opacity-[0.08]" style="background-image:radial-gradient(circle,#fff 1.5px,transparent 1.5px);background-size:24px 24px"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-300/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-400/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="reveal-left">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-widest mb-6">Para comerciantes</span>
                <h2 class="text-4xl sm:text-5xl font-black text-white leading-tight mb-6">
                    ¿Tienes un negocio?<br>
                    <span class="text-amber-300">¡Empieza a vender hoy!</span>
                </h2>
                <p class="text-orange-100 text-lg leading-relaxed mb-8 max-w-lg">
                    Digitaliza tu comercio en minutos, llega a más clientes y gestiona tus pedidos desde cualquier lugar. Sin costos ocultos.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('comerciante.commerce.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold
                              text-orange-600 bg-white hover:bg-orange-50 shadow-xl transition-all duration-200 hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Crear mi comercio gratis
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold
                              text-white border-2 border-white/30 hover:bg-white/10 hover:border-white/50 transition-all duration-200">
                        Ya tengo cuenta →
                    </a>
                </div>
            </div>

            <div class="reveal-right grid grid-cols-2 gap-4">
                @php
                    $sellPerks = [
                        ['emoji'=>'⚡','title'=>'Alta en 5 minutos','desc'=>'Sube tus productos y empieza a vender hoy mismo.'],
                        ['emoji'=>'📊','title'=>'Gestión de pedidos','desc'=>'Recibe y administra pedidos desde tu panel.'],
                        ['emoji'=>'🌍','title'=>'Más visibilidad','desc'=>'Llega a compradores que buscan comercios locales.'],
                        ['emoji'=>'💰','title'=>'Sin comisiones ocultas','desc'=>'Conoce exactamente lo que pagas por usar la plataforma.'],
                    ];
                @endphp
                @foreach($sellPerks as $p)
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/20 hover:bg-white/20 transition-all duration-200 stagger-{{ $loop->index + 1 }}">
                        <span class="text-3xl mb-3 block">{{ $p['emoji'] }}</span>
                        <h4 class="font-bold text-white text-sm mb-1">{{ $p['title'] }}</h4>
                        <p class="text-orange-200 text-xs leading-relaxed">{{ $p['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════ TESTIMONIALS ══════════════════════ --}}
<section class="py-24 bg-gray-50/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 reveal">
            <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-widest mb-4">Testimonios</span>
            <h2 class="text-4xl sm:text-5xl font-black text-gray-900 mb-4">Lo que dicen nuestros usuarios</h2>
            <p class="text-lg text-gray-500 max-w-xl mx-auto">Compradores y comerciantes que ya hacen parte de la comunidad LocalMarket.</p>
        </div>

        @php
            $testimonials = [
                ['name'=>'María González','role'=>'Compradora frecuente','initial'=>'M','color'=>'orange','quote'=>'Encontré todos los productos que necesito en comercios de mi barrio. Ya no tengo que ir a grandes superficies, apoyo a mi comunidad y consigo mejores precios.','stars'=>5],
                ['name'=>'Carlos Ramírez','role'=>'Dueño de panadería','initial'=>'C','color'=>'blue','quote'=>'Como comerciante, logré digitalizar mi negocio en minutos. Mis ventas aumentaron un 40% desde que me uní a LocalMarket. Es increíblemente fácil de usar.','stars'=>5],
                ['name'=>'Ana Lucía Torres','role'=>'Compradora habitual','initial'=>'A','color'=>'amber','quote'=>'La plataforma es súper intuitiva y los comercios son excelentes. El proceso de compra es rápido y los comerciantes responden muy rápido. ¡100% recomendado!','stars'=>5],
            ];
            $colorsBg = ['orange'=>'bg-orange-500','blue'=>'bg-blue-500','amber'=>'bg-amber-500'];
        @endphp

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($testimonials as $t)
                @php $stagger = $loop->index + 1; @endphp
                <div class="reveal stagger-{{ $stagger }}
                            bg-white rounded-3xl p-8 border border-gray-100 shadow-sm
                            hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                    {{-- Stars --}}
                    <div class="flex gap-1 mb-4">
                        @for($s=0;$s<$t['stars'];$s++)
                            <svg class="w-5 h-5 text-amber-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    {{-- Quote --}}
                    <blockquote class="text-gray-600 leading-relaxed mb-6 text-sm">
                        "{{ $t['quote'] }}"
                    </blockquote>
                    {{-- Author --}}
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full {{ $colorsBg[$t['color']] }} flex items-center justify-center text-white font-bold text-sm shadow-md">
                            {{ $t['initial'] }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">{{ $t['name'] }}</p>
                            <p class="text-xs text-gray-400">{{ $t['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════ FOOTER ══════════════════════ --}}
<footer class="bg-slate-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            {{-- Brand --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center shadow-lg shadow-orange-500/30">
                        <span class="text-white font-black text-sm">L</span>
                    </div>
                    <span class="font-extrabold text-xl">Local<span class="text-orange-400">Market</span> <span class="text-slate-400 font-medium text-sm">24hrs</span></span>
                </div>
                <p class="text-slate-400 leading-relaxed mb-6 max-w-sm text-sm">
                    Conectamos compradores con comercios locales para impulsar la economía de las comunidades. Disponible las 24 horas, los 7 días de la semana.
                </p>
                <div class="flex gap-3">
                    <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-orange-500 hover:text-white transition-all duration-200 cursor-pointer">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-orange-500 hover:text-white transition-all duration-200 cursor-pointer">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </div>
                </div>
            </div>

            {{-- Nav --}}
            <div>
                <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-4">Plataforma</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('marketplace.home') }}" class="text-sm text-slate-400 hover:text-orange-400 transition-colors">Inicio</a></li>
                    <li><a href="#comercios" class="text-sm text-slate-400 hover:text-orange-400 transition-colors">Comercios</a></li>
                    @auth
                        <li><a href="{{ route('marketplace.cart.index') }}" class="text-sm text-slate-400 hover:text-orange-400 transition-colors">Mi carrito</a></li>
                        <li><a href="{{ route('marketplace.orders.index') }}" class="text-sm text-slate-400 hover:text-orange-400 transition-colors">Mis pedidos</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Comerciantes --}}
            <div>
                <h4 class="font-bold text-white text-sm uppercase tracking-wider mb-4">Comerciantes</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('register') }}" class="text-sm text-slate-400 hover:text-orange-400 transition-colors">Registrarse</a></li>
                    <li><a href="{{ route('comerciante.commerce.create') }}" class="text-sm text-slate-400 hover:text-orange-400 transition-colors">Crear comercio</a></li>
                    @auth
                        @if(auth()->user()->role === 'comerciante')
                            <li><a href="{{ route('comerciante.dashboard') }}" class="text-sm text-slate-400 hover:text-orange-400 transition-colors">Mi panel</a></li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-slate-500">© {{ date('Y') }} LocalMarket 24hrs · Todos los derechos reservados.</p>
            <p class="text-sm text-slate-500">Hecho con ❤️ para los comercios locales</p>
        </div>
    </div>
</footer>

</body>
</html>

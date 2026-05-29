<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $commerce->name }} - LocalMarket 24hrs</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Scroll reveal ── */
        .sr { opacity: 0; transform: translateY(28px); transition: opacity .55s cubic-bezier(.22,1,.36,1), transform .55s cubic-bezier(.22,1,.36,1); }
        .sr.sr-left  { transform: translateX(-28px); }
        .sr.sr-right { transform: translateX(28px); }
        .sr.sr-scale { transform: scale(.94); }
        .sr.visible  { opacity: 1 !important; transform: none !important; }

        /* ── Product card ── */
        .product-card { transition: transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -8px rgba(249,115,22,.18); }

        /* ── Float back-to-top ── */
        #btt { opacity: 0; pointer-events: none; transition: opacity .3s, transform .3s; transform: translateY(12px); }
        #btt.show { opacity: 1; pointer-events: auto; transform: none; }

        /* ── Stagger delay helpers ── */
        .d-1 { transition-delay: .05s; }
        .d-2 { transition-delay: .12s; }
        .d-3 { transition-delay: .19s; }
        .d-4 { transition-delay: .26s; }

        /* ── Glass ── */
        .glass { background: rgba(255,255,255,.85); backdrop-filter: blur(14px); }

        /* ── Price ── */
        .price-tag { font-feature-settings:"tnum"; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

{{-- ════════════════════════════════ NAVBAR ════════════════════════════════ --}}
<nav x-data="{ open: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
     :class="scrolled ? 'shadow-md' : 'shadow-sm'"
     class="sticky top-0 z-50 glass border-b border-white/60 transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <div class="flex items-center gap-3">
                <a href="{{ route('marketplace.home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-105 transition-transform">
                        <span class="text-white font-black text-lg leading-none">L</span>
                    </div>
                    <div class="hidden sm:block">
                        <span class="font-black text-gray-900 text-lg leading-none">LocalMarket</span>
                        <span class="block text-[10px] font-semibold text-orange-500 leading-none tracking-widest uppercase">24hrs</span>
                    </div>
                </a>
                <div class="hidden md:flex items-center gap-1 ml-2 text-sm text-gray-400">
                    <span>/</span>
                    <a href="{{ route('marketplace.home') }}" class="hover:text-gray-700 ml-1 transition-colors">Inicio</a>
                    <span class="ml-1">/</span>
                    <span class="text-gray-600 font-medium ml-1 truncate max-w-[160px]">{{ $commerce->name }}</span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('marketplace.home') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Inicio
                </a>

                @auth
                    <a href="{{ route('marketplace.orders.index') }}"
                       class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Mis pedidos
                    </a>

                    <a href="{{ route('marketplace.conversations.index') }}"
                       class="relative p-2.5 rounded-xl text-gray-500 hover:text-orange-500 hover:bg-orange-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        @if(!empty($unreadBuyerChats) && $unreadBuyerChats > 0)
                            <span class="absolute -top-1.5 -right-1.5 flex">
                                <span class="animate-ping absolute inline-flex h-3.5 w-3.5 rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative min-w-[14px] h-3.5 px-0.5 rounded-full bg-orange-500 text-white text-[9px] font-bold flex items-center justify-center leading-none ring-2 ring-white">{{ $unreadBuyerChats > 9 ? '9+' : $unreadBuyerChats }}</span>
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('marketplace.cart.index') }}"
                       class="relative p-2.5 rounded-xl text-gray-500 hover:text-orange-500 hover:bg-orange-50 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        @if(!empty($cartItemCount) && $cartItemCount > 0)
                            <span class="absolute -top-1 -right-1 flex">
                                <span class="animate-ping absolute inline-flex h-4 w-4 rounded-full bg-orange-400 opacity-75"></span>
                                <span class="relative min-w-[16px] h-4 px-0.5 rounded-full bg-orange-500 text-white text-[9px] font-bold flex items-center justify-center leading-none ring-2 ring-white">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
                            </span>
                        @endif
                    </a>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-gray-100 transition-all">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('marketplace.orders.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Mis pedidos
                            </a>
                            <a href="{{ route('marketplace.conversations.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Mis chats
                            </a>
                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Cerrar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg shadow-orange-500/25 transition-all">
                        Regístrate
                    </a>
                @endauth
            </div>

            <button @click="open = !open" class="md:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1.5">
        @auth
            <a href="{{ route('marketplace.cart.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-orange-600 bg-orange-50">
                Carrito
                @if(!empty($cartItemCount) && $cartItemCount > 0)
                    <span class="ml-auto min-w-[18px] h-[18px] px-1 rounded-full bg-orange-600 text-white text-[10px] font-bold flex items-center justify-center leading-none">{{ $cartItemCount > 9 ? '9+' : $cartItemCount }}</span>
                @endif
            </a>
            <a href="{{ route('marketplace.orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">Mis pedidos</a>
            <a href="{{ route('marketplace.conversations.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">Mis chats</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-red-600 hover:bg-red-50">Cerrar sesión</button>
            </form>
        @else
            <a href="{{ route('login') }}"    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600">Regístrate gratis</a>
        @endauth
    </div>
</nav>

{{-- ════════════════════════════ HERO / BANNER ════════════════════════════ --}}
<section class="relative overflow-hidden">
    @if ($commerce->banner_url)
        <div class="h-64 sm:h-80 relative">
            <img src="{{ $commerce->banner_url }}" alt="{{ $commerce->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        </div>
    @else
        <div class="h-64 sm:h-80 bg-gradient-to-br from-orange-500 via-orange-600 to-amber-600 relative overflow-hidden">
            {{-- dot pattern --}}
            <div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle,#fff 1.5px,transparent 1.5px);background-size:28px 28px"></div>
            {{-- floating blobs --}}
            <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-amber-400/20 rounded-full blur-2xl"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-28 h-28 rounded-3xl bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center shadow-2xl">
                    <span class="text-white font-black text-5xl leading-none drop-shadow-sm">{{ strtoupper(substr($commerce->name, 0, 1)) }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- ── Commerce info card ── --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sr bg-white rounded-3xl shadow-xl border border-gray-100 -mt-14 relative z-10 p-6 sm:p-8">
            <div class="flex flex-col md:flex-row md:items-start gap-6">

                {{-- Avatar --}}
                <div class="shrink-0">
                    @if ($commerce->logo_url)
                        <img src="{{ $commerce->logo_url }}" alt="{{ $commerce->name }}"
                             class="w-20 h-20 rounded-2xl object-cover shadow-lg ring-4 ring-orange-100">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-orange-400 to-amber-500 flex items-center justify-center text-white font-black text-3xl shadow-lg shadow-orange-200 ring-4 ring-orange-100">
                            {{ strtoupper(substr($commerce->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-black text-gray-900">{{ $commerce->name }}</h1>
                            @if ($commerce->category)
                                <span class="inline-flex items-center gap-1.5 mt-1.5 px-3 py-1 rounded-full text-sm font-semibold text-orange-700 bg-orange-50 border border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                    {{ $commerce->category->name }}
                                </span>
                            @endif
                        </div>
                        @php $isOpen = $commerce->status === 'activo'; @endphp
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border shrink-0
                            {{ $isOpen ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-500 border-gray-200' }}">
                            <span class="w-2 h-2 rounded-full {{ $isOpen ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></span>
                            {{ $isOpen ? 'Abierto' : ucfirst($commerce->status) }}
                        </span>
                    </div>

                    @if ($commerce->description)
                        <p class="mt-3 text-gray-600 leading-relaxed max-w-2xl">{{ $commerce->description }}</p>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-5">
                        <div class="flex items-center gap-2.5 px-3 py-2.5 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Teléfono</p>
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $commerce->phone ?: 'No registrado' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 px-3 py-2.5 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Dirección</p>
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $commerce->address ?: 'No registrada' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 px-3 py-2.5 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide">Productos</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $products->total() }} disponibles</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions row --}}
            <div class="mt-6 pt-5 border-t border-gray-100 flex flex-wrap items-center gap-3">
                @auth
                    @if ($commerce->user_id !== auth()->id())
                        <form method="POST" action="{{ route('marketplace.conversations.start', $commerce) }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                Contactar comercio
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg shadow-orange-500/25 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Inicia sesión para contactar
                    </a>
                @endauth

                <a href="{{ route('marketplace.home') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═════════════════════════════════ ALERTS ══════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    @if (session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3.5 rounded-2xl text-sm font-medium">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-2xl text-sm font-medium">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif
</div>

{{-- ════════════════════════════════ PRODUCTS ═════════════════════════════ --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Section header --}}
    <div class="sr flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center shadow-md shadow-orange-500/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900">Productos disponibles</h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    @if ($products->total() > 0)
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                            {{ $products->total() }} {{ $products->total() === 1 ? 'producto' : 'productos' }} en stock
                        </span>
                    @else
                        Aún no hay productos publicados
                    @endif
                </p>
            </div>
        </div>

        @if ($products->total() > 0)
            <div class="flex items-center gap-2 px-3.5 py-2 bg-orange-50 border border-orange-100 rounded-xl">
                <svg class="w-4 h-4 text-orange-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <span class="text-sm font-semibold text-orange-700">{{ $commerce->category->name ?? 'General' }}</span>
            </div>
        @endif
    </div>

    @if ($products->count() > 0)
        {{-- ── Product grid ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($products as $i => $product)
                @php
                    $delay = ['d-1','d-2','d-3','d-4'][$i % 4];
                    $hasDiscount = $product->discount_percentage > 0;
                    $finalPrice  = $hasDiscount
                        ? $product->price * (1 - $product->discount_percentage / 100)
                        : $product->price;
                @endphp

                <div class="sr {{ $delay }} product-card group bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm">

                    {{-- Image area --}}
                    <div class="relative h-44 bg-gradient-to-br from-orange-50 to-amber-50 overflow-hidden">
                        @if ($product->image_url)
                            <img src="{{ $product->image_url }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-white/70 border border-orange-100 flex items-center justify-center shadow-sm">
                                    <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            </div>
                        @endif

                        {{-- Discount badge --}}
                        @if ($hasDiscount)
                            <div class="absolute top-2 left-2 bg-orange-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full shadow">
                                -{{ $product->discount_percentage == intval($product->discount_percentage) ? intval($product->discount_percentage) : $product->discount_percentage }}%
                            </div>
                        @endif

                        {{-- Out of stock overlay --}}
                        @if ($product->stock <= 0)
                            <div class="absolute inset-0 bg-gray-900/40 flex items-center justify-center">
                                <span class="bg-gray-800/80 text-white text-xs font-bold px-3 py-1.5 rounded-full">Sin stock</span>
                            </div>
                        @endif
                    </div>

                    {{-- Card body --}}
                    <div class="p-4 flex flex-col gap-3">

                        {{-- Name + description --}}
                        <div>
                            <h3 class="font-bold text-gray-900 leading-snug line-clamp-2 group-hover:text-orange-600 transition-colors text-sm">
                                {{ $product->name }}
                            </h3>
                            @if ($product->description)
                                <p class="text-xs text-gray-400 mt-1.5 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                            @endif
                        </div>

                        {{-- Price block --}}
                        <div class="flex items-end justify-between">
                            <div class="price-tag">
                                @if ($hasDiscount)
                                    <p class="text-xs text-gray-400 line-through leading-none">Q{{ number_format($product->price, 2) }}</p>
                                    <p class="text-2xl font-black text-green-600 leading-none mt-0.5">Q{{ number_format($finalPrice, 2) }}</p>
                                @else
                                    <p class="text-2xl font-black text-gray-900 leading-none">Q{{ number_format($product->price, 2) }}</p>
                                @endif
                            </div>
                            @if ($product->stock > 0)
                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-green-600 bg-green-50 border border-green-100 px-2 py-1 rounded-lg">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                                    {{ $product->stock }}
                                </span>
                            @endif
                        </div>

                        {{-- CTA button --}}
                        @if ($product->stock > 0)
                            @auth
                                <form method="POST" action="{{ route('marketplace.cart.add', $product) }}" class="mt-auto">
                                    @csrf
                                    <button type="submit"
                                            class="w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-sm shadow-orange-500/20 hover:shadow-md hover:shadow-orange-500/30 active:scale-95 transition-all duration-150 flex items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Agregar al carrito
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="mt-auto block text-center w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-orange-600 bg-orange-50 hover:bg-orange-100 border border-orange-200 transition-all">
                                    Inicia sesión para comprar
                                </a>
                            @endauth
                        @else
                            <button disabled
                                    class="mt-auto w-full py-2.5 px-4 rounded-xl text-sm font-semibold text-gray-400 bg-gray-100 cursor-not-allowed">
                                Sin stock
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="mt-12 sr">{{ $products->links() }}</div>
        @endif

    @else
        {{-- Empty state --}}
        <div class="sr text-center py-24">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-orange-100 to-amber-50 flex items-center justify-center mx-auto mb-6 border-2 border-dashed border-orange-200">
                <svg class="w-10 h-10 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="text-2xl font-black text-gray-900 mb-2">Sin productos aún</h3>
            <p class="text-gray-500 mb-8 max-w-sm mx-auto">Este comercio aún no ha publicado productos. Vuelve pronto.</p>
            <a href="{{ route('marketplace.home') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg shadow-orange-500/25 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Explorar otros comercios
            </a>
        </div>
    @endif

</main>

{{-- ════════════════════════ BACK TO TOP BUTTON ════════════════════════ --}}
<button id="btt" onclick="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 text-white shadow-xl shadow-orange-500/40 flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-200">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

<script>
    // ── Scroll reveal ──────────────────────────────────────────────────────
    const srObserver = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                srObserver.unobserve(e.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -48px 0px' });

    document.querySelectorAll('.sr').forEach(el => srObserver.observe(el));

    // ── Back to top visibility ──────────────────────────────────────────────
    const btt = document.getElementById('btt');
    window.addEventListener('scroll', () => {
        btt.classList.toggle('show', window.scrollY > 400);
    }, { passive: true });
</script>

</body>
</html>

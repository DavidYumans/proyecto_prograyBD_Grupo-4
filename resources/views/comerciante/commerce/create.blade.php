<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear comercio — LocalMarket 24hrs</title>
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

            {{-- Logo --}}
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
                <span class="text-orange-500 font-semibold">Crear comercio</span>
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('marketplace.home') }}"
                   class="hidden sm:flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Volver
                </a>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl border border-gray-200 bg-white">
                    <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 max-w-[100px] truncate hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════════ HERO HEADER ══════════════ --}}
<div class="relative overflow-hidden bg-gradient-to-br from-orange-50 via-amber-50/40 to-white border-b border-gray-100">
    <div class="absolute inset-0 opacity-[0.04]" style="background-image:radial-gradient(circle,#f97316 1.5px,transparent 1.5px);background-size:28px 28px"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-orange-100/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center shadow-xl shadow-orange-500/30 animate-fade-in shrink-0">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="animate-fade-in-up">
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                    Crea tu <span class="gradient-text">comercio</span>
                </h1>
                <p class="text-gray-500 mt-1.5">Registra tu negocio en LocalMarket 24hrs y empieza a vender hoy.</p>
            </div>
        </div>

        {{-- Steps indicator --}}
        <div class="mt-8 flex items-center gap-3 animate-fade-in-up" style="animation-delay:0.1s">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-orange-500 flex items-center justify-center text-white text-xs font-bold shadow-lg shadow-orange-500/30">1</div>
                <span class="text-sm font-semibold text-orange-600">Datos del negocio</span>
            </div>
            <div class="w-12 h-0.5 bg-gray-200 rounded-full"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-xs font-bold">2</div>
                <span class="text-sm text-gray-400">Productos</span>
            </div>
            <div class="w-12 h-0.5 bg-gray-200 rounded-full"></div>
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-xs font-bold">3</div>
                <span class="text-sm text-gray-400">¡Listo para vender!</span>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════ MAIN CONTENT ══════════════ --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
      x-data="{
        name: '{{ old('name') }}',
        description: '{{ old('description') }}',
        category: '{{ old('category_id') ? $categories->firstWhere('id', old('category_id'))?->name : '' }}',
        address: '{{ old('address') }}',
        phone: '{{ old('phone') }}',
        logoUrl: null,
        bannerUrl: null,
        handleLogo(e) {
          const file = e.target.files[0];
          this.logoUrl = file ? URL.createObjectURL(file) : null;
        },
        handleBanner(e) {
          const file = e.target.files[0];
          this.bannerUrl = file ? URL.createObjectURL(file) : null;
        }
      }">

    <div class="grid lg:grid-cols-5 gap-8 items-start">

        {{-- ── FORM (3 cols) ────────────────────────────────── --}}
        <div class="lg:col-span-3 space-y-6">

            {{-- Errores globales --}}
            @if ($errors->any())
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-red-50 border border-red-200 animate-fade-in">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-700 mb-1">Por favor corrige los siguientes errores:</p>
                        <ul class="text-sm text-red-600 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>· {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Card 1: Información básica --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden reveal">
                <div class="px-7 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-orange-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900">Información básica</h2>
                        <p class="text-xs text-gray-400">Nombre, categoría y descripción de tu negocio</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('comerciante.commerce.store') }}" enctype="multipart/form-data" class="p-7 space-y-6" id="commerce-form">
                    @csrf

                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Logo del comercio
                            <span class="ml-1 text-xs font-normal text-gray-400">(opcional · JPG, PNG o WebP · máx. 2 MB)</span>
                        </label>
                        <div class="flex items-center gap-5">
                            {{-- Preview circle --}}
                            <div class="shrink-0 w-20 h-20 rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center transition-all duration-300"
                                 :class="logoUrl ? 'border-orange-300 bg-white' : 'border-gray-200 bg-gray-50'">
                                <img x-show="logoUrl" :src="logoUrl" alt="Logo preview"
                                     class="w-full h-full object-cover">
                                <svg x-show="!logoUrl" class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            {{-- Drop zone / button --}}
                            <div class="flex-1">
                                <label for="logo"
                                       class="flex flex-col items-center justify-center w-full py-5 rounded-xl border-2 border-dashed cursor-pointer transition-all duration-200"
                                       :class="logoUrl ? 'border-orange-300 bg-orange-50/50' : 'border-gray-200 bg-gray-50 hover:border-orange-300 hover:bg-orange-50/30'">
                                    <svg class="w-6 h-6 mb-1.5 transition-colors" :class="logoUrl ? 'text-orange-400' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <span class="text-sm font-semibold transition-colors" :class="logoUrl ? 'text-orange-600' : 'text-gray-600'">
                                        <span x-show="!logoUrl">Seleccionar imagen</span>
                                        <span x-show="logoUrl">Cambiar imagen</span>
                                    </span>
                                    <span class="text-xs text-gray-400 mt-0.5">o arrastra y suelta aquí</span>
                                    <input id="logo" name="logo" type="file"
                                           accept="image/jpg,image/jpeg,image/png,image/webp"
                                           class="hidden"
                                           @change="handleLogo($event)">
                                </label>
                            </div>
                        </div>
                        @error('logo')
                            <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Banner --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Banner del comercio
                            <span class="ml-1 text-xs font-normal text-gray-400">(opcional · JPG, PNG o WebP · máx. 4 MB · recomendado 1200×400 px)</span>
                        </label>

                        {{-- Preview wide --}}
                        <div class="w-full h-32 rounded-xl border-2 border-dashed overflow-hidden mb-3 flex items-center justify-center transition-all duration-300 relative"
                             :class="bannerUrl ? 'border-orange-300 bg-white' : 'border-gray-200 bg-gray-50'">
                            <img x-show="bannerUrl" :src="bannerUrl" alt="Banner preview"
                                 class="w-full h-full object-cover">
                            <div x-show="!bannerUrl" class="text-center">
                                <svg class="w-10 h-10 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-xs text-gray-400 mt-1">Vista previa del banner</p>
                            </div>
                        </div>

                        <label for="banner"
                               class="flex items-center justify-center gap-3 w-full py-3.5 rounded-xl border-2 border-dashed cursor-pointer transition-all duration-200"
                               :class="bannerUrl ? 'border-orange-300 bg-orange-50/50' : 'border-gray-200 bg-gray-50 hover:border-orange-300 hover:bg-orange-50/30'">
                            <svg class="w-5 h-5 transition-colors" :class="bannerUrl ? 'text-orange-400' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span class="text-sm font-semibold transition-colors" :class="bannerUrl ? 'text-orange-600' : 'text-gray-600'">
                                <span x-show="!bannerUrl">Seleccionar banner</span>
                                <span x-show="bannerUrl">Cambiar banner</span>
                            </span>
                            <span class="text-xs text-gray-400">o arrastra y suelta aquí</span>
                            <input id="banner" name="banner" type="file"
                                   accept="image/jpg,image/jpeg,image/png,image/webp"
                                   class="hidden"
                                   @change="handleBanner($event)">
                        </label>
                        @error('banner')
                            <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nombre del comercio <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <input type="text" id="name" name="name"
                                   x-model="name"
                                   value="{{ old('name') }}"
                                   placeholder="Ej: Panadería La Esperanza, Tech Store..."
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border-2 {{ $errors->has('name') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }} bg-white text-gray-900 placeholder-gray-400 transition-all duration-200 focus:ring-4 focus:outline-none hover:border-gray-300">
                        </div>
                        @error('name')
                            <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <select id="category_id" name="category_id"
                                    @change="category = $event.target.options[$event.target.selectedIndex].text"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-2 {{ $errors->has('category_id') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }} bg-white text-gray-900 transition-all duration-200 focus:ring-4 focus:outline-none hover:border-gray-300 appearance-none cursor-pointer">
                                <option value="">— Selecciona una categoría —</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                        @if($categories->isEmpty())
                            <p class="mt-2 text-xs text-amber-600 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                Aún no hay categorías. El administrador debe crear algunas primero.
                            </p>
                        @endif
                        @error('category_id')
                            <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="description" class="block text-sm font-semibold text-gray-700">Descripción</label>
                            <span class="text-xs text-gray-400" x-text="(description || '').length + ' caracteres'"></span>
                        </div>
                        <div class="relative">
                            <div class="absolute top-3.5 left-0 pl-3.5 flex items-start pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10"/></svg>
                            </div>
                            <textarea id="description" name="description" rows="4"
                                      x-model="description"
                                      placeholder="Cuéntales a tus clientes qué ofreces, cuáles son tus especialidades, horarios especiales..."
                                      class="w-full pl-11 pr-4 py-3 rounded-xl border-2 {{ $errors->has('description') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }} bg-white text-gray-900 placeholder-gray-400 transition-all duration-200 focus:ring-4 focus:outline-none hover:border-gray-300 resize-none">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </form>
            </div>

            {{-- Card 2: Contacto y ubicación --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden reveal stagger-2">
                <div class="px-7 py-5 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-900">Contacto y ubicación</h2>
                        <p class="text-xs text-gray-400">Dirección y teléfono de tu negocio</p>
                    </div>
                </div>

                <div class="p-7">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Dirección --}}
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Dirección
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                                <input type="text" id="address" name="address"
                                       x-model="address"
                                       value="{{ old('address') }}"
                                       placeholder="Ej: Calle 5 #12-34, Zona 1"
                                       class="w-full pl-11 pr-4 py-3 rounded-xl border-2 {{ $errors->has('address') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }} bg-white text-gray-900 placeholder-gray-400 transition-all duration-200 focus:ring-4 focus:outline-none hover:border-gray-300">
                            </div>
                            @error('address')
                                <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Teléfono / WhatsApp
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <input type="text" id="phone" name="phone"
                                       x-model="phone"
                                       value="{{ old('phone') }}"
                                       placeholder="Ej: +502 5555-5555"
                                       class="w-full pl-11 pr-4 py-3 rounded-xl border-2 {{ $errors->has('phone') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }} bg-white text-gray-900 placeholder-gray-400 transition-all duration-200 focus:ring-4 focus:outline-none hover:border-gray-300">
                            </div>
                            @error('phone')
                                <p class="mt-2 flex items-center gap-1.5 text-sm text-red-600">
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aviso de rol --}}
            <div class="flex items-start gap-3 p-5 rounded-2xl bg-amber-50 border border-amber-200 reveal stagger-3">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-amber-700">
                    <span class="font-semibold">¡Importante!</span> Al crear tu comercio, tu cuenta cambiará automáticamente al rol de <strong>comerciante</strong>, lo que te dará acceso al panel de administración de tu negocio.
                </p>
            </div>

            {{-- Botones --}}
            <div class="flex items-center gap-4 reveal stagger-4">
                <button type="submit" form="commerce-form"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl text-base font-semibold text-white
                               bg-gradient-to-r from-orange-500 to-orange-600
                               hover:from-orange-600 hover:to-orange-700 active:scale-[0.98]
                               shadow-xl shadow-orange-500/30 hover:shadow-orange-500/40
                               focus:outline-none focus:ring-4 focus:ring-orange-500/30
                               transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Crear mi comercio
                </button>

                <a href="{{ route('marketplace.home') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl text-sm font-semibold
                          text-gray-600 bg-white border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50
                          transition-all duration-200">
                    Cancelar
                </a>
            </div>
        </div>

        {{-- ── SIDEBAR (2 cols) ──────────────────────────────── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Live preview card --}}
            <div class="sticky top-24 space-y-6">
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden reveal-right">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-semibold text-gray-700">Vista previa en tiempo real</span>
                    </div>

                    {{-- Preview card --}}
                    <div class="p-5">
                        <p class="text-xs text-gray-400 mb-4">Así verán tu comercio los compradores en el marketplace:</p>

                        <div class="rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden transition-all duration-300"
                             :class="name ? 'border-orange-200' : 'border-gray-200'">
                            {{-- Banner --}}
                            <div class="h-32 bg-gradient-to-br from-orange-50 via-amber-50 to-orange-100 flex items-center justify-center relative overflow-hidden">
                                <img x-show="bannerUrl" :src="bannerUrl" alt="Banner" class="absolute inset-0 w-full h-full object-cover">
                                <div x-show="!bannerUrl" class="text-center">
                                    <svg class="w-10 h-10 text-orange-200 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-xs text-orange-300 mt-1">Banner del comercio</p>
                                </div>
                                {{-- Category badge --}}
                                <div class="absolute top-2 left-2" x-show="category && category !== '— Selecciona una categoría —'">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-white/90 text-gray-700 shadow-sm" x-text="category"></span>
                                </div>
                            </div>

                            {{-- Card body --}}
                            <div class="p-4">
                                <div class="flex items-start gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden shadow-md shrink-0 transition-all duration-300 bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center">
                                        <img x-show="logoUrl" :src="logoUrl" alt="Logo" class="w-full h-full object-cover">
                                        <span x-show="!logoUrl" class="text-white font-black text-base" x-text="name ? name.charAt(0).toUpperCase() : '?'"></span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-bold text-gray-900 text-sm leading-tight truncate transition-all duration-200"
                                            x-text="name || 'Nombre de tu comercio'">
                                        </h4>
                                        <p class="text-xs text-gray-400 mt-0.5 transition-all duration-200"
                                           x-text="(category && category !== '— Selecciona una categoría —') ? category : 'Sin categoría'">
                                        </p>
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-3 min-h-[2.5rem] transition-all duration-200"
                                   x-text="description || 'La descripción de tu comercio aparecerá aquí...'">
                                </p>

                                <div x-show="address || phone" class="flex flex-col gap-1 mb-3">
                                    <div x-show="address" class="flex items-center gap-1.5 text-xs text-gray-400">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        <span x-text="address" class="truncate"></span>
                                    </div>
                                    <div x-show="phone" class="flex items-center gap-1.5 text-xs text-gray-400">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        <span x-text="phone" class="truncate"></span>
                                    </div>
                                </div>

                                <div class="h-8 rounded-lg flex items-center justify-center transition-all duration-300"
                                     :class="name ? 'bg-gradient-to-r from-orange-500 to-orange-600' : 'bg-gray-100'">
                                    <span class="text-xs font-semibold transition-colors duration-300"
                                          :class="name ? 'text-white' : 'text-gray-400'">
                                        Ver comercio →
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tips card --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 reveal-right stagger-2">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="text-lg">💡</span> Consejos para destacar
                    </h3>
                    <ul class="space-y-3">
                        @php
                            $tips = [
                                ['icon'=>'✍️','text'=>'Usa un nombre claro y fácil de recordar.'],
                                ['icon'=>'📝','text'=>'Una buena descripción genera más visitas.'],
                                ['icon'=>'📸','text'=>'Un banner atractivo genera más confianza y visitas.'],
                                ['icon'=>'📞','text'=>'El teléfono ayuda a los clientes a contactarte directamente.'],
                                ['icon'=>'📍','text'=>'La dirección aumenta la confianza del comprador.'],
                            ];
                        @endphp
                        @foreach($tips as $tip)
                            <li class="flex items-start gap-2.5 text-sm text-gray-500">
                                <span class="shrink-0 text-base leading-snug">{{ $tip['icon'] }}</span>
                                <span>{{ $tip['text'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- What happens next --}}
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white reveal-right stagger-3">
                    <h3 class="font-bold mb-4 flex items-center gap-2">
                        <span class="text-lg">🚀</span> ¿Qué pasa después?
                    </h3>
                    <ul class="space-y-3">
                        @php $nexts = [
                            ['num'=>'1','text'=>'Tu comercio aparecerá en el marketplace.'],
                            ['num'=>'2','text'=>'Podrás agregar productos desde tu panel.'],
                            ['num'=>'3','text'=>'Los compradores podrán ver y comprar tus productos.'],
                            ['num'=>'4','text'=>'Recibirás pedidos y podrás gestionarlos fácilmente.'],
                        ]; @endphp
                        @foreach($nexts as $n)
                            <li class="flex items-start gap-3">
                                <span class="w-5 h-5 rounded-full bg-orange-500 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">{{ $n['num'] }}</span>
                                <span class="text-sm text-slate-300">{{ $n['text'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>

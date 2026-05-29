<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar tienda — LocalMarket 24hrs</title>
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
            <a href="{{ route('comerciante.dashboard') }}" class="flex items-center gap-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center shadow-md shadow-orange-500/30 group-hover:scale-105 transition-transform duration-200">
                    <span class="text-white font-black text-sm">L</span>
                </div>
                <span class="font-extrabold text-gray-900 text-lg leading-none">
                    Local<span class="text-orange-500">Market</span>
                    <span class="text-xs font-medium text-gray-400 ml-0.5">24hrs</span>
                </span>
            </a>

            <div class="hidden sm:flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('comerciante.dashboard') }}" class="hover:text-gray-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-orange-500 font-semibold">Editar tienda</span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('comerciante.dashboard') }}"
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

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 flex items-center justify-center shadow-xl shadow-orange-500/30 shrink-0">
                @if ($commerce->logo_url)
                    <img src="{{ $commerce->logo_url }}" alt="{{ $commerce->name }}" class="w-full h-full object-cover rounded-2xl">
                @else
                    <span class="text-white font-black text-2xl">{{ strtoupper(substr($commerce->name, 0, 1)) }}</span>
                @endif
            </div>
            <div>
                <h1 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                    Editar <span class="gradient-text">{{ $commerce->name }}</span>
                </h1>
                <p class="text-gray-500 mt-1.5">Actualiza la información, imágenes y contacto de tu tienda.</p>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════ MAIN CONTENT ══════════════ --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
      x-data="{
        name: '{{ addslashes(old('name', $commerce->name)) }}',
        description: '{{ addslashes(old('description', $commerce->description ?? '')) }}',
        logoUrl: {{ $commerce->logo_url ? '\''.e($commerce->logo_url).'\'' : 'null' }},
        bannerUrl: {{ $commerce->banner_url ? '\''.e($commerce->banner_url).'\'' : 'null' }},
        handleLogo(e) {
          const file = e.target.files[0];
          this.logoUrl = file ? URL.createObjectURL(file) : this.logoUrl;
        },
        handleBanner(e) {
          const file = e.target.files[0];
          this.bannerUrl = file ? URL.createObjectURL(file) : this.bannerUrl;
        }
      }">

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 p-4 rounded-2xl bg-green-50 border border-green-200 animate-fade-in">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-semibold text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid lg:grid-cols-5 gap-8 items-start">

        {{-- ── FORM (3 cols) ────────────────────────────────── --}}
        <div class="lg:col-span-3 space-y-6">

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

                <form method="POST" action="{{ route('comerciante.commerce.update') }}" enctype="multipart/form-data" class="p-7 space-y-6" id="commerce-form">
                    @csrf
                    @method('PUT')

                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Logo del comercio
                            <span class="ml-1 text-xs font-normal text-gray-400">(opcional · JPG, PNG o WebP · máx. 2 MB)</span>
                        </label>
                        <div class="flex items-center gap-5">
                            <div class="shrink-0 w-20 h-20 rounded-2xl border-2 border-dashed overflow-hidden bg-gray-50 flex items-center justify-center transition-all duration-300"
                                 :class="logoUrl ? 'border-orange-300 bg-white' : 'border-gray-200'">
                                <img x-show="logoUrl" :src="logoUrl" alt="Logo" class="w-full h-full object-cover">
                                <svg x-show="!logoUrl" class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label for="logo"
                                       class="flex flex-col items-center justify-center w-full py-5 rounded-xl border-2 border-dashed cursor-pointer transition-all duration-200"
                                       :class="logoUrl ? 'border-orange-300 bg-orange-50/50' : 'border-gray-200 bg-gray-50 hover:border-orange-300 hover:bg-orange-50/30'">
                                    <svg class="w-6 h-6 mb-1.5" :class="logoUrl ? 'text-orange-400' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <span class="text-sm font-semibold" :class="logoUrl ? 'text-orange-600' : 'text-gray-600'">
                                        <span x-show="!logoUrl">Seleccionar imagen</span>
                                        <span x-show="logoUrl">Cambiar imagen</span>
                                    </span>
                                    <span class="text-xs text-gray-400 mt-0.5">o arrastra y suelta aquí</span>
                                    <input id="logo" name="logo" type="file" accept="image/jpg,image/jpeg,image/png,image/webp" class="hidden" @change="handleLogo($event)">
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
                            Banner (imagen de portada)
                            <span class="ml-1 text-xs font-normal text-gray-400">(opcional · JPG, PNG o WebP · máx. 4 MB)</span>
                        </label>
                        <div class="rounded-2xl border-2 border-dashed cursor-pointer overflow-hidden transition-all duration-200"
                             :class="bannerUrl ? 'border-orange-300' : 'border-gray-200 hover:border-orange-300'">
                            <label for="banner" class="cursor-pointer block">
                                <div x-show="bannerUrl" class="relative h-36">
                                    <img :src="bannerUrl" alt="Banner" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                                        <span class="text-white text-sm font-semibold">Cambiar banner</span>
                                    </div>
                                </div>
                                <div x-show="!bannerUrl" class="py-8 flex flex-col items-center bg-gray-50">
                                    <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-500">Subir banner de portada</span>
                                    <span class="text-xs text-gray-400 mt-0.5">Recomendado: 1200 × 400 px</span>
                                </div>
                                <input id="banner" name="banner" type="file" accept="image/jpg,image/jpeg,image/png,image/webp" class="hidden" @change="handleBanner($event)">
                            </label>
                        </div>
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
                                   placeholder="Nombre de tu comercio"
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
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-2 {{ $errors->has('category_id') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }} bg-white text-gray-900 transition-all duration-200 focus:ring-4 focus:outline-none hover:border-gray-300 appearance-none cursor-pointer">
                                <option value="">— Selecciona una categoría —</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $commerce->category_id)) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
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
                            <span class="text-xs text-gray-400" x-text="(description || '').length + ' / 500'"></span>
                        </div>
                        <div class="relative">
                            <div class="absolute top-3.5 left-0 pl-3.5 flex items-start pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10"/></svg>
                            </div>
                            <textarea id="description" name="description" rows="4"
                                      x-model="description"
                                      placeholder="Cuéntales a tus clientes qué ofreces..."
                                      class="w-full pl-11 pr-4 py-3 rounded-xl border-2 {{ $errors->has('description') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }} bg-white text-gray-900 placeholder-gray-400 transition-all duration-200 focus:ring-4 focus:outline-none hover:border-gray-300 resize-none">{{ old('description', $commerce->description) }}</textarea>
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
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-1.5">Dirección</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                </div>
                                <input type="text" id="address" name="address" form="commerce-form"
                                       value="{{ old('address', $commerce->address) }}"
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

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1.5">Teléfono / WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <input type="text" id="phone" name="phone" form="commerce-form"
                                       value="{{ old('phone', $commerce->phone) }}"
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

            {{-- Botones --}}
            <div class="flex items-center gap-4 reveal stagger-3">
                <button type="submit" form="commerce-form"
                        class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-2xl text-base font-semibold text-white
                               bg-gradient-to-r from-orange-500 to-orange-600
                               hover:from-orange-600 hover:to-orange-700 active:scale-[0.98]
                               shadow-xl shadow-orange-500/30 hover:shadow-orange-500/40
                               focus:outline-none focus:ring-4 focus:ring-orange-500/30
                               transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Guardar cambios
                </button>
                <a href="{{ route('comerciante.dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl text-sm font-semibold text-gray-600 bg-white border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all duration-200">
                    Cancelar
                </a>
            </div>
        </div>

        {{-- ── SIDEBAR (2 cols) ──────────────────────────────── --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="sticky top-24 space-y-6">

                {{-- Current state card --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden reveal-right">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <div class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-semibold text-gray-700">Estado actual de tu tienda</span>
                    </div>
                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Estado</span>
                            @if ($commerce->isActivo())
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>Activo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>{{ ucfirst($commerce->status) }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Categoría actual</span>
                            <span class="font-semibold text-gray-900">{{ $commerce->category->name ?? '—' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Productos</span>
                            <span class="font-semibold text-gray-900">{{ $commerce->products()->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Repartidores</span>
                            <span class="font-semibold text-gray-900">{{ $commerce->repartidores()->count() }}</span>
                        </div>
                        <div class="pt-2 border-t border-gray-100">
                            <a href="{{ route('comerciante.repartidores.index') }}"
                               class="flex items-center justify-between text-sm text-orange-600 hover:text-orange-700 font-semibold transition-colors">
                                Gestionar repartidores
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tips --}}
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 reveal-right stagger-2">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="text-lg">💡</span> Consejos
                    </h3>
                    <ul class="space-y-3">
                        @php
                            $tips = [
                                ['icon'=>'📸','text'=>'Un banner atractivo aumenta la tasa de visitas hasta un 40%.'],
                                ['icon'=>'📝','text'=>'Una descripción detallada genera más confianza.'],
                                ['icon'=>'📞','text'=>'El teléfono permite contacto directo con clientes.'],
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

                {{-- Quick links --}}
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 text-white reveal-right stagger-3">
                    <h3 class="font-bold mb-4">Accesos rápidos</h3>
                    <div class="space-y-2">
                        @php $links = [
                            ['route'=>'comerciante.products.index','label'=>'Mis productos','icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                            ['route'=>'comerciante.coupons.index','label'=>'Cupones','icon'=>'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
                            ['route'=>'comerciante.orders.index','label'=>'Pedidos','icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                            ['route'=>'comerciante.repartidores.index','label'=>'Repartidores','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ]; @endphp
                        @foreach($links as $link)
                            <a href="{{ route($link['route']) }}"
                               class="flex items-center gap-3 px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 transition-colors group">
                                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $link['icon'] }}"/></svg>
                                <span class="text-sm text-slate-300 group-hover:text-white transition-colors">{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>

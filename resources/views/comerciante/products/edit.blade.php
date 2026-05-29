<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar producto — LocalMarket 24hrs</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass { background: rgba(255,255,255,.85); backdrop-filter: blur(14px); }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

{{-- ════════════════════ NAVBAR ════════════════════ --}}
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
                    <a href="{{ route('comerciante.dashboard') }}" class="hover:text-gray-700 ml-1 transition-colors">Panel</a>
                    <span class="ml-1">/</span>
                    <a href="{{ route('comerciante.products.index') }}" class="hover:text-gray-700 ml-1 transition-colors">Mis productos</a>
                    <span class="ml-1">/</span>
                    <span class="text-gray-600 font-medium ml-1">Editar</span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('comerciante.products.index') }}"
                   class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Volver
                </a>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-gray-100 transition-all">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                        <div class="px-4 py-2 border-b border-gray-100 mb-1">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('comerciante.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Panel
                        </a>
                        <div class="border-t border-gray-100 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="open = !open" class="md:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden':open,'inline-flex':!open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden':!open,'inline-flex':open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    <div :class="{'block':open,'hidden':!open}" class="hidden md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1.5">
        <a href="{{ route('comerciante.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">Panel</a>
        <a href="{{ route('comerciante.products.index') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-gray-700 hover:bg-gray-100">← Volver a productos</a>
    </div>
</nav>

{{-- ════════════════════ HERO ════════════════════ --}}
<section class="bg-gradient-to-br from-slate-900 via-slate-800 to-gray-900 text-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-orange-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-amber-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/4 pointer-events-none"></div>
    <div class="absolute inset-0 opacity-[0.04]" style="background-image:radial-gradient(circle,#fff 1.5px,transparent 1.5px);background-size:28px 28px"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur rounded-full border border-white/20 text-xs font-semibold text-orange-300 mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editando producto
        </div>
        <h1 class="text-3xl sm:text-4xl font-black leading-tight">
            Editar <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-400">producto</span>
        </h1>
        <p class="text-slate-400 mt-2 text-sm">Actualiza los datos del producto en tu catálogo.</p>
    </div>

    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 36" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
            <path d="M0 36L60 30.8C120 25.6 240 15.2 360 12C480 8.8 600 11.2 720 14.8C840 18.4 960 23.6 1080 24.4C1200 25.2 1320 21.6 1380 19.8L1440 18V36H0Z" fill="rgb(249,250,251)"/>
        </svg>
    </div>
</section>

{{-- ════════════════════ FORM ════════════════════ --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-16"
      x-data="{
          name: '{{ addslashes(old('name', $product->name)) }}',
          price: '{{ old('price', $product->price) }}',
          stock: '{{ old('stock', $product->stock) }}',
          discount: '{{ old('discount_percentage', $product->discount_percentage) }}',
          status: '{{ old('status', $product->status) }}',
          imagePreview: {{ $product->image_url ? '\''.e($product->image_url).'\'' : 'null' }},
          imageChanged: false,

          get finalPrice() {
              const p = parseFloat(this.price) || 0;
              const d = parseFloat(this.discount) || 0;
              if (d > 0) return (p * (1 - d / 100)).toFixed(2);
              return p > 0 ? p.toFixed(2) : null;
          },
          get hasDiscount() {
              return parseFloat(this.discount) > 0 && parseFloat(this.price) > 0;
          },
          get stockLabel() {
              const s = parseInt(this.stock);
              if (s <= 0) return { text: 'Sin stock', cls: 'bg-red-100 text-red-700' };
              if (s <= 5) return { text: 'Bajo stock (' + s + ')', cls: 'bg-yellow-100 text-yellow-700' };
              return { text: 'En stock (' + s + ')', cls: 'bg-green-100 text-green-700' };
          },

          handleImage(e) {
              const file = e.target.files[0];
              if (!file) return;
              this.imageChanged = true;
              const reader = new FileReader();
              reader.onload = (ev) => { this.imagePreview = ev.target.result; };
              reader.readAsDataURL(file);
          },
          clearImage() {
              this.imagePreview = null;
              this.imageChanged = true;
              const input = document.getElementById('image');
              if (input) input.value = '';
          }
      }">

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 flex gap-3 items-start">
            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-semibold text-red-700">Corrige los siguientes errores:</p>
                <ul class="mt-1 text-sm text-red-600 list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ── FORM ── --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <form method="POST"
                      action="{{ route('comerciante.products.update', $product) }}"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nombre del producto <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   x-model="name"
                                   maxlength="150"
                                   class="w-full pl-10 pr-4 py-2.5 border-2 rounded-xl text-sm transition-colors
                                          {{ $errors->has('name') ? 'border-red-400 focus:border-red-500' : 'border-gray-200 focus:border-orange-500' }}
                                          focus:outline-none focus:ring-0">
                        </div>
                        @error('name')
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Descripción <span class="text-gray-400 font-normal">(opcional)</span>
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="3"
                                  maxlength="500"
                                  placeholder="Describe el producto: materiales, tallas, características..."
                                  class="w-full px-4 py-2.5 border-2 rounded-xl text-sm transition-colors resize-none
                                         {{ $errors->has('description') ? 'border-red-400 focus:border-red-500' : 'border-gray-200 focus:border-orange-500' }}
                                         focus:outline-none focus:ring-0">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Imagen --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Imagen <span class="text-gray-400 font-normal">(opcional)</span>
                        </label>
                        <div class="relative">
                            <label for="image"
                                   class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-xl cursor-pointer transition-colors
                                          {{ $errors->has('image') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 hover:border-orange-400 hover:bg-orange-50' }}">
                                <template x-if="!imagePreview">
                                    <div class="flex flex-col items-center gap-2 text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-sm font-medium">Haz clic para subir una nueva imagen</span>
                                        <span class="text-xs">JPG, PNG o WEBP · Máx. 2 MB</span>
                                    </div>
                                </template>
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" class="h-full w-full object-contain rounded-xl p-1" alt="Vista previa">
                                </template>
                                <input type="file"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       class="hidden"
                                       @change="handleImage($event)">
                            </label>
                            <template x-if="imagePreview">
                                <button type="button"
                                        @click="clearImage()"
                                        class="absolute top-2 right-2 w-7 h-7 bg-white rounded-full shadow border border-gray-200 flex items-center justify-center text-gray-500 hover:text-red-500 hover:border-red-300 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </template>
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5">Si subes una nueva imagen, reemplazará la anterior.</p>
                        @error('image')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Precio / Stock / Descuento --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Precio <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold text-sm">Q</span>
                                </div>
                                <input type="number"
                                       id="price"
                                       name="price"
                                       x-model="price"
                                       step="0.01"
                                       min="0.01"
                                       class="w-full pl-8 pr-3 py-2.5 border-2 rounded-xl text-sm transition-colors
                                              {{ $errors->has('price') ? 'border-red-400 focus:border-red-500' : 'border-gray-200 focus:border-orange-500' }}
                                              focus:outline-none focus:ring-0">
                            </div>
                            @error('price')
                                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Stock <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <input type="number"
                                       id="stock"
                                       name="stock"
                                       x-model="stock"
                                       min="0"
                                       class="w-full pl-10 pr-3 py-2.5 border-2 rounded-xl text-sm transition-colors
                                              {{ $errors->has('stock') ? 'border-red-400 focus:border-red-500' : 'border-gray-200 focus:border-orange-500' }}
                                              focus:outline-none focus:ring-0">
                            </div>
                            @error('stock')
                                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_percentage" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Descuento
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M17 17h.01M5.636 5.636l12.728 12.728M5.636 18.364L18.364 5.636"/></svg>
                                </div>
                                <input type="number"
                                       id="discount_percentage"
                                       name="discount_percentage"
                                       x-model="discount"
                                       step="0.01"
                                       min="0"
                                       max="100"
                                       class="w-full pl-10 pr-8 py-2.5 border-2 rounded-xl text-sm transition-colors
                                              {{ $errors->has('discount_percentage') ? 'border-red-400 focus:border-red-500' : 'border-gray-200 focus:border-orange-500' }}
                                              focus:outline-none focus:ring-0">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm font-medium">%</span>
                                </div>
                            </div>
                            @error('discount_percentage')
                                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label :class="status === 'activo'
                                       ? 'border-green-500 bg-green-50 ring-1 ring-green-500'
                                       : 'border-gray-200 bg-white hover:border-gray-300'"
                                   class="flex items-center gap-3 p-3.5 border-2 rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="status" value="activo" x-model="status" class="hidden">
                                <div :class="status === 'activo' ? 'bg-green-500' : 'bg-gray-200'"
                                     class="w-4 h-4 rounded-full flex items-center justify-center transition-colors shrink-0">
                                    <div x-show="status === 'activo'" class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                </div>
                                <div>
                                    <p :class="status === 'activo' ? 'text-green-700' : 'text-gray-600'"
                                       class="text-sm font-semibold">Activo</p>
                                    <p class="text-xs text-gray-400">Visible en el catálogo</p>
                                </div>
                            </label>
                            <label :class="status === 'inactivo'
                                       ? 'border-gray-400 bg-gray-50 ring-1 ring-gray-400'
                                       : 'border-gray-200 bg-white hover:border-gray-300'"
                                   class="flex items-center gap-3 p-3.5 border-2 rounded-xl cursor-pointer transition-all">
                                <input type="radio" name="status" value="inactivo" x-model="status" class="hidden">
                                <div :class="status === 'inactivo' ? 'bg-gray-500' : 'bg-gray-200'"
                                     class="w-4 h-4 rounded-full flex items-center justify-center transition-colors shrink-0">
                                    <div x-show="status === 'inactivo'" class="w-1.5 h-1.5 bg-white rounded-full"></div>
                                </div>
                                <div>
                                    <p :class="status === 'inactivo' ? 'text-gray-700' : 'text-gray-600'"
                                       class="text-sm font-semibold">Inactivo</p>
                                    <p class="text-xs text-gray-400">Oculto del catálogo</p>
                                </div>
                            </label>
                        </div>
                        @error('status')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                                class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white text-sm font-semibold rounded-xl shadow-md shadow-orange-500/25 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Guardar cambios
                        </button>
                        <a href="{{ route('comerciante.products.index') }}"
                           class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition-all">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="lg:col-span-5">
            <div class="sticky top-24 space-y-4">

                {{-- Preview card --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Vista previa</p>

                    <div :class="status === 'activo' ? 'border-gray-100' : 'border-gray-200 opacity-60'"
                         class="border rounded-2xl overflow-hidden transition-all">

                        <div class="relative bg-gradient-to-br from-orange-50 to-amber-50 h-32 flex items-center justify-center overflow-hidden">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="w-full h-full object-cover" alt="Vista previa">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="w-14 h-14 rounded-2xl bg-white shadow-sm border border-orange-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            </template>

                            <template x-if="hasDiscount">
                                <div class="absolute top-2 right-2 bg-orange-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full">
                                    -<span x-text="parseFloat(discount)"></span>%
                                </div>
                            </template>

                            <template x-if="status === 'inactivo'">
                                <div class="absolute inset-0 bg-gray-900/30 flex items-center justify-center rounded-t-2xl">
                                    <span class="text-white text-xs font-bold bg-gray-700/80 px-2 py-0.5 rounded-full">Inactivo</span>
                                </div>
                            </template>
                        </div>

                        <div class="p-3.5">
                            <p class="text-sm font-bold text-gray-900 leading-snug truncate"
                               x-text="name || 'Nombre del producto'"></p>

                            <div class="flex items-center gap-2 mt-1.5">
                                <template x-if="hasDiscount">
                                    <span class="text-xs text-gray-400 line-through"
                                          x-text="'Q ' + (parseFloat(price) || 0).toFixed(2)"></span>
                                </template>
                                <span :class="hasDiscount ? 'text-orange-600 font-black' : 'text-gray-900 font-bold'"
                                      class="text-sm"
                                      x-text="price ? 'Q ' + (finalPrice || (parseFloat(price)||0).toFixed(2)) : 'Q 0.00'"></span>
                            </div>

                            <div class="mt-2">
                                <span :class="stockLabel.cls"
                                      class="inline-flex text-[10px] font-semibold px-2 py-0.5 rounded-full"
                                      x-text="stockLabel.text"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info del producto --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Información actual</p>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Creado</span>
                            <span class="font-medium text-gray-700">{{ $product->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Última actualización</span>
                            <span class="font-medium text-gray-700">{{ $product->updated_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Comercio</span>
                            <span class="font-medium text-gray-700 truncate max-w-[120px]">{{ $product->commerce->name ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Tips --}}
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                    <p class="text-xs font-semibold text-blue-700 mb-2 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        Consejos
                    </p>
                    <ul class="text-xs text-blue-600 space-y-1.5 list-disc list-inside">
                        <li>Usa nombres claros y descriptivos.</li>
                        <li>El descuento se aplica automáticamente al precio base.</li>
                        <li>Un stock de 0 mostrará el producto como sin stock.</li>
                        <li>Los productos inactivos no aparecen en el catálogo.</li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</main>

</body>
</html>

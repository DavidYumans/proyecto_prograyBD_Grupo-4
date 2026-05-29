<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar producto - LocalMarket 24hrs</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Editar producto</h1>
            <p class="text-sm text-gray-500">Actualiza los datos del producto</p>
        </div>

        <a href="{{ route('comerciante.products.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
            Volver
        </a>
    </div>
</header>

<main class="max-w-4xl mx-auto px-6 py-8">

    <section class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <form method="POST"
              action="{{ route('comerciante.products.update', $product) }}"
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre del producto
                </label>

                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $product->name) }}"
                       class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">

                @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción
                </label>

                <textarea id="description"
                          name="description"
                          rows="4"
                          class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">{{ old('description', $product->description) }}</textarea>

                @error('description')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                    Imagen del producto
                </label>

                @if ($product->image_url)
                    <div class="mb-3">
                        <p class="text-xs text-gray-500 mb-2">Imagen actual:</p>

                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                @else
                    <div class="mb-3 w-32 h-32 rounded-lg bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                        Sin imagen
                    </div>
                @endif

                <input type="file"
                       id="image"
                       name="image"
                       accept="image/*"
                       class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">

                <p class="text-xs text-gray-500 mt-1">
                    Si subes una nueva imagen, reemplazará la anterior.
                </p>

                @error('image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                        Precio <span class="text-gray-400 font-normal">(Quetzales)</span>
                    </label>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-bold text-sm">Q</span>
                        </div>
                        <input type="number"
                               id="price"
                               name="price"
                               value="{{ old('price', $product->price) }}"
                               step="0.01"
                               min="0"
                               class="w-full pl-7 rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500">
                    </div>

                    @error('price')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                        Stock
                    </label>

                    <input type="number"
                           id="stock"
                           name="stock"
                           value="{{ old('stock', $product->stock) }}"
                           min="0"
                           class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">

                    @error('stock')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-1">
                        Descuento %
                    </label>

                    <input type="number"
                           id="discount_percentage"
                           name="discount_percentage"
                           value="{{ old('discount_percentage', $product->discount_percentage) }}"
                           step="0.01"
                           min="0"
                           max="100"
                           class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">

                    @error('discount_percentage')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Estado
                </label>

                <select id="status"
                        name="status"
                        class="w-full rounded-lg border-gray-300 focus:border-slate-500 focus:ring-slate-500">
                    <option value="activo" {{ old('status', $product->status) === 'activo' ? 'selected' : '' }}>
                        Activo
                    </option>

                    <option value="inactivo" {{ old('status', $product->status) === 'inactivo' ? 'selected' : '' }}>
                        Inactivo
                    </option>
                </select>

                @error('status')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800">
                    Actualizar producto
                </button>

                <a href="{{ route('comerciante.products.index') }}"
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
            </div>
        </form>
    </section>

</main>

</body>
</html>

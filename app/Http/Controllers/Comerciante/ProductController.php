<?php

namespace App\Http\Controllers\Comerciante;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ImageUploadService $images) {}

    public function index()
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce) {
            return redirect()
                ->route('comerciante.commerce.create')
                ->with('error', 'Primero debes crear tu comercio.');
        }

        $products = $commerce->products()
            ->latest()
            ->paginate(10);

        return view('comerciante.products.index', compact('commerce', 'products'));
    }

    public function create()
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce) {
            return redirect()
                ->route('comerciante.commerce.create')
                ->with('error', 'Primero debes crear tu comercio.');
        }

        return view('comerciante.products.create', compact('commerce'));
    }

    public function store(Request $request)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce) {
            return redirect()
                ->route('comerciante.commerce.create')
                ->with('error', 'Primero debes crear tu comercio.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'integer', 'min:0'],
            'discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:activo,inactivo'],
        ], [
            'name.required' => 'El nombre del producto es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'image.max' => 'La imagen no debe pesar más de 2MB.',
            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'status.required' => 'El estado es obligatorio.',
        ]);

        $imagePath = $request->hasFile('image')
            ? $this->images->upload($request->file('image'), 'products')
            : null;

        $commerce->products()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('comerciante.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce || $product->commerce_id !== $commerce->id) {
            abort(403, 'No tienes permiso para editar este producto.');
        }

        return view('comerciante.products.edit', compact('commerce', 'product'));
    }

    public function update(Request $request, Product $product)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce || $product->commerce_id !== $commerce->id) {
            abort(403, 'No tienes permiso para actualizar este producto.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'stock' => ['required', 'integer', 'min:0'],
            'discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:activo,inactivo'],
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            if ($product->image) $this->images->delete($product->image);
            $imagePath = $this->images->upload($request->file('image'), 'products');
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'discount_percentage' => $validated['discount_percentage'] ?? 0,
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('comerciante.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce || $product->commerce_id !== $commerce->id) {
            abort(403, 'No tienes permiso para eliminar este producto.');
        }

        if ($product->image) $this->images->delete($product->image);

        $product->delete();

        return redirect()
            ->route('comerciante.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function toggleStatus(Product $product)
    {
        $commerce = auth()->user()->commerce;

        if (!$commerce || $product->commerce_id !== $commerce->id) {
            abort(403, 'No tienes permiso para cambiar este producto.');
        }

        $product->update([
            'status' => $product->status === 'activo' ? 'inactivo' : 'activo',
        ]);

        return redirect()
            ->route('comerciante.products.index')
            ->with('success', 'Estado del producto actualizado correctamente.');
    }
}

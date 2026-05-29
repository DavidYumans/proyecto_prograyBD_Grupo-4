<?php

namespace App\Http\Controllers\Comerciante;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Commerce;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class CommerceController extends Controller
{
    public function __construct(private ImageUploadService $images) {}

    public function create()
    {
        $user = auth()->user();

        if ($user->commerce) {
            return redirect()
                ->route('comerciante.dashboard')
                ->with('error', 'Ya tienes un comercio registrado.');
        }

        $categories = Category::where('status', 'activa')
            ->orderBy('name')
            ->get();

        return view('comerciante.commerce.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->commerce) {
            return redirect()
                ->route('comerciante.dashboard')
                ->with('error', 'Ya tienes un comercio registrado.');
        }

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'category_id' => ['required', 'exists:categories,id'],
            'address'     => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'banner'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'name.required'        => 'El nombre del comercio es obligatorio.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists'   => 'La categoría seleccionada no es válida.',
            'logo.image'           => 'El logo debe ser una imagen.',
            'logo.mimes'           => 'El logo debe ser JPG, PNG o WebP.',
            'logo.max'             => 'El logo no puede superar los 2 MB.',
            'banner.image'         => 'El banner debe ser una imagen.',
            'banner.mimes'         => 'El banner debe ser JPG, PNG o WebP.',
            'banner.max'           => 'El banner no puede superar los 4 MB.',
        ]);

        $logoPath   = $request->hasFile('logo')   ? $this->images->upload($request->file('logo'),   'logos')   : null;
        $bannerPath = $request->hasFile('banner') ? $this->images->upload($request->file('banner'), 'banners') : null;

        Commerce::create([
            'user_id'     => $user->id,
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'address'     => $validated['address'] ?? null,
            'phone'       => $validated['phone'] ?? null,
            'logo'        => $logoPath,
            'banner'      => $bannerPath,
            'status'      => 'activo',
        ]);

        $user->update(['role' => 'comerciante']);

        return redirect()
            ->route('comerciante.dashboard')
            ->with('success', 'Tu comercio fue creado correctamente.');
    }

    public function edit()
    {
        $user     = auth()->user();
        $commerce = $user->commerce;

        if (! $commerce) {
            return redirect()->route('comerciante.commerce.create');
        }

        $categories = Category::where('status', 'activa')->orderBy('name')->get();

        return view('comerciante.commerce.edit', compact('commerce', 'categories'));
    }

    public function update(Request $request)
    {
        $user     = auth()->user();
        $commerce = $user->commerce;

        if (! $commerce) {
            abort(403);
        }

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'category_id' => ['required', 'exists:categories,id'],
            'address'     => ['nullable', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'banner'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'name.required'        => 'El nombre del comercio es obligatorio.',
            'category_id.required' => 'Debes seleccionar una categoría.',
            'category_id.exists'   => 'La categoría seleccionada no es válida.',
            'logo.image'           => 'El logo debe ser una imagen.',
            'logo.mimes'           => 'El logo debe ser JPG, PNG o WebP.',
            'logo.max'             => 'El logo no puede superar los 2 MB.',
            'banner.image'         => 'El banner debe ser una imagen.',
            'banner.mimes'         => 'El banner debe ser JPG, PNG o WebP.',
            'banner.max'           => 'El banner no puede superar los 4 MB.',
        ]);

        // Never overwrite existing images unless a new file is actually uploaded
        unset($validated['logo'], $validated['banner']);

        if ($request->hasFile('logo')) {
            if ($commerce->logo) $this->images->delete($commerce->logo);
            $validated['logo'] = $this->images->upload($request->file('logo'), 'logos');
        }

        if ($request->hasFile('banner')) {
            if ($commerce->banner) $this->images->delete($commerce->banner);
            $validated['banner'] = $this->images->upload($request->file('banner'), 'banners');
        }

        $commerce->update($validated);

        return redirect()
            ->route('comerciante.commerce.edit')
            ->with('success', 'Información del comercio actualizada correctamente.');
    }
}

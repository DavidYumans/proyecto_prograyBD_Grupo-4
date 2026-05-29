<?php

namespace App\Http\Controllers\Comerciante;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Commerce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommerceController extends Controller
{
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

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

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

        $user->update([
            'role' => 'comerciante',
        ]);

        return redirect()
            ->route('comerciante.dashboard')
            ->with('success', 'Tu comercio fue creado correctamente.');
    }

    public function edit()
    {
        $user = auth()->user();
        $commerce = $user->commerce;

        if (! $commerce) {
            return redirect()->route('comerciante.commerce.create');
        }

        $categories = Category::where('status', 'activa')->orderBy('name')->get();

        return view('comerciante.commerce.edit', compact('commerce', 'categories'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
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

        if ($request->hasFile('logo')) {
            if ($commerce->logo) {
                Storage::disk('public')->delete($commerce->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('banner')) {
            if ($commerce->banner) {
                Storage::disk('public')->delete($commerce->banner);
            }
            $validated['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $commerce->update($validated);

        return redirect()
            ->route('comerciante.commerce.edit')
            ->with('success', 'Información del comercio actualizada correctamente.');
    }
}

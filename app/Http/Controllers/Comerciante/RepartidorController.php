<?php

namespace App\Http\Controllers\Comerciante;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RepartidorController extends Controller
{
    private function commerce()
    {
        $commerce = auth()->user()->commerce;

        if (! $commerce) {
            abort(403, 'No tienes un comercio registrado.');
        }

        return $commerce;
    }

    public function index()
    {
        $commerce = $this->commerce();

        $repartidores = User::where('commerce_id', $commerce->id)
            ->where('role', 'repartidor')
            ->withCount([
                'deliveryOrders as total_entregas',
                'deliveryOrders as entregas_activas' => fn ($q) => $q->whereIn('status', ['confirmado', 'en_preparacion', 'en_camino']),
            ])
            ->orderBy('name')
            ->get();

        return view('comerciante.repartidores.index', compact('commerce', 'repartidores'));
    }

    public function store(Request $request)
    {
        $commerce = $this->commerce();

        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required'         => 'El nombre es obligatorio.',
            'email.required'        => 'El correo es obligatorio.',
            'email.email'           => 'Ingresa un correo válido.',
            'email.unique'          => 'Este correo ya está registrado.',
            'password.required'     => 'La contraseña es obligatoria.',
            'password.confirmed'    => 'Las contraseñas no coinciden.',
        ]);

        User::create([
            'commerce_id' => $commerce->id,
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => 'repartidor',
            'status'      => 'activo',
        ]);

        return redirect()
            ->route('comerciante.repartidores.index')
            ->with('success', 'Repartidor registrado correctamente.');
    }

    public function toggleStatus(User $user)
    {
        $this->authorizeRepartidor($user);

        $user->update([
            'status' => $user->status === 'activo' ? 'inactivo' : 'activo',
        ]);

        return back()->with('success', 'Estado actualizado.');
    }

    public function destroy(User $user)
    {
        $this->authorizeRepartidor($user);

        $user->deliveryOrders()->update(['repartidor_id' => null]);
        $user->delete();

        return back()->with('success', 'Repartidor eliminado correctamente.');
    }

    private function authorizeRepartidor(User $user): void
    {
        $commerce = $this->commerce();

        if ($user->role !== 'repartidor' || $user->commerce_id !== $commerce->id) {
            abort(403);
        }
    }
}

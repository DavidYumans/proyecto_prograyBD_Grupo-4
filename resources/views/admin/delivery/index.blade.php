@extends('admin.layouts.app')

@section('title', 'Repartidores')

@section('content')
<div class="space-y-8"
     x-data="{ createModal: {{ $errors->has('name') || $errors->has('email') || $errors->has('password') ? 'true' : 'false' }} }">

    {{-- ══════ HEADER ══════ --}}
    <div class="reveal relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 via-orange-600 to-amber-600 p-6 text-white shadow-xl shadow-orange-500/20">
        <div class="absolute -top-10 -right-10 w-52 h-52 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-1/3 w-32 h-32 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-black">Repartidores</h1>
                    <p class="text-orange-100 text-sm mt-0.5">Gestiona el equipo de reparto y asigna pedidos</p>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0 flex-wrap">
                <div class="text-center bg-white/20 backdrop-blur rounded-xl px-4 py-2 border border-white/20">
                    <p class="text-xl font-black">{{ $total }}</p>
                    <p class="text-xs text-orange-100">Total</p>
                </div>
                <div class="text-center bg-green-300/30 backdrop-blur rounded-xl px-4 py-2 border border-green-300/30">
                    <p class="text-xl font-black text-green-100">{{ $activos }}</p>
                    <p class="text-xs text-orange-100">Activos</p>
                </div>
                <div class="text-center bg-red-400/20 backdrop-blur rounded-xl px-4 py-2 border border-red-300/20">
                    <p class="text-xl font-black text-red-100">{{ $total - $activos }}</p>
                    <p class="text-xs text-orange-100">Inactivos</p>
                </div>
                <button @click="createModal = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-white text-orange-700 hover:bg-orange-50 shadow-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nuevo repartidor
                </button>
            </div>
        </div>
    </div>

    {{-- ══════ LISTA DE REPARTIDORES ══════ --}}
    <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-orange-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-gray-900">Repartidores registrados</h2>
                <p class="text-xs text-gray-400">{{ $total }} {{ $total === 1 ? 'repartidor' : 'repartidores' }} en total</p>
            </div>
        </div>

        @if($repartidores->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Repartidor</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Comercio</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Activas</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Entregas</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($repartidores as $rep)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-md shadow-orange-500/20">
                                            {{ strtoupper(substr($rep->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $rep->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $rep->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if ($rep->repartidorCommerce)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            {{ Str::limit($rep->repartidorCommerce->name, 20) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-700 border border-orange-200">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064"/></svg>
                                            Global
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($rep->entregas_activas > 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
                                            {{ $rep->entregas_activas }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 text-lg font-light">—</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="font-black text-gray-900 text-lg">{{ $rep->total_entregas }}</span>
                                </td>

                                <td class="px-6 py-4">
                                    @if($rep->status === 'activo')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.delivery.toggle-status', $rep) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition-colors
                                                           {{ $rep->status === 'activo'
                                                               ? 'text-amber-700 bg-amber-50 hover:bg-amber-100'
                                                               : 'text-green-700 bg-green-50 hover:bg-green-100' }}">
                                                {{ $rep->status === 'activo' ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.delivery.destroy', $rep) }}"
                                              x-data
                                              @submit.prevent="if(confirm('¿Eliminar a {{ addslashes($rep->name) }}? Sus pedidos asignados quedarán sin repartidor.')) $el.submit()">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-16 text-center">
                <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center mx-auto mb-4 border-2 border-dashed border-orange-200">
                    <svg class="w-7 h-7 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900">Sin repartidores</h3>
                <p class="text-gray-400 text-sm mt-1 mb-5">Registra el primero para comenzar a asignar entregas.</p>
                <button @click="createModal = true"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 shadow-lg shadow-orange-500/25 hover:from-orange-600 hover:to-orange-700 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Registrar repartidor
                </button>
            </div>
        @endif
    </div>

    {{-- ══════ ASIGNAR PEDIDOS ══════ --}}
    <div class="reveal bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-gray-900">Asignación de pedidos</h2>
                <p class="text-xs text-gray-400">Asigna un repartidor a cada pedido</p>
            </div>
        </div>

        @if($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pedido</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Comprador</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Entrega</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Repartidor</th>
                            <th class="px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Guardar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach ($orders as $order)
                            <tr class="hover:bg-blue-50/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="w-9 h-9 rounded-xl bg-gray-100 flex items-center justify-center">
                                        <span class="font-black text-gray-600 text-xs">#{{ $order->id }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900">{{ $order->user->name ?? 'Sin comprador' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ $order->statusLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                 {{ $order->repartidor_id ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $order->deliveryStatusLabel() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form id="assign-{{ $order->id }}" method="POST" action="{{ route('admin.delivery.assign', $order) }}">
                                        @csrf @method('PATCH')
                                        <div class="relative">
                                            <select name="repartidor_id"
                                                    class="w-full pr-8 pl-3 py-2 rounded-xl border-2 border-gray-200 text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all appearance-none bg-white">
                                                <option value="">Sin asignar</option>
                                                @foreach ($activeRepartidores as $rep)
                                                    <option value="{{ $rep->id }}" {{ $order->repartidor_id === $rep->id ? 'selected' : '' }}>
                                                        {{ $rep->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="submit" form="assign-{{ $order->id }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Guardar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="py-10 text-center">
                <p class="text-gray-400 text-sm">No hay pedidos para asignar.</p>
            </div>
        @endif
    </div>

    {{-- ══════ MODAL: NUEVO REPARTIDOR ══════ --}}
    <div x-show="createModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-black/60 backdrop-blur-sm p-4"
         @click.self="createModal = false"
         style="display: none;">

        <div x-show="createModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
             class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">

            <div class="bg-gradient-to-r from-orange-500 to-amber-600 px-6 py-5 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-lg leading-tight">Nuevo repartidor</h3>
                            <p class="text-orange-200 text-xs mt-0.5">Repartidor global de la plataforma</p>
                        </div>
                    </div>
                    <button @click="createModal = false" class="p-2 rounded-xl hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6">
                @if($errors->has('name') || $errors->has('email') || $errors->has('password'))
                    <div class="mb-4 flex items-start gap-3 p-3.5 rounded-xl bg-red-50 border border-red-200">
                        <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <ul class="text-xs text-red-600 space-y-0.5">
                            @foreach($errors->all() as $error)<li>· {{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.delivery.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Nombre completo <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Carlos Méndez" autofocus
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border-2 text-sm transition-all focus:outline-none focus:ring-4 {{ $errors->has('name') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                            Correo electrónico <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="correo@ejemplo.com"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border-2 text-sm transition-all focus:outline-none focus:ring-4 {{ $errors->has('email') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" placeholder="Mín. 8 caracteres"
                                   class="w-full px-4 py-2.5 rounded-xl border-2 text-sm transition-all focus:outline-none focus:ring-4 {{ $errors->has('password') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/10' : 'border-gray-200 focus:border-orange-500 focus:ring-orange-500/10' }}">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Confirmar</label>
                            <input type="password" name="password_confirmation" placeholder="Repite la clave"
                                   class="w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 text-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 focus:outline-none transition-all">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="createModal = false"
                                class="flex-1 py-3 rounded-xl text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-all">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex-1 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-600 shadow-lg shadow-orange-500/25 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

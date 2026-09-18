@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-6">Crear Usuario</h2>

    <form action="{{ route('users.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Rol</label>
            <select name="id_rol" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="">Seleccione un rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('id_rol') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-end gap-2 pt-4">
            <a href="{{ route('users.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Cancelar</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Guardar</button>
        </div>
    </form>
</div>
@endsection
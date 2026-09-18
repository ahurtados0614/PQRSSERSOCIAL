<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra el listado de usuarios con sus roles.
     */
    public function index(Request $request)
    {
        $users = User::with('role')
            ->when($request->filled('name_filter'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name_filter . '%');
            })
            ->when($request->filled('id_rol_filter'), function ($query) use ($request) {
                $query->where('id_rol', $request->id_rol_filter);
            })
            ->get();

        $roles = Roles::all();

        return view('users.index', compact('users', 'roles'));
    }


    /**
     * Crea un nuevo usuario via AJAX.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        // Los datos ya vienen completamente validados por el FormRequest
        $validated = $request->validated();

        try {
            // Encriptar contraseña
            $validated['password'] = Hash::make($validated['password']);

            // Crear el registro en base de datos
            $user = User::create($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Usuario creado con éxito.',
                'user'    => $user->load('role'),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Ocurrió un error al intentar crear el usuario.',
            ], 500);
        }
    }

    /**
     * Actualiza el usuario via AJAX.
     */

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        // Obtener los datos previamente validados por el UpdateUserRequest
        $validated = $request->validated();

        try {
            // Si se envió contraseña, se encripta; de lo contrario, se elimina para no sobrescribirla
            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            // Actualizar el registro
            $user->update($validated);

            return response()->json([
                'status'  => 'success',
                'message' => 'Usuario actualizado con éxito.',
                'user'    => $user->fresh(['role']),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Ocurrió un error al intentar actualizar el usuario.',
            ], 500);
        }
    }
}

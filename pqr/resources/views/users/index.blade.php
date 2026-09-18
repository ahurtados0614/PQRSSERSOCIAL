<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filtros --}}
            <div class="bg-white shadow-xl sm:rounded-lg mb-6">
                <div class="p-5 sm:p-6">

                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Filtros de búsqueda
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Filtra las USUARIOS según los criterios disponibles.
                            </p>
                        </div>
                    </div>

                    <form id="filter-form">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label
                                    for="id_rol_filter"
                                    class="block text-sm font-medium text-gray-700">
                                    Rol
                                </label>

                                <select
                                    id="id_rol_filter"
                                    name="id_rol_filter"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        shadow-sm focus:border-indigo-500
                                        focus:ring-indigo-500">
                                    <option value="">Todos</option>
                                    @foreach($roles as $value => $labels)
                                    <option
                                        value="{{ $labels->id }}"
                                        {{ old('id_rol_filter', request('id_rol_filter')) == $labels->id ? 'selected' : '' }}>
                                        {{ $labels->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    for="name_filter"
                                    class="block text-sm font-medium text-gray-700">
                                    Nombre
                                </label>

                                <input
                                    value="{{ old('name_filter', request('name_filter')) }}"
                                    type="text"
                                    id="name_filter"
                                    name="name_filter"
                                    placeholder="Buscar el nombre..."
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        shadow-sm focus:border-indigo-500
                                        focus:ring-indigo-500">
                            </div>
                        </div>


                        <div class="mt-5 flex flex-col sm:flex-row sm:justify-end gap-2">
                            <a
                                href="{{ route('users.index') }}"
                                class="inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                Limpiar
                            </a>

                            <button
                                type="submit"
                                id="filter-button"
                                class="inline-flex justify-center items-center px-4 py-2
                           bg-gray-800 border border-transparent rounded-md
                           font-semibold text-xs text-white uppercase
                           tracking-widest hover:bg-gray-700
                           disabled:opacity-50">
                                Buscar
                            </button>

                        </div>
                </div>



                </form>
            </div>
        </div>
        <!-- Mensaje de Éxito -->

        <div
            id="user-success"
            class="hidden mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <div class="flex items-center gap-2" style="color: #0a3622; background: #d1e7dd; padding: 1.5em;font-weight: bold;">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span id="user-success-text"></span>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg mb-6">
                <div class="px-5 py-4 sm:px-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                USUARIOS registrados
                            </h3>
                        </div>
                        <div class="flex justify-end mb-4" style="width: 100%;">
                            <button type="button"
                                onclick="openNewUserModal()"
                                class="px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 disabled:opacity-50">
                                Nuevo Usuario
                            </button>
                        </div>
                    </div>
                </div>

                <table class="min-w-full divide-y divide-gray-200" style="width: 100%;">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body" class="divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->role->name ?? 'Sin Rol' }}</td>
                            <td class="px-6 py-4">
                                <button type="button" onclick="openEditUserModal({{ json_encode($user) }})" class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                                    Editar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>
    </div>

    <!-- Modal Editar Usuario -->
    <x-modal-custom id="user-edit-modal" maxWidth="lg" formId="user-edit-form" primaryButtonText="Guardar cambios" primaryButtonType="submit" primaryButtonId="user-submit">
        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Editar Usuario
                            </h3>
        </div>
        <input type="hidden" id="edit_user_id" name="id">

        <div>
            <label for="edit_name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" id="edit_name" name="name" class="mt-1 block w-full rounded-md border-gray-300">
        </div>

        <div>
            <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="edit_email" name="email" class="mt-1 block w-full rounded-md border-gray-300">
        </div>

        <div>
            <label for="edit_id_rol" class="block text-sm font-medium text-gray-700">Rol</label>
            <select id="edit_id_rol" name="id_rol" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="">Seleccione un rol...</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="edit_password" class="block text-sm font-medium text-gray-700">Contraseña (Opcional)</label>
            <input type="password" id="edit_password" name="password" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Dejar en blanco para conservar la actual">
        </div>

        <!-- Error General del Modal -->
        <div id="user-form-error" class="hidden rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700"></div>

    </x-modal-custom>

    <!-- Modal Nuevo Usuario -->
    <x-modal-custom id="user-new-modal" maxWidth="lg" formId="user-new-form" primaryButtonText="Guardar cambios" primaryButtonType="submit" primaryButtonId="user-new-submit">
        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                Nuevo Usuario
                            </h3>
        </div>
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300">
        </div>

        <div>
            <label for="id_rol" class="block text-sm font-medium text-gray-700">Rol</label>
            <select id="id_rol" name="id_rol" class="mt-1 block w-full rounded-md border-gray-300">
                <option value="">Seleccione un rol...</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300" required>
        </div>

        <!-- Error General del Modal -->
        <div id="user-new-form-error" class="hidden rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700"></div>

    </x-modal-custom>
    @push('scripts')
    <script>
        // Abrir el modal y precargar los datos
        function openEditUserModal(user) {
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_name').value = user.name || '';
            document.getElementById('edit_email').value = user.email || '';
            document.getElementById('edit_id_rol').value = user.id_rol || '';
            document.getElementById('edit_password').value = '';

            const generalError = document.getElementById('user-form-error');
            if (generalError) generalError.classList.add('hidden');

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'user-edit-modal'
            }));
        }

        // Abrir el modal nuevo usuario
        function openNewUserModal() {

            const generalError = document.getElementById('user-new-form-error');
            if (generalError) generalError.classList.add('hidden');

            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'user-new-modal'
            }));
        }
    </script>
    <script src="{{ asset('js/userlist.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/userNew.js') }}?v={{ time() }}"></script>
    @endpush
</x-app-layout>
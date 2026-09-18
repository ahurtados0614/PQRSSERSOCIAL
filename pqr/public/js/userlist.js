document.addEventListener('DOMContentLoaded', function () {
    // Formularios
    const editForm = document.getElementById('user-edit-form');
    const filterForm = document.getElementById('user-filter-form');

    // Botones y Elementos UI
    const submitButton = document.getElementById('user-submit');
    const generalError = document.getElementById('user-form-error');
    const successMessage = document.getElementById('user-success');
    const successText = document.getElementById('user-success-text');

    /* ==========================================================================
       EDICIÓN DE USUARIO (MODAL AJAX)
       ========================================================================== */
    if (editForm) {
        editForm.addEventListener('submit', async function (event) {
            event.preventDefault();

            const userId = document.getElementById('edit_user_id')?.value;
            if (!userId) return;

            const formData = new FormData(editForm);
            const data = Object.fromEntries(formData.entries());
            data['_method'] = 'PUT';

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Guardando...';
            }

            try {
                const response = await fetch(`/users/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.status === 422) {
                    const firstError = Object.values(result.errors)[0][0];
                    showGeneralError(firstError || 'Revise los campos del formulario.');
                    return;
                }

                if (!response.ok) {
                    showGeneralError(result.message || 'Error al actualizar el usuario.');
                    return;
                }

                // Éxito: cerrar modal y recargar listado/página
                window.dispatchEvent(new CustomEvent('close-modal', {
                    detail: 'user-edit-modal'
                }));

                if (successMessage && successText) {
                    successText.textContent = result.message || 'Usuario actualizado correctamente.';
                    successMessage.classList.remove('hidden');
                }

                setTimeout(() => window.location.reload(), 1200);

            } catch (error) {
                console.error(error);
                showGeneralError('Ocurrió un error al comunicarse con el servidor.');
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Guardar cambios';
                }
            }
        });
    }

    /* ==========================================================================
       FILTROS Y BÚSQUEDA DE USUARIOS
       ========================================================================== */
    function getFilterUrl() {
        const params = new URLSearchParams();

        const idRolInput = document.getElementById('id_rol_filter');
        const nameInput = document.getElementById('name_filter');

        const id_rol_filter = idRolInput ? idRolInput.value.trim() : '';
        const name_filter = nameInput ? nameInput.value.trim() : '';

        if (id_rol_filter) {
            params.set('id_rol_filter', id_rol_filter);
        }

        if (name_filter) {
            params.set('name_filter', name_filter);
        }

        const queryString = params.toString();
        return queryString ? `/api/users?${queryString}` : '/api/users';
    }

    // Escuchar el evento submit del formulario de filtros
    if (filterForm) {
        filterForm.addEventListener('submit', function (event) {
            event.preventDefault();
            loadUsers(getFilterUrl());
        });
    }


    /* ==========================================================================
       CARGA DINÁMICA DE USUARIOS (FETCH AJAX)
       ========================================================================== */
    function loadUsers(url = BASE_URL) {
        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Garantizar que data sea una lista/array antes de hacer forEach
                const users = Array.isArray(data) ? data : (data.users || []);

                renderUsersTable(users);
            })
            .catch(error => {
                console.error('Error al filtrar usuarios:', error);
            });
    }

    // Función auxiliar para renderizar filas en la tabla
    function renderUsersTable(users) {
        const tableBody = document.getElementById('users-table-body');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        if (users.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No se encontraron usuarios con los filtros aplicados.
                    </td>
                </tr>`;
            return;
        }

        users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">${user.name}</td>
                <td class="px-6 py-4 whitespace-nowrap">${user.email}</td>
                <td class="px-6 py-4 whitespace-nowrap">${user.role?.name || 'Sin Rol'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                    <button onclick="editUser(${user.id})" class="text-indigo-600 hover:text-indigo-900">Editar</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    /* ==========================================================================
       UTILIDADES
       ========================================================================== */
    function showGeneralError(msg) {
        if (generalError) {
            generalError.textContent = msg;
            generalError.classList.remove('hidden');
        }
    }
});
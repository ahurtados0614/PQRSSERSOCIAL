document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('user-new-form');
    const submitButton = document.getElementById('user-new-submit');
    const generalError = document.getElementById('user-new-form-error');
    const successMessage = document.getElementById('user-success');
    const successText = document.getElementById('user-success-text');

    if (form) {
        form.addEventListener('submit', async function(event) {
            event.preventDefault();
            
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            submitButton.disabled = true;
            submitButton.textContent = 'Guardando...';

            try {
                const response = await fetch('/users', {
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
                    showGeneralError(result.message || 'Error al crear el usuario.');
                    return;
                }

                // Cierra el modal de NUEVO usuario (no el de edición)
                window.dispatchEvent(new CustomEvent('close-modal', {
                    detail: 'user-new-modal'
                }));

                if (successMessage && successText) {
                    successText.textContent = result.message || 'Usuario creado correctamente.';
                    successMessage.classList.remove('hidden');
                }

                setTimeout(() => window.location.reload(), 1200);

            } catch (error) {
                console.error(error);
                showGeneralError('Ocurrió un error al comunicarse con el servidor.');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Guardar cambios';
            }
        });
    }

    function showGeneralError(msg) {
        if (generalError) {
            generalError.textContent = msg;
            generalError.classList.remove('hidden');
        }
    }
});
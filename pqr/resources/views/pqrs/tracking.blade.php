<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastreo de PQR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    label.block.text-xs.font-medium.uppercase.text-gray-500.dark\:text-gray-400 {
        margin-bottom: 0.3em;
        margin-top: 0.5em;
    }

    .rounded-lg.border.border-gray-200.dark\:border-gray-700.bg-gray-50.dark\:bg-gray-900.p-4.text-sm.space-y-1 {
        margin-bottom: 0.5em;
    }

    div#pqrDescripcion {
        margin-bottom: 0.5em;
    }

    @media only screen and (max-width : 900px) {
        button#submitBtn {
            width: 100% !important;
        }
    }
</style>

<body class="bg-gray-50 min-h-screen text-gray-800 antialiased py-10 px-4 sm:px-6">

    <div class="max-w-3xl mx-auto space-y-6">

        {{-- Tarjeta de Búsqueda --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-gray-900 text-center">Consultar Estado de PQR</h1>
            <p class="text-sm text-gray-500 text-center mt-1">Ingresa el número de radicado para consultar el avance de tu solicitud.</p>

            <!-- Formulario -->
            <form id="trackingForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 rounded-lg border border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-900">
                    <input
                        type="text"
                        id="radicadoInput"
                        name="radicado"
                        value="{{ $radicado }}"
                        placeholder="Ingrese el radicado..."
                        class="w-full px-4 py-2 border rounded-lg" />
                    <button style="width: 30%;" type="submit" id="submitBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg items-center gap-2">
                        <span id="btnSpinner" class="hidden animate-spin">🌀</span>
                        <span id="btnText">Consultar</span>
                    </button>
                </div>
            </form>

            <div id="errorMessage" class="hidden mt-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg"></div>

            <!-- Tarjeta de Resultados (Oculta por defecto) -->
            <div class="space-y-6">

                {{-- ENCABEZADO DE LA VISTA --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Seguimiento de la Solicitud
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Consulte la información detallada y el historial de avance de su PQR.
                    </p>
                </div>

                {{-- BLOQUE ROW PRINCIPAL --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 rounded-lg border border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-900">

                    <!--- BLOQUE 1: INFORMACIÓN DETALLADA --->
                    <div id="bloque1" class="space-y-4 rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">

                        {{-- INFORMACIÓN DE LA PQR --}}
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-800">

                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                Información de la PQR
                            </h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Radicado
                                    </dt>

                                    <dd id="pqrRadicado" class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Tipo
                                    </dt>

                                    <dd id="pqrTipo" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Categoría
                                    </dt>

                                    <dd id="pqrCategoria" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Prioridad
                                    </dt>

                                    <dd id="pqrPrioridad" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Estado
                                    </dt>

                                    <dd id="pqrEstado" class="mt-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Fecha de Registro
                                    </dt>

                                    <dd id="pqrFecha" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                            </div>

                        </div>

                        {{-- TÍTULO Y DESCRIPCIÓN --}}
                        <div class="space-y-4">

                            <div>
                                <label class="block text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Asunto / Título
                                </label>

                                <div id="pqrTitulo" class="mt-1 rounded-md border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    —
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Descripción de la solicitud
                                </label>

                                <div id="pqrDescripcion" class="mt-1 min-h-[100px] whitespace-pre-line rounded-md border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                    —
                                </div>
                            </div>

                        </div>

                        {{-- SOLICITANTE --}}
                        <div class="rounded-lg border border-gray-200 p-5 dark:border-gray-700">

                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                Información del solicitante
                            </h3>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Nombre
                                    </dt>

                                    <dd id="pqrSolicitante" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Identificación
                                    </dt>

                                    <dd id="pqrIdentificacion" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Correo electrónico
                                    </dt>

                                    <dd id="pqrEmail" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                        Teléfono
                                    </dt>

                                    <dd id="pqrTelefono" class="mt-1 text-sm text-gray-900 dark:text-white">
                                        —
                                    </dd>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!--- BLOQUE 2: HISTÓRICO DE GESTIONES --->
                    <div id="bloque2" class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">
                        <h3 class="mb-1 text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                            Histórico de la PQR
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                            A continuación se muestra la trazabilidad de las acciones realizadas sobre su solicitud.
                        </p>

                        {{-- TREN DE SEGUIMIENTOS / HISTORIAL --}}
                        <div id="timelineContainer" class="space-y-3 max-w-2xl mx-auto py-2">
                            <!-- Se llena mediante JavaScript al recibir la respuesta de la API -->
                        </div>
                    </div>

                </div>
            </div>
            {{-- Mensaje de Error --}}
            <div id="errorMessage" class="hidden mt-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm text-center"></div>
        </div>

        {{-- Tarjeta de Resultados (Oculta por defecto) --}}
        <div id="resultCard" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">




        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('trackingForm');
            const input = document.getElementById('radicadoInput');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');
            const errorMessage = document.getElementById('errorMessage');
            const resultCard = document.getElementById('resultCard');

            // AUTO-CONSULTAR SI YA VIENE UN RADICADO EN EL INPUT
            const initialRadicado = input ? input.value.trim() : '';
            if (initialRadicado) {
                fetchPqr(initialRadicado, false);
            }

            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const radicado = input ? input.value.trim() : '';
                    if (radicado) {
                        fetchPqr(radicado, true);
                    }
                });
            }

            window.addEventListener('popstate', () => {
                const params = new URLSearchParams(window.location.search);
                const radicado = params.get('radicado');
                if (radicado) {
                    if (input) input.value = radicado;
                    fetchPqr(radicado, false);
                } else {
                    if (input) input.value = '';
                    if (resultCard) resultCard.classList.add('hidden');
                    hideError();
                }
            });

            async function fetchPqr(radicado, pushToHistory = true) {
                setLoading(true);
                hideError();
                if (resultCard) resultCard.classList.add('hidden'); // Ocultar mientras busca

                try {
                    const response = await fetch(`/api/pqr/rastreo?radicado=${encodeURIComponent(radicado)}`);
                    const result = await response.json();

                    if (!response.ok || result.status !== 'success') {
                        throw new Error(result.message || 'No se encontró información con el radicado ingresado.');
                    }

                    renderPqrData(result.data);

                    if (pushToHistory) {
                        const newUrl = `${window.location.pathname}?radicado=${encodeURIComponent(radicado)}`;
                        window.history.pushState({
                            radicado
                        }, '', newUrl);
                    }
                } catch (error) {
                    showError(error.message);
                } finally {
                    setLoading(false);
                }
            }

            function renderPqrData(pqr) {
                // 1. Campos de la PQR
                document.getElementById('pqrRadicado').textContent = pqr.radicado ?? '—';
                document.getElementById('pqrTipo').textContent = pqr.tipo_label ?? pqr.tipo ?? '—';
                document.getElementById('pqrCategoria').textContent = pqr.categoria ?? 'N/A';
                document.getElementById('pqrPrioridad').textContent = pqr.prioridad_label ?? pqr.prioridad ?? '—';
                document.getElementById('pqrEstado').textContent = pqr.estado_label ?? pqr.estado ?? '—';
                document.getElementById('pqrFecha').textContent = pqr.created_at ? new Date(pqr.created_at).toLocaleDateString('es-ES') : '—';

                // 2. Detalle
                document.getElementById('pqrTitulo').textContent = pqr.titulo ?? '—';
                document.getElementById('pqrDescripcion').textContent = pqr.descripcion ?? '—';

                // 3. Solicitante
                const solicitante = pqr.solicitante || {};
                document.getElementById('pqrSolicitante').textContent = solicitante.nombre ?? '—';
                document.getElementById('pqrIdentificacion').textContent = solicitante.identificacion ?? '—';
                document.getElementById('pqrEmail').textContent = solicitante.email ?? '—';
                document.getElementById('pqrTelefono').textContent = solicitante.telefono ?? '—';

                // 4. Render del Histórico (Bloque 2)
                const timeline = document.getElementById('timelineContainer');
                if (timeline) {
                    timeline.innerHTML = '';
                    const seguimientos = pqr.seguimientos ?? [];

                    if (seguimientos.length === 0) {
                        timeline.innerHTML = `
                <div class="rounded-lg border border-dashed border-gray-300 dark:border-gray-700 p-4 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Aún no se registran actualizaciones de gestión.</p>
                </div>`;
                    } else {
                        seguimientos.forEach((item) => {
                            const date = new Date(item.created_at).toLocaleString('es-ES', {
                                dateStyle: 'medium',
                                timeStyle: 'short'
                            });

                            timeline.innerHTML += `
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4 text-sm space-y-1">
                        <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">${escapeHtml(item.tipo_accion_label ?? 'Seguimiento')}</span>
                            <span>${date}</span>
                        </div>
                        <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line">${escapeHtml(item.descripcion)}</p>
                    </div>
                `;
                        });
                    }
                }

                // Mostrar el contenedor completo de resultados
                const resultCard = document.getElementById('resultCard');
                if (resultCard) resultCard.classList.remove('hidden');
            }

            function setLoading(loading) {
                if (submitBtn) submitBtn.disabled = loading;
                if (btnText) btnText.textContent = loading ? 'Buscando...' : 'Consultar';
                if (btnSpinner) btnSpinner.classList.toggle('hidden', !loading);
            }

            function showError(msg) {
                if (!errorMessage) return;
                errorMessage.textContent = msg;
                errorMessage.classList.remove('hidden');
            }

            function hideError() {
                if (!errorMessage) return;
                errorMessage.classList.add('hidden');
                errorMessage.textContent = '';
            }

            function escapeHtml(str) {
                return (str ?? '').replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
            }
        });
    </script>

</body>

</html>
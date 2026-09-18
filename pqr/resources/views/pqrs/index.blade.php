<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pqrs') }}
        </h2>
        <p class="text-sm text-gray-500">
            Gestión de peticiones, quejas, reclamos
        </p>
    </x-slot>

    <div class="py-12 w-full max-w-full overflow-x-hidden">
        <div class="py-8 w-full max-w-full">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">

                {{-- Filtros --}}
                <div class="bg-white shadow-xl sm:rounded-lg mb-6">
                    <div class="p-5 sm:p-6">

                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    Filtros de búsqueda
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Filtra las PQR según los criterios disponibles.
                                </p>
                            </div>
                        </div>

                        <form id="filter-form">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        for="type"
                                        class="block text-sm font-medium text-gray-700">
                                        Tipo
                                    </label>

                                    <select
                                        id="type"
                                        name="type"
                                        class="mt-1 block w-full rounded-md border-gray-300
                               shadow-sm focus:border-indigo-500
                               focus:ring-indigo-500">
                                        <option value="">Todos</option>
                                        @foreach($PqrsType as $value => $labels)
                                        <option value="{{ $value }}">
                                            {{ $labels }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="status"
                                        class="block text-sm font-medium text-gray-700">
                                        Estado
                                    </label>

                                    <select
                                        id="status"
                                        name="status"
                                        class="mt-1 block w-full rounded-md border-gray-300
                               shadow-sm focus:border-indigo-500
                               focus:ring-indigo-500">
                                        <option value="">Todos</option>
                                        @foreach($PqrsStatus as $value => $labels)
                                        <option value="{{ $value }}">
                                            {{ $labels }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="priority"
                                        class="block text-sm font-medium text-gray-700">
                                        Prioridad
                                    </label>

                                    <select
                                        id="priority"
                                        name="priority"
                                        class="mt-1 block w-full rounded-md border-gray-300
                               shadow-sm focus:border-indigo-500
                               focus:ring-indigo-500">
                                        <option value="">Todas</option>
                                        @foreach($PqrsPriority as $value => $labels)
                                        <option value="{{ $value }}">
                                            {{ $labels }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label
                                        for="category"
                                        class="block text-sm font-medium text-gray-700">
                                        Categoría
                                    </label>

                                    <input
                                        type="text"
                                        id="category"
                                        name="category"
                                        placeholder="Buscar categoría..."
                                        class="mt-1 block w-full rounded-md border-gray-300
                               shadow-sm focus:border-indigo-500
                               focus:ring-indigo-500">
                                </div>

                            </div>

                            <div class="mt-5 flex flex-col sm:flex-row sm:justify-end gap-2">

                                <button
                                    type="button"
                                    id="clear-filters"
                                    class="inline-flex justify-center items-center px-4 py-2
                           bg-white border border-gray-300 rounded-md
                           font-semibold text-xs text-gray-700 uppercase
                           tracking-widest hover:bg-gray-50">
                                    Limpiar
                                </button>

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

                        </form>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="w-full max-w-full bg-white shadow-xl sm:rounded-lg overflow-hidden border border-gray-200">

                    <!-------Mensaje de éxito-------------->
                    <div
                        id="gestion-success"
                        class="hidden mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        <div class="flex items-center gap-2" style="color: #0a3622; background: #d1e7dd; padding: 1.5em;font-weight: bold;">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span id="gestion-success-text"></span>
                        </div>
                    </div>

                    <div class="px-5 py-4 sm:px-6 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    PQR registradas
                                </h3>
                                <p id="results-summary" class="text-sm text-gray-500 mt-1">
                                    Cargando información...
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Estado de carga --}}
                    <div id="loading" class="hidden px-6 py-10 text-center">
                        <div class="inline-flex items-center gap-3 text-sm text-gray-500">
                            <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Cargando PQR...
                        </div>
                    </div>

                    {{-- Error --}}
                    <div id="error-message" class="hidden m-6 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    No fue posible cargar las PQR.
                                </h3>
                                <p id="error-text" class="mt-1 text-sm text-red-700"></p>
                            </div>
                        </div>
                    </div>

                    {{-- CONTENEDOR DE SCROLL AISLADO --}}
                    <div id="table-container" style="width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table style="width: 100%; min-width: 800px; table-layout: fixed;" class="divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th style="width: 110px;" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Radicado</th>
                                    <th style="width: 90px;" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th style="width: 200px;" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                    <th style="width: 100px;" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                                    <th style="width: 100px;" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th style="width: 100px;" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th style="width: 100px;" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="pqrs-table-body" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>

                    {{-- Sin resultados --}}
                    <div id="empty-state" class="hidden px-6 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron PQR</h3>
                        <p class="mt-1 text-sm text-gray-500">No existen registros que coincidan con los filtros seleccionados.</p>
                    </div>

                    {{-- Paginación --}}
                    <div id="pagination" class="hidden px-5 py-4 sm:px-6 border-t border-gray-200"></div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Custom --}}
    <x-modal-custom
        id="pqr-detail-modal"
        maxWidth="3xl"
        formId="pqr-management-form"
        secondaryButtonText="Cancelar"
        primaryButtonText="Guardar gestión"
        primaryButtonType="submit"
        primaryButtonId="gestion-submit">
        <div class="space-y-6">

            {{-- ENCABEZADO --}}
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detalle de la PQR
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Consulte la información y registre la gestión realizada.
                </p>
            </div>

            {{-- BLOQUE ROW --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 rounded-lg border border-gray-200 bg-gray-50 p-2 dark:border-gray-700 dark:bg-gray-900">
                <!---BLOQUE 1--->
                <div id="bloque1" class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">

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

                                <dd
                                    id="pqr-detail-radicado"
                                    class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Tipo
                                </dt>

                                <dd
                                    id="pqr-detail-tipo"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Categoría
                                </dt>

                                <dd
                                    id="pqr-detail-categoria"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Prioridad
                                </dt>

                                <dd
                                    id="pqr-detail-prioridad"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Estado
                                </dt>

                                <dd
                                    id="pqr-detail-estado"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Canal
                                </dt>

                                <dd
                                    id="pqr-detail-canal"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                        </div>

                    </div>

                    {{-- TÍTULO Y DESCRIPCIÓN --}}
                    <div class="space-y-4 mt-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Título
                            </label>

                            <div
                                id="pqr-detail-titulo"
                                class="mt-1 rounded-md border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                —
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Descripción
                            </label>

                            <div
                                id="pqr-detail-descripcion"
                                class="mt-1 min-h-[100px] whitespace-pre-line rounded-md border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                —
                            </div>
                        </div>

                    </div>

                    {{-- SOLICITANTE --}}
                    <div class="rounded-lg border border-gray-200 p-5 dark:border-gray-700 mt-4">

                        <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                            Información del solicitante
                        </h3>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Nombre
                                </dt>

                                <dd
                                    id="pqr-detail-solicitante"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Identificación
                                </dt>

                                <dd
                                    id="pqr-detail-identificacion"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Correo electrónico
                                </dt>

                                <dd
                                    id="pqr-detail-email"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                            <div>
                                <dt class="text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                    Teléfono
                                </dt>

                                <dd
                                    id="pqr-detail-telefono"
                                    class="mt-1 text-sm text-gray-900 dark:text-white">
                                    —
                                </dd>
                            </div>

                        </div>

                    </div>

                    {{-- GESTIÓN --}}
                    <div class="rounded-lg border border-gray-200 p-5 dark:border-gray-700 mt-4">
                        <input type="hidden" id="gestion-pqr-id" name="pqr_id">
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                                Gestión
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Registre la acción realizada sobre esta PQR.
                            </p>
                        </div>

                        <div class="space-y-4">

                            <div>
                                <label
                                    for="gestion-tipo-accion"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tipo de acción
                                </label>

                                <select
                                    id="gestion-tipo-accion"
                                    name="tipo_accion"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        shadow-sm focus:border-indigo-500
                                        focus:ring-indigo-500
                                        dark:border-gray-600
                                        dark:bg-gray-800
                                        dark:text-white">
                                    <option value="">Seleccionar...</option>
                                    @foreach($TrackingActionType as $value => $labels)
                                    
                                    <option value="{{ $value }}">
                                        {{ $labels }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    for="gestion-priority"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Prioridad (Cambiar según considere)
                                </label>

                                <select
                                    id="gestion-priority"
                                    name="priority"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        shadow-sm focus:border-indigo-500
                                        focus:ring-indigo-500
                                        dark:border-gray-600
                                        dark:bg-gray-800
                                        dark:text-white">
                                    <option value="">Seleccionar...</option>
                                    @foreach($PqrsPriority as $value => $labels)
                                    <option value="{{ $value }}">
                                        {{ $labels }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    for="gestion-status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Estado (Cambiar según considere)
                                </label>

                                <select
                                    id="gestion-status"
                                    name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        shadow-sm focus:border-indigo-500
                                        focus:ring-indigo-500
                                        dark:border-gray-600
                                        dark:bg-gray-800
                                        dark:text-white">
                                    <option value="">Seleccionar...</option>
                                    @foreach($PqrsStatus as $value => $labels)
                                    <option value="{{ $value }}">
                                        {{ $labels }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label
                                    for="gestion-descripcion"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Descripción de la gestión
                                </label>

                                <textarea
                                    id="gestion-descripcion"
                                    name="descripcion"
                                    rows="4"
                                    class="mt-1 block w-full rounded-md border-gray-300
                                        shadow-sm focus:border-indigo-500
                                        focus:ring-indigo-500
                                        dark:border-gray-600
                                        dark:bg-gray-800
                                        dark:text-white"
                                    placeholder="Describa la gestión realizada..."></textarea>
                                <p id="gestion-descripcion-ayuda" class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Para estados recibida o en gestión se utilizará un mensaje
                                    predeterminado si no escribe una descripción.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

                <!---BLOQUE 2--->
                <div id="bloque2" class="rounded-lg border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-800">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-300">
                        Histórico de la PQR
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Al dar clic en los recuadros negros se desplegará su correspondiente comentario.</p>
                    <div class="space-y-3 max-w-2xl mx-auto p-4" id="content_items">

                    </div>
                </div>
            </div>
        </div>
        <!-- ERROR GENERAL -->
        <div
            id="gestion-form-error"
            class="mt-5 hidden rounded-md border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-700">
        </div>
    </x-modal-custom>

    @push('scripts')
    <script>
        window.pqrMaps = {
            priority: JSON.parse('@json($PqrsPriority)'),
            status: JSON.parse('@json($PqrsStatus)'),
            chanel: JSON.parse('@json($PqrsChanel)'),
            type: JSON.parse('@json($PqrsType)'),
            tracking: JSON.parse('@json($TrackingActionType)')
        };
    </script>
    <script src="{{ asset('js/pqrslist.js') }}?v={{ time() }}"></script>
    @endpush
</x-app-layout>
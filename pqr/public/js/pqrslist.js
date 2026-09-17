
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('filter-form');
            const clearButton = document.getElementById('clear-filters');
            const filterButton = document.getElementById('filter-button');

            const loading = document.getElementById('loading');
            const errorMessage = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');

            const tableContainer = document.getElementById('table-container');
            const tableBody = document.getElementById('pqrs-table-body');
            const emptyState = document.getElementById('empty-state');
            const pagination = document.getElementById('pagination');
            const resultsSummary = document.getElementById('results-summary');

            /**
             * Cargar PQR desde la API.
             */
            async function loadPqrs(url = '/api/pqr') {

                loading.classList.remove('hidden');
                errorMessage.classList.add('hidden');
                emptyState.classList.add('hidden');
                pagination.classList.add('hidden');

                filterButton.disabled = true;

                try {

                    const response = await fetch(url, {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (response.status === 401 || response.status === 403) {
                        throw new Error(
                            'No tienes permisos para consultar las PQR.'
                        );
                    }

                    if (!response.ok) {
                        throw new Error(
                            'Ocurrió un error al consultar las PQR.'
                        );
                    }

                    const data = await response.json();

                    renderTable(data);

                } catch (error) {

                    console.error(error);

                    tableBody.innerHTML = '';

                    tableContainer.classList.add('hidden');
                    emptyState.classList.add('hidden');

                    errorText.textContent = error.message;
                    errorMessage.classList.remove('hidden');

                    resultsSummary.textContent = '';

                } finally {

                    loading.classList.add('hidden');
                    filterButton.disabled = false;
                }
            }
            // Exponer en window para que la llamada de guardado pueda recargar la tabla
            window.loadPqrs = loadPqrs;
            /**
             * Renderizar tabla.
             */
            function renderTable(data) {

                tableContainer.classList.remove('hidden');
                errorMessage.classList.add('hidden');

                tableBody.innerHTML = '';

                if (!data.data || data.data.length === 0) {

                    tableContainer.classList.add('hidden');
                    emptyState.classList.remove('hidden');

                    resultsSummary.textContent = '0 registros';

                    return;
                }

                emptyState.classList.add('hidden');

                data.data.forEach(function(pqr) {

                    const row = document.createElement('tr');

                    row.className = 'hover:bg-gray-50';
                    const pqrJson = JSON.stringify(pqr).replace(/"/g, '&quot;');
                    row.innerHTML = `
                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">
                                ${escapeHtml(pqr.radicado ?? '')}
                            </span>
                        </td>

                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-700">
                                ${formatType(pqr.tipo)}
                            </span>
                        </td>

                        <td class="px-4 sm:px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                ${escapeHtml(pqr.titulo ?? '')}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                ${escapeHtml(pqr.categoria ?? '')}
                            </div>
                        </td>

                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            ${priorityBadge(pqr.prioridad)}
                        </td>

                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                            ${statusBadge(pqr.estado)}
                        </td>

                        <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${formatDate(pqr.created_at)}
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm">
                              <button
                                        type="button"
                                        onclick="openPqrDetail(${pqrJson})"
                                        class="inline-flex items-center gap-2 rounded-md
                                            border border-gray-300
                                            bg-white px-3 py-2
                                            text-sm font-medium text-gray-700
                                            transition hover:bg-gray-100
                                            focus:outline-none focus:ring-2 focus:ring-gray-400
                                            dark:border-gray-600
                                            dark:bg-gray-800
                                            dark:text-gray-200
                                            dark:hover:bg-gray-700"
                                >
                                        Ver detalle
                                    </button>
                        </td>
                    `;

                    tableBody.appendChild(row);
                });

                resultsSummary.textContent =
                    `Mostrando ${data.from ?? 0} - ${data.to ?? 0} de ${data.total ?? 0} registros`;

                renderPagination(data);
            }

            /**
             * Paginación.
             */
            function renderPagination(data) {

                if (!data.links || data.last_page <= 1) {
                    pagination.classList.add('hidden');
                    return;
                }

                pagination.classList.remove('hidden');

                const wrapper = document.createElement('div');

                wrapper.className =
                    'flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4';

                const info = document.createElement('div');

                info.className = 'text-sm text-gray-500';

                info.textContent =
                    `Página ${data.current_page} de ${data.last_page}`;

                const links = document.createElement('div');

                links.className = 'flex flex-wrap gap-1';

                data.links.forEach(function(link) {

                    if (!link.url) {
                        const span = document.createElement('span');

                        span.className =
                            'px-3 py-2 text-sm text-gray-400';

                        span.innerHTML = link.label;

                        links.appendChild(span);

                        return;
                    }

                    const button = document.createElement('button');

                    button.type = 'button';

                    button.className =
                        'px-3 py-2 text-sm border rounded-md ' +
                        (link.active ?
                            'bg-gray-800 text-white border-gray-800' :
                            'bg-white text-gray-700 border-gray-300 hover:bg-gray-50');

                    button.innerHTML = link.label;
                    if (button) {
                        button.addEventListener('click', function() {
                            loadPqrs(link.url);
                        });
                    }
                    links.appendChild(button);
                });

                wrapper.appendChild(info);
                wrapper.appendChild(links);

                pagination.innerHTML = '';
                pagination.appendChild(wrapper);
            }

            /**
             * Badge de prioridad.
             */
            function priorityBadge(priority) {

                const labels = {
                    baja: 'Baja',
                    media: 'Media',
                    alta: 'Alta'
                };

                const classes = {
                    baja: 'bg-gray-100 text-gray-700',
                    media: 'bg-yellow-100 text-yellow-800',
                    alta: 'bg-red-100 text-red-800'
                };

                const label = labels[priority] ?? priority ?? '';
                const css = classes[priority] ?? 'bg-gray-100 text-gray-700';

                return `
                    <span class="inline-flex items-center px-3 py-1
                                 rounded-full text-xs font-medium ${css}">
                        ${escapeHtml(label)}
                    </span>
                `;
            }

            /**
             * Badge de estado.
             */
            function statusBadge(status) {

                const labels = {
                    recibida: 'Recibida',
                    en_gestion: 'En proceso',
                    resuelta: 'resuelta',
                    cerrada: 'Cerrada'
                };

                const classes = {
                    recibida: 'bg-blue-100 text-blue-800',
                    en_gestion: 'bg-yellow-100 text-yellow-800',
                    resuelta: 'bg-green-100 text-green-800',
                    cerrada: 'bg-gray-100 text-gray-800'
                };

                const label = labels[status] ?? status ?? '';
                const css = classes[status] ?? 'bg-gray-100 text-gray-800';

                return `
                    <span class="inline-flex items-center px-3 py-1
                                 rounded-full text-xs font-medium ${css}">
                        ${escapeHtml(label)}
                    </span>
                `;
            }

            /**
             * Formatear tipo.
             */
            function formatType(type) {

                const labels = {
                    peticion: 'Petición',
                    queja: 'Queja',
                    reclamo: 'Reclamo',
                    sugerencia: 'Sugerencia'
                };

                return escapeHtml(labels[type] ?? type ?? '');
            }


            /**
             * Formatear fecha.
             */
            function formatDate(date) {

                if (!date) {
                    return '';
                }

                const value = new Date(date);

                if (Number.isNaN(value.getTime())) {
                    return escapeHtml(date);
                }

                return value.toLocaleDateString('es-CO', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit'
                });
            }

            /**
             * Evitar insertar HTML recibido desde la API.
             */
            function escapeHtml(value) {

                const div = document.createElement('div');

                div.textContent = value ?? '';

                return div.innerHTML;
            }

            /**
             * Construir URL con filtros.
             */
            function getFilterUrl() {

                const params = new URLSearchParams();

                const type = document.getElementById('type').value;
                const status = document.getElementById('status').value;
                const priority = document.getElementById('priority').value;
                const category = document.getElementById('category').value.trim();

                if (type) {
                    params.set('type', type);
                }

                if (status) {
                    params.set('status', status);
                }

                if (priority) {
                    params.set('priority', priority);
                }

                if (category) {
                    params.set('category', category);
                }

                const queryString = params.toString();

                return queryString ?
                    `/api/pqr?${queryString}` :
                    '/api/pqr';
            }

            /**
             * Aplicar filtros.
             */
            if (form) {
                form.addEventListener('submit', function(event) {

                    event.preventDefault();

                    loadPqrs(getFilterUrl());
                });
            }
            /**
             * Limpiar filtros.
             */
            if (clearButton) {
                clearButton.addEventListener('click', function() {

                    form.reset();

                    loadPqrs('/api/pqr');
                });
            }

            /**
             * Carga inicial.
             */
            loadPqrs();

        });

        //open modal
        function openPqrDetail(pqr) {
            
            let pqrId = pqr.id;
            const maps = window.pqrMaps || {};
            const pqrsPriorityMap = maps.priority || {};
            const pqrsPqrsStatusMap = maps.status || {};
            const pqrsPqrsChanelMap = maps.chanel || {};
            const pqrsPqrsTypeMap = maps.type || {};
            const TrackingActionTypeMap = maps.tracking || {};
            
            /*
            |--------------------------------------------------------------------------
            | Guardar ID de la PQR
            |--------------------------------------------------------------------------
            */

            const pqrIdInput =
                document.getElementById('gestion-pqr-id');

            if (pqrIdInput) {

                pqrIdInput.value =
                    pqrId;
            }

            /*
            |--------------------------------------------------------------------------
            | Asignar info pqr
            |--------------------------------------------------------------------------
            */
            const estadoInfo =
                document.getElementById('pqr-detail-estado');

            if (estadoInfo) {

                estadoInfo.innerText = pqrsPqrsStatusMap[pqr.estado] ?? pqr.estado;
            }
            const radicadoInfo =
                document.getElementById('pqr-detail-radicado');

            if (radicadoInfo) {

                radicadoInfo.innerText = pqr.radicado;
            }
            const tipoInfo =
                document.getElementById('pqr-detail-tipo');

            if (tipoInfo) {

                tipoInfo.innerText = pqrsPqrsTypeMap[pqr.tipo] ?? pqr.tipo;
            }
            const categoriaInfo =
                document.getElementById('pqr-detail-categoria');

            if (categoriaInfo) {

                categoriaInfo.innerText = pqr.categoria;
            }
            const prioridadInfo =
                document.getElementById('pqr-detail-prioridad');

            if (prioridadInfo) {
                prioridadInfo.innerText = pqrsPriorityMap[pqr.prioridad] ?? pqr.prioridad;
            }

            const canalInfo =
                document.getElementById('pqr-detail-canal');

            if (canalInfo) {

                canalInfo.innerText = pqrsPqrsChanelMap[pqr.canal] ?? pqr.canal;
            }

            const canalTitulo =
                document.getElementById('pqr-detail-titulo');

            if (canalTitulo) {

                canalTitulo.innerText = capitalizarString(pqr.titulo);
            }

            const canalDescripcion =
                document.getElementById('pqr-detail-descripcion');

            if (canalDescripcion) {

                canalDescripcion.innerText = capitalizarString(pqr.descripcion);
            }

            const canalSolicitante =
                document.getElementById('pqr-detail-solicitante');

            if (canalSolicitante) {

                canalSolicitante.innerText = capitalizarString(pqr.solicitante.nombre) + " " + capitalizarString(pqr.solicitante.apellido);
            }

            const canalIdentificacion =
                document.getElementById('pqr-detail-identificacion');

            if (canalIdentificacion) {

                canalIdentificacion.innerText = pqr.solicitante.identificacion;
            }

            const canalCorreo =
                document.getElementById('pqr-detail-email');

            if (canalCorreo) {

                canalCorreo.innerText = pqr.solicitante.email;
            }

            const canalTelefono =
                document.getElementById('pqr-detail-telefono');

            if (canalTelefono) {

                canalTelefono.innerText = pqr.solicitante.telefono;
            }
            //set values selects
            const tipoAccionSelect = document.getElementById('gestion-tipo-accion');

            if (tipoAccionSelect) {
                // Asigna el valor que coincide con el atributo 'value' de las <option>
                tipoAccionSelect.value = pqr.seguimientos.at(0)?.tipo_accion ?? '';
            }

            const tipoPrioritySelect = document.getElementById('gestion-priority');
            if (tipoPrioritySelect) {
                // Asigna el valor que coincide con el atributo 'value' de las <option>
                tipoPrioritySelect.value = pqr.prioridad ?? 'baja';
            }

            const tipoStatusSelect = document.getElementById('gestion-status');
            if (tipoStatusSelect) {
                // Asigna el valor que coincide con el atributo 'value' de las <option>
                tipoStatusSelect.value = pqr.estado ?? 'recibida';
            }
            /*
            |--------------------------------------------------------------------------
            | Limpiar estado
            |--------------------------------------------------------------------------
            */

            const estadoSelect =
                document.getElementById('gestion-estado');

            if (estadoSelect) {

                estadoSelect.value = '';
            }


            /*
            |--------------------------------------------------------------------------
            | Limpiar descripción
            |--------------------------------------------------------------------------
            */

            const descripcion =
                document.getElementById('gestion-descripcion');

            if (descripcion) {

                descripcion.value = '';

                descripcion.required = false;

                descripcion.placeholder =
                    'Describa la gestión realizada...';
            }


            /*
            |--------------------------------------------------------------------------
            | Limpiar errores
            |--------------------------------------------------------------------------
            */

            const generalError =
                document.getElementById('gestion-form-error');

            if (generalError) {

                generalError.classList.add('hidden');

                generalError.textContent = '';
            }

            /*
            |--------------------------------------------------------------------------
            | Cargar seguimientos en el acordeón (content_items)
            |--------------------------------------------------------------------------
            */
           
            const contentItems = document.getElementById('content_items');

            if (contentItems) {
                contentItems.innerHTML = '';

                const seguimientos = pqr.seguimientos ?? [];

                if (seguimientos.length === 0) {
                    contentItems.innerHTML = `
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                            No hay seguimientos registrados para esta PQR.
                        </p>
                    `;
                } else {
                    seguimientos.forEach((seguimiento, index) => {
                        const details = document.createElement('details');
                        details.className = 'group mb-2 rounded-lg bg-white shadow-md transition-all overflow-hidden mb-3 py-1';
                        
                        // Abrir automáticamente el último seguimiento
                        if (index === 0) {
                            details.setAttribute('open', 'true');
                        }

                        const tipoAccionTexto = TrackingActionTypeMap[seguimiento.tipo_accion] ?? seguimiento.tipo_accion ?? 'Seguimiento';
                        const fechaFormateada = formatDate(seguimiento.created_at);

                        details.innerHTML = `
                            <summary class="flex cursor-pointer items-center justify-between p-4 font-bold text-sm leading-normal transition-colors bg-[#1b1b18] text-white border border-black hover:bg-black hover:border-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:border-[#eeeeec] dark:hover:bg-white dark:hover:border-white group-open:bg-gray-800 group-open:text-white">
                                <span>${escapeHtml(tipoAccionTexto)} - <span class="font-normal opacity-80">${fechaFormateada}</span></span>
                                <svg class="h-5 w-5 transition-transform duration-200 group-open:rotate-180 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </summary>
                            <div class="p-4 text-gray-600  bg-white dark:bg-gray-800 dark:text-gray-300 text-sm space-y-2">
                                <p class="whitespace-pre-line">${escapeHtml(capitalizarString(seguimiento.descripcion ?? 'Sin descripción.'))}</p>
                                ${seguimiento.usuario ? `
                                    <div class="mt-2 pt-2 border-t border-gray-100 dark:border-gray-700 text-xs text-gray-400">
                                        Gestionado por: <span class="font-medium text-gray-600 dark:text-gray-300">${escapeHtml(seguimiento.usuario.name ?? '')}</span>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                        
                        contentItems.appendChild(details);
                        
                    });
                }
            }
            /*
            |--------------------------------------------------------------------------
            | Abrir modal
            |--------------------------------------------------------------------------
            */

            window.dispatchEvent(
                new CustomEvent(
                    'open-modal', {
                        detail: 'pqr-detail-modal'
                    }
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Cargar información de la PQR
            |--------------------------------------------------------------------------
            |
            | Aquí puedes conservar la lógica que ya tienes
            | para consultar y mostrar el detalle.
            |
            */
        }

        const estadoSelect = document.getElementById('gestion-estado');
        const descripcion = document.getElementById('gestion-descripcion');

        const mensajesDefault = {
            recibida: 'La PQR ha sido recibida y se encuentra pendiente de gestión.',
            en_gestion: 'La PQR se encuentra actualmente en proceso de gestión.'
        };

        function actualizarDescripcionPorEstado() {

            const estado = estadoSelect.value;

            if (estado === 'resuelta' || estado === 'cerrada') {

                descripcion.placeholder =
                    estado === 'resuelta' ?
                    'Indique cómo fue resuelta la PQR...' :
                    'Indique el motivo o resultado del cierre de la PQR...';

                descripcion.required = true;

                return;
            }

            descripcion.required = false;

            if (mensajesDefault[estado]) {

                descripcion.placeholder = mensajesDefault[estado];

            } else {

                descripcion.placeholder =
                    'Describa la gestión realizada...';
            }
        }
        if (estadoSelect) {
            estadoSelect.addEventListener(
                'change',
                actualizarDescripcionPorEstado
            );
        }
        function formatDate(date) {
            if (!date) return '';

            const value = new Date(date);

            if (Number.isNaN(value.getTime())) {
                return escapeHtml(date);
            }

            return value.toLocaleDateString('es-CO', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        }
        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value ?? '';
            return div.innerHTML;
        }
        function capitalizarString(texto) {
            if (!texto) return '';
            return texto.split(' ').map(palabra =>
                palabra.charAt(0).toUpperCase() + palabra.slice(1)
            ).join(' ');
        }


    
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('gestion-success');
            const successText = document.getElementById('gestion-success-text');

            const form = document.getElementById('pqr-management-form');
            const submitButton = document.getElementById('gestion-submit');
            const generalError = document.getElementById('gestion-form-error');

            const estadoSelect = document.getElementById('gestion-status');
            const descripcion = document.getElementById('gestion-descripcion');
            const pqrIdInput = document.getElementById('gestion-pqr-id');
            const prioritySelect = document.getElementById('gestion-priority');
            const statusOld = document.getElementById('pqr-detail-estado');


            /*
             * Mensajes predeterminados según el estado
             */
            const mensajesDefault = {

                recibida: 'La PQR ha sido recibida y se encuentra pendiente de gestión.',

                en_gestion: 'La PQR se encuentra actualmente en proceso de gestión.'
            };


            /*
             * Cambiar placeholder y obligatoriedad
             * dependiendo del estado seleccionado.
             */
            if (estadoSelect) {
                estadoSelect.addEventListener('change', function() {

                    const estado = estadoSelect.value;

                    /*
                     * RESUELTA / CERRADA
                     * requieren comentario obligatorio.
                     */
                    if (
                        estado === 'resuelta' ||
                        estado === 'cerrada'
                    ) {

                        descripcion.required = true;

                        if (estado === 'resuelta') {

                            descripcion.placeholder =
                                'Indique cómo fue resuelta la PQR...';

                        } else {

                            descripcion.placeholder =
                                'Indique el motivo o resultado del cierre de la PQR...';
                        }

                        return;
                    }


                    /*
                     * RECIBIDA / EN GESTIÓN
                     * comentario opcional.
                     */
                    descripcion.required = false;

                    descripcion.placeholder =
                        mensajesDefault[estado] ??
                        'Describa la gestión realizada...';
                });
            }


            /*
             * Interceptar el submit del formulario
             */
            if (form) {
                form.addEventListener('submit', async function(event) {

                    /*
                     * Evita el submit tradicional
                     */
                    event.preventDefault();
                    event.stopPropagation();

                    clearErrors();


                    /*
                     * Obtener ID de la PQR
                     */
                    const pqrId = pqrIdInput.value;

                    if (!pqrId) {

                        showGeneralError(
                            'No se pudo identificar la PQR.'
                        );

                        return;
                    }

                    /*
                     * Obtener prioridad
                     */
                    const prioridad = prioritySelect.value;

                    if (!prioridad) {

                        showGeneralError(
                            'Debe seleccionar la nueva prioridad de la PQR.'
                        );

                        return;
                    }


                    /*
                     * Obtener estado
                     */
                    const estado = estadoSelect.value;

                    if (!estado) {

                        showGeneralError(
                            'Debe seleccionar el nuevo estado de la PQR.'
                        );

                        return;
                    }


                    /*
                     * Obtener descripción
                     */
                    let descripcionValue =
                        descripcion.value.trim();

                    /*
                     * Obtener estado Anterior
                     */
                    let statusOldValue = statusOld.textContent.trim().toLowerCase() ?? 'recibida';

                    statusOldValue = formatStatus(statusOldValue);

                    /*
                     * RESUELTA / CERRADA
                     * requieren comentario.
                     */
                    if (
                        (
                            estado === 'resuelta' ||
                            estado === 'cerrada'
                        ) &&
                        !descripcionValue
                    ) {

                        showGeneralError(
                            'Debe ingresar un comentario para marcar la PQR como resuelta o cerrada.'
                        );

                        descripcion.focus();

                        return;
                    }


                    /*
                     * RECIBIDA / EN GESTIÓN
                     *
                     * Si el usuario no escribe comentario,
                     * utilizamos el mensaje predeterminado.
                     */
                    if (
                        !descripcionValue &&
                        mensajesDefault[estado]
                    ) {

                        descripcionValue =
                            mensajesDefault[estado];
                    }


                    /*
                     * Datos que se enviarán a la API
                     */
                    const data = {

                        estado: estado,

                        /*
                         * Esta pantalla está realizando
                         * un cambio de estado.
                         */
                        tipo_accion: 'cambio_estado',

                        descripcion: descripcionValue,

                        prioridad: prioridad,

                        statusOldValue: statusOldValue,
                    };


                    /*
                     * Deshabilitar botón
                     */
                    submitButton.disabled = true;
                    submitButton.textContent = 'Guardando...';

                    /**
                     * Formatear estado.
                     */
                    function formatStatus(type) {
                        const labels = {
                            'recibida': 'recibida',
                            'en gestion': 'en_gestion',
                            'en gestión': 'en_gestion',
                            'resuelta': 'resuelta',
                            'cerrada': 'cerrada'
                        };

                        return labels[type] ?? type ?? '';
                    }

                    try {

                        /*
                         * Actualizar PQR y registrar seguimiento
                         */
                        const response = await fetch(
                            `/api/pqr/${pqrId}/gestion`, {
                                method: 'PATCH',

                                credentials: 'same-origin',

                                headers: {

                                    'Content-Type': 'application/json',

                                    'Accept': 'application/json',

                                    'X-Requested-With': 'XMLHttpRequest',

                                    'X-CSRF-TOKEN': document
                                        .querySelector(
                                            'meta[name="csrf-token"]'
                                        )
                                        ?.getAttribute('content')
                                },

                                body: JSON.stringify(data)
                            }
                        );


                        /*
                         * Leer respuesta JSON
                         */
                        const result =
                            await response.json();


                        /*
                         * ERROR DE VALIDACIÓN
                         */
                        if (response.status === 422) {

                            if (result.errors) {

                                showValidationErrors(
                                    result.errors
                                );

                            } else {

                                showGeneralError(
                                    result.message ??
                                    'Revise los datos ingresados.'
                                );
                            }

                            return;
                        }


                        /*
                         * NO AUTORIZADO
                         */
                        if (
                            response.status === 401 ||
                            response.status === 403
                        ) {

                            showGeneralError(
                                'No tienes permisos para gestionar esta PQR.'
                            );

                            return;
                        }


                        /*
                         * PQR NO ENCONTRADA
                         */
                        if (response.status === 404) {

                            showGeneralError(
                                'La PQR no fue encontrada.'
                            );

                            return;
                        }


                        /*
                         * OTROS ERRORES
                         */
                        if (!response.ok) {

                            showGeneralError(
                                result.message ??
                                'No fue posible registrar la gestión.'
                            );

                            return;
                        }


                        /*

                    * GESTIÓN REGISTRADA CORRECTAMENTE
                   
                    * Mostrar mensaje de éxito
                    */
                        if (successMessage && successText) {
                            
                            successText.textContent =
                                result.message ??
                                'La gestión de la PQR fue registrada correctamente.';

                            successMessage.classList.remove('hidden');

                            /*

                            * Llevar al usuario al mensaje
                                */
                            successMessage.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });

                            /*

                            * Ocultar automáticamente después de unos segundos
                                */
                            setTimeout(function() {
                                successMessage.classList.add('hidden');
                            }, 5000);
                        }

                        /*

                        * Cerrar modal después de guardar correctamente
                        */
                        window.dispatchEvent(
                            new CustomEvent('close-modal', {
                                detail: 'pqr-detail-modal'
                            })
                        );

                        /*

                        * Actualizar la tabla
                        *
                        * loadPqrs pertenece a otro bloque de
                        * DOMContentLoaded, por lo que la exponemos
                        * como función global.
                        */
                        if (typeof window.loadPqrs === 'function') {
                            await window.loadPqrs();
                        }


                    } catch (error) {

                        console.error(
                            'Error registrando gestión:',
                            error
                        );

                        showGeneralError(
                            'No fue posible comunicarse con el servidor. Intente nuevamente.'
                        );

                    } finally {

                        /*
                         * Reactivar botón
                         */
                        submitButton.disabled = false;
                        submitButton.textContent =
                            'Guardar gestión';
                    }
                });
            }

            /*
             * Limpiar errores
             */
            function clearErrors() {

                document
                    .querySelectorAll('[data-error]')
                    .forEach(element => {

                        element.textContent = '';
                    });


                generalError.classList.add('hidden');
                generalError.textContent = '';
            }


            /*
             * Mostrar errores de validación
             */
            function showValidationErrors(errors) {

                Object.entries(errors)
                    .forEach(([field, messages]) => {

                        const element =
                            document.querySelector(
                                `[data-error="${field}"]`
                            );

                        if (
                            element &&
                            messages.length > 0
                        ) {

                            element.textContent =
                                messages[0];

                        } else if (
                            messages.length > 0
                        ) {

                            showGeneralError(
                                messages[0]
                            );
                        }
                    });
            }


            /*
             * Mostrar error general
             */
            function showGeneralError(message) {

                generalError.textContent =
                    message;

                generalError.classList.remove(
                    'hidden'
                );

                generalError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'

                });
            }
        });
   
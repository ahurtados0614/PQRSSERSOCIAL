<div class="p-6 lg:p-8 bg-white border-b border-gray-200">

    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Bienvenido al sistema {{env('APP_NAME')}}!
    </h1>

    <p class="mt-6 text-gray-500 leading-relaxed">
        Te damos la bienvenida al portal centralizado de gestión de PQR. Aquí podrás hacer seguimiento en tiempo real a tus solicitudes, consultar su estado actualizado y visualizar indicadores de gestión de manera transparente.
        <br><br>
        Navega por el sistema utilizando el menú lateral en dispositivos móviles o el menú superior desde tu equipo de escritorio o portátil.
    </p>
</div>
@if(in_array(Auth::user()->id_rol, [1, 3]))
<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 stroke-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Diagrama PQRs Por Estado
            </h2>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div style=" margin-bottom: 1em; margin-top:1em">
            <button type="button" class="inline-flex justify-center items-center px-4 py-2
                           bg-gray-800 border border-transparent
                           font-semibold text-xs text-white uppercase
                           tracking-widest hover:bg-gray-700
                           disabled:opacity-50" onclick="loadStats('bar')"><i class="fa fa-bar-chart"></i> Barras</button>

            <button type="button" class="inline-flex justify-center items-center px-4 py-2
                           bg-indigo-500 border border-transparent 
                           font-semibold text-xs text-white uppercase
                           tracking-widest hover:bg-indigo-600
                           disabled:opacity-50" onclick="loadStats('line')"><i class="fa fa-line-chart"></i> Lineas</button>
        </div>
        <div class="relative w-full h-80">
            <canvas id="pqr_by_status"></canvas>
        </div>
    </div>

    <div>
        <div class="flex items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="size-6 stroke-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Diagrama PQRs por Tipo
            </h2>
        </div>

        <!-- Contenedor con altura controlada para evitar colapsos de pantalla -->
        <div class="relative w-full h-80">
            <canvas id="pqr_by_type"></canvas>
        </div>
    </div>

    <script>
        let typeChartInstance = null;

        async function loadTypeStats() {
            try {
                const response = await fetch("/api/pqr/stat-by-type");
                const result = await response.json();

                const canvas = document.getElementById('pqr_by_type');
                if (!canvas) return;

                const ctx = canvas.getContext('2d');

                if (typeChartInstance !== null) {
                    typeChartInstance.destroy();
                }

                typeChartInstance = new Chart(ctx, {
                    type: 'pie', // Puedes cambiarlo a 'doughnut' para un diseño con dona central
                    data: {
                        labels: result.labels,
                        datasets: [{
                            data: result.data,
                            backgroundColor: [
                                '#3b82f6', // Azul (Petición)
                                '#ef4444', // Rojo (Queja)
                                '#f59e0b', // Naranja (Reclamo)
                                '#10b981', // Verde (Sugerencia)
                                '#8b5cf6' // Morado (Otro)
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Distribución total por tipo de solicitud'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error al cargar la gráfica de tipos de PQR:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadTypeStats();
        });
    </script>

    <script>
        let chartInstance = null; // Guardar la instancia global

        // Paleta de colores mapeada según la clave del estado o el orden del dataset
        const colorPalette = [{
                border: '#3b82f6',
                bg: 'rgba(59, 130, 246, 0.2)'
            }, // Azul (Recibida)
            {
                border: '#f59e0b',
                bg: 'rgba(245, 158, 11, 0.2)'
            }, // Naranja (En proceso/gestión)
            {
                border: '#10b981',
                bg: 'rgba(16, 185, 129, 0.2)'
            }, // Verde (Resuelta)
            {
                border: '#6b7280',
                bg: 'rgba(107, 114, 128, 0.2)'
            } // Gris (Cerrada)
        ];

        async function loadStats(stylegraph = 'bar') {
            try {
                const response = await fetch("/api/pqr/stat-by-status");
                const result = await response.json();

                const canvas = document.getElementById('pqr_by_status');
                if (!canvas) return;

                const ctx = canvas.getContext('2d');

                // Destruir el gráfico anterior si existe para evitar superposiciones
                if (chartInstance !== null) {
                    chartInstance.destroy();
                }

                // Aplicar estilos de color a los datasets que vienen dinámicamente del backend
                const datasetsWithStyles = result.datasets.map((dataset, index) => {
                    const color = colorPalette[index % colorPalette.length];
                    return {
                        ...dataset,
                        borderColor: color.border,
                        backgroundColor: color.bg,
                        borderWidth: 2,
                        fill: stylegraph === 'line' // Relleno automático solo para líneas
                    };
                });

                // Crear el nuevo gráfico
                chartInstance = new Chart(ctx, {
                    type: stylegraph,
                    data: {
                        labels: result.labels,
                        datasets: datasetsWithStyles
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: {
                                display: true,
                                text: 'PQRs recibidas por mes año ({{ date("Y") }})'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0 // Garantiza que solo se muestren números enteros
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error al cargar las estadísticas de PQR:', error);
            }
        }

        // Cargar gráfico inicial
        document.addEventListener('DOMContentLoaded', function() {
            loadStats('bar');
        });
    </script>
    
</div>
@endif

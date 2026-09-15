<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PQR registrada</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">

    <div class="w-full max-w-xl">

        <div style="padding: 1em;" class="rounded-xl bg-white p-8 text-center shadow-lg">

            {{-- Icono --}}
            <div  class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100">

                <svg
                    class="h-8 w-8 text-green-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

            </div>

            {{-- Título --}}
            <h1 class="mt-6 text-2xl font-bold text-gray-900">
                ¡PQR registrada correctamente!
            </h1>

            {{-- Mensaje --}}
            <p class="mt-3 text-gray-600">
                Su solicitud ha sido registrada exitosamente.
                Conserve el siguiente número de radicado para consultar
                posteriormente el estado de su PQR.
            </p>

            {{-- Radicado --}}
            <div class="mt-6 rounded-lg bg-gray-100 p-5" style="margin: 1em;">

                <p class="text-sm text-gray-500">
                    Número de radicado
                </p>

                <p class="mt-2 text-3xl font-bold tracking-wider text-gray-900">
                    {{ $pqr->radicado }}
                </p>

            </div>

            {{-- Estado --}}
            <div class="mt-6 text-sm text-gray-500">

                <p>
                    Estado inicial:

                    <strong class="text-gray-700">
                        {{ucwords($pqr->estado) }}
                    </strong>
                </p>

            </div>

            {{-- Acciones --}}
            <div class="mt-8 flex justify-center">

                <a
                    href="/"
                    class="inline-block dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal"
                >
                    Volver al inicio
                </a>

            </div>

        </div>

    </div>

</body>

</html>
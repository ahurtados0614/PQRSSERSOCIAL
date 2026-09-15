@props([
    'id',
    'maxWidth' => '2xl',
])

@php
    $id = $id ?? md5($attributes->wire('model'));

    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth] ?? 'sm:max-w-2xl';
@endphp

<div
    x-data="{ show: false }"
    x-on:open-modal.window="
        if ($event.detail === '{{ $id }}') {
            show = true;
        }
    "
    x-on:close-modal.window="
        if ($event.detail === '{{ $id }}') {
            show = false;
        }
    "
    x-on:keydown.escape.window="show = false"
    x-effect="document.body.style.overflow = show ? 'hidden' : ''"
>
    <template x-teleport="body">

        <!-- CONTENEDOR PRINCIPAL -->
        <div
            x-show="show"
            x-cloak
            class="fixed inset-0 z-[99999]"
        >

            <!-- OVERLAY -->
            <div
                class="absolute inset-0"
                style="background: rgba(0, 0, 0, 0.65);"
                x-on:click="show = false"
            ></div>

            <!-- MODAL -->
            <div
                class="relative flex min-h-full items-center justify-center p-4"
            >
                <div
                    x-show="show"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    x-on:click.stop
                    class="w-full {{ $maxWidth }} max-h-[90vh] overflow-y-auto rounded-lg bg-white p-6 shadow-2xl"
                >

                    {{ $slot }}

                    <button
                        type="button"
                        x-on:click="show = false"
                        class="mt-4 rounded-lg bg-gray-200 px-4 py-2 hover:bg-gray-300"
                    >
                        Cerrar
                    </button>

                </div>
            </div>

        </div>

    </template>
</div>
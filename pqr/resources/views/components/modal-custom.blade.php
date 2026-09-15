@props([
    'id',
    'maxWidth' => '2xl',

    // Formulario
    'formId' => null,
    'formAction' => '#',
    'formMethod' => 'POST',

    // Footer
    'showFooter' => true,
    'secondaryButtonText' => 'Cancelar',
    'primaryButtonText' => 'Guardar',
    'primaryButtonType' => 'submit',
    'primaryButtonId' => null,
])

@php
    $id = $id ?? md5($attributes->wire('model'));

    $formId = $formId ?? $id . '-form';

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

    x-on:keydown.escape.window="
        show = false;
    "

    x-effect="
        document.body.style.overflow = show ? 'hidden' : '';
    "
>
    <template x-teleport="body">

        <!-- ========================================== -->
        <!-- CONTENEDOR DEL MODAL                       -->
        <!-- ========================================== -->

        <div
            x-show="show"
            x-cloak
            class="fixed inset-0 z-[99999] overflow-y-auto"
        >

            <!-- ====================================== -->
            <!-- OVERLAY                                -->
            <!-- ====================================== -->

             <div
                class="fixed inset-0"
                style="background: rgba(0, 0, 0, 0.65);"
                x-on:click="show = false"
            ></div>


            <!-- ====================================== -->
            <!-- CENTRADO DEL MODAL                     -->
            <!-- ====================================== -->

            <div
                class="relative flex h-full w-full
                       items-center justify-center p-4"
            >

                <!-- ================================== -->
                <!-- MODAL                              -->
                <!-- ================================== -->

                <div
                    x-show="show"

                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"

                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"

                    x-on:click.stop

                    class="relative flex w-full {{ $maxWidth }}
                           flex-col overflow-y-auto
                             bg-white shadow-2xl
                           dark:bg-gray-800 p-6"
                
                

                    style="
                        height: calc(100vh - 2rem);
                        max-height: calc(100vh - 2rem);
                    "
                >

                    <!-- ================================== -->
                    <!-- FORMULARIO                          -->
                    <!-- ================================== -->

                    <form
                        id="{{ $formId }}"
                        action="{{ $formAction }}"
                        method="{{ $formMethod }}"
                        class="flex min-h-0 flex-1 flex-col"
                    >

                        <!-- ============================== -->
                        <!-- CONTENIDO CON SCROLL           -->
                        <!-- ============================== -->

                        <div
                            class="min-h-0 flex-1 overflow-y-auto
                                   overscroll-contain px-6 py-6"
                        >

                            {{ $slot }}

                        </div>


                        <!-- ============================== -->
                        <!-- FOOTER                          -->
                        <!-- ============================== -->

                        @if ($showFooter)

                            <div
                                class="flex shrink-0 items-center
                                       justify-end gap-3
                                       border-t border-gray-200
                                       bg-gray-50
                                       px-6 py-4
                                       dark:border-gray-700
                                       dark:bg-gray-900"
                            >

                                <!-- ====================== -->
                                <!-- CANCELAR                -->
                                <!-- ====================== -->

                                <button
                                    type="button"

                                    x-on:click="
                                        $dispatch(
                                            'close-modal',
                                            '{{ $id }}'
                                        )
                                    "

                                    class="rounded-md
                                           border border-gray-300
                                           bg-white
                                           px-4 py-2
                                           text-sm font-medium
                                           text-gray-700
                                           transition
                                           hover:bg-gray-100
                                           focus:outline-none
                                           focus:ring-2
                                           focus:ring-gray-400
                                           dark:border-gray-600
                                           dark:bg-gray-800
                                           dark:text-gray-200
                                           dark:hover:bg-gray-700"
                                >
                                    {{ $secondaryButtonText }}
                                </button>


                                <!-- ====================== -->
                                <!-- REGISTRAR               -->
                                <!-- ====================== -->

                                <button
                                    type="{{ $primaryButtonType }}"

                                    @if ($primaryButtonId)
                                        id="{{ $primaryButtonId }}"
                                    @endif

                                    class="rounded-md border
                                           dark:bg-[#eeeeec] dark:border-[#eeeeec] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white hover:bg-black hover:border-black px-5 py-1.5 bg-[#1b1b18] rounded-sm border border-black text-white text-sm leading-normal"
                                >
                                    {{ $primaryButtonText }}
                                </button>

                            </div>

                        @endif

                    </form>

                </div>

            </div>

        </div>

    </template>
</div>
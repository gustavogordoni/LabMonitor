<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Salas') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">
        @if (session()->has('message'))
            <div class="p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-white rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($rooms as $room)
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow space-y-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sala {{ $room['name'] }}</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Total: {{ $room['total'] }}</p>
                    <p class="text-sm text-green-600 dark:text-green-400">Ativos: {{ $room['active'] }}</p>
                    <p class="text-sm text-red-600 dark:text-red-400">Inativos: {{ $room['inactive'] }}</p>

                    <div class="flex gap-2 pt-2">
                        @if ($room['inactive'] > 0)
                            <button wire:click="activateAll('{{ $room['name'] }}')"
                                class="px-3 py-1.5 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Ativar Todos
                            </button>
                        @endif

                        @if ($room['active'] > 0)
                            <button wire:click="deactivateAll('{{ $room['name'] }}')"
                                class="px-3 py-1.5 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Inativar Todos
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

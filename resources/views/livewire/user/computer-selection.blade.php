<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Seleção de Computador') }}
    </h2>
</x-slot>

<div class="p-6 bg-white dark:bg-gray-900 rounded-lg space-y-6">

    @if (session()->has('error'))
        <div class="text-red-600 dark:text-red-400">{{ session('error') }}</div>
    @endif

    @if ($activeUsage)
        <div class="p-4 bg-blue-100 dark:bg-blue-800 rounded flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Sessão atual</h3>
                <p class="text-sm text-gray-700 dark:text-gray-200">
                    Ativa desde
                    <strong>{{ \Carbon\Carbon::parse($activeUsage->start_time)->format('d/m/y - H:i') }}</strong> no
                    computador <strong><span class="font-bold">{{ $activeUsage->computer->label }}</span></strong>
                </p>
            </div>
            <button wire:click="cancel" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded font-semibold">
                Cancelar utilização
            </button>
        </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($computers as $computer)
            <div
                class="border rounded-lg p-4 text-center shadow transition
                {{ $computer->status === 'available' && !$activeUsage ? 'bg-green-100 dark:bg-green-800' : 'bg-gray-200 dark:bg-gray-700 opacity-70 cursor-not-allowed' }}">

                <p class="font-bold text-lg text-gray-800 dark:text-white">{{ $computer->label }}</p>

                <p class="text-sm mb-2 text-white">
                    Status:
                    @switch($computer->status)
                        @case('available')
                            <span class="text-green-600 dark:text-green-400 font-semibold">Disponível</span>
                        @break

                        @case('in_use')
                            <span class="text-blue-600 dark:text-blue-400 font-semibold">Em uso</span>
                        @break

                        @default
                            <span class="text-gray-500">Indeterminado</span>
                    @endswitch
                </p>

                @if ($activeUsage && $computer->id === $activeUsage->computer_id)
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-300">Em uso</span>
                @elseif($computer->status === 'available' && !$activeUsage)
                    <button wire:click="select({{ $computer->id }})"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Solicitar
                    </button>
                @else
                    <span class="text-sm text-gray-500 dark:text-gray-400">Ação indisponível</span>
                @endif
            </div>
        @endforeach
    </div>
</div>
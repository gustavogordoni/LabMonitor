<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Seleção de Computador') }}
    </h2>
</x-slot>

<div class="p-6 bg-white dark:bg-gray-900 rounded-lg space-y-6">

    @if(session()->has('error'))
    <div class="text-red-600 dark:text-red-400">{{ session('error') }}</div>
    @endif

    @if($activeUsage)
    <div class="p-4 bg-blue-100 dark:bg-blue-800 rounded flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Iniciado em: {{ \Carbon\Carbon::parse($activeUsage->start_time)->format('d/m/y - H:i') }}
            </p>

            <p class="text-sm text-gray-600 dark:text-gray-300">
                Finalizado em: {{ \Carbon\Carbon::parse($activeUsage->end_time)->format('d/m/y - H:i') }}
            </p>
            
        </div>
        <button wire:click="cancel" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded font-semibold">
            Cancelar utilização
        </button>
    </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($computers as $computer)
        <div
            class="border rounded-lg p-4 text-center shadow
                {{ $computer->status === 'available' ? 'bg-green-100 dark:bg-green-800' : 'bg-gray-200 dark:bg-gray-700' }}">
            <p class="font-bold text-lg text-gray-800 dark:text-white">{{ $computer->label }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2 capitalize">
                Status: {{ str_replace('_', ' ', $computer->status) }}
            </p>

            @if($computer->status === 'available' && !$activeUsage)
            <button wire:click="select({{ $computer->id }})"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Solicitar
            </button>
            @elseif($activeUsage && $computer->id === $activeUsage->computer_id)
            <span class="text-sm font-semibold text-blue-600 dfark:text-blue-300">Em uso</span>
            @else
            <span class="text-sm text-gray-500 dark:text-gray-400">Indisponível</span>
            @endif
        </div>
        @endforeach
    </div>
</div>
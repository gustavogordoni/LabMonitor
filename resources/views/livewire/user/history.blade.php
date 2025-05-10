<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Histórico de Utilização') }}
    </h2>
</x-slot>

<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">

    @if($activeSession)
    <div class="p-4 bg-blue-100 dark:bg-blue-800 rounded flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Sessão atual</h3>
            <p class="text-sm text-gray-700 dark:text-gray-200">
                Ativa desde <strong>{{ \Carbon\Carbon::parse($activeSession->start_time)->format('d/m/y - H:i') }}</strong> no
                computador <strong><span class="font-bold">{{ $activeSession->computer->label }}</span></strong>
            </p>
        </div>
    </div>
    @endif

    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Informações gerais</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Tempo médio semanal</h3>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $averageWeekly }} min</p>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Tempo médio mensal</h3>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $averageMonthly }} min</p>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Total de sessões</h3>
            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $usages->count() }}</p>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Histórico completo</h3>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-center">
                    <tr>
                        <th class="px-4 py-2">Computador</th>
                        <th class="px-4 py-2">Início</th>
                        <th class="px-4 py-2">Fim</th>
                        <th class="px-4 py-2">Duração</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($usages as $usage)
                    <tr class="border-t border-gray-300 dark:border-gray-600">
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ $usage->computer->label }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($usage->start_time)->format('d/m/y - H:i') }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ $usage->end_time ? \Carbon\Carbon::parse($usage->end_time)->format('d/m/y - H:i') : 'Em
                            uso' }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ $usage->end_time ?
                            \Carbon\Carbon::parse($usage->start_time)->diffForHumans($usage->end_time, true) : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                            Nenhum registro encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
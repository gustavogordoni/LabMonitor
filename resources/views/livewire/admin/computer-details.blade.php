<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Detalhes do Computador: ') .  $computer->label}}
    </h2>
</x-slot>

<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Informações gerais</h3>    

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Status Atual</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ ucfirst($computer->status) }}</p>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Usos Hoje</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $dailyUsageCount }}</p>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow col-span-2">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Sessões Ativas</h3>
            @forelse($activeSessions as $session)
            <p class="text-gray-900 dark:text-white">
                {{ $session->user->name }} (iniciado às {{ \Carbon\Carbon::parse($session->start_time)->format('H:i')
                }})
            </p>
            @empty
            <p class="text-gray-500 dark:text-gray-400">Nenhuma sessão ativa.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Histórico de uso</h3>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2">Usuário</th>
                        <th class="px-4 py-2">Início</th>
                        <th class="px-4 py-2">Fim</th>
                        <th class="px-4 py-2">Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($computer->usages as $usage)
                    <tr class="border-t border-gray-300 dark:border-gray-600">
                        <td class="px-4 py-2 text-gray-800 dark:text-white"><a
                                href="{{ route('admin.student.details', ['userId' => $usage->user_id]) }}"
                                class="text-blue-500 hover:underline">
                                {{ $usage->user->name }}
                            </a></td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">{{
                            \Carbon\Carbon::parse($usage->start_time)->format('d/m/y - H:i') }}</td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ $usage->end_time ? \Carbon\Carbon::parse($usage->end_time)->format('d/m/y - H:i') : 'Em uso'
                            }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ $usage->end_time ?
                            \Carbon\Carbon::parse($usage->start_time)->diffForHumans($usage->end_time, true) : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Painel Administrativo</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Usuários cadastrados</h3>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalUsers }}</span>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Usos ativos</h3>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeUsages }}</span>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Computadores disponíveis</h3>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $availableComputers }}</span>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Total de advertências</h3>
            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalWarnings }}</span>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Sessões Ativas</h3>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2">Usuário</th>
                        <th class="px-4 py-2">Computador</th>
                        <th class="px-4 py-2">Início</th>
                        <th class="px-4 py-2">Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($activeSessions as $session)
                    <tr class="border-t border-gray-300 dark:border-gray-600">
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            <a href="{{ route('admin.user.details', ['userId' => $session->user_id]) }}"
                                class="text-blue-500 hover:underline">
                                {{ $session->user->name }}
                            </a>
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">{{ $session->computer->label }}</td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">{{
                            \Carbon\Carbon::parse($session->start_time)->format('H:i d/m') }}</td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            <button wire:click="forceEndSession({{ $session->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold">
                                Encerrar sessão
                            </button>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Nenhuma sessão
                            ativa no momento.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Histórico de Utilização - Hoje</h3>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2">Usuário</th>
                        <th class="px-4 py-2">Computador</th>
                        <th class="px-4 py-2">Início</th>
                        <th class="px-4 py-2">Término</th>
                        <th class="px-4 py-2">Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completedToday as $session)
                    <tr class="border-t border-gray-300 dark:border-gray-600">
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ $session->user->name }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ $session->computer->label }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                        </td>
                        <td class="px-4 py-2 text-gray-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($session->start_time)->diffForHumans($session->end_time, true) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                            Nenhum uso finalizado hoje.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
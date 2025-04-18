<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Perfil de {{ $user->name }}</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Email</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->email }}</p>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Função</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->role }}</p>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Advertências</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->warnings->count() }}</p>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Usos Totais</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->usages->count() }}</p>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Histórico de uso</h3>

        <div class="bg-white dark:bg-gray-800 rounded shadow overflow-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2">Computador</th>
                        <th class="px-4 py-2">Início</th>
                        <th class="px-4 py-2">Fim</th>
                        <th class="px-4 py-2">Duração</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user->usages as $usage)
                    <tr class="border-t border-gray-300 dark:border-gray-600">
                        <td class="px-4 py-2 text-gray-800 dark:text-white"> <a
                                href="{{ route('admin.computer.details', ['computerId' => $usage->computer_id]) }}"
                                class="text-blue-500 hover:underline">
                                {{ $usage->computer->label }}
                            </a>
                        </td>
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

    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Advertências</h3>

        <div class="bg-white dark:bg-gray-800 rounded shadow">
            @forelse($user->warnings as $warn)
            <div
                class="px-4 py-2 border-b border-gray-300 dark:border-gray-600 text-sm text-gray-700 dark:text-gray-300">
                <strong>{{ $warn->reason }}</strong> – <em>{{ \Carbon\Carbon::parse($warn->issued_at)->format('d/m H:i')
                    }}</em>

            </div>
            @empty
            <p class="px-4 py-4 text-gray-500 dark:text-gray-400">Sem advertências registradas.</p>
            @endforelse
        </div>
    </div>
</div>
<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Lista de Estudantes</h2>

    <input type="text" wire:model.debounce.500ms="search" placeholder="Pesquisar por nome"
        class="w-full md:w-1/3 px-4 py-2 rounded border dark:bg-gray-800 dark:text-white" />

    <div class="mt-4 overflow-auto rounded shadow">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr class="border-t border-gray-300 dark:border-gray-600">
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $student->name }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $student->email }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.student.details', ['userId' => $student->id]) }}"
                            class="text-blue-500 hover:underline">Ver detalhes</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        Nenhum estudante encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
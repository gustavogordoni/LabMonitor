<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Lista de Alunos') }}
    </h2>
</x-slot>

<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4 items-center">
        <div class="md:col-span-2">
            <input type="text" wire:model.live="search" placeholder="Pesquisar"
                class="w-full px-4 py-2 rounded border dark:bg-gray-800 dark:text-white" />
        </div>

        <div>
            <select wire:model.live="searchColumn" class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white">
                <option value="all">Pesquisar em todas</option>
                <option value="name">Nome</option>
                <option value="email">Email</option>
            </select>
        </div>
    </div>


    <div class="mt-4 overflow-auto rounded shadow">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-center">
                <tr>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Usos</th>
                    <th class="px-4 py-2">Advertências</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody class=" text-center">
                @forelse($students as $student)
                <tr class="border-t border-gray-300 dark:border-gray-600">
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $student->name }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $student->email }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $student->usages->count() }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $student->warnings->count() }}</td>
                    <td class="px-4 py-2 flex justify-center gap-3">
                        <a href="{{ route('admin.student.details', ['userId' => $student->id]) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700 rounded-md transition">
                            🔍 Ver detalhes
                        </a>
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
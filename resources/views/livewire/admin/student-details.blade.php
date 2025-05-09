<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Detalhes do Aluno: ') . $user->name }}
    </h2>
</x-slot>

<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Informações gerais</h3>

    <div class="flex flex-wrap gap-4">

        @if ($user->email != null)
            <div class="flex-1 min-w-[200px] bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
                <h3 class="text-sm text-gray-700 dark:text-gray-300">Email</h3>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->email }}</p>
            </div>
        @endif

        <div class="flex-1 min-w-[200px] bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Prontuário</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->enrollment }}</p>
        </div>

        <div class="flex-1 min-w-[200px] bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Curso</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->course }}</p>
        </div>

        <div class="w-28 bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-sm text-gray-700 dark:text-gray-300">Advertências</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->warnings->count() }}</p>
        </div>

        <div class="w-28 bg-gray-100 dark:bg-gray-800 p-4 rounded shadow">
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
                    @forelse($user->usages as $usage)
                        <tr class="border-t border-gray-300 dark:border-gray-600">
                            <td class="px-4 py-2 text-gray-800 dark:text-white"> <a
                                    href="{{ route('admin.computer.details', ['computerId' => $usage->computer_id]) }}"
                                    class="text-blue-500 hover:underline">
                                    {{ $usage->computer->label }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-gray-800 dark:text-white">
                                {{ \Carbon\Carbon::parse($usage->start_time)->format('d/m/y - H:i') }}</td>
                            <td class="px-4 py-2 text-gray-800 dark:text-white">
                                {{ $usage->end_time ? \Carbon\Carbon::parse($usage->end_time)->format('d/m/y - H:i') : 'Em uso' }}
                            </td>
                            <td class="px-4 py-2 text-gray-800 dark:text-white">
                                {{ $usage->end_time ? \Carbon\Carbon::parse($usage->start_time)->diffForHumans($usage->end_time, true) : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">Não possui
                                histórico de sessões.</td>
                        </tr>
                    @endforelse
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
                    <strong>{{ $warn->reason }}</strong> –
                    <em>{{ \Carbon\Carbon::parse($warn->issued_at)->format('d/m H:i') }}</em>

                </div>
            @empty
                <p class="px-4 py-4 text-gray-500 dark:text-gray-400">Sem advertências registradas.</p>
            @endforelse
        </div>
    </div>

    <div class="flex justify-end mb-4">
        <x-danger-button wire:click="confirmStudentDeletion">
            Excluir usuário
        </x-danger-button>
    </div>

    <!-- Modal de confirmação de exclusão -->
    <x-dialog-modal wire:model.live="confirmingStudentDeletion">
        <x-slot name="title">
            Confirmar exclusão
        </x-slot>

        <x-slot name="content">
            Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita.
            Por favor, confirme com sua senha de administrador.

            <div class="mt-4" x-data="{}"
                x-on:confirming-student-deletion.window="setTimeout(() => $refs.password.focus(), 250)">
                <x-input type="password" class="mt-1 block w-3/4" placeholder="Senha" autocomplete="current-password"
                    x-ref="password" wire:model.live="adminPassword" wire:keydown.enter="deleteStudent" />

                <x-input-error for="adminPassword" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingStudentDeletion', false)">
                Cancelar
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteStudent">
                Confirmar exclusão
            </x-danger-button>
        </x-slot>
    </x-dialog-modal>
</div>

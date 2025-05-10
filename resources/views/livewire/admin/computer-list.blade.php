<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Lista de Computadores') }}
    </h2>
</x-slot>

<div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4 items-center">
        <div class="md:col-span-2">
            <input type="text" wire:model.live="search" placeholder="Pesquisar"
                class="w-full px-4 py-2 rounded border dark:bg-gray-800 dark:text-white" />
        </div>

        <div>
            <select wire:model.live="statusFilter"
                class="w-full px-3 py-2 border rounded dark:bg-gray-800 dark:text-white">
                <option value="all">Todos os Status</option>
                <option value="disponível">Disponível</option>
                <option value="em uso">Em uso</option>
                <option value="indisponível">Indisponível</option>
            </select>
        </div>
    </div>

    <div class="mt-4 overflow-auto rounded shadow">
        <table class="min-w-full text-left text-sm">    
            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-center">
                <tr>
                    <th class="px-4 py-2">Etiqueta</th>
                    <th class="px-4 py-2">Sala</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($computers as $computer)
                <tr class="border-t border-gray-300 dark:border-gray-600">
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $computer->label }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-white">{{ $computer->room }}</td>
                    <td class="px-4 py-2 text-gray-900 dark:text-white">
                        @switch($computer->status)
                        @case('available')
                        <span class="text-green-600 dark:text-green-400 font-bold">Disponível</span>
                        @break
                        @case('in_use')
                        <span class="text-blue-600 dark:text-blue-400 font-bold">Em uso</span>
                        @break
                        @case('inactive')
                        <span class="text-red-600 dark:text-red-400 font-bold">Indisponível</span>
                        @break
                        @default
                        Indeterminado
                        @endswitch
                    </td>
                    <td class="px-4 py-2 flex justify-center gap-3">
                        <a href="{{ route('admin.computer.details', ['computerId' => $computer->id]) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 dark:bg-gray-800 dark:text-blue-400 dark:hover:bg-gray-700 rounded-md transition">
                            Ver detalhes
                        </a>

                        @if($computer->status === 'available' || $computer->status === 'in_use')
                        <a href="#" wire:click.prevent="inactivateComputer({{ $computer->id }})"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700 rounded-md transition">
                            Inativar
                        </a>
                        @else
                        <a href="#" wire:click.prevent="availableComputer({{ $computer->id }})"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-green-600 bg-green-50 hover:bg-green-100 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700 rounded-md transition">
                            Ativar
                        </a>
                        @endif
                        @if($computer->status === 'available')
                        <button wire:click="openUserModal({{ $computer->id }})"
                            class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-medium text-orange-600 bg-orange-50 hover:bg-orange-100 dark:bg-gray-800 dark:text-orange-400 dark:hover:bg-gray-700 rounded-md transition">
                            Associar Usuário
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                        Nenhum computador encontrado.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($showUserModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md p-6 space-y-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Associar Usuário ao Computador</h2>

                <div class="space-y-2">
                    <label for="user" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Buscar Usuário
                    </label>
                    <div class="relative">
                        <input type="text" id="user" wire:model.live="searchUser"
                            placeholder="Digite o nome do usuário..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            autocomplete="off">

                        @if($searchUser && !$selectedUserId)
                        <ul
                            class="absolute z-50 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow mt-2 max-h-60 overflow-y-auto">
                            @forelse($this->filteredUsers as $user)
                            <li wire:click="selectUser({{ $user->id }})"
                                class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-white">
                                {{ $user->name }} <span class="text-xs text-gray-500">({{ $user->email }})</span>
                            </li>
                            @empty
                            <li class="px-4 py-2 text-gray-500 dark:text-gray-400">Nenhum usuário encontrado</li>
                            @endforelse
                        </ul>
                        @endif
                    </div>

                    @if($selectedUserId)
                    <div class="text-green-600 dark:text-green-400 text-sm mt-2">
                        Usuário selecionado: <strong>{{ $selectedUserName }}</strong>
                    </div>
                    @endif

                    @error('selectedUserId')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <hr class="border-t dark:border-gray-600">

                <div class="flex justify-end gap-3 pt-2">
                    <button wire:click="$set('showUserModal', false)"
                        wire:click.prevent="$set('selectedUserId', null); $set('searchUser', ''); $set('selectedUserName', null)"
                        class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition">
                        Cancelar
                    </button>
                    <button wire:click="createManualSession"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md transition">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>
        @endif

    </div>

    <div class="mt-4">
        {{ $computers->links() }}
    </div>
</div>
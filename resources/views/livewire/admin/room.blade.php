<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Salas') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-900 rounded-lg shadow space-y-6">
        @if (session()->has('message'))
            <div class="p-4 bg-green-100 dark:bg-green-800 text-green-800 dark:text-white rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($rooms as $room)
                <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded shadow space-y-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Sala {{ $room['name'] }}</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300">Total: {{ $room['total'] }}</p>
                    <p class="text-sm text-green-600 dark:text-green-400">Ativos: {{ $room['active'] }}</p>
                    <p class="text-sm text-red-600 dark:text-red-400">Inativos: {{ $room['inactive'] }}</p>

                    <div class="flex gap-2 pt-2">
                        @if ($room['inactive'] > 0)
                            <button wire:click="activateAll('{{ $room['name'] }}')"
                                class="px-3 py-1.5 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Ativar Todos
                            </button>
                        @endif

                        @if ($room['active'] > 0)
                            <button wire:click="deactivateAll('{{ $room['name'] }}')"
                                class="px-3 py-1.5 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Inativar Todos
                            </button>
                        @endif

                        <button wire:click="showRoomComputers('{{ $room['name'] }}')"
                            class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Gerenciar
                        </button>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-dialog-modal wire:model.live="showRoomModal">
        <x-slot name="title">
            Computadores da Sala {{ $selectedRoomName }}
        </x-slot>

        <x-slot name="content">
            @if ($editingComputer)
                <div class="mt-4 space-y-4">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Editar Computador</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label for="editLabel" value="Etiqueta" />
                            <x-input id="editLabel" wire:model.live="editLabel" type="text"
                                class="mt-1 block w-full dark:bg-gray-800" />
                            @error('editLabel')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <x-label for="editCode" value="Código" />
                            <x-input id="editCode" wire:model.live="editCode" type="text"
                                class="mt-1 block w-full dark:bg-gray-800" />
                            @error('editCode')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            @else
                <table class="w-full text-sm table-auto mt-2">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr class="text-left text-gray-700 dark:text-gray-200">
                            <th class="px-3 py-2">Etiqueta</th>
                            <th class="px-3 py-2">Código</th>
                            <th class="px-3 py-2 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($selectedComputers as $computer)
                            <tr class="border-t border-gray-300 dark:border-gray-600">
                                <td class="px-3 py-2 text-gray-800 dark:text-white">{{ $computer['label'] }}</td>
                                <td class="px-3 py-2 text-gray-800 dark:text-white">{{ $computer['code'] }}</td>
                                <td class="px-3 py-2 flex justify-center gap-2">
                                    <button wire:click="startEdit({{ $computer['id'] }})"
                                        class="px-2 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                                        Editar
                                    </button>
                                    <button wire:click="deleteComputer({{ $computer['id'] }})"
                                        class="px-2 py-1 text-sm bg-red-600 hover:bg-red-700 text-white rounded transition">
                                        Excluir
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum computador nesta sala.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-center gap-2 mt-4">
                <x-secondary-button wire:click="$set('showRoomModal', false)">
                    Fechar
                </x-secondary-button>

                @if ($editingComputer)
                    <x-secondary-button wire:click="cancelEdit">
                        Cancelar
                    </x-secondary-button>

                    <x-button wire:click="saveEdit">
                        Salvar Alterações
                    </x-button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>

</div>

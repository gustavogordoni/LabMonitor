<div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    
    
    <x-application-logo class="block h-12 w-auto" />

    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        Sobre o Sistema de Gerenciamento de PC
    </h1>

    <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
        Este sistema foi desenvolvido para facilitar o gerenciamento do uso dos PCs em laboratórios de informática. 
        Com ele, usuários podem se cadastrar e escolher os PCs disponíveis, enquanto os administradores podem controlar os registros de uso e gerar relatórios.
    </p>

    <div class="mt-8">
        @guest
            <p class="text-gray-500 dark:text-gray-400">Você não está autenticado. Faça login para acessar o sistema.</p>
        @else
            @if($user->role == 'admin')
                <h3 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Bem-vindo, Administrador!</h3>
                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    Como administrador, você pode gerenciar todos os registros de uso dos PCs, gerenciar os usuários e gerar relatórios detalhados de uso.
                </p>
            @else
                <h3 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Bem-vindo, {{ $user->name }}!</h3>
                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    Como aluno, você pode registrar o uso de PCs disponíveis e acompanhar o tempo de uso. Escolha um PC para começar.
                </p>
            @endif
        @endguest
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Como Funciona?</h2>
        <p class="mt-4 text-gray-500 dark:text-gray-400">
            O sistema permite que você registre a utilização de PCs em laboratórios, com a opção de escolher um PC disponível. 
            Para administradores, há uma interface para gerenciar o uso e gerar relatórios em Excel.
        </p>
    </div>
</div>

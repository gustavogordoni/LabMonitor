<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="enrollment" value="{{ __('Prontuário') }}" />
                <x-input id="enrollment" class="block mt-1 w-full uppercase" type="text" name="enrollment"
                    :value="old('enrollment', 'VP')" required minlength="9" maxlength="9" autocomplete="off" />
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('enrollment');

                    if (input.value === '') {
                        input.value = 'VP';
                    }

                    input.addEventListener('keydown', function(e) {
                        const value = this.value;
                        const isLetter = /^[a-zA-Z]$/.test(e.key);
                        const isNumber = /^[0-9]$/.test(e.key);
                        const isControlKey = ['Backspace', 'ArrowLeft', 'ArrowRight', 'Tab', 'Delete'].includes(e
                            .key);

                        if (isControlKey) return;

                        if (value.length < 2 && !isLetter) {
                            e.preventDefault();
                        } else if (value.length >= 2 && value.length < 9 && !isNumber) {
                            e.preventDefault();
                        } else if (value.length >= 9) {
                            e.preventDefault();
                        }
                    });

                    input.addEventListener('input', function() {
                        this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 9);
                    });
                });
            </script>

            <div class="mt-4">
                <x-label for="course" value="{{ __('Curso') }}" />
                <x-select id="course" class="block mt-1 w-full py-2.5" name="course" required>
                    <option value="">Selecione um curso</option>
                    <option value="Informática" @selected(old('course') == 'Informática')>Informática</option>
                    <option value="Mecatrônica" @selected(old('course') == 'Mecatrônica')>Mecatrônica</option>
                    <option value="Edificações" @selected(old('course') == 'Edificações')>Edificações</option>
                    <option value="Engenharia Civil" @selected(old('course') == 'Engenharia Civil')>Engenharia Civil</option>
                    <option value="Engenharia Elétrica" @selected(old('course') == 'Engenharia Elétrica')>Engenharia Elétrica</option>
                    <option value="Física" @selected(old('course') == 'Física')>Física</option>
                    <option value="Sistemas de Informação" @selected(old('course') == 'Sistemas de Informação')>Sistemas de Informação</option>
                </x-select>

            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Cadastre-se') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cotações</title>
    <!-- Inclua o CSS compilado do Tailwind -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
<!-- Cabeçalho e Navegação -->
<header class="bg-white shadow">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                <span class="sr-only">Sistema de Cotações</span>
                <!-- Substitua o src abaixo pelo caminho do seu logo -->
                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Logo">
            </a>
        </div>
        <div class="flex lg:hidden">
            <button id="mobile-menu-button" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" aria-expanded="false">
                <span class="sr-only">Abrir menu principal</span>
                <!-- Ícone de menu -->
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="{{ route('solicitacoes.index') }}" class="text-sm font-semibold leading-6 text-gray-900">Solicitações de Cotação</a>
            <!-- Adicione links de autenticação aqui, se necessário -->
        </div>
{{--        <div class="hidden lg:flex lg:flex-1 lg:justify-end">--}}
{{--            <!-- Exemplo de link de login/logout -->--}}
{{--            @auth--}}
{{--                <form method="POST" action="{{ route('logout') }}">--}}
{{--                    @csrf--}}
{{--                    <button type="submit" class="text-sm font-semibold leading-6 text-gray-900">Sair <span aria-hidden="true">&rarr;</span></button>--}}
{{--                </form>--}}
{{--            @else--}}
{{--                <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-gray-900">Entrar <span aria-hidden="true">&rarr;</span></a>--}}
{{--            @endauth--}}
{{--        </div>--}}
    </nav>
    <!-- Menu Mobile -->
    <div id="mobile-menu" class="hidden lg:hidden" role="dialog" aria-modal="true">
        <!-- Fundo do menu -->
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-20 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="-m-1.5 p-1.5">
                    <span class="sr-only">Sistema de Cotações</span>
                    <!-- Substitua o src abaixo pelo caminho do seu logo -->
                    <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Logo">
                </a>
                <button id="close-mobile-menu-button" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Fechar menu</span>
                    <!-- Ícone de fechar -->
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="{{ route('solicitacoes.index') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Solicitações de Cotação</a>
                         <!-- Adicione links de autenticação aqui, se necessário -->
                    </div>
{{--                    <div class="py-6">--}}
{{--                        @auth--}}
{{--                            <form method="POST" action="{{ route('logout') }}">--}}
{{--                                @csrf--}}
{{--                                <button type="submit" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Sair</button>--}}
{{--                            </form>--}}
{{--                        @else--}}
{{--                            <a href="{{ route('login') }}" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Entrar</a>--}}
{{--                        @endauth--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Conteúdo Principal -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <!-- Mensagens de sucesso/erro -->
    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Ícone de sucesso -->
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Ícone de erro -->
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Conteúdo da página -->
    <main>
        @yield('content')
    </main>
</div>

<!-- Scripts para o menu mobile -->
<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu-button');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
    });

    closeMobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
    });

    // Fechar o menu ao clicar fora dele
    window.addEventListener('click', function(event) {
        if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
</script>
</body>
</html>

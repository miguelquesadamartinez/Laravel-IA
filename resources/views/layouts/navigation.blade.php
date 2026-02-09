<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @php
                        $usersActive = request()->routeIs('users.*');
                        $usersClasses = $usersActive
                            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
                            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
                    @endphp

                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" class="{{ $usersClasses }} h-16">
                                {{ __('Usuarios') }}
                                <svg class="ms-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('users.index')">
                                {{ __('Listado') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('users.create')">
                                {{ __('Nuevo') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    @php
                        $aiActive = request()->routeIs('ai.*');
                        $aiClasses = $aiActive
                            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition ease-in-out duration-150'
                            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150';
                    @endphp

                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button type="button" class="{{ $aiClasses }} h-16">
                                {{ __('IA') }}
                                <svg class="ms-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('ai.index', 'openai')">
                                {{ __('OpenAI') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ai.index', 'anthropic')">
                                {{ __('Anthropic') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ai.index', 'gemini')">
                                {{ __('Gemini') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ai.index', 'groq')">
                                {{ __('Groq') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ai.index', 'xai')">
                                {{ __('xAI') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ai.index', 'deepseek')">
                                {{ __('DeepSeek') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ai.index', 'mistral')">
                                {{ __('Mistral') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('ai.index', 'ollama')">
                                {{ __('Ollama') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-nav-link :href="route('multi-search.index')" :active="request()->routeIs('multi-search.*')">
                            {{ __('Multi Búsqueda') }}
                        </x-nav-link>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <div class="px-3 pt-2 text-xs font-semibold uppercase text-gray-500">
                {{ __('Usuarios') }}
            </div>
            <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="ps-6">
                {{ __('Listado') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('users.create')" :active="request()->routeIs('users.create')" class="ps-6">
                {{ __('Nuevo') }}
            </x-responsive-nav-link>
            <div class="px-3 pt-2 text-xs font-semibold uppercase text-gray-500">
                {{ __('IA') }}
            </div>
            <x-responsive-nav-link :href="route('ai.index', 'openai')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'openai'" class="ps-6">
                {{ __('OpenAI') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.index', 'anthropic')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'anthropic'" class="ps-6">
                {{ __('Anthropic') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.index', 'gemini')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'gemini'" class="ps-6">
                {{ __('Gemini') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.index', 'groq')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'groq'" class="ps-6">
                {{ __('Groq') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.index', 'xai')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'xai'" class="ps-6">
                {{ __('xAI') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.index', 'deepseek')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'deepseek'" class="ps-6">
                {{ __('DeepSeek') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.index', 'mistral')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'mistral'" class="ps-6">
                {{ __('Mistral') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ai.index', 'ollama')" :active="request()->routeIs('ai.*') && request()->route('provider') === 'ollama'" class="ps-6">
                {{ __('Ollama') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('multi-search.index')" :active="request()->routeIs('multi-search.*')">
                {{ __('Multi Búsqueda') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

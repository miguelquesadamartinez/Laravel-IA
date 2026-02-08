<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buscar en ChatGPT') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <form method="POST" action="{{ route('chatgpt.search') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="query" :value="__('Consulta')" />
                            <textarea id="query" name="query" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Escribe tu pregunta...">{{ old('query', $query ?? '') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('query')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Buscar') }}</x-primary-button>
                        </div>
                    </form>

                    @isset($answer)
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-800">Respuesta</h3>
                            <div class="mt-3 whitespace-pre-line text-gray-700">
                                {{ $answer }}
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

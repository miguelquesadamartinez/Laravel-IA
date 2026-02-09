<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Multi Búsqueda IA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('multi-search.search') }}" method="POST" class="mb-6">
                        @csrf
                        <div>
                            <label for="query" class="block text-sm font-medium text-gray-700">Consulta a múltiples IAs</label>
                            <div class="mt-1">
                                <textarea id="query" name="query" rows="4" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Escribe tu pregunta aquí...">{{ old('query', $query ?? '') }}</textarea>
                            </div>
                            @error('query')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-primary-button>
                                {{ __('Consultar') }}
                            </x-primary-button>
                        </div>
                    </form>

                    @if(isset($summary))
                        <div class="mb-8 border-b pb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 bg-yellow-100 p-2 rounded">Resumen y Análisis de Contradicciones (por Gemini)</h3>
                            <div class="prose max-w-none text-gray-800 bg-gray-50 p-4 rounded-lg">
                                {!! nl2br(e($summary)) !!}
                            </div>
                        </div>
                    @endif

                    @if(isset($results))
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Resultados Individuales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($results as $provider => $response)
                                <div class="bg-white border rounded-lg shadow-sm p-4">
                                    <h4 class="font-semibold text-indigo-600 mb-2">{{ $provider }}</h4>
                                    <div class="prose prose-sm max-w-none text-gray-600">
                                        {!! nl2br(e($response)) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(isset($aiErrors) && count($aiErrors) > 0)
                        <div class="mt-8">
                            <h4 class="font-semibold text-red-600 mb-2">Errores / IAs no disponibles:</h4>
                            <ul class="list-disc pl-5 text-sm text-red-500">
                                @foreach($aiErrors as $provider => $error)
                                    <li><strong>{{ $provider }}:</strong> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

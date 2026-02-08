<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Usuarios') }}
            </h2>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                {{ __('Nuevo usuario') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Creado</th>
                                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-3 py-2 text-sm text-gray-700">{{ $user->id }}</td>
                                        <td class="px-3 py-2 text-sm text-gray-700">{{ $user->name }}</td>
                                        <td class="px-3 py-2 text-sm text-gray-700">{{ $user->email }}</td>
                                        <td class="px-3 py-2 text-sm text-gray-700">{{ $user->created_at?->format('Y-m-d') }}</td>
                                        <td class="px-3 py-2 text-right text-sm">
                                            <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="ml-3 text-red-600 hover:text-red-800" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-3 py-6 text-center text-sm text-gray-500" colspan="5">No hay usuarios registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

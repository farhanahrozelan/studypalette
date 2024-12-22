<x-app-layout>
    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-100">

                    <h1 class="text-2xl font-medium text-gray-900">Shared Notes</h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                        @forelse($sharedNotes as $note)
                            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                                <!-- Note Title -->
                                <div class="flex justify-between items-center">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $note->title }}</h2>
                              
                                    </div>
                                <!-- Note Summary -->
                                <p class="text-gray-600 mt-2">
                                    {{ \Illuminate\Support\Str::limit($note->key_points, 100) }}
                                </p>
                                
                                <!-- Shared By Information -->
                                <p class="text-gray-500 text-sm mt-2">
                                    Shared by: {{ $note->user->name }}
                                </p>

                                <!-- View Full Note Button -->
                                <div class="mt-4">
                                    <a href="{{ route('notes.shared.show', $note->id) }}" 
                                       class="text-blue-500 hover:text-blue-700 transition">
                                       <i class="fas fa-eye"></i>
                                    </a>
                                    
                                </div>
                            </div>
                        @empty
                            <p class="col-span-3 text-gray-500 text-center">
                                No shared notes available at the moment.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

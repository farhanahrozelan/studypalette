<x-app-layout>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Page Title and Back Button -->
            <div class="flex justify-between items-center mb-6">
                <!-- Note Title -->
                <h1 class="text-2xl font-bold text-gray-800">{{ $note->title }}</h1>
                <!-- Back Button -->
                <a href="{{ route('notes.index') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            
            <!-- Flexbox layout for Key Points, Notes, and Summary -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Key Points -->
                <div class="p-4 bg-gray-100 border border-gray-300 rounded-md">
                    <h2 class="text-lg font-semibold text-gray-700">Key Points:</h2>
                    <p class="text-gray-600">{{ $note->key_points ?? 'No key points provided.' }}</p>
                </div>
                <!-- Notes -->
                <div class="col-span-2 p-4 bg-gray-100 border border-gray-300 rounded-md">
                    <h2 class="text-lg font-semibold text-gray-700">Notes:</h2>
                    <p class="text-gray-600">{{ $note->notes ?? 'No additional notes provided.' }}</p>
                </div>
            </div>

            <!-- Summary -->
            <div class="p-4 bg-gray-100 border border-gray-300 rounded-md mb-6">
                <h2 class="text-lg font-semibold text-gray-700">Summary:</h2>
                <p class="text-gray-600">{{ $note->summary ?? 'No summary provided.' }}</p>
            </div>

            <!-- Edit and Delete Buttons -->
            <div class="flex justify-end space-x-2">
                <!-- Edit -->
                <a href="{{ route('notes.edit', $note->id) }}" 
                   class="text-green-500 hover:text-green-700 transition">
                    <i class="fas fa-edit"></i>
                </a>
                <!-- Delete -->
                <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700 transition"
                            onclick="return confirm('Are you sure you want to delete this note?');">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
</x-app-layout>

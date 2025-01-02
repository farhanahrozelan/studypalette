<x-app-layout>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-100">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-medium text-gray-900">My Notes</h1>
                    <!-- Create New Note Button -->
                    <a href="{{ route('notes.create') }}" 
                       class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                       <i class="fas fa-plus"></i>
                    </a>
                </div>  

                <!-- Notes Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    @forelse($notes as $note)
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                            <!-- Note Title and Share Button -->
                            <div class="flex justify-between items-center">
                                <h2 class="text-lg font-semibold text-gray-800">{{ $note->title }}</h2>
                                <!-- Share Button (Only visible if the note is not already shared) -->
                                @if (!$note->is_shared)
                                    <form action="{{ route('notes.share', ['note' => $note->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-500 hover:text-blue-700 transition">
                                            <i class="fas fa-share-alt"></i> Share
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Note Summary -->
                            <p class="text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($note->summary, 100) }}</p>

                            <!-- Actions -->
                            <div class="mt-4 flex justify-between items-center">
                                <!-- View -->
                                <a href="{{ route('notes.show', $note->id) }}" 
                                   class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="fas fa-eye"></i>
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
                    @empty
                        <p class="col-span-3 text-gray-500 text-center">
                            No notes available. Start by creating a new note!
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
</x-app-layout>

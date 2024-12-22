<x-app-layout>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Page Title and Back Button -->
            <div class="flex justify-between items-center mb-6">
                <!-- Note Title and Shared By -->
                <h1 class="text-2xl font-medium text-gray-900 mt-4">{{ $note->title }}
                    <div class="text-gray-500 text-sm mt-2">
                        Shared by: {{ $note->user->name }}
                    </div>
                </h1>

                <!-- Report and Back Buttons -->
                <div class="flex items-center space-x-2">
                     <!-- Report Button -->
    <form action="{{ route('notes.report', $note->id) }}" method="POST" class="inline">
        @csrf
        <input type="hidden" name="reason" value="Inappropriate content">
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow-md transition duration-200"
                onclick="return confirm('Are you sure you want to report this note?');">
            <i class="fas fa-flag"></i> Report
        </button>
    </form>

                    <!-- Back Button -->
                    <a href="{{ route('notes.shared') }}" 
                       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
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
        </div>
    </div>
</div>
@endsection
</x-app-layout>

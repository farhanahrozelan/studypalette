<x-app-layout>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Page Title and Buttons -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $flashcardSet->name }}</h1>
                <div class="flex space-x-2">
                    <!-- Back Button -->
                    <a href="{{ route('flashcards.index') }}" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                    <i class="fas fa-arrow-left"></i> 
                </a>
                </div>
            </div>

            <!-- Flashcard Container -->
            <div id="flashcard-container" class="flashcard-container">
                @foreach ($flashcardSet->flashcards as $index => $flashcard)
                    <div class="flashcard {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                        <div class="front p-4"> <!-- Added padding -->
                            <h2 class="text-lg font-bold text-gray-700">{{ $flashcard->title }}</h2>
                            <p class="text-gray-600">{{ $flashcard->question }}</p>
                        </div>
                        <div class="back p-4"> <!-- Added padding -->
                            <p class="text-gray-600">{{ $flashcard->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-center space-x-4 mt-4">
                <button id="prev" disabled 
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-full shadow-md transition duration-200 hover:bg-gray-400 disabled:opacity-50">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="next" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-full shadow-md transition duration-200 hover:bg-blue-600 disabled:opacity-50">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Add new flashcard Buttons -->
            <div class="flex justify-end space-x-2">            
                <!-- Add Button -->
                <a href="{{ route('flashcards.add', $flashcardSet->id) }}" 
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                    <i class="fas fa-plus"></i> Add New Flashcard
                </a>
               
            </div>
        </div>
    </div>
</div>
@endsection
</x-app-layout>

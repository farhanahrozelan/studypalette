@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">

            <h1 class="text-2xl font-medium mb-6">Edit Flashcard Set</h1>

              <!-- Back Button -->
              <a href="{{ route('flashcards.index') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                   <i class="fas fa-arrow-left"></i>
                </a>
            </div>

            <form action="{{ route('flashcards.update', $flashcardSet->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Flashcard Set Name -->
                <div class="mb-6">
                    <label for="set_name" class="block text-gray-700 font-medium">Flashcard Set Name:</label>
                    <input type="text" name="set_name" id="set_name" 
                           value="{{ old('set_name', $flashcardSet->name) }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                
                        </div>

                <!-- Flashcards -->
                <h2 class="text-lg font-medium mb-4">Flashcards</h2>
                @foreach($flashcardSet->flashcards as $index => $flashcard)
                    <div class="mb-6 border p-4 rounded-lg shadow-sm">
                        <input type="hidden" name="flashcards[{{ $index }}][id]" value="{{ $flashcard->id }}">

                        <!-- Question -->
                        <div class="mb-2">
                            <label for="flashcards[{{ $index }}][question]" class="block text-gray-700 font-medium">Question:</label>
                            <input type="text" name="flashcards[{{ $index }}][question]" 
                                   value="{{ old("flashcards.$index.question", $flashcard->question) }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <!-- Answer -->
                        <div>
                            <label for="flashcards[{{ $index }}][answer]" class="block text-gray-700 font-medium">Answer:</label>
                            <input type="text" name="flashcards[{{ $index }}][answer]" 
                                   value="{{ old("flashcards.$index.answer", $flashcard->answer) }}" 
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                    </div>
                @endforeach

                <!-- Add Flashcard -->
                <div id="new-flashcards"></div>
                <button type="button" onclick="addNewFlashcard()" 
                        class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 mb-6">
                        <i class="fas fa-plus"></i> New Flashcard
                </button>

                <!-- Submit -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded shadow hover:bg-blue-600">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let newFlashcardIndex = {{ $flashcardSet->flashcards->count() }};
    function addNewFlashcard() {
        const container = document.getElementById('new-flashcards');
        container.innerHTML += `
            <div class="mb-6 border p-4 rounded-lg shadow-sm">
                <div class="mb-2">
                    <label class="block text-gray-700 font-medium">Question:</label>
                    <input type="text" name="flashcards[${newFlashcardIndex}][question]" 
                           placeholder="Enter the question"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Answer:</label>
                    <input type="text" name="flashcards[${newFlashcardIndex}][answer]" 
                           placeholder="Enter the answer"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
            </div>
        `;
        newFlashcardIndex++;
    }
</script>
@endsection

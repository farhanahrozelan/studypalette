<x-app-layout>
    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Page Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Add Flashcard</h1>

                <!-- Add Flashcard Form -->
                <form method="POST" action="{{ route('flashcards.storeFlashcard', $flashcardSet->id) }}">
                    @csrf
                    <!-- Question Field -->
                    <div class="mb-4">
                        <label for="question" class="block text-sm font-medium text-gray-700">Question</label>
                        <textarea id="question" name="question" rows="4" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('question')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Answer Field -->
                    <div class="mb-4">
                        <label for="answer" class="block text-sm font-medium text-gray-700">Answer</label>
                        <textarea id="answer" name="answer" rows="4" required
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        @error('answer')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded shadow-md hover:bg-blue-600 transition">
                            Add Flashcard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

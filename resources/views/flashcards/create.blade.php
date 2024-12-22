<x-app-layout>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Create Flashcards</h1>
                <a href="{{ route('flashcards.index') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            <form action="{{ route('flashcards.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="set_name" class="block text-sm font-medium text-gray-700">Flashcard Set (Optional)</label>
                    <input type="text" name="set_name" id="set_name" placeholder="E.g., Math Revision" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div id="flashcards-container">
                    <div class="flashcard-form-item">
                        <div class="mb-4">
                            <label for="question_1" class="block text-sm font-medium text-gray-700">Question</label>
                            <textarea name="questions[]" id="question_1" rows="3" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="answer_1" class="block text-sm font-medium text-gray-700">Answer</label>
                            <textarea name="answers[]" id="answer_1" rows="3" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-flashcard" 
                        class="bg-blue-500 text-white px-4 py-2 rounded shadow-md transition duration-200 hover:bg-blue-600">
                    <i class="fas fa-plus"></i> Add Flashcard
                </button>

                <button type="submit" 
                        class="bg-green-500 text-white px-4 py-2 rounded shadow-md transition duration-200 hover:bg-green-600 mt-4">
                    Save Flashcards
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let count = 1;
    document.getElementById('add-flashcard').addEventListener('click', () => {
        count++;
        const container = document.getElementById('flashcards-container');
        container.insertAdjacentHTML('beforeend', `
            <div class="flashcard-form-item">
                <div class="mb-4">
                    <label for="question_${count}" class="block text-sm font-medium text-gray-700">Question</label>
                    <textarea name="questions[]" id="question_${count}" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="answer_${count}" class="block text-sm font-medium text-gray-700">Answer</label>
                    <textarea name="answers[]" id="answer_${count}" rows="3" 
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
        `);
    });
</script>
@endsection
</x-app-layout>

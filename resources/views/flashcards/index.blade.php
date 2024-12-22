@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-100">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-medium text-gray-900">My Flashcards</h1>
                    <!-- Create New Flashcard Button -->
                    <a href="{{ route('flashcards.create') }}" 
                       class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                       <i class="fas fa-plus"></i>
                    </a>
                </div>

                <!-- Flashcard Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    @forelse($flashcardSets as $set)
                        <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                            <!-- Flashcard Set Title -->
                            <h2 class="text-lg font-semibold text-gray-800">{{ $set->name }}</h2>
                            <!-- Flashcard Count -->
                            <p class="text-gray-600 mt-2">
                                {{ $set->flashcards->count() }} Flashcards
                            </p>
                            <!-- Actions -->
                            <div class="mt-4 flex justify-between items-center">
                                <!-- View -->
                                <a href="{{ route('flashcards.show', $set->id) }}" 
                                   class="text-blue-500 hover:text-blue-700 transition">
                                    <i class="fas fa-eye"></i> 
                                </a>

                                <!-- Actions (Edit and Delete) -->
                                <div class="flex space-x-4">
                                    <!-- Edit -->
                                    <a href="{{ route('flashcards.edit', $set->id) }}" 
                                       class="text-green-500 hover:text-green-700 transition">
                                       <i class="fas fa-edit"></i> 
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('flashcards.destroy', $set->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition"
                                        onclick="showDeleteModal({{ $set->id }})">    
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State -->
                        <p class="col-span-3 text-gray-500 text-center">
                            No flashcard sets available. Start by creating a new set!
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Are you sure you want to delete this flashcard set?</h2>
        <div class="flex justify-between">
            <button id="cancel-btn" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                Cancel
            </button>
            <button id="confirm-btn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Confirm
            </button>
        </div>
    </div>
</div>

<script>
    function showDeleteModal(id) {
        // Show the modal
        document.getElementById('delete-modal').classList.remove('hidden');
        
        // Set the form's action to the specific delete route
        document.getElementById('confirm-btn').onclick = function() {
            document.getElementById('delete-form-' + id).submit();
        };

        // Close the modal if the user clicks "Cancel"
        document.getElementById('cancel-btn').onclick = function() {
            document.getElementById('delete-modal').classList.add('hidden');
        };
    }
</script>
@endsection

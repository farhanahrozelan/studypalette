<x-app-layout>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <!-- Page Title and Back Button -->
            <div class="flex justify-between items-center mb-6">
                <!-- Title -->
                <h1 class="text-2xl font-bold text-gray-800">Edit Note</h1>

                <!-- Back Button -->
                <a href="{{ route('notes.index') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                    Back
                </a>
            </div>

            <!-- Edit Form -->
            <form action="{{ route('notes.update', $note->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Use PUT method for updates -->

                <!-- Title Field -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">Title</label>
                    <input type="text" name="title" id="title"
                           class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                           value="{{ $note->title }}" required>
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Flexbox layout for Key Points, Notes, and Summary -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Key Points Field -->
                    <div class="mb-4 p-4 bg-gray-100 border border-gray-300 rounded-md">
                        <label for="key_points" class="block text-gray-700 font-medium">Key Points</label>
                        <textarea name="key_points" id="key_points" rows="6"
                                  class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                                  required>{{ $note->key_points }}</textarea>
                        @error('key_points')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Notes Field -->
                    <div class="col-span-2 mb-4 p-4 bg-gray-100 border border-gray-300 rounded-md">
                        <label for="notes" class="block text-gray-700 font-medium">Notes</label>
                        <textarea name="notes" id="notes" rows="6"
                                  class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                                  required>{{ $note->notes }}</textarea>
                        @error('notes')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Summary Field -->
                <div class="mb-4 p-4 bg-gray-100 border border-gray-300 rounded-md">
                    <label for="summary" class="block text-gray-700 font-medium">Summary</label>
                    <textarea name="summary" id="summary" rows="4"
                              class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                              required>{{ $note->summary }}</textarea>
                    @error('summary')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Save Changes Button -->
                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow-md transition duration-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
</x-app-layout>

<x-app-layout>
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Page Title -->
                <h1 class="text-2xl font-bold mb-6">Create New Note</h1>

                <!-- Note Creation Form -->
                <form action="{{ route('notes.store') }}" method="POST">
                    @csrf <!-- CSRF token for security -->

                    <!-- Title Field -->
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-medium">Title</label>
                        <input type="text" name="title" id="title"
                               class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                               placeholder="Enter note title" required>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Flexbox layout for Key Points, Notes, and Summary -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <!-- Key Points Field (Left side) -->
                        <div class="mb-4">
                            <label for="key_points" class="block text-gray-700 font-medium">Key Points</label>
                            <textarea name="key_points" id="key_points" rows="6"
                                      class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                                      placeholder="Enter key points for the note" required></textarea>
                            @error('key_points')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Notes Field (Right side, taking two columns for the Notes area) -->
                        <div class="col-span-2 mb-4">
                            <label for="notes" class="block text-gray-700 font-medium">Notes</label>
                            <textarea name="notes" id="notes" rows="6"
                                      class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                                      placeholder="Enter detailed notes" required></textarea>
                            @error('notes')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Summary Field -->
                    <div class="mb-4">
                        <label for="summary" class="block text-gray-700 font-medium">Summary</label>
                        <textarea name="summary" id="summary" rows="4"
                                  class="w-full mt-1 p-2 border-gray-300 rounded-md shadow-sm"
                                  placeholder="Enter a brief summary of the note" required></textarea>
                        @error('summary')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                            Save Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

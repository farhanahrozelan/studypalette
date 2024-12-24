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
                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow-md transition duration-200"
                            onclick="showReportModal();">
                        <i class="fas fa-exclamation-circle"></i> Report
                    </button>

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

<!-- Modal -->
<div id="reportModal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Report Note</h2>
        <form action="{{ route('notes.report', $note->id) }}" method="POST" onsubmit="return confirmReportReason();">
            @csrf
            <textarea id="reason-textarea" name="reason" placeholder="Enter your reason for reporting..." 
                      class="border border-gray-300 rounded px-3 py-2 w-full"></textarea>
            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow-md" onclick="closeReportModal();">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow-md">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showReportModal() {
        document.getElementById('reportModal').classList.remove('hidden');
    }

    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
    }

    function confirmReportReason() {
        const reason = document.getElementById('reason-textarea').value.trim();
        if (!reason) {
            alert('Please provide a reason for reporting this note.');
            return false; // Prevent form submission
        }
        return confirm('Are you sure you want to report this note for the following reason?\n\n' + reason);
    }
</script>
@endsection
</x-app-layout>

<x-app-layout>
    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-100">
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-medium text-gray-900">My Tasks</h1>
                    
                    </div>

                    <!-- Task Form -->
                    <div id="task-form" class="mb-6">
                        <form action="{{ route('tasks.store') }}" method="POST">
                            @csrf
                            <div class="flex items-center gap-4">
                                <input type="text" name="title" placeholder="Enter a new task"
                                       class="w-full p-2 border rounded-lg" required />
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow">
                                    Add 
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tasks List -->
                    <ul class="space-y-4">
                        @forelse ($tasks as $task)
                            <li class="flex justify-between items-center border-b pb-2">
                                <!-- Task Update Form -->
                                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <label class="flex items-center space-x-3">
                                        <input type="checkbox" name="is_done" 
                                               onchange="this.form.submit()" {{ $task->is_done ? 'checked' : '' }} />
                                        <span class="{{ $task->is_done ? 'line-through text-gray-400' : '' }}">
                                            {{ $task->title }}
                                        </span>
                                    </label>
                                </form>

                                <!-- Task Delete Form -->
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </li>
                        @empty
                            <!-- Empty State -->
                            <p class="text-gray-500 text-center">
                                No tasks available. Start by adding a new task!
                            </p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

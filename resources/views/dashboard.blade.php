<x-app-layout>
    @section('content')
        <!-- Main Content Section -->
        <div class="content flex-grow overflow-y-auto bg-gray-100">
            <div class="dashboard-content flex flex-col items-center gap-6 p-6">
                <!-- Center Content -->
                <div class="max-w-4xl w-full space-y-6 mx-auto">

                    <!-- Tasks Section -->
                    <div class="todo-box bg-white shadow rounded-lg p-6">
                        <h2 class="text-lg font-semibold mb-4">Tasks</h2>
                        
                        @if($tasks->isEmpty())
                            <p class="text-gray-500">No pending tasks. Enjoy your day!</p>
                        @else
                            <ul class="space-y-3">
                                @foreach($tasks as $task)
                                    <li class="flex justify-between items-center border-b pb-2">
                                        <div class="flex items-center space-x-3">
                                            <span class="{{ $task->is_done ? 'line-through text-gray-400' : '' }}">
                                                {{ $task->title }}
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        
                        <!-- View All Tasks Button -->
                        <div class="text-right mt-4">
                            <a href="{{ route('tasks.index') }}" class="text-blue-500 hover:underline">
                                View all tasks
                            </a>
                        </div>
                    </div>

                    <!-- Calendar Section -->
                    <div class="calendar-container bg-white shadow rounded-lg p-6">
                        <h2 class="text-lg font-semibold mb-4 text-center">Calendar</h2>
                        <div id="calendar" class="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>

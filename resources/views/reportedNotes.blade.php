<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Study Palette') }}</title>

        <link rel="stylesheet" href="{{ asset('studyPalette.css') }}">

        <!-- Favicon --> 
        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Satisfy&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">

        <style>
            
            h1 {
                text-align: center;
                font-size: 28px;
                padding-top: 10px;
                margin-bottom: 40px;
                font-family: 'Poppins', sans-serif;
            }

        </style>
    </head>

    <body>
        <header>
            <div class="header-content">
                <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo">
                <span>Study Palette</span>
            </div>
        </header>

        <div class="main-content" id="main-content">
            
            <div style="text-align: left; margin: 40px 20px 10px;">
                <a href="{{ route('adminDashboard') }}" class="back-btn">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
            </div>

            <h1>Reported Notes for Review</h1>

            <table>
                <thead>
                    <tr>
                        <th>Note ID</th>
                        <th>Created By</th>
                        <th>Report Type</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                @if ($reportedNotes->isEmpty())
                <tbody>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; font-size: 18px; color: #888;">
                            No reported notes available for review at the moment.
                        </td>
                    </tr>
                </tbody>
                @else
                <tbody>
                    @foreach ($reportedNotes as $report)
                    <tr id="note-row-{{ $report->note->id }}">
                        <td>{{ $report->note->id }}</td>
                        <td>{{ $report->user->id }}</td>
                        <td>{{ $report->reason }}</td>
                        <td>{{ $report->created_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="review-btn" 
                            data-note-id="{{ $report->note->id }}" 
                            data-note-title="{{ $report->note->title }}" 
                            data-note-keypoints="{{ $report->note->key_points }}" 
                            data-note-content="{{ $report->note->notes }}"
                            data-note-summary="{{ $report->note->summary }}">
                            Review</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
            </table>
        </div>

        <script>
        
        document.addEventListener('DOMContentLoaded', () => {
            let currentNoteId = null;
            
            document.querySelectorAll('.review-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const noteId = this.getAttribute('data-note-id');
                    const noteTitle = this.getAttribute('data-note-title');
                    const noteKeyPoints = this.getAttribute('data-note-keypoints');
                    const noteContent = this.getAttribute('data-note-content');
                    const noteSummary = this.getAttribute('data-note-summary');
                    
                    currentNoteId = noteId;
                    
                    Swal.fire({
                        title: `<h3 class="text-2xl font-bold mb-4 text-left">${noteTitle || 'No Title Provided'}</h3>`,
                        html: `
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mb-4">
                                <!-- Key Points -->
                                <div class="p-4 bg-gray-100 shadow-md border border-gray-300 rounded-md text-left">
                                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Key Points:</h2>
                                    <p class="text-gray-600">${noteKeyPoints || 'No key points provided.'}</p>
                                </div>
                                <!-- Notes -->
                                <div class="col-span-2 p-4 bg-gray-100 shadow-md border border-gray-300 rounded-md text-left">
                                    <h2 class="text-lg font-semibold text-gray-700 mb-2">Notes:</h2>
                                    <p class="text-gray-600">${noteContent || 'No additional notes provided.'}</p>
                                </div>
                            </div>
                                    
                            <!-- Summary -->
                            <div class="p-4 bg-gray-100 shadow-md border border-gray-300 rounded-md text-left">
                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Summary:</h2>
                                <p class="text-gray-600">${noteSummary || 'No summary provided.'}</p>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Approve',
                        cancelButtonText: 'Disapprove',
                        customClass: {
                            actions: 'swal2-actions',
                            confirmButton: 'approve-btn-style',
                            cancelButton: 'disapprove-btn-style',
                        },
                        width: '70%', // Adjust modal size
                        padding: '2rem', // Adjust padding inside the modal
                    }).then((result) => {
                        if (result.isConfirmed) {
                            updateNoteStatus(currentNoteId, 'approve');
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            updateNoteStatus(currentNoteId, 'disapprove');
                        }
                    });
                });
            });
            
            function updateNoteStatus(noteId, action) {
                fetch(`/reported-notes/${noteId}/${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`note-row-${noteId}`).remove();
                        Swal.fire({
                            icon: 'success',
                            title: action === 'approve' ? 'Approved!' : 'Disapproved!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong. Please try again.',
                    });
                });
            }
        });


        </script>

    </body>

</html>

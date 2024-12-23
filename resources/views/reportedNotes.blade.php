<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Study Palette') }}</title>

        <link rel="stylesheet" href="{{ asset('studyPalette.css') }}">

        <!-- Favicon --> 
        <link rel="icon" type="image/png" href="{{ url('favicon.png') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Satisfy&display=swap" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </header>

        <div class="main-content" id="main-content">
            
            <div style="text-align: left; margin: 40px 20px 10px;">
                <a href="{{ route('adminDashboard') }}" class="back-btn">
                    <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> Back to Dashboard
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
                        title: '<h3 style="font-size: 1.8rem; font-weight: 600; color: #333; margin-bottom: 10px; font-family: Poppins, sans-serif;">Note ID: ${noteId}</h3>',
                        html: `
                            <div style="font-family: 'Poppins', sans-serif; text-align: left; max-width: 700px; margin: 0 auto;">
                                <!-- Note Title -->
                                <h1 style="font-size: 1.8rem; font-weight: 600; color: #333; margin-bottom: 10px;">${noteTitle}</h1>
            
                                <!-- Key Points -->
                                <div style="margin-bottom: 20px; padding: 15px; background-color: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                    <h2 style="font-size: 1.2rem; font-weight: 500; color: #2d3748; margin-bottom: 8px;">Key Points:</h2>
                                    <p style="font-size: 1rem; color: #4a5568;">${noteKeyPoints || 'No key points provided.'}</p>
                                </div>
            
                                <!-- Notes -->
                                <div style="margin-bottom: 20px; padding: 15px; background-color: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                    <h2 style="font-size: 1.2rem; font-weight: 500; color: #2d3748; margin-bottom: 8px;">Notes:</h2>
                                    <p style="font-size: 1rem; color: #4a5568;">${noteContent || 'No additional notes provided.'}</p>
                                </div>
            
                                <!-- Summary -->
                                <div style="margin-bottom: 20px; padding: 15px; background-color: #f7fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                                    <h2 style="font-size: 1.2rem; font-weight: 500; color: #2d3748; margin-bottom: 8px;">Summary:</h2>
                                    <p style="font-size: 1rem; color: #4a5568;">${noteSummary || 'No summary provided.'}</p>
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Approve',
                        cancelButtonText: 'Disapprove',
                        customClass: {
                            /*popup: 'swal2-popup',
                            htmlContainer: 'swal2-html-container', */
                            actions: 'swal2-actions',
                            confirmButton: 'approve-btn-style',
                            cancelButton: 'disapprove-btn-style',
                        }
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

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

            .close-btn-style {
                width: 150px;
                padding: 10px 0;
                font-family: Poppins, sans-serif;
                font-size: 14px;
                text-align: center;
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

            <h1>Disapproved Notes Logs</h1>

            <table>
                <thead>
                    <tr>
                        <th>Note ID</th>
                        <th>Created By</th>
                        <th>Date Disapproved</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($disapprovedNotes as $disapproved)
                        <tr>
                            <td>{{ $disapproved->id }}</td>
                            <td>{{ $disapproved->user->id }}</td>
                            <td>{{ $disapproved->updated_at->format('Y-m-d') }}</td>
                            <td>
                                <button class="view-btn" 
                                data-note-id="{{ $disapproved->id }}" 
                                data-note-title="{{ $disapproved->title }}"
                                data-note-keypoints="{{ $disapproved->key_points }}"  
                                data-note-content="{{ $disapproved->notes }}"
                                data-note-summary="{{ $disapproved->summary }}">
                                View</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <script>
             document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.view-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        const noteId = this.getAttribute('data-note-id');

                        // Fetch note details dynamically
                        fetch(`/notes/${noteId}/view`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const note = data.note;

                                Swal.fire({
                                    title: `<h3 class="text-2xl font-bold mb-4 text-left">${note.title}</h3>`,
                                    html: `
                                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mb-4">
                                            <!-- Key Points -->
                                            <div class="p-4 bg-gray-100 shadow-md border border-gray-300 rounded-md text-left">
                                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Key Points:</h2>
                                                <p class="text-gray-600">${note.key_points || 'No key points provided.'}</p>
                                            </div>
                                            <!-- Notes -->
                                            <div class="col-span-2 p-4 bg-gray-100 shadow-md border border-gray-300 rounded-md text-left">
                                                <h2 class="text-lg font-semibold text-gray-700 mb-2">Notes:</h2>
                                                <p class="text-gray-600">${note.notes || 'No additional notes provided.'}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Summary -->
                                        <div class="p-4 bg-gray-100 shadow-md border border-gray-300 rounded-md text-left">
                                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Summary:</h2>
                                            <p class="text-gray-600">${note.summary || 'No summary provided.'}</p>
                                        </div>
        
                                    `,
                                    confirmButtonText: 'Close',
                                    confirmButtonColor: '#c2837a',
                                    customClass: {
                                        confirmButton: 'close-btn-style',
                                    },
                                    width: '70%', // Adjust modal size
                                    padding: '2rem', // Adjust padding inside the modal
                                });

                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: data.message || 'Note not found.',
                                    icon: 'error',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching note details:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to fetch note details.',
                                icon: 'error',
                            });
                        });

                    });
                });
            });

        </script>

    </body>

</html>
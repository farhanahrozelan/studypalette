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

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/luxon"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon"></script>

        <style>
        
        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
        }
            
        h1 {
            text-align: center;
            font-size: 40px;
            font-weight: bold;
            padding-top: 50px;
            margin-bottom: 8px;
        }

        h2 {
            text-align: center;
            font-size: 28px;
            font-weight: 500;
            margin-bottom: 30px;
        }

        h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .custom-confirm-btn {
            width: 150px;
            padding: 10px 0;
            font-family: Poppins, sans-serif;
            font-size: 16px;
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
            <form method="POST" action="{{ route('adminLogout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i></button>
            </form>
        </header>

        <div class="main-content" id="main-content">
            
            <h1>Welcome to Your Dashboard !</h1>
            <h2>Note Status Overview</h2>

            <div class="overview-container">
                <a href="{{ route('approvedNotes') }}" style="text-decoration: none;">
                    <div class="overview-card">
                        <h3>Approved</h3>
                        <p>{{ $approvedNotes }} Notes</p> 
                    </div>
                </a>
                
                <a href="{{ route('disapprovedNotes') }}" style="text-decoration: none;">
                    <div class="overview-card">
                        <h3>Disapproved</h3>
                        <p>{{ $disapprovedNotes }} Notes</p> 
                    </div>
                </a>

                <a href="{{ route('reportedNotes') }}" style="text-decoration: none;">
                    <div class="overview-card">
                        <h3>Reported for Review</h3>
                        <p>{{ $reportedNotes }} Notes</p> 
                    </div>
                </a>

            </div>
            
            <div class="main-content-wrapper">
                <div class="chart-container" id="chart-container">
                    <h3>Note Approval vs. Disapproval</h3>
                    <div class="chart-wrapper">
                        <canvas id="approvalDisapprovalChart"></canvas>
                    </div>
                    <div class="chart-controls">
                        <button class="filter-btn" data-chart="approvalDisapprovalChart"><i class="fa-solid fa-filter"></i> Filter</button>
                        <button class="reset-btn" data-chart="approvalDisapprovalChart"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                    </div>
                </div>

                <div class="chart-container">
                    <h3>Note Sharing Trends Over Time</h3>
                    <div class="chart-wrapper">
                        <canvas id="noteSharingChart"></canvas>
                    </div>
                    <div class="chart-controls">
                        <button class="filter-btn" data-chart="noteSharingChart"><i class="fa-solid fa-filter"></i> Filter</button>
                        <button class="reset-btn" data-chart="noteSharingChart"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                    </div>
                </div>

                <div class="chart-container">
                    <h3>Reported Notes Over Time</h3>
                    <div class="chart-wrapper">
                        <canvas id="reportedNotesChart"></canvas>
                    </div>
                    <div class="chart-controls">
                        <button class="filter-btn" data-chart="reportedNotesChart"><i class="fa-solid fa-filter"></i> Filter</button>
                        <button class="reset-btn" data-chart="reportedNotesChart"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                    </div>
                </div>


                <div class="chart-container">
                    <h3>Proportions of Reported Issues</h3>
                    <div class="chart-wrapper">
                        <canvas id="reportedIssuesChart"></canvas>
                    </div>
                    <div class="chart-controls">
                        <button class="filter-btn" data-chart="reportedIssuesChart"><i class="fa-solid fa-filter"></i> Filter</button>
                        <button class="reset-btn" data-chart="reportedIssuesChart"><i class="fa-solid fa-arrow-rotate-left"></i> Reset</button>
                    </div>
                </div>
                
            </div>

        <script>
        
        // Function to initialize the charts
        function initializeChart(canvasId, chartConfig) {
            return new Chart(document.getElementById(canvasId), chartConfig);
        }

        
        // Function to add date filtering for charts
        function addChartControls(chart, fetchUrl) {
            document.querySelector(`.filter-btn[data-chart="${chart.canvas.id}"]`).addEventListener('click', () => {
                Swal.fire({
                    title: '<h3 style="font-family: Poppins, sans-serif; font-size: 24px; font-weight: 600; color: #333; margin-bottom: 20px;">Select Date Range</h3>',
                    html: `
                        <div style="text-align: left; font-family: Figtree, sans-serif; font-size: 14px; color: #555;">
                            <label style="font-weight: 500; margin-bottom: 5px; display: block;">Start Date:</label>
                            <input id="startDate" type="date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 15px; font-family: Figtree, sans-serif; font-size: 14px; color: #333;">
                    
                            <label style="font-weight: 500; margin-bottom: 5px; display: block;">End Date:</label>
                            <input id="endDate" type="date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 15px; font-family: Figtree, sans-serif; font-size: 14px; color: #333;">
                        </div>
                    `,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#c2837a',
                    customClass: {
                        confirmButton: 'custom-confirm-btn'
                    },
                    preConfirm: () => {
                        const startDate = Swal.getPopup().querySelector('#startDate').value;
                        const endDate = Swal.getPopup().querySelector('#endDate').value;
                        if (!startDate || !endDate) {
                            Swal.showValidationMessage('Both start and end dates are required');
                        }
                        return { startDate, endDate };
                    },
                }).then(result => {
                    if (result.isConfirmed) {
                        if (chart.canvas.id === 'approvalDisapprovalChart') {
                            // For the approval/disapproval chart
                            updateApprovalDisapprovalChart(chart, fetchUrl, result.value.startDate, result.value.endDate);
                        } else {
                            // For other charts
                            updateChart(chart, fetchUrl, result.value.startDate, result.value.endDate);
                        }
                    }
                });
            });
            
            document.querySelector(`.reset-btn[data-chart="${chart.canvas.id}"]`).addEventListener('click', () => {
                if (chart.canvas.id === 'approvalDisapprovalChart') {
                    // For the approval/disapproval chart
                    updateApprovalDisapprovalChart(chart, fetchUrl); // Reset to default (all dates)
                } else {
                    // For other charts
                    updateChart(chart, fetchUrl); // Reset to default (all dates)
                }
            });
        }


        // Function to add combined category and date filtering for Reported Issues chart
        function addReportedIssuesChartControls(chart, fetchUrl) {
            document.querySelector(`.filter-btn[data-chart="${chart.canvas.id}"]`).addEventListener('click', () => {
                Swal.fire({
                    title: '<h3 style="font-family: Poppins, sans-serif; font-size: 24px; font-weight: 600; color: #333; margin-bottom: 20px;">Filter Options</h3>',
                    html: `
                        <div style="text-align: left; font-family: Figtree, sans-serif; font-size: 14px; color: #555;">
                            <label style="font-weight: 500; margin-bottom: 5px; display: block;">Start Date:</label>
                            <input id="startDate" type="date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 15px; font-family: Figtree, sans-serif; font-size: 14px; color: #333;">
                
                            <label style="font-weight: 500; margin-bottom: 5px; display: block;">End Date:</label>
                            <input id="endDate" type="date" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 15px; font-family: Figtree, sans-serif; font-size: 14px; color: #333;">
                
                            <label style="font-weight: 500; margin-bottom: 10px; display: block;">Select Categories:</label>
                            <div id="categoriesList" style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; border-radius: 6px; padding: 10px; background-color: #f9f9f9;">
                                <!-- Categories dynamically loaded here -->
                            </div>
                        </div>
                    `,
                    didOpen: () => {
                        // Fetch categories for the checkboxes dynamically
                        fetch('/analytics/reported-issues-categories')
                        .then(response => response.json())
                        .then(categories => {
                            const categoriesList = document.getElementById('categoriesList');
                            categoriesList.innerHTML = categories.map(cat => `
                            <label style="display: flex; align-items: center; margin-bottom: 5px;">
                                <input type="checkbox" name="categories" value="${cat}" style="margin-right: 8px;">
                                <span style="font-family: Figtree, sans-serif; font-size: 14px; color: #333;">${cat}</span>
                            </label>
                            `).join('');
                        });
                    },
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#c2837a',
                    customClass: {
                        confirmButton: 'custom-confirm-btn',
                    },
                    preConfirm: () => {
                        const startDate = Swal.getPopup().querySelector('#startDate').value;
                        const endDate = Swal.getPopup().querySelector('#endDate').value;
                        const selectedCategories = Array.from(Swal.getPopup().querySelectorAll('input[name="categories"]:checked'))
                        .map(checkbox => checkbox.value);
                        
                        if (!startDate || !endDate) {
                            Swal.showValidationMessage('Both start and end dates are required');
                        }
                        return { startDate, endDate, selectedCategories };
                    },
                }).then(result => {
                    if (result.isConfirmed) {
                        updateReportedIssuesChart(chart, fetchUrl, result.value.startDate, result.value.endDate, result.value.selectedCategories);
                    }
                });
            });
            
            document.querySelector(`.reset-btn[data-chart="${chart.canvas.id}"]`).addEventListener('click', () => {
                updateReportedIssuesChart(chart, fetchUrl); // Reset to default (all filters cleared)
            });
        }


        // Function to fetch and update the charts
        function updateChart(chart, fetchUrl, startDate = null, endDate = null) {
            const url = new URL(fetchUrl, window.location.origin);
            if (startDate && endDate) {
                url.searchParams.append('start_date', startDate);
                url.searchParams.append('end_date', endDate);
            }
            
            fetch(url)
            .then(response => response.json())
            .then(data => {
                chart.data.labels = data.map(item => item.date);
                chart.data.datasets[0].data = data.map(item => item.count);
                chart.update();
            })
            .catch(error => console.error('Error updating chart:', error));
        }


        // Function to fetch and update the Approval vs. Disapproval chart
        function updateApprovalDisapprovalChart(chart, fetchUrl, startDate = null, endDate = null) {
            const url = new URL(fetchUrl, window.location.origin);
            if (startDate && endDate) {
                url.searchParams.append('start_date', startDate);
                url.searchParams.append('end_date', endDate);
            }
            
            fetch(url)
            .then(response => response.json())
            .then(data => {
                const dates = [...new Set(data.map(item => item.date))];
                const approvedCounts = dates.map(date => {
                    const found = data.find(item => item.date === date && item.status === 'approved');
                    return found ? found.count : 0;
                });
                const disapprovedCounts = dates.map(date => {
                    const found = data.find(item => item.date === date && item.status === 'disapproved');
                    return found ? found.count : 0;
                });
                chart.data.labels = dates;
                chart.data.datasets = [
                    {
                        label: 'Approved',
                        data: approvedCounts,
                        backgroundColor: '#e4b4a1',
                    },
                    {
                        label: 'Disapproved',
                        data: disapprovedCounts,
                        backgroundColor: '#c2837a',
                    },
                ];
                chart.update();
            })
            .catch(error => console.error('Error updating chart:', error));
        }


        // Function to fetch and update the Reported Issues chart
        function updateReportedIssuesChart(chart, fetchUrl, startDate = null, endDate = null, selectedCategories = []) {
            const url = new URL(fetchUrl, window.location.origin);
            
            // Append query parameters for date and category filters
            if (startDate && endDate) {
                url.searchParams.append('start_date', startDate);
                url.searchParams.append('end_date', endDate);
            }
            if (selectedCategories.length) {
                url.searchParams.append('categories', selectedCategories.join(','));
            }
            
            fetch(url)
            .then(response => response.json())
            .then(data => {
                // Aggregate data to avoid duplicate categories
                const aggregatedData = data.reduce((acc, item) => {
                    if (!acc[item.reason]) {
                        acc[item.reason] = 0;
                    }
                    acc[item.reason] += item.count;
                    return acc;
                }, {});
                
                // Update chart data
                chart.data.labels = Object.keys(aggregatedData);
                chart.data.datasets[0].data = Object.values(aggregatedData);
                chart.update();
            })
            .catch(error => console.error('Error updating chart:', error));
        }


        //Initialize and configure Note Approval vs. Disapproval chart
        const approvalDisapprovalChart = initializeChart('approvalDisapprovalChart', {
            type: 'bar',
            data: { labels: [], datasets: [] },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                },
                scales: {
                    x: {
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Date', // X-axis label
                            font: { size: 14, weight: 'bold' },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        stacked: true,
                        title: {
                            display: true,
                            text: 'Number of Notes', // Y-axis label
                            font: { size: 14, weight: 'bold' },
                        },
                    },
                },
            },
        });
        addChartControls(approvalDisapprovalChart, '/analytics/approval-disapproval');
        updateApprovalDisapprovalChart(approvalDisapprovalChart, '/analytics/approval-disapproval');


        // Initialize and configure Note Sharing Trends Over Time Chart
        const noteSharingChart = initializeChart('noteSharingChart', {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Shared Notes',
                        data: [],
                        borderColor: '#c2837a', 
                        backgroundColor: 'rgba(188, 130, 102, 0.3)', 
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Date', // X-axis label
                            font: { size: 14, weight: 'bold' },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Shared Notes', // Y-axis label
                            font: { size: 14, weight: 'bold' },
                        },
                    },
                },
            },
        });
        addChartControls(noteSharingChart, '/analytics/note-sharing');
        updateChart(noteSharingChart, '/analytics/note-sharing');


        // Initialize and configure Reported Notes Over Time chart
        const reportedNotesChart = initializeChart('reportedNotesChart', {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Reported Notes',
                        data: [],
                        borderColor: '#7c3f3f',
                        backgroundColor: 'rgba(154, 92, 68, 0.3)',
                        fill: true,
                    },
                ],
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'category',
                        title: {
                            display: true,
                            text: 'Date', // X-axis label
                            font: { size: 14, weight: 'bold' },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Reported Notes', // Y-axis label
                            font: { size: 14, weight: 'bold' },
                        },
                    },
                },
            },
        });
        addChartControls(reportedNotesChart, '/analytics/reported-notes-over-time');
        updateChart(reportedNotesChart, '/analytics/reported-notes-over-time');


        // Initialize and configure Reported Issues chart
        const reportedIssuesChart = initializeChart('reportedIssuesChart', {
            type: 'pie',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Reported Issues',
                        data: [],
                        backgroundColor: ['#7c3f3f', '#a76a61', '#c2837a', '#e4b4a1'],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const dataIndex = tooltipItem.dataIndex;
                                const label = tooltipItem.chart.data.labels[dataIndex];
                                const value = tooltipItem.raw;
                                const total = tooltipItem.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return `${label}: ${percentage}% (${value})`;
                            },
                        },
                    },
                },
            },
        });
        addReportedIssuesChartControls(reportedIssuesChart, '/analytics/reported-issues');
        updateReportedIssuesChart(reportedIssuesChart, '/analytics/reported-issues');


        </script>

    </body>

</html>
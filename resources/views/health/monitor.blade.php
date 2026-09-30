<!DOCTYPE html>
<html>
<head>
    <title>Health Monitoring - Medical Services</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Murecho:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Add your existing styles here */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 110px;
            padding: 20px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .metric-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .metric-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .metric-title {
            font-size: 1.2em;
            color: #2c3e50;
            margin: 0;
        }

        .metric-value {
            font-size: 2em;
            color: #dd2476;
            font-weight: 600;
            margin: 10px 0;
        }

        .metric-chart {
            height: 200px;
            margin-top: 15px;
        }

        .recommendations {
            grid-column: 1 / -1;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .recommendation-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .recommendation-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #dd2476;
        }

        .medication-reminders {
            grid-column: 1 / -1;
        }

        .reminder-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .reminder-card {
            background: #fff3f7;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .add-button {
            background: linear-gradient(to right, #dd2476, #ff512f);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(221, 36, 118, 0.3);
        }
    </style>
</head>
<body>
    @include('layouts.header')

    <div class="dashboard-grid">
        <!-- Health Metrics -->
        <div class="metric-card">
            <div class="metric-header">
                <h3 class="metric-title">Weight Tracking</h3>
                <button class="add-button" onclick="logMetric('weight')">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="metric-value">{{ $latest_weight ?? '-- ' }} kg</div>
            <div class="metric-chart">
                <canvas id="weightChart"></canvas>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <h3 class="metric-title">Blood Pressure</h3>
                <button class="add-button" onclick="logMetric('bp')">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="metric-value">{{ $latest_bp ?? '-- ' }}</div>
            <div class="metric-chart">
                <canvas id="bpChart"></canvas>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-header">
                <h3 class="metric-title">Heart Rate</h3>
                <button class="add-button" onclick="logMetric('heart_rate')">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="metric-value">{{ $latest_hr ?? '-- ' }} bpm</div>
            <div class="metric-chart">
                <canvas id="heartRateChart"></canvas>
            </div>
        </div>

        <!-- AI Recommendations -->
        <div class="recommendations">
            <h3>AI Health Recommendations</h3>
            <div class="recommendation-list">
                @foreach($recommendations as $rec)
                <div class="recommendation-item">
                    <h4><i class="fas {{ $rec->icon }}"></i> {{ $rec->title }}</h4>
                    <p>{{ $rec->description }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Medication Reminders -->
        <div class="medication-reminders">
            <div class="metric-header">
                <h3>Medication Reminders</h3>
                <button class="add-button" onclick="addMedication()">
                    <i class="fas fa-plus"></i> Add Medication
                </button>
            </div>
            <div class="reminder-list">
                @foreach($reminders as $reminder)
                <div class="reminder-card">
                    <div>
                        <h4>{{ $reminder->medication_name }}</h4>
                        <p>{{ $reminder->dosage }} - {{ $reminder->frequency }}</p>
                        <small>Next: {{ $reminder->next_reminder }}</small>
                    </div>
                    <div>
                        <button onclick="markTaken({{ $reminder->id }})">
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        // Initialize charts
        function initializeCharts() {
            const weightCtx = document.getElementById('weightChart').getContext('2d');
            new Chart(weightCtx, {
                type: 'line',
                data: {
                    labels: @json($weight_dates),
                    datasets: [{
                        label: 'Weight (kg)',
                        data: @json($weight_data),
                        borderColor: '#dd2476',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            // Add similar chart initializations for BP and heart rate
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        // Metric logging functions
        function logMetric(type) {
            // Implement metric logging modal/form
        }

        // Medication functions
        function addMedication() {
            // Implement medication addition modal/form
        }

        function markTaken(id) {
            // Implement medication marking as taken
        }
    </script>
</body>
</html>
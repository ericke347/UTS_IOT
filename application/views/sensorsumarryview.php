<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Summary Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #ece9e6, #ffffff);
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .dashboard-container {
            margin-top: 50px;
            padding: 20px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-body {
            text-align: center;
            padding: 25px;
        }
        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .highlight {
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
        }
        .table-custom th {
            background-color: #007BFF;
            color: white;
            text-transform: uppercase;
        }
        .table-custom td, .table-custom th {
            text-align: center;
            vertical-align: middle;
        }
        .list-group-item {
            font-size: 1.1rem;
            font-weight: 500;
        }
        .header-text {
            font-weight: bold;
            font-size: 2rem;
            color: #444;
        }
        .card-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        .bg-gradient-danger {
            background: linear-gradient(135deg, #ff5f6d, #ffc371);
        }
        .bg-gradient-info {
            background: linear-gradient(135deg, #36d1dc, #5b86e5);
        }
        .bg-gradient-success {
            background: linear-gradient(135deg, #56ab2f, #a8e063);
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h2 class="text-center mb-5 header-text">Sensor Summary Dashboard</h2>

        <!-- Row for Summary Cards -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-gradient-danger">
                    <div class="card-body">
                        <i class="fas fa-thermometer-full card-icon"></i>
                        <h5 class="card-title">Max Temperature</h5>
                        <p class="highlight" id="suhumax">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-gradient-info">
                    <div class="card-body">
                        <i class="fas fa-thermometer-empty card-icon"></i>
                        <h5 class="card-title">Min Temperature</h5>
                        <p class="highlight" id="suhumin">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-gradient-success">
                    <div class="card-body">
                        <i class="fas fa-thermometer-half card-icon"></i>
                        <h5 class="card-title">Average Temperature</h5>
                        <p class="highlight" id="suhurata">Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table for Detailed Records -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-list"></i> Records with Max Temperature and Max Humidity
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered table-custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Temperature (°C)</th>
                            <th>Humidity (%)</th>
                            <th>Brightness (Lux)</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody id="records-table">
                        <tr>
                            <td colspan="5">Loading data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- List of Unique Month-Year -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-calendar-alt"></i> Unique Month-Year Records
            </div>
            <div class="card-body">
                <ul class="list-group" id="month-year-list">
                    <li class="list-group-item">Loading data...</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Fetch API Data -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://localhost/uts_iot/api/sensor_summary')
                .then(response => response.json())
                .then(data => {
                    // Populate the summary cards
                    document.getElementById('suhumax').innerText = data.suhumax + ' °C';
                    document.getElementById('suhumin').innerText = data.suhumin + ' °C';
                    document.getElementById('suhurata').innerText = data.suhurata + ' °C';

                    // Populate the table
                    const recordsTable = document.getElementById('records-table');
                    recordsTable.innerHTML = '';
                    if (data.nilai_suhu_max_humid_max.length > 0) {
                        data.nilai_suhu_max_humid_max.forEach(record => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${record.idx}</td>
                                <td>${record.suhun}</td>
                                <td>${record.humid}</td>
                                <td>${record.kecerahan}</td>
                                <td>${record.timestamp}</td>
                            `;
                            recordsTable.appendChild(row);
                        });
                    } else {
                        recordsTable.innerHTML = '<tr><td colspan="5">No records found</td></tr>';
                    }

                    // Populate the month-year list
                    const monthYearList = document.getElementById('month-year-list');
                    monthYearList.innerHTML = '';
                    if (data.month_year_max.length > 0) {
                        data.month_year_max.forEach(item => {
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item';
                            listItem.innerText = item.month_year;
                            monthYearList.appendChild(listItem);
                        });
                    } else {
                        monthYearList.innerHTML = '<li class="list-group-item">No records found</li>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    document.getElementById('suhumax').innerText = 'Error';
                    document.getElementById('suhumin').innerText = 'Error';
                    document.getElementById('suhurata').innerText = 'Error';
                    document.getElementById('records-table').innerHTML = '<tr><td colspan="5">Error loading data</td></tr>';
                    document.getElementById('month-year-list').innerHTML = '<li class="list-group-item">Error loading data</li>';
                });
        });
    </script>
</body>
</html>

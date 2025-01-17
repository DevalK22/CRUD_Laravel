<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .summary-container {
            max-width: 800px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 50px auto;
        }
        .summary-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .summary-body {
            padding: 20px 30px;
        }
        .table thead {
            background-color: #6c757d;
            color: #fff;
        }
        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border: none;
        }
        .btn-back:hover {
            background-color: #565e64;
        }
        .btn-print {
            background-color: #2575fc;
            color: #fff;
            border: none;
        }
        .btn-print:hover {
            background-color: #1a5fbf;
        }

        /* Hide navbar and buttons during printing */
        @media print {
            .navbar, .btn, header {
                display: none !important;
            }
            .summary-container {
                max-width: 100% !important;
                box-shadow: none !important;
            }
            body {
                background-color: #fff;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navigation -->
    @include('layouts.nav')

    <!-- Success Alert -->
    @include('layouts.success_alert')

    <main>
        <div class="summary-container">
            <!-- Employee Summary Header -->
            <div class="summary-header">
                <h2>Employee Summary</h2>
            </div>

            <!-- Summary Body -->
            <div class="summary-body">
                <h5>Employee Information</h5>
                <p><strong>ID:</strong> {{ $employee->id }}</p>
                <p><strong>Name:</strong> {{ $employee->name }}</p>
                <p><strong>Email:</strong> {{ $employee->email }}</p>
                <p><strong>Gender:</strong> {{ $employee->gender }}</p>
                <p><strong>Age:</strong> {{ $employee->age }}</p>

                <!-- Conditional display for Department -->
                @if($employee->department)
                    <p><strong>Department:</strong> {{ $employee->department }}</p>
                @endif

                <!-- Conditional display for Designation -->
                @if($employee->designation)
                    <p><strong>Designation:</strong> {{ $employee->designation }}</p>
                @endif

                <h5 class="mt-4">Salary Bifurcation</h5>
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Component</th>
                            <th>Amount (&#8377;)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Basic Pay</td>
                            <td>{{ number_format($employee->salary * 0.4, 2) }}</td>
                        </tr>
                        <tr>
                            <td>HRA (20%)</td>
                            <td>{{ number_format($employee->salary * 0.2, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Conveyance</td>
                            <td>{{ number_format($employee->salary * 0.1, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Other Allowances</td>
                            <td>{{ number_format($employee->salary * 0.3, 2) }}</td>
                        </tr>
                        <tr class="table-success">
                            <td><strong>Total</strong></td>
                            <td><strong>&#8377;{{ number_format($employee->salary, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Back and Print Buttons -->
                <div class="text-center mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-back me-2">Back</a>
                    <!-- Disable print button if total salary is 0 or if certain parameters are missing -->
                    <button id="printButton" onclick="window.print()" class="btn btn-print"
                            {{ $employee->salary == 0 || !isset($employee->department) || !isset($employee->designation) ? 'disabled' : '' }}>
                        Print
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

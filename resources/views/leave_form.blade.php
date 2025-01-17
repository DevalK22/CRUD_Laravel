<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Request</title>
    @include('layouts.logged_in_nav')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
            width: 48%;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            color: white;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
            width: 48%;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: white;
        }

        .form-control, select {
            padding: 1rem;
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
        }

        h2 {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
        }

        .status-message {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Leave Request Form</h2>

    @if(isset($leave_status)) <!-- Check if leave status is available -->
        <div class="status-message">
            @if($leave_status == 'approved')
                <p class="text-success">Your leave request has been <strong>Approved</strong>.</p>
            @elseif($leave_status == 'rejected')
                <p class="text-danger">Your leave request has been <strong>Rejected</strong>.</p>
            @else
                <p class="text-warning">Your leave request is <strong>Pending</strong>.</p>
            @endif
        </div>
    @else
        <!-- Leave Request Form -->
        <form method="POST" action="{{ route('leave.send') }}">
            @csrf

            <div class="form-group">
                <label for="leave_type" class="form-label">Leave Type</label>
                <select name="leave_type" id="leave_type" class="form-control" required>
                    <option value="">Select Leave Type</option>
                    <option value="Sick Leave">Sick Leave</option>
                    <option value="Casual Leave">Casual Leave</option>
                    <option value="Annual Leave">Annual Leave</option>
                </select>
                @error('leave_type')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="leave_start" class="form-label">Leave Start Date</label>
                <input type="date" name="leave_start" id="leave_start" class="form-control" required>
                @error('leave_start')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="leave_end" class="form-label">Leave End Date</label>
                <input type="date" name="leave_end" id="leave_end" class="form-control" required>
                @error('leave_end')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="reason" class="form-label">Reason for Leave</label>
                <textarea name="reason" id="reason" class="form-control" rows="4" required></textarea>
                @error('reason')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-custom">Submit Request</button>
                <a href="{{ route('employee.logged') }}" class="btn btn-back">Back</a>
            </div>
        </form>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

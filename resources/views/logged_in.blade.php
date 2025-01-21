<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
        }

        .employee-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .employee-details p {
            font-size: 1.1rem;
            margin: 0;
        }

        .employee-details strong {
            font-weight: bold;
        }

        .action-btns {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .action-btns .btn {
            font-size: 0.875rem;
        }

        .action-btns span {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 5px;
            color: white;
            font-size: 0.875rem;
            text-align: center;
            cursor: pointer;
            line-height: 1.5;
            margin-left: 10px;
        }

        .action-btns span:hover {
            opacity: 0.8;
        }

        .status-pending {
            background-color: orange;
        }

        .status-approved {
            background-color: green;
        }

        .status-rejected {
            background-color: red;
        }
    </style>
</head>
<body>
    @include('layouts.logged_in_nav')
    @include('layouts.success_alert')


    <main>
        <div class="container" style="max-width: 400px">
            <h2 class="text-center mb-4">Employee Details</h2>

            <div class="employee-details">
                <p><strong>ID:</strong> {{ $employee->id }}</p>
                <p><strong>Email:</strong> {{ $employee->email }}</p>
                <p><strong>Name:</strong> {{ $employee->name }}</p>
                <p><strong>Gender:</strong> {{ $employee->gender }}</p>
                <p><strong>Age:</strong> {{ $employee->age }}</p>
                <p><strong>Salary:</strong> &#8377;{{ $employee->salary }}</p>
                <p><strong>Department:</strong> {{ $employee->department }}</p>
                <p><strong>Designation:</strong> {{ $employee->designation }}</p>
            </div>

            <div class="action-btns">
                <!-- View Salary Button that triggers modal -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#passwordModal">
                    View Salary
                </button>
                @if($employee->status==null)
                    <a href="{{route ('leave.form')}}" class="btn btn-dark ms-3">Request for Leave</a>
                @elseif($employee->status=="Pending")
                    <span class="status-pending">Pending</span>
                @elseif($employee->status=="Approved")
                    <span class="status-approved">Approved</span>
                @elseif($employee->status=="Rejected")
                    <span class="status-rejected">Rejected</span>
                @endif
            </div>
        </div>
    </main>

    <!-- Modal for Password Input -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Enter Your Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('employee.summary',$employee->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

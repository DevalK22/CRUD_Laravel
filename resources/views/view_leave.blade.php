<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Details - {{ $employee->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('layouts.nav')
    @include('layouts.success_alert')

    <main>
        <div class="container mt-5">
            <h2>Leave Details for {{ $employee->name }}</h2>
            <p><strong>ID:</strong> {{ $employee->id}}</p>
            <p><strong>Email:</strong> {{ $employee->email }}</p>
            <p><strong>Designation:</strong> {{ $employee->designation }}</p>
            <p><strong>Department:</strong> {{ $employee->department }}</p>

            <!-- Leave Table -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th scope="col">Leave Type</th>
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $employee->leave_type }}</td>
                        <td>{{ \Carbon\Carbon::parse($employee->start_leave)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($employee->end_leave)->format('d-m-Y') }}</td>
                        <td>{{ $employee->reason }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-start mt-3">
                <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">Back to Dashboard</a>

                <!-- Approve and Reject buttons -->
                <form action="{{route('approve',$employee->id)}}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-success me-2">Approve</button>
                </form>
                <form action="{{route('reject',$employee->id)}}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

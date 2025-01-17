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
        }

        .employee-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .employee-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .employee-card .card-header {
            background-color: #f8f9fa;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .action-btns .btn {
            font-size: 0.875rem;
        }

        .pagination {
            justify-content: center;
        }
    </style>
</head>
<body>
    @include('layouts.nav')
    @include('layouts.success_alert')

    <main>
        <div class="container mt-5">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                <div class="col-md-2">
                    <input type="text" name="email" class="form-control" placeholder="Email" value="{{ request('email') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ request('name') }}">
                </div>
                <div class="col-md-2">
                    <select name="gender" class="form-select">
                        <option value="">Gender</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="age" class="form-control" placeholder="Age" value="{{ request('age') }}">
                </div>
                <div class="col-md-2">
                    <input type="number" name="salary" class="form-control" placeholder="Salary" value="{{ request('salary') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="designation" class="form-control" placeholder="Designation" value="{{ request('designation') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="department" class="form-control" placeholder="Department" value="{{ request('department') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <!-- Reset Button -->
                    <button type="button" class="btn btn-secondary w-100" onclick="resetForm()">Reset</button>
                </div>
            </form>

            <script>
                function resetForm() {
                    const form = document.querySelector('form');
                    form.reset();
                    // Remove query parameters and reload the page with no filters
                    window.location.href = "{{ route('dashboard') }}";
                }
            </script>

            <div class="mt-4"></div>

            <!-- Employee Cards -->
            <div class="row">
                @foreach($employees as $employee)
                    <div class="col-md-4 mb-4">
                        <div class="employee-card">
                            <div class="card-header">
                                Employee #{{ $employee->id }}
                            </div>
                            <div class="card-body">
                                <p><strong>Email:</strong> {{ $employee->email }}</p>
                                <p><strong>Name:</strong> {{ $employee->name }}</p>
                                <p><strong>Gender:</strong> {{ $employee->gender }}</p>
                                <p><strong>Age:</strong> {{ $employee->age }}</p>
                                <p><strong>Salary:</strong> &#8377;{{ $employee->salary }}</p>
                                <p><strong>Designation:</strong> {{ $employee->designation }}</p>
                                <p><strong>Department:</strong> {{ $employee->department }}</p>
                            </div>
                            <div class="action-btns">
                                <a href="{{ route('employee.update', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                                <a href="{{ route('admin.showSummary', $employee->id) }}" class="btn btn-warning btn-sm">Summary</a>
                                @if($employee->status=='Pending')
                                <a href="{{route('view.leave',$employee->id)}}" class="btn btn-info btn-sm">View Leave</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Customized Pagination -->
            <div class="d-flex justify-content-between mt-3">
                <span>
                    Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
                </span>
                <div>
                    {{ $employees->links('pagination.custom') }} <!-- Assuming a custom pagination view -->
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

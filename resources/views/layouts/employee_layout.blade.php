<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

            <!-- Employee Table -->
            <table class="table table-striped table-bordered" id="employee-table">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Salary</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ $employee->age }}</td>
                            <td>&#8377;{{ $employee->salary }}</td>
                            <td>
                                <a href="{{ route('employee.update', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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

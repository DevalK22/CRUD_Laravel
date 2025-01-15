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
    @include('layouts.logged_in_nav')
    @include('layouts.success_alert')

    <main>
        <div class="container mt-5">
            <h2 class="text-center mb-4">Employee Details</h2>

            <div class="mx-auto" style="max-width: 1000px;">
                <table class="table table-striped table-bordered" id="employee-table">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Salary</th>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->gender }}</td>
                            <td>{{ $employee->age }}</td>
                            <td>&#8377;{{ $employee->salary }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>

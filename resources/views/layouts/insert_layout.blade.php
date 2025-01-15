<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        @include('layouts.nav')
        @include('layouts.success_alert')
    </header>
    <main>
    <div class="d-block justify-content-center align-items-center" style="margin-top:50px; margin-left: 400px ">
        <div class="col-md-8">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                <h2 style = 'text-align:center'>CRUD- Create Read Update Delete</h2>
                <p>Please fill out the form below:</p>
                <form action="{{route('employee_post')}}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Email</label>
                        <input type="email" class="form-control" name='email' id="emailInput" placeholder="Enter your email">
                        @error('email')
                            <span class="d-block fs-6 text-danger mt-2">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Password</label>
                        <input type="password" class="form-control" name='password' id="passwordInput" placeholder="Enter your password">
                        @error('password')
                            <span class="d-block fs-6 text-danger mt-2">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nameInput" class="form-label">Name</label>
                        <input type="text" class="form-control" name='name' id="nameInput" placeholder="Enter your name">
                        @error('name')
                            <span class="d-block fs-6 text-danger mt-2">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="ageInput" class="form-label">Age</label>
                        <input type="number" class="form-control" id="ageInput" name='age' placeholder="Enter your age">
                        @error('age')
                            <span class="d-block fs-6 text-danger mt-2">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="genderSelect" class="form-label">Gender</label>
                        <select class="form-select" id="genderSelect" name='gender'>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('gender')
                            <span class="d-block fs-6 text-danger mt-2">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="salaryInput" class="form-label">Salary</label>
                        <input type="number" class="form-control" name='salary' id="salaryInput" placeholder="Enter your salary">
                        @error('salary')
                            <span class="d-block fs-6 text-danger mt-2">{{$message}}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</main>


    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

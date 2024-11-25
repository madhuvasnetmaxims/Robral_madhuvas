<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('productImages/one.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            background: rgba(0, 0, 0, 0.8);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }

        .login-card .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 10px;
            color: #fff;
        }

        .login-card .form-control:focus {
            box-shadow: 0 0 10px #007bff;
            background: rgba(255, 255, 255, 0.2);
        }

        .login-card .btn-primary {
            border-radius: 10px;
        }

        .login-card h3 {
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
   

    <div class="login-card">

        <h3>Login</h3>
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @error('error')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
        <form action="{{route('user-verify')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>

</body>
</html>

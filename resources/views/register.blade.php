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

        .text-danger {
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h3>Register</h3>

        <form action="{{route('reg-save')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Name
                    <span class="text-danger">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{old('name')}}" class="form-control" placeholder="Enter your name" required>
                @error('name') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email
                    <span class="text-danger">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Enter your email" required>
                @error('email') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone
                    <span class="text-danger">*</span>
                </label>
                <input type="tel" id="phone" name="phone" value="{{old('phone')}}" class="form-control" placeholder="Enter your phone" required>
                @error('phone') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password
                    <span class="text-danger">*</span>
                </label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                @error('password') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password
                    <span class="text-danger">*</span>
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm your password" required>
                @error('password_confirmation') 
                    <span class="text-danger">{{ $message }}</span> 
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </div>

</body>
</html>

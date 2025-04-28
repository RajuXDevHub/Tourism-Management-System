<?php
include 'db.php';

$message = "";  // To store success or error message

if(isset($_POST['register'])){
    // Input sanitization
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if(empty($name) || empty($email) || empty($password)) {
        $message = "<div class='alert error'>All fields are required!</div>";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert error'>Invalid email format!</div>";
    } elseif(strlen($password) < 8) {
        $message = "<div class='alert error'>Password must be at least 8 characters!</div>";
    } elseif($password !== $confirm_password) {
        $message = "<div class='alert error'>Passwords do not match!</div>";
    } else {
        // Check if email already exists
        $check_email = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($check_email);
        
        if($result->num_rows > 0) {
            $message = "<div class='alert error'>Email already registered!</div>";
        } else {
            // Hash password (better than md5)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO users(name, email, password) VALUES('$name', '$email', '$hashed_password')";

            if($conn->query($sql)){
                $message = "<div class='alert success'>Registration Successful! <a href='login.php'>Login Now</a></div>";
            } else {
                $message = "<div class='alert error'>Error: " . $conn->error . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Travel Explorer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            transition: all 0.3s ease;
        }
        
        .container:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 3px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #aaa;
        }
        
        .input-icon input {
            padding-left: 40px;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .alert.success {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }
        
        .alert.error {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .password-strength {
            margin-top: 0.5rem;
            height: 5px;
            background: #eee;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }
        
        @media (max-width: 576px) {
            .container {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        
        <?php echo $message; ?>
        
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password (min 8 characters)">
                </div>
                <div class="password-strength">
                    <div class="strength-meter" id="strength-meter"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password">
                </div>
            </div>
            
            <button type="submit" name="register" class="btn">
                <i class="fas fa-user-plus"></i> Register
            </button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.getElementById('strength-meter');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            // Check for length
            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            
            // Check for uppercase letters
            if (/[A-Z]/.test(password)) strength += 1;
            
            // Check for numbers
            if (/[0-9]/.test(password)) strength += 1;
            
            // Check for special characters
            if (/[^A-Za-z0-9]/.test(password)) strength += 1;
            
            // Update strength meter
            const width = strength * 20;
            strengthMeter.style.width = width + '%';2

            // This 
            
            // Update color
            if (strength <= 1) {
                strengthMeter.style.backgroundColor = '#e74c3c';
            } else if (strength <= 3) {
                strengthMeter.style.backgroundColor = '#f39c12';
            } else {
                strengthMeter.style.backgroundColor = '#2ecc71';
            }
        });
        
        // Confirm password validation
        const confirmPasswordInput = document.getElementById('confirm_password');
        
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity("Passwords don't match");
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>
<?php
include 'db.php';
session_start();

// Redirect if already logged in
if(isset($_SESSION['email'])) {
    header("Location: index1.php");
    exit();
}

$message = "";

if(isset($_POST['login'])){
    // Sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        
        // Verify password (replace md5 with password_verify)
        if(password_verify($password, $row['password'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            
            header("Location: index1.php");
            exit();
        } else {
            $message = "<div class='alert error'>Invalid email or password!</div>";
        }
    } else {
        $message = "<div class='alert error'>Account not found!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Travel Explorer</title>
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
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            animation: gradientBG 15s ease infinite;
            background-size: 400% 400%;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 2.5rem;
            transition: all 0.4s ease;
            animation: fadeInUp 0.8s ease-out;
            overflow: hidden;
            position: relative;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--primary-color);
            animation: borderGrow 1.5s ease-in-out;
        }
        
        @keyframes borderGrow {
            0% { height: 0; }
            100% { height: 100%; }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        h2 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 1.8rem;
            font-size: 2rem;
            position: relative;
            padding-bottom: 15px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
            animation: underlineGrow 1s ease-out;
        }
        
        @keyframes underlineGrow {
            0% { width: 0; }
            100% { width: 60px; }
        }
        
        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            color: var(--dark-color);
            font-weight: 500;
            font-size: 0.95rem;
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
            transition: all 0.3s ease;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
            outline: none;
            padding-left: 50px;
        }
        
        .form-control:focus + i {
            color: var(--primary-color);
            transform: translateY(-50%) scale(1.1);
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        .btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }
        
        .alert {
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 1.8rem;
            font-size: 0.95rem;
            animation: fadeIn 0.5s ease-out;
            display: flex;
            align-items: center;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert.error {
            background-color: rgba(231, 76, 60, 0.15);
            color: var(--error-color);
            border-left: 4px solid var(--error-color);
        }
        
        .alert i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .links a:hover {
            color: var(--secondary-color);
        }
        
        .links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: var(--secondary-color);
            transition: width 0.3s ease;
        }
        
        .links a:hover::after {
            width: 100%;
        }
        
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            background: rgba(52, 152, 219, 0.1);
            border-radius: 50%;
            pointer-events: none;
            animation: float 15s linear infinite;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }
        
        @media (max-width: 576px) {
            .container {
                padding: 2rem 1.5rem;
            }
            
            .links {
                flex-direction: column;
                gap: 0.8rem;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape" style="width: 80px; height: 80px; left: 10%; animation-delay: 0s; animation-duration: 15s;"></div>
        <div class="shape" style="width: 120px; height: 120px; left: 25%; animation-delay: 2s; animation-duration: 18s;"></div>
        <div class="shape" style="width: 60px; height: 60px; left: 75%; animation-delay: 4s; animation-duration: 12s;"></div>
        <div class="shape" style="width: 100px; height: 100px; left: 60%; animation-delay: 1s; animation-duration: 20s;"></div>
    </div>
    
    <div class="container">
        <h2>Welcome Back</h2>
        
        <?php echo $message; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
            </div>
            
            <button type="submit" name="login" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
            
            <div class="links">
                <a href="forgot-password.php"><i class="fas fa-key"></i> Forgot Password?</a>
                <a href="register.php"><i class="fas fa-user-plus"></i> Create Account</a>
            </div>
        </form>
    </div>

    <script>
        // Add ripple effect to button
        const button = document.querySelector('.btn');
        button.addEventListener('click', function(e) {
            const x = e.clientX - e.target.getBoundingClientRect().left;
            const y = e.clientY - e.target.getBoundingClientRect().top;
            
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 1000);
        });
        
        // Add floating animation to form inputs on focus
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.parentElement.style.transform = 'translateY(-5px)';
            });
            
            input.addEventListener('blur', () => {
                input.parentElement.parentElement.style.transform = 'translateY(0)';
            });
        });
        
        // Generate more floating shapes dynamically
        const shapesContainer = document.querySelector('.floating-shapes');
        for (let i = 0; i < 5; i++) {
            const shape = document.createElement('div');
            shape.classList.add('shape');
            
            const size = Math.random() * 100 + 50;
            const left = Math.random() * 100;
            const delay = Math.random() * 5;
            const duration = Math.random() * 10 + 10;
            
            shape.style.width = `${size}px`;
            shape.style.height = `${size}px`;
            shape.style.left = `${left}%`;
            shape.style.animationDelay = `${delay}s`;
            shape.style.animationDuration = `${duration}s`;
            
            shapesContainer.appendChild(shape);
        }
    </script>
</body>
</html>
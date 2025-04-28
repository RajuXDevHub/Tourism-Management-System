<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore the World | Tourism Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --success-color: #2ecc71;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark-color);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            line-height: 1.6;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(155, 89, 182, 0.05) 0%, rgba(155, 89, 182, 0.05) 90%),
                radial-gradient(circle at 90% 80%, rgba(41, 128, 185, 0.05) 0%, rgba(41, 128, 185, 0.05) 90%);
        }
        
        .container {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 700px;
            width: 100%;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--success-color));
            animation: rainbow 8s linear infinite;
            background-size: 400% 100%;
        }
        
        h2 {
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
            display: inline-block;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 3px;
        }
        
        .welcome-text {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #666;
            animation: fadeIn 1s ease-out 0.3s both;
        }
        
        .user-name {
            font-weight: 600;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
        }
        
        .user-name::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }
        
        .user-name:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.9rem 1.8rem;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            min-width: 180px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-places {
            background-color: var(--primary-color);
            color: white;
            z-index: 1;
        }
        
        .btn-places::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            z-index: -1;
            transition: opacity 0.4s ease;
            opacity: 1;
        }
        
        .btn-places:hover::before {
            opacity: 0.9;
        }
        
        .btn-logout {
            background-color: white;
            color: var(--accent-color);
            border: 2px solid var(--accent-color);
        }
        
        .btn-logout:hover {
            background-color: var(--accent-color);
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .btn:active {
            transform: translateY(1px);
        }
        
        .btn i {
            margin-right: 8px;
            transition: transform 0.3s ease;
        }
        
        .btn:hover i {
            transform: scale(1.1);
        }
        
        .feature-highlights {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin: 2.5rem 0;
        }
        
        .feature {
            padding: 1.5rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: rgba(52, 152, 219, 0.3);
        }
        
        .feature i {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 2rem;
            transition: transform 0.3s ease;
        }
        
        .feature:hover i {
            transform: scale(1.2) rotate(5deg);
        }
        
        .feature p {
            font-size: 1rem;
            color: #555;
            font-weight: 500;
        }
        
        .feature::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease;
        }
        
        .feature:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .travel-tip {
            margin-top: 2rem;
            padding: 1rem;
            background-color: rgba(52, 152, 219, 0.1);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            animation: slideInRight 0.8s ease-out 0.5s both;
        }
        
        .travel-tip p {
            font-size: 0.9rem;
            color: var(--dark-color);
            font-style: italic;
        }
        
        .travel-tip i {
            color: var(--primary-color);
            margin-right: 8px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes fadeInUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInRight {
            from { 
                opacity: 0;
                transform: translateX(20px);
            }
            to { 
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes rainbow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 1.8rem;
            }
            
            h2 {
                font-size: 1.8rem;
            }
            
            .feature-highlights {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="floating">Welcome to Travel Explorer</h2>
        
        <p class="welcome-text">
            Hello, <span class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>!<br>
            Ready to discover amazing destinations around the world? Let's make your travel dreams come true!
        </p>
        
        <div class="feature-highlights">
            <div class="feature">
                <i class="fas fa-map-marked-alt"></i>
                <p>100+ Destinations</p>
            </div>
            <div class="feature">
                <i class="fas fa-umbrella-beach"></i>
                <p>Beach Resorts</p>
            </div>
            <div class="feature">
                <i class="fas fa-mountain"></i>
                <p>Mountain Tours</p>
            </div>
            <div class="feature">
                <i class="fas fa-city"></i>
                <p>City Guides</p>
            </div>
        </div>
        
        <div class="travel-tip">
            <p><i class="fas fa-lightbulb"></i> <strong>Travel Tip:</strong> Book early for the best deals! Our summer specials are now available.</p>
        </div>
        
        <div class="btn-container">
            <a href="places.php" class="btn btn-places">
                <i class="fas fa-binoculars"></i> Explore Places
            </a>
            <a href="logout.php" class="btn btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <script>
        // Add some interactive JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
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
            });
            
            // Animate features on scroll into view
            const features = document.querySelectorAll('.feature');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            features.forEach(feature => {
                feature.style.opacity = 0;
                feature.style.transform = 'translateY(20px)';
                feature.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(feature);
            });
        });
    </script>
</body>
</html>
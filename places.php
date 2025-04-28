<?php
include 'db.php';
session_start();

if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

// Handle add to database
if(isset($_POST['add_place'])){
    $placeName = mysqli_real_escape_string($conn, $_POST['place_name']);
    $placeDescription = mysqli_real_escape_string($conn, $_POST['place_description']);

    $sql = "INSERT INTO selected_places (user_email, place_name, place_description) 
            VALUES ('".$_SESSION['email']."', '$placeName', '$placeDescription')";
    
    if($conn->query($sql) === TRUE){
        echo "<script>
                Toastify({
                    text: 'Place Added Successfully!',
                    duration: 3000,
                    close: true,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: '#4CAF50',
                }).showToast();
              </script>";
    } else {
        echo "<script>
                Toastify({
                    text: 'Failed to Add Place',
                    duration: 3000,
                    close: true,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: '#f44336',
                }).showToast();
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Tourist Places | TravelGuide</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #45a049;
            --accent-color: #FF6B6B;
            --dark-color: #2C3E50;
            --light-color: #ECF0F1;
            --text-color: #333;
            --text-light: #777;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            animation: fadeIn 1s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Background decorative elements */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .bg-shapes span {
            position: absolute;
            display: block;
            border-radius: 50%;
            opacity: 0.1;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            animation: float 15s linear infinite;
        }
        
        .bg-shapes span:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .bg-shapes span:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            left: 80%;
            animation-delay: 3s;
            animation-duration: 12s;
        }
        
        .bg-shapes span:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 50%;
            animation-delay: 6s;
            animation-duration: 18s;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.1;
            }
            50% {
                opacity: 0.15;
            }
            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Header styles */
        header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }
        
        .logo i {
            margin-right: 10px;
            color: var(--accent-color);
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            bottom: -5px;
            left: 0;
            transition: width 0.3s;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        /* Main content */
        main {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .page-header h1::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            bottom: -10px;
            left: 25%;
            border-radius: 2px;
        }
        
        .page-header p {
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        /* Places grid */
        .places-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .place-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .place-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        .card-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .place-card:hover .card-image {
            transform: scale(1.05);
        }
        
        .card-content {
            padding: 1.5rem;
        }
        
        .card-content h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }
        
        .card-content p {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }
        
        .card-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.4);
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            box-shadow: none;
        }
        
        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-accent {
            background: linear-gradient(135deg, var(--accent-color), #FF8E8E);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }
        
        .btn-accent:hover {
            background: linear-gradient(135deg, #FF8E8E, var(--accent-color));
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.4);
        }
        
        /* Footer */
        footer {
            background: var(--dark-color);
            color: white;
            padding: 4rem 2rem 2rem;
            margin-top: 4rem;
        }
        
        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .footer-col h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        
        .footer-col h3::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background: var(--primary-color);
            /* background: white; */
            bottom: -8px;
            left: 0;
        }
        
        .footer-col p {
            color: #BDC3C7;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        .newsletter-form {
            display: flex;
            margin-top: 1.5rem;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 30px 0 0 30px;
            outline: none;
        }
        
        .newsletter-form button {
            padding: 0 1.5rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .newsletter-form button:hover {
            background: var(--secondary-color);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #BDC3C7;
            font-size: 0.9rem;
            text-decoration: none;
            
        }
        
        /* Floating action button */
        .fab {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            background: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(255, 107, 107, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 99;
        }
        
        .fab:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.5);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .places-grid {
                grid-template-columns: 1fr;
            }
            
            .page-header h1 {
                font-size: 2rem;
            }
        }
        
        /* Loading animation */
        .loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .loader-content {
            text-align: center;
        }
        
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Search bar */
        .search-container {
            max-width: 600px;
            margin: 0 auto 3rem;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 30px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            font-size: 1rem;
            padding-left: 3rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .search-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }
    </style>
</head>
<body>
    <div class="bg-shapes">
        <span></span>
        <span></span>
        <span></span>
    </div>
    
    <header>
        <div class="logo">
            <i class="fas fa-map-marked-alt"></i>
            <span>TravelGuide</span>
        </div>
        <nav class="nav-links">
            <a href="index1.php"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="active"><i class="fas fa-umbrella-beach"></i> Places</a>
            <a href="#"><i class="fas fa-heart"></i> Favorites</a>
            <a href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
    </header>
    
    <main>
        <div class="page-header">
            <h1>Discover Amazing Places</h1>
            <p>Explore our curated collection of breathtaking destinations. Add your favorites to your travel bucket list.</p>
        </div>
        
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search for places...">
        </div>
        
        <div class="places-grid">
            <!-- Place 1: Taj Mahal -->
            <div class="place-card">
                <span class="card-badge">Top Rated</span>
                <img src="images/tajmahal.jpg" alt="Taj Mahal" class="card-image">
                <div class="card-content">
                    <h3>Taj Mahal</h3>
                    <p>One of the 7 wonders of the world located in Agra, India. A stunning white marble mausoleum built by Mughal Emperor Shah Jahan.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Taj Mahal">
                        <input type="hidden" name="place_description" value="One of the 7 wonders of the world located in Agra, India. A stunning white marble mausoleum built by Mughal Emperor Shah Jahan.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 2: Goa Beaches -->
            <div class="place-card">
                <img src="images/goa.jpg" alt="Goa Beaches" class="card-image">
                <div class="card-content">
                    <h3>Goa Beaches</h3>
                    <p>Famous for its golden beaches, vibrant nightlife, water sports, and Portuguese heritage architecture.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Goa Beaches">
                        <input type="hidden" name="place_description" value="Famous for its golden beaches, vibrant nightlife, water sports, and Portuguese heritage architecture.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 3: Kerala -->
            <div class="place-card">
                <span class="card-badge">Popular</span>
                <img src="images/kerala.jpg" alt="Kerala" class="card-image">
                <div class="card-content">
                    <h3>Kerala</h3>
                    <p>Known as God's Own Country with beautiful backwaters, lush greenery, Ayurvedic treatments, and houseboat stays.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Kerala">
                        <input type="hidden" name="place_description" value="Known as God's Own Country with beautiful backwaters, lush greenery, Ayurvedic treatments, and houseboat stays.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 4: Himalayas -->
            <div class="place-card">
                <img src="images/himalayas.jpg" alt="Himalayas" class="card-image">
                <div class="card-content">
                    <h3>Himalayas</h3>
                    <p>Famous for trekking, scenic mountain views, spiritual significance, and adventure sports like paragliding and skiing.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Himalayas">
                        <input type="hidden" name="place_description" value="Famous for trekking, scenic mountain views, spiritual significance, and adventure sports like paragliding and skiing.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 5: Jaipur -->
            <div class="place-card">
                <span class="card-badge">Heritage</span>
                <img src="images/jaipur.jpg" alt="Jaipur" class="card-image">
                <div class="card-content">
                    <h3>Jaipur</h3>
                    <p>The Pink City, famous for its palaces, forts, vibrant bazaars, and rich Rajput history. Part of the Golden Triangle.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Jaipur">
                        <input type="hidden" name="place_description" value="The Pink City, famous for its palaces, forts, vibrant bazaars, and rich Rajput history. Part of the Golden Triangle.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 6: Varanasi -->
            <div class="place-card">
                <img src="images/varanasi.jpg" alt="Varanasi" class="card-image">
                <div class="card-content">
                    <h3>Varanasi</h3>
                    <p>One of the oldest living cities in the world, sacred to Hindus, known for Ganga Aarti, ghats, and spiritual enlightenment.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Varanasi">
                        <input type="hidden" name="place_description" value="One of the oldest living cities in the world, sacred to Hindus, known for Ganga Aarti, ghats, and spiritual enlightenment.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 7: Ladakh -->
            <div class="place-card">
                <span class="card-badge">Adventure</span>
                <img src="images/ladakh.jpg" alt="Ladakh" class="card-image">
                <div class="card-content">
                    <h3>Ladakh</h3>
                    <p>Known for stunning landscapes, Buddhist monasteries, adventure sports like river rafting, and the highest motorable roads.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Ladakh">
                        <input type="hidden" name="place_description" value="Known for stunning landscapes, Buddhist monasteries, adventure sports like river rafting, and the highest motorable roads.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 8: Ooty -->
            <div class="place-card">
                <img src="images/ooty.jpg" alt="Ooty" class="card-image">
                <div class="card-content">
                    <h3>Ooty</h3>
                    <p>Known as the Queen of Hill Stations, famous for its scenic beauty, tea gardens, pleasant weather, and toy train.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Ooty">
                        <input type="hidden" name="place_description" value="Known as the Queen of Hill Stations, famous for its scenic beauty, tea gardens, pleasant weather, and toy train.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 9: Andaman -->
            <div class="place-card">
                <span class="card-badge">Tropical</span>
                <img src="images/andaman.jpg" alt="Andaman" class="card-image">
                <div class="card-content">
                    <h3>Andaman Islands</h3>
                    <p>Pristine beaches, coral reefs, water activities like scuba diving and snorkeling, and historical Cellular Jail.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Andaman Islands">
                        <input type="hidden" name="place_description" value="Pristine beaches, coral reefs, water activities like scuba diving and snorkeling, and historical Cellular Jail.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            
            <!-- Place 10: Rishikesh -->
            <div class="place-card">
                <img src="images/rishikesh.jpg" alt="Rishikesh" class="card-image">
                <div class="card-content">
                    <h3>Rishikesh</h3>
                    <p>Yoga capital of the world, famous for river rafting in Ganges, spiritual retreats, and the iconic Laxman Jhula bridge.</p>
                    <form method="POST">
                        <input type="hidden" name="place_name" value="Rishikesh">
                        <input type="hidden" name="place_description" value="Yoga capital of the world, famous for river rafting in Ganges, spiritual retreats, and the iconic Laxman Jhula bridge.">
                        <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
                    </form>
                </div>
            </div>
            <div class="place-card">
    <img src="images/shimla.jpg" alt="Shimla" class="card-image">
    <div class="card-content">
        <h3>Shimla</h3>
        <p>Popular hill station known for colonial architecture, scenic views, Mall Road shopping, and snow-covered mountains.</p>
        <form method="POST">
            <input type="hidden" name="place_name" value="Shimla">
            <input type="hidden" name="place_description" value="Popular hill station known for colonial architecture, scenic views, Mall Road shopping, and snow-covered mountains.">
            <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
        </form>
    </div>
</div>

            <div class="place-card">
            <span class="card-badge">Top Rated</span>
    <img src="images/manali.jpg" alt="Manali" class="card-image">
    <div class="card-content">
        <h3>Manali</h3>
        <p>Popular hill station in Himachal Pradesh known for its scenic beauty, adventure sports, snow-covered mountains, and the Solang Valley.</p>
        <form method="POST">
            <input type="hidden" name="place_name" value="Manali">
            <input type="hidden" name="place_description" value="Popular hill station in Himachal Pradesh known for its scenic beauty, adventure sports, snow-covered mountains, and the Solang Valley.">
            <button type="submit" name="add_place" class="btn">Add to Bucket List</button>
        </form>
    </div>
</div>

        </div>
    </main>
    
    <a href="#" class="fab" title="Back to Top">
        <i class="fas fa-arrow-up"></i>
    </a>
    
    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <h3>TravelGuide</h3>
                <p>Discover the world's most amazing destinations with our curated travel guides and recommendations.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
            
            <div class="footer-col">
                <h3>Quick Links</h3>
                <p><a href="index1.php">Home</a></p>
                <p><a href="#">Destinations</a></p>
                <p><a href="#">Travel Tips</a></p>
                <p><a href="#">About Us</a></p>
                <p><a href="#">Contact</a></p>
            </div>
            
            <div class="footer-col">
                <h3>Newsletter</h3>
                <p>Subscribe to our newsletter for the latest travel updates and exclusive offers.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your Email">
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
            
            <div class="footer-col">
                <h3>Contact Us</h3>
                <p><i class="fas fa-map-marker-alt"></i> 123 Travel Street, Wanderlust City</p>
                <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                <p><i class="fas fa-envelope"></i> info@travelguide.com</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2023 TravelGuide. All Rights Reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Smooth scroll to top
        document.querySelector('.fab').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Show/hide floating button based on scroll position
        window.addEventListener('scroll', function() {
            const fab = document.querySelector('.fab');
            if (window.pageYOffset > 300) {
                fab.style.display = 'flex';
            } else {
                fab.style.display = 'none';
            }
        });
        
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const placeCards = document.querySelectorAll('.place-card');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            placeCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // Form submission loading indicator
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                // Show loading indicator
                const loader = document.createElement('div');
                loader.className = 'loader';
                loader.innerHTML = `
                    <div class="loader-content">
                        <div class="spinner"></div>
                        <p>Adding to your bucket list...</p>
                    </div>
                `;
                document.body.appendChild(loader);
                
                // Hide after form submission would complete
                setTimeout(() => {
                    loader.remove();
                }, 1500);
            });
        });
    </script>
</body>
</html>
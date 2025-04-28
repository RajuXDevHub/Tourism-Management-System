<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Sent Successfully</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: linear-gradient(135deg, #4CAF50, #2e7d32);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .success-box {
            background: #fff;
            padding: 50px 40px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            animation: fadeIn 1s ease forwards;
        }

        .success-box h1 {
            color: #4CAF50;
            font-size: 2rem;
            margin-bottom: 15px;
            animation: slideDown 1s ease forwards;
        }

        .success-box p {
            color: #555;
            font-size: 1.1rem;
            margin-bottom: 30px;
            animation: slideDown 1.2s ease forwards;
        }

        .btn {
            background: #4CAF50;
            color: #fff;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.4s;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: "";
            position: absolute;
            left: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: 0.4s;
        }

        .btn:hover::before {
            left: 0;
        }

        .btn:hover {
            background: #45a049;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</head>
<body>

    <div class="success-box">
        <h1>Congratulations!</h1>
        <p>You Successfully Sent Message To Us</p>
        <a href="places.php">
            <button class="btn">OK</button>
        </a>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        /* Reset margin and padding for the body and html */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        /* Background styling */
        .landing-page {
            background: url('https://i0.wp.com/www.smkbinarahayu.sch.id/wp-content/uploads/2024/10/Role-of-Digital-Certificates-in-Preventing-Ransomware-Attacks.jpg?fit=734%2C420&ssl=1/1500x800') no-repeat center center fixed;
            background-size: cover;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        /* Heading style */
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        /* Button style */
        .login-btn {
            padding: 15px 30px;
            font-size: 1.2rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .login-btn:hover {
            background-color: #45a049;
        }

        /* Additional text style */
        .landing-text {
            font-size: 1.5rem;
            margin-bottom: 30px;
            color: black;
        }

        h1 {
            font-size: 4rem;
            /* Ukuran font yang lebih besar */
            font-weight: 700;
            /* Font tebal untuk menarik perhatian */
            margin-bottom: 30px;
            color: #FFD700;
            /* Mengubah warna font menjadi putih agar kontras dengan latar belakang */
            text-transform: uppercase;
            /* Mengubah teks menjadi huruf kapital semua */
            letter-spacing: 5px;
            /* Memberikan spasi antara huruf agar terlihat lebih elegan */
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
            /* Efek bayangan untuk teks agar lebih pop-up */
            font-family: 'Arial', sans-serif;
            /* Menentukan font modern */
            animation: fadeIn 1.5s ease-in-out;
            /* Menambahkan animasi untuk tampilan yang lebih dinamis */
        }

        /* Menambahkan animasi fadeIn */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-50px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="landing-page">
        <div>
            <h1>PT. GLOBAL TEKNOLOGI CATV INDONESIA</h1>
            <a href="/login" class="login-btn">Login</a>
        </div>
    </div>

</body>

</html>
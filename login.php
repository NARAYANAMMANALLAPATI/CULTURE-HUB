<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body, html {
        height: 100%;
        margin: 0;
    }
   .bg {
        background: url("images/img1.jpg") no-repeat center center fixed;
        background-size: cover;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: -1;
    }
    .container-left {
        background-image: url('images/1.jpg') ;
        position: absolute;
        top: 52%;
        transform: translate(0, -50%);
        width: 30%;
        height: 70%;
        left: 17%;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 10px 0 0 10px;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
        padding: 50px;
        text-align: center;
    }
    .container-left h1 {
        margin-bottom: 25px;
        background: linear-gradient(to right, #007b8f, #00bf6f);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 50px;
        font-weight: bold;
        line-height: 1.4;
    }
    .container-right h2 {
        background: linear-gradient(to right, #007b8f, #00bf6f);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .container-right {
        position: absolute;
        top: 52%;
        right: 20%;
        transform: translate(0, -50%);
        width: 33%;
        height: 70%;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 0 10px 10px 0;
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
        padding: 20px;
        line-height: 2.3;
    }
    .container-left p {
        font-size: 18px;
        color: green;
        line-height: 2.3;
    }
    .container-right {
        padding: 20px 30px;
    }
    .container-right h2 {
        margin-bottom: 13px;
    }
    </style>
</head>
<body>
<div class="bg"></div>
<div class="container-left">
 <h1>Welcome Back to Culture Hub</h1>
    <p><b><i>Log in to continue your cultural journey.</b></i></p>
</div>
<div class="container-right">
    <h2 class="text-center mb-4">Login</h2>

    <?php
    session_start();
    include 'conn.php'; // Include your database connection file

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);

        if (empty($email) || empty($pass)) {
            $error = "* Please enter email and password";
        } else {
            // Check if the email and password match
            $check_user = "SELECT * FROM user WHERE email='$email' AND password='$pass'";
            $result = mysqli_query($conn, $check_user);

            if (mysqli_num_rows($result) == 1) {
                $_SESSION['email'] = $email; // Set session variable for logged-in user
                header('Location: catg.html'); // Redirect to dashboard after successful login
                exit();
            } else {
                $error = "* Incorrect email or password";
            }
        }
    }
    ?>

    <!-- Display error messages -->
    <?php
    if (!empty($error)) {
        echo "<div style='color: red; text-align: center;'>$error</div>";
    }
    ?>

    <!-- Login form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="loginForm">
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
        <div class="mt-3 text-center">
            Don't have an account? <a href="signup.php">Sign Up</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

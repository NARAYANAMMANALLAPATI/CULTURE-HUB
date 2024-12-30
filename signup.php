<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
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
            background-image: url('images/t.jpg');
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 30%;
            height: 80%;
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
        .container-left p {
            font-size: 18px;
            color: green;
            line-height: 2.3;
        }
        .container-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            right: 20%;
            width: 33%;
            height: 80%;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 0 10px 10px 0;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.5);
            padding: 20px;
            line-height: 2.3;
        }
        .container-right h2 {
            background: linear-gradient(to right, #007b8f, #00bf6f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 13px;
        }
    </style>
</head>
<body>
<div class="bg"></div>
<div class="container-left">
    <h1>Welcome to Culture Hub</h1>
    <p><b><i>Explore and discover diverse cultures from around the world.</i></b></p>
</div>
<div class="container-right">
    <h2 class="text-center mb-4">Sign Up</h2>

    <?php
    session_start();
    include 'conn.php'; // Include your database connection file

    $error = "";
    $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);
        $cpass = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

        if (empty($email) || empty($pass) || empty($cpass)) {
            $error = "* Please fill all the required fields";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "* Invalid email format";
        } elseif (strlen($pass) < 6) {
            $error = "* Password must be at least 6 characters";
        } elseif ($pass != $cpass) {
            $error = "* Passwords do not match";
        } else {
            // Check if email already exists
            $check_email = "SELECT * FROM user WHERE email='$email'";
            $result = mysqli_query($conn, $check_email);

            if (mysqli_num_rows($result) > 0) {
                $error = "Email already exists";
            } else {
                // Insert new user into database (consider password hashing)
                $insert_user = "INSERT INTO user (email, password) VALUES ('$email', '$pass')";
                $query = mysqli_query($conn, $insert_user);

                if ($query) {
                    $_SESSION['email'] = $email; // Set session variable for logged-in user
                    header('Location: dashboard.php'); // Redirect to dashboard after successful signup
                    exit();
                } else {
                    $error = "Error: " . mysqli_error($conn);
                }
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

    <!-- Signup form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="signupForm">
        <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword"><i class="fas fa-lock"></i> Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block">Sign Up</button>
        <div class="mt-3 text-center">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


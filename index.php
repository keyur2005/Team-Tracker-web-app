<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title> Sign in </title>
    <!-- Custom styles -->
    <link href="css/main.css" rel="stylesheet">
    <style>
    body{
      background-color: lightgray;
    }
   </style>
</head>
<div class="container">
    <h1> Cricket - Team tracker</h1>
    <div class="row">
        <div class="col-md-6">
            <!-- Sign up form here-->
            <h2> Not a Member? Register Right Now! </h2>
            <form action="register.php" method="post">
                <input type="text" name="first_name" placeholder="Enter Your First Name" class="form-control"><br>
                <input type="text" name="last_name" placeholder="Enter Your Last Name"  class="form-control"><br>
                <input type="text" name="username" placeholder="Choose a Username"  class="form-control"><br>
                <input type="email" name="email" placeholder="Enter Your Email Address"  class="form-control"><br>
                <input type="password" name="password" placeholder="Choose a Password"  class="form-control"><br>
                <input type="password" name="confirm_password" placeholder="Confirm Your Password" class="form-control"><br>
                <input type="submit" name="submit" value="Sign Up" class="btn btn-primary">
            </form>
        </div>
        <div class="col-md-6">
            <!-- Login Form is here -->
            <h2> Already a Member of Cricket- Team Tracker? Sign In Here! </h2>
            <form action="login.php" method="post">
                <input type="text" name="user_login" placeholder="Username or Email Address" required class="form-control"><br>
                <input type="password" name="password" placeholder="Choose a Password" required class="form-control"><br>
                <input type="submit" name="submit" value="Login" class="btn btn-primary">
            </form>

        </div>
    </div>
    <!--end row -->
</div>
<!--end container -->
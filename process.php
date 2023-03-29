<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Team Tracker - Cricket  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Piedra&family=Quicksand&display=swap" rel="stylesheet">
  <link href="main.css" rel="stylesheet">
</head>

<body>
  <div class="container">
    <header>
      <h1> Cricket Team Tracker Form  </h1>
    </header>
    <main>
      <?php

      try {
        //create variables to store form data 
        $firstname = filter_input(INPUT_POST, 'fname');
        $lastname = filter_input(INPUT_POST, 'lname');
        $position = filter_input(INPUT_POST, 'position');
        $phone_num = filter_input(INPUT_POST, 'phone_num');
        $email = filter_input(INPUT_POST, 'email');
        $team_name = filter_input(INPUT_POST, 'team_name');

        //Connect to the database 
        require('connect.php');

        //Set up the SQl statement 
        $sql = "INSERT INTO crickets(first_name,last_name, position, phone_num, email, team_name,profile_image) VALUES (:firstname,:lastname, :position, :phone_num, :email, :team_name, :profile_image);";

        //call the prepare method of the PDO object, returns a PDOStatement Object 
        $statement = $db->prepare($sql);

        //bind Parameters 
        $statement->bindParam(':firstname', $firstname);
        $statement->bindParam(':lastname', $lastname);
        $statement->bindParam(':position', $position);
        $statement->bindParam(':phone_num', $phone_num);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':team_name', $team_name);


        //execute the query 
        $statement->execute();

        echo "<p> Thanks for submitting! </p>";

        //close DB connection 
        $statement->closeCursor();
      } catch (PDOException $e) {
        echo "<p> Sorry! Something went wrong!! </p>";
        $error = $e->getMessage();
        echo "<p> $error </p>";
      }

      ?>
      <a href="members.php" class="error-btn"> Back to Form </a>
    </main>
    <footer>
      <p> &copy; <?php echo getdate()['year']; ?> </p>
    </footer>
  </div>
  <!--end container-->
</body>

</html>
Footer
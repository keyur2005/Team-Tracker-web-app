<?php require_once('auth.php')?>
<?php require_once('header.php')?>
 <body>
   <div class="container">
     <header>
       <h1> Cricket Team Tracker Form </h1>
     </header>
     <main>
     <?php

    $firstname = null;
    $lastname = null;
    $position = null;
    $phone_num = null;
    $email = null;
    $team_name = null;

    $user_id = null;
    $user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


    //check if there is a user_id available in URL string, then prepare and execute a query that will return the information associated with the user_id selected and echo in the form 

    if (!empty($user_id) && $user_id !== false) {
    //connect to db
    require_once('connect.php');
    //set up sql query 
    $sql = "SELECT * FROM crickets WHERE user_id = :user_id;";
    //prepare query 
    $statement = $db->prepare($sql);
    //bind
    $statement->bindParam(':user_id', $user_id);
    //execute 
    $statement->execute();
    //use fetchAll method 
    $records = $statement->fetchAll();

    foreach ($records as $record) {
    $firstname = $record['first_name'];
    $lastname = $record['last_name'];
    $position = $record['position'];
    $phone_num = $record['phone_num'];
    $email = $record['email'];
    $team_name = $record['team_name'];
    }
    //close db connection 
    $statement->closeCursor();
}
        if (isset($_POST['submit'])) {
             //check whether the recaptcha was checked by the user 
          if (!empty($_POST['g-recaptcha-response'])) {
          //create variables to store form data, using filter input to validate & sanitize 
          /*https://www.php.net/manual/en/filter.filters.sanitize.php*/
          $input_firstname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
          $input_lastname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_SPECIAL_CHARS);
          $input_position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
          $input_phone_num = filter_input(INPUT_POST, 'phone_num', FILTER_SANITIZE_SPECIAL_CHARS); 
          $input_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
          $input_team_name = filter_input(INPUT_POST, 'team_name', FILTER_SANITIZE_SPECIAL_CHARS);

          //imformation of photo
          $photo = $_FILES['photo']['name'];
          $photo_type = $_FILES['photo']['type'];
          $photo_size = $_FILES['photo']['size'];
          $photo_tmp = $_FILES['photo']['tmp_name'];
          $photo_error = $_FILES['photo']['error'];

          $id = null;
          $id = filter_input(INPUT_POST, 'user_id');

          //link server side recaptcha 
          $secret = '6Le1jDwhAAAAALRCiHVGFy_YHyP4U3vyfNKw5k8_';
          $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);

          $responseData = json_decode($verifyResponse, true);
          echo $responseData['hostname'];
          echo $responseData['success'];

          var_dump($verifyResponse);

          require('validate.php');

          if (!empty($errors)) {
            echo "<div class='error_msg alert alert-danger'>";
            foreach ($errors as $error) {
              echo "<p>" . $error . "</p>";
            }
            echo "</div>";
          } else {

            try {
              //connect to database 
              require_once('connect.php');

              //move the uploaded image from temporary directory to images folder 
              $target = 'images/'. $photo;
               move_uploaded_file($photo_tmp, $target);
              
              //hash the password 
              $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);

              // set up SQL command to insert data into table
              if(!empty($id))
              {
                $sql = "UPDATE crickets SET first_name = :firstname, last_name = :lastname, position = :position, phone_num = :phone_num, email = :email, team_name = :team_name, profile_image = :profile_image WHERE user_id = :id";
              }
              else{
                    $sql = "INSERT INTO crickets(first_name,last_name, position, phone_num, email, team_name, profile_image) VALUES (:firstname,:lastname, :position, :phone_num, :email, :team_name, :profile_image);";
              } 

              //call the prepare method of the PDO object, return PDOStatement Object
              $statement = $db->prepare($sql);

              //bind parameters
              $statement->bindParam(':firstname', $input_firstname);
              $statement->bindParam(':lastname', $input_lastname);
              $statement->bindParam(':position', $input_position);
              $statement->bindParam(':phone_num', $input_phone_num);
              $statement->bindParam(':email', $input_email);
              $statement->bindParam(':team_name', $input_team_name);
              $statement->bindParam(':profile_image', $photo);

              if (!empty($id)) {
                $statement->bindParam(':id', $id);
              }

              //execute the query 
              $statement->execute();

              //close the db connection 
              $statement->closeCursor();
              //send user to team list page 
              header("Location: teamlist.php");
            } catch (PDOException $e) {
              echo "<p> Sorry! Something has gone wrong on our end! An email has been sent to our admin team </p>";
              $error_message = $e->getMessage();
              mail("keyurpatel@gmail.com", "CricketForm", "An Error has occured " + $error_message);
              echo $error_message;
            }
          }
        }
        else {
            echo "<p class='alert alert-danger'> Please let us know you are not a robot! </p>";
          }
        }
        ?>
        <!-- Create Member form  -->
      <p>Do you wanna see Team list?</p>
      <a href="teamlist.php" class="error-btn"> Team list </a>
      <p> Want to join our team ? Let's join with your Whole team and Win the match..!! </p>
      
       <div class="row">
         <div class="col-md-6">
       <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form"  enctype="multipart/form-data">
       <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
         <div class="form-group">
           <label for="fname"> Your First Name </label>
           <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $firstname; ?>" required>
         </div>
         <div class="form-group">
           <label for="lname"> Your Last Name </label>
           <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $lastname; ?>" required>
         </div>
         <div class="form-group">
           <label for="position"> Position </label>
           <input type="text" name="position" id="position" class="form-control" value="<?php echo $position; ?>"required>
         </div>
         <div class="form-group">
           <label for="phone_num"> Phone Number </label>
           <input type="number" name="phone_num" id="phone_num" class="form-control" value="<?php echo $phone_num; ?>" required>
         </div>
         <div class="form-group">
           <label for="email"> Your Email </label>
           <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>" required>
         </div>
         <div class="form-group">
           <label for="team_name"> Team Name </label>
           <input type="text" name="team_name" id="team_name" class="form-control" value="<?php echo $team_name; ?>" required>
         </div>
         <!-- Choose Profile pic of member-->
         <div class="form-group">
              <label for="profile"> Profile Pic </label>
              <input type="file" name="photo" id="profilepic">
            </div>
         
            <!-- Add Recaptcha here-->
         <div class="g-recaptcha" data-sitekey="6Le1jDwhAAAAAD0UTwxGrCI3H1HZmGPgcFr6Sid8"></div>
         <input type="submit" name="submit" value="Submit" class="btn btn-primary">
       </form>
      </div>
       </div>
     </main>
     <br>
     <a href="logout.php" class="btn btn-primary"> Logout? </a>
     <footer>
       <p> &copy; <?php echo getdate()['year']; ?> </p>
     </footer>
   </div>
   <!--end container-->
 </body>

 </html>
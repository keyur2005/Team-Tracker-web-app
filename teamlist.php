<?php require_once('header.php')?>
<link href="css/main.css" rel="stylesheet">
<body>
  <div class="container">
    <header>
      <h1> Cricket Team Tracker Form </h1>
    </header>
    <main class="view">
    <div class="row">
        <div class="col-md-8">
        <form method="get" action="search_results.php" class="search-form">
          <div class="form-group">
            <label for="keywords"> Search for a Position: </label>
            <input type="text" name="keywords" class="form-control" placeholder="Enter Positon for more Details" />
          </div>
          <input type="submit" value="Search" class="btn btn-primary" /> 
        </form>
        <h3>Our members : </h3>
      <?php
      
      //connect to our db 
      require('connect.php'); 

      //set up SQL statement 
      $sql = "SELECT * FROM crickets;"; 

      //prepare the query 
      $statement = $db->prepare($sql); 

      //execute 
      $statement->execute(); 

      //use fetchAll to store the results 
      $records = $statement->fetchAll(); 

      //build the top of the table 
      echo "<table><tbody>";

      foreach ($records as $record) {
        echo "<tr><td>"
          . $record['first_name'] . "</td><td><t>" . $record['last_name'] . "</td><td>" . $record['position'] . "</td><td>" . $record['phone_num'] . "</td><td>" .  $record['email'] . "</td><td>" . $record['team_name'] . "</td>
          
          <td>
            <a href='delete.php?id=". $record['user_id'] ."' class='btn btn-danger' onclick='return confirm(\"Are you sure? \");' > Delete Tune </a>
          </td>
          <td>
            <a href='members.php?id=". $record['user_id'] ."' class='btn btn-primary' > Update Tune </a>
          </td>
        
          </tr>";
      }
      echo "</tbody></table>";
      $statement->closeCursor();
?>

  <div>
     
<?php
      
      require('connect.php'); 

      //set up SQL statement 
      $sql = "SELECT * FROM crickets;"; 

      //prepare the query 
      $statement = $db->prepare($sql); 

      //execute 
      $statement->execute(); 

      //use fetchAll to store the results 
      $records = $statement->fetchAll(); 
    
    //create a div element
    echo "<div class='user_container'>";
    //loop through info stored in users using a foreach loop 
    foreach ($users as $user) {
      echo "<div class='user'>";
      echo "<img src='images/" . $user['profile_image'] . "' alt='" . $user['first_name'] . "'>";
      echo "<p>" . $user['first_name'] . "</p>";
      echo "</div>";
    }
    //create the closing div 
    echo "</div>";
    // /*
    //close db connection
    $statement->closeCursor();
      ?>
  </div>   


     <a href="members.php" class="btn btn-primary"> Want to Join? </a><br>
     <a href="logout.php" class="btn btn-primary"> Logout? </a>
    </main>

      <footer>
        <p> &copy; <?php echo getdate()['year']; ?> Cricket - Team Tracker </p>
      </footer>
  </div>
  <!--end container-->
</body>

</html>
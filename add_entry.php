<?php
session_start();
// connect to database
require_once "db_connect.php";
if(isset($_SESSION["signedin"]) == true){
  header("location: edit.php");
  exit;
}

$fname = $lname = $entry = "";
$fname_err = $lname_err = $entry_err = "";
 
// Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate first name
    if(empty(trim($_POST["first_name"]))){
        $fname_err = "Please enter first name";
    } elseif(!preg_match_all('/[a-zA-Z]/', trim($_POST["first_name"]))){
        $fname_err = "First name must only contain letters";
    } else{
      $fname = trim($_POST["first_name"]);
    }
    // Validate last name
    if(empty(trim($_POST["last_name"]))){
      $lname_err = "Please enter last name";
    } elseif(!preg_match_all('/[a-zA-Z]/', trim($_POST["last_name"]))){
      $lname_err = "Last name must only contain letters";
    } else{
      $lname = trim($_POST["last_name"]);
    }
    if($fname && $lname == "admin"){
      session_start();
      $_SESSION["signedin"] = true;
      $_SESSION["username"] = $fname;
      header("location: edit.php");
    }else{
      // Validate entry
      if(empty(trim($_POST["entry"]))){
        $entry_err = "Please enter an entry";
      } else{
        $entry = trim($_POST["entry"]);
      }
        $add_entry = "INSERT INTO book (first_name,last_name,post_entry) VALUES ('$fname','$lname','$entry')";
        if (mysqli_query($link, $add_entry)) {
          mysqli_close($link);
          header('Location: index.php');
          exit;
        } else {
          echo "Error adding entry";
        }
    }
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guestbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar fixed-top bg-dark">
    <a class="navbar-brand text-light" href="index.php">Guestbook</a>
  </nav>
    <main class="form-signin w-100 m-auto">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1 class="h3 mb-3 fw-normal text-center">Add an Entry</h1>
            <small class="error-text text-danger"><?php echo $fname_err;?></small>
            <div class="form-floating">
                <input type="text" name="first_name" class="form-control" id="floatingFirst" placeholder="First name" value="<?php echo $fname;?>">
                <label for="floatingFirst">First name</label>
             </div>
             <small class="error-text text-danger"><?php echo $lname_err;?></small>
             <div class="form-floating">
                <input type="text" name="last_name" class="form-control" id="floatingLast" placeholder="Last name" value="<?php echo $lname;?>">
                <label for="floatingLast">Last name</label>
            </div>
            <small class="error-text text-danger"><?php echo $entry_err;?></small>
            <div class="form-floating">
                <textarea name="entry" class="form-control" id="floatingEntry" placeholder="Entry" value="<?php echo $entry;?>"></textarea>
                <label for="floatingEntry">Entry</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Add Entry</button>
        </form>
    </main>
</body>
</html>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["signedin"]) || $_SESSION["signedin"] !== true){
    header("location: add_entry.php");
    exit;
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
  <body class="text-center">
  <nav class="navbar fixed-top bg-dark">
    <a class="navbar-brand text-light" href="index.php">Guestbook</a>
    <span class="text-light"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
    <a href='signout.php' class='btn btn-primary me-2'>Sign out</a>
</nav>
    <main class='book w-100 m-auto'>
      <div class='list-group'>
      <?php
      require_once "db_connect.php";
      $show = "SELECT id, first_name, last_name, post_entry FROM book";
      $result = $link->query($show);
      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<section class='list-group-item list-group-item-action'>";
            echo "<div class='d-flex w-100 justify-content-between'>";
            echo "<h5 class='mb-1'>" . $row["first_name"] . " " . $row["last_name"] . "</h5>";
            echo "</div>";
            echo "<p class='mb-1'>" . $row["post_entry"] . "</p>";
            echo "<a href='delete.php?id=".$row['id']."' class='btn btn-danger'>Delete</a>";
            echo "</section>";
        }
    } else {
        echo "<h1 class='h3 mb-3 fw-normal text-muted'>No Entries</h1>";
    }
    $link->close();
    ?>
      </div>
    </main>
</body>
</html>
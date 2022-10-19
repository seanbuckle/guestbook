<?php
session_start();
require_once "db_connect.php";
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
    <?php
    if(isset($_SESSION["signedin"]) && $_SESSION["signedin"] == true){
      echo "<a href='edit.php' class='btn btn-success me-2'>Edit</a>";
    }else{
      echo "<a href='add_entry.php' class='btn btn-primary me-2'>Add Entry</a>";
    }
    ?>
    </nav>
    <main class='book w-100 m-auto'>
      <div class='list-group'>
        <?php
        $sql = "SELECT first_name, last_name, post_entry FROM book";
        $result = $link->query($sql);
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            echo "<section class='list-group-item list-group-item-action'>";
            echo "<div class='d-flex w-100 justify-content-between'>";
            echo "<h5 class='mb-1'>" . $row["first_name"] . " " . $row["last_name"] . "</h5>";
            echo "</div>";
            echo "<p class='mb-1'>" . $row["post_entry"] . "</p>";
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

<?php
session_start();
require 'dbconfig/config.php';

// Check if the required files have been uploaded
if (isset($_FILES["plot_milkyah"]) && isset($_FILES["plot_krooky"]) && isset($_FILES["ID"])) {

    // Retrieve the user's email address (or id) from the session or database
    $email = $_SESSION['email'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        // Set PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the statement to insert the combined file names and data into the files table
        $stmt = $pdo->prepare("INSERT INTO files (name, data, email) VALUES (?, ?, ?)");

        // Get the file names
        $fileNames = implode(", ", [
            $_FILES["plot_milkyah"]["name"],
            $_FILES["plot_krooky"]["name"],
            $_FILES["ID"]["name"]
        ]);

        // Get the file data
        $fileData = implode(", ", [
            file_get_contents($_FILES["plot_milkyah"]["tmp_name"]),
            file_get_contents($_FILES["plot_krooky"]["tmp_name"]),
            file_get_contents($_FILES["ID"]["tmp_name"])
        ]);

        $stmt->bindParam(1, $fileNames);
        $stmt->bindParam(2, $fileData);
        $stmt->bindParam(3, $email);
        $stmt->execute();

        // Redirect the user to space_area.php after successful upload
        header('Location: space_area.php');
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Files</title>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!--Bootstrap-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <style>
    body {
      margin: 0px;
      height: 100vh;
      background: #fff1b4;
    }
    form{
      margin-top: 15%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #fff;
      width: 1100px;
      margin-left: 7%;
    }

    .center {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-input {
      width: 350px;
      padding: 20px;
      background: #fff;
    }

    .form-input input {
      display: none;
    }

    .form-input label {
      display: block;
      width: 45%;
      height: 45px;
      margin-left: 25%;
      line-height: 50px;
      text-align: center;
      background: #000000;
      color: #fff;
      font-size: 15px;
      font-family: "Open Sans", sans-serif;
      text-transform: uppercase;
      font-weight: 600;
      border-radius: 5px;
      cursor: pointer;
    }

    .form-input img {
      width: 100%;
      display: none;
      margin-bottom: 30px;
    }

  </style>
</head>
<body>
    <form action="load.php" method="post" enctype="multipart/form-data">
  <div class="center">
    <div class="form-input">
      <div class="preview">
        <img id="plot_milkyah-preview">
      </div>
      <label for="plot_milkyah">Plot Mulkiyah</label>
      <input id="plot_milkyah" name="plot_milkyah" type="file" accept="image/*" onchange="showPreview(event, 'plot_milkyah', 'plot_milkyah-preview');" required>
    </div>
    <div class="form-input">
      <div class="preview">
        <img id="plot_krooky-preview">
      </div>
      <label for="plot_krooky">Plot Krooky</label>
      <input id="plot_krooky" name="plot_krooky" type="file" accept="image/*" onchange="showPreview(event, 'plot_krooky', 'plot_krooky-preview');">
    </div>
    <div class="form-input">
      <div class="preview">
        <img id="id-preview">
      </div>
      <label for="ID">Load ID</label>
      <input id="ID" name="ID" type="file" accept="image/*" onchange="showPreview(event, 'id', 'id-preview');">
    </div>
  </div>
          <button type="submit" name="submit" onclick="validateForm()">Next<ion-icon name="chevron-forward-circle"></ion-icon>
        </button>
</form>
  <script>
    function showPreview(event, fileId, previewId) {
      const file = event.target.files[0];
      const preview = document.getElementById(previewId);

      if (file) {
        const reader = new FileReader();
        reader.onload = function() {
          preview.src = reader.result;
          preview.style.display = "block";
        }
        reader.readAsDataURL(file);
      } else {
        preview.src = "";
        preview.style.display = "none";
      }
    }
  </script>
      <script src="script2.js"></script>
      <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
      <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  
       
      <!-- Add the SweetAlert CSS and JS files to your HTML file -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  
      <script>
        function validateForm() {
          var file1 = document.getElementById("plot_milkyah").value;
          var file2 = document.getElementById("plot_krooky").value;
          var file3 = document.getElementById("ID").value;
  
          if (file1 == "" || file2 == "" || file3 == "") {
            swal("Please upload all required files.");
            event.preventDefault(); // prevents the form from submitting
          }
        }
      </script>
</body>
</html>

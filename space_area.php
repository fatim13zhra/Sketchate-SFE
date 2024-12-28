<?php session_start();
require 'dbconfig/config.php';

// Check if the form is submitted
if (isset($_POST['submit_btn'])) {
    // Retrieve the submitted values
    $stairs = $_POST['stairs'];
    $spaceName = $_POST['space_name'];
    $spaceArea = $_POST['space_area'];

    // Validate the data
    $errors = array();


    // If there are no errors, proceed with saving the data to the database
    if (empty($errors)) {
        try {
            // Connect to the database
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            // Set PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve the email from the session or wherever it is stored
            $email = $_SESSION['email']; // Replace with the appropriate code to retrieve the email

            // Prepare the SQL query
            $query = "INSERT INTO spaces (stairs, space_name, space_area, email) VALUES ";

            // Build the value set for insertion
            $stairValues = implode(",", $stairs);
            $nameValues = implode(",", $spaceName);
            $areaValues = implode(",", $spaceArea);
            $query .= "('$stairValues', '$nameValues', '$areaValues', '$email')";

            // Execute the query
            $pdo->exec($query);

            // Redirect to price_category.php
            header("Location: price_category.php");
            exit;

            //echo "Space data saved successfully.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        // Display the validation errors
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

?>
   
<!DOCTYPE html>
<html>
<head>
  <title>Space area</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/space_area.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-bLB9/U7HjO1yIB/1zrFchJZc2zZlYwFbmNjCgFbX9bNpPC+xHbtJ5dCxhjKlgFbPRIdZwYtly2m3j5Of5c5GEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <form action="space_area.php" method="POST" id="space-form">
    <div class="spaces_bg">
      <div id="spaces">
        <div class="space">
          <input type="text" name="stairs[]" placeholder="Which stairs? Basement? Stairs 1, 2..">
          <input type="text" name="space_name[]" placeholder="e.g.: men's council, sitting hall, indoor kitchen..">
          <input type="text" name="space_area[]" placeholder="e.g.: 2*5, 5*5, big, small..">
          <button type="button" class="remove remove-space">&times;</button>
        </div>
      </div>

      <div id="add-space-wrapper">
      <button type="button" class="add" id="add-space">Add Space</button>
    </div>
    <button type="submit" id="submit_btn" name="submit_btn" class="btn btn-dark">Submit</button>
  
    </div>
    </form>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-PFQ7ZGd/MR+T49Ggk07J/bWcrCEd0vFzg7jKX9NgpW+ww8XRv/LsF18g1AOSc42HmKON10vLKF2dxED+X9PSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <!-- Add the SweetAlert CSS and JS files to your HTML file -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script>
    // Add event listener to handle removal of space elements
    document.addEventListener('click', function(event) {
      if (event.target.classList.contains('remove-space')) {
        event.target.parentNode.remove();
      }
    });

    // Add event listener to handle addition of space elements
    document.getElementById('add-space').addEventListener('click', function() {
      var spaces = document.getElementById('spaces');
      var newSpace = document.createElement('div');
      newSpace.className = 'space'; // Add the "space" class
      newSpace.innerHTML = `
        <input type="text" name="stairs[]" placeholder="Which stairs? Basement? Stairs 1, 2..">
        <input type="text" name="space_name[]" placeholder="e.g.: men's council, sitting hall, indoor kitchen..">
        <input type="text" name="space_area[]" placeholder="e.g.: 2*5, 5*5, big, small..">
        <button type="button" class="remove remove-space">&times;</button>
      `;
      spaces.appendChild(newSpace);
    });

    // Form submission validation
    document.getElementById('submit_btn').addEventListener('click', function(event) {
      var spaces = document.querySelectorAll('.space');
      var filledSpaces = 0;

      spaces.forEach(function(space) {
        var stairs = space.querySelector('input[name="stairs[]"]').value.trim();
        var spaceName = space.querySelector('input[name="space_name[]"]').value.trim();
        var spaceArea = space.querySelector('input[name="space_area[]"]').value.trim();

        if (stairs !== '' && spaceName !== '' && spaceArea !== '') {
          filledSpaces++;
        }
      });

      if (filledSpaces < 3) {
        event.preventDefault(); // Prevent form submission
        swal("Error!", "Please fill at least 3 spaces with stairs, space name, and space area!", "error");
      }
    });
  </script>
</body>
</html>


<?php
require 'dbconfig/config.php';
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected option
    $choice = $_POST["radioOptions"];
    $email = $_SESSION["email"];
    try {
        // Prepare the SQL statement
        $sql = "INSERT INTO price_category (choice, email) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        
        // Bind the parameters and execute the statement
        $stmt->execute([$choice, $email]);

        $id = $pdo->lastInsertId(); // Get the auto-generated id

        // Redirect to further_detailed_options.php
        header("Location: further_detailed_options.php");
        exit(); // Ensure the script stops executing after the redirect
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Price</title>
	<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_space_area.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-bLB9/U7HjO1yIB/1zrFchJZc2zZlYwFbmNjCgFbX9bNpPC+xHbtJ5dCxhjKlgFbPRIdZwYtly2m3j5Of5c5GEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/creation_style.css">
   
    <style>
	</style>
</head>
<body>
    <form method="post" action="price_category.php">
	<div class="form-check mt-3">
		<div class="wrapper">
		<center>
	        <div class="wrapper-inner">
	        		<small class="text-white text-wrap text-center" style="font-family: 'Courier New', Courier, monospace; color: black !important; font-size: 24px; font-weight: bold;">
					    I am ready to invest in design as following:
					</small>
	        </div>
	        <div class="d-flex justify-content-center mt-3">
	        	<div class="form-check-container">
					<div class="form-check mt-3">
					  <label class="form-check-label ml-2" for="radioOption2">
					  	<input class="form-check-input" type="radio" name="radioOptions" id="radioOption2" value=" 0.5-1.0 OMR/Sq.m">
					    0.5-1.0 OMR/Sq.m
					  </label>
					</div>
					<div class="form-check mt-3">
					  <label class="form-check-label ml-2" for="radioOption3">
					  	<input class="form-check-input" type="radio" name="radioOptions" id="radioOption3" value="1.1-1.5 OMR/Sq.m">
					    1.1-1.5 OMR/Sq.m
					  </label>
					</div>
					<div class="form-check mt-3">
					  <label class="form-check-label ml-2" for="radioOption4">
					  	<input class="form-check-input" type="radio" name="radioOptions" id="radioOption4" value="1.6-2.0 OMR/Sq.m">
					    1.6-2.0 OMR/Sq.m
					  </label>
					</div>
					<div class="form-check mt-3">
					  <label class="form-check-label ml-2" for="radioOption5">
					  	<input class="form-check-input" type="radio" name="radioOptions" id="radioOption5" value="2.1-2.5 OMR/Sq.m">
					    2.1-2.5 OMR/Sq.m
					  </label>
					 </div>
					<div class="form-check mt-3">
					  <label class="form-check-label ml-2" for="radioOption5">
					  	<input class="form-check-input" type="radio" name="radioOptions" id="radioOption5" value="More than 2.5 OMR/Sq.m">
					    More than 2.5 OMR/Sq.m
					  </label>
					</div>
					<div>
					<button type="submit" name="submit" class="btn btn-outline-dark">Next<ion-icon name="chevron-forward-circle"></ion-icon></button>
					</div>
				</div>
			</div>
	    </center>
	  </div>
	</div>
</form>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

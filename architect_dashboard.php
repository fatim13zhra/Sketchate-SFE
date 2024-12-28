<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/architect_style.css">
  <style>
    /* Add custom styles for the carousel */
    .carousel {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;
      scroll-snap-type: x mandatory;
    }

    .carousel-item {
      scroll-snap-align: start;
      flex: 0 0 auto;
      width: 100%;
    }

    .carousel-item img {
      width: 100%;
      height: auto;
    }

    /* Center content */
    .centered {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* Custom styles for the buy-wrapper */
    .buy-wrapper {
      text-align: center;
      margin-top: 20px;
    }

    body {
      margin: 0;
      padding: 0;
    }

    .container {
      display: flex;
    }

    .sidebar {
      width: 250px;
      padding: 20px;
    }

    .main-content {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .centered {
      flex-grow: 1;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .carousel-wrapper {
      flex-grow: 1;
      padding: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <nav class="sidebar close">
      <header>
        <div class="image-text">
          <span class="image">
            <h1 class="open">SketChate</h1>
            <h1 class="closed">SC</h1>
            <i class="bx bx-chevron-left toggle"></i>
          </span><br>
        </div>
      </header>
      <br>
      <div class="menu-bar">
        <div class="menu">
          <li class="search-box"></li>
          <ul class="menu-links">
            <li class="nav-link">
              <a href="#">
              <i class='bx bxs-user'></i>
                <span class="text nav-text">archi@gmail.com</span>
              </a>
            </li>
            <li class="nav-link">
              <a href="#">
                <i class="bx bxs-home"></i>
                <span class="text nav-text">Home Page</span>
              </a>
            </li>
            <li class="nav-link">
              <a>
                <i class="bx bxs-file-plus"></i>
                <span class="text nav-text">New Project</span>
              </a>
            </li>
            <li class="nav-link">
              <a href="#">
                <i class="bx bxs-file-blank"></i>
                <span class="text nav-text">Current Project</span>
              </a>
            </li>
            <li class="nav-link">
              <a href="#">
                <i class="bx bxs-box"></i>
                <span class="text nav-text">Previous Submission</span>
              </a>
            </li>
            <div class="bottom-content">
              <li class="">
                <a href="#">
                <i class='bx bxs-edit-alt'></i>
                  <span class="text nav-text">Edit Profile</span>
                </a>
              </li>
            <div class="bottom-content">
              <li class="">
                <a href="#">
                  <i class="bx bxs-log-out"></i>
                  <span class="text nav-text">Logout</span>
                </a>
              </li>
              <br><br><br>
              <li class="mode">
                <div class="moon-sun">
                  <i class="bx bx-moon icon moon"></i>
                  <i class="bx bx-sun icon sun"></i>
                </div>
                <span class="mode-text text">Dark Mode</span>
                <div class="toggle-switch">
                  <span class="switch"></span>
                </div>
              </li>
            </div>
          </ul>
        </div>
        <div class="bottom-content"></div>
      </div>
    </nav>

    <div class="main-content">
      <div class="centered">
        <h1>Welcome </h1>
      </div>
      <br>
      <div class="carousel-wrapper">
        <div id="carouselExample" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <?php
  
        require 'dbconfig/config.php';
        // Retrieve image data for the user
        //$email = $_SESSION['email'];
        // Calculate the sum of space_area values
        $sum = 0;
        $stmt2 = $pdo->prepare("SELECT space_area FROM spaces");
        $stmt2->execute();
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
          $spaceArea = $row['space_area'];
          $values = explode(',', $spaceArea);
          foreach ($values as $value) {
            $sum += (int) $value;
          }
        }
        ?>
            <div class="wrapper-text">
              <h6>Client From: Meknès </h6>
              <?php
        try {
          // Prepare the SQL query
          $stmt4 = $pdo->prepare("SELECT place FROM details");

          // Execute the query
          $stmt4->execute();

          // Fetch the data row by row
          while ($row = $stmt4->fetch(PDO::FETCH_ASSOC)) {
            // Access the "choice" column in each row
            $place = $row['place'];
            
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          die();
        }
        ?>

        <h6>Approx. Area: <?php echo $sum; ?></h6>


        <?php
        try {
          // Prepare the SQL query
          $stmt3 = $pdo->prepare("SELECT choice FROM price_category");

          // Execute the query
          $stmt3->execute();

          // Fetch the data row by row
          while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
            // Access the "choice" column in each row
            $choice = $row['choice'];

            echo "<h6>Client willing to pay from $choice for Design</h6>";
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
          die();
        }
        ?>
      </div><?php
      if (isset($_POST['buy'])) {

        echo '
        <div class="wrapper-text">
          <h6>Project ID: 321467</h6>
          <h6>Status: Incomplete</h6>
          <h6>You have 72 hours to submit your proposal</h6>
          <form method="POST">
            <div class="buy-wrapper">
              <button id="regret" name="regret" class="btn btn-primary">Regret</button>
              <button id="submit_sketch" name="submit_sketch" class="btn btn-primary">Submit your sketch</button>
            </div>
          </form>
        </div>
        ';
      } else {
        // Check if the state is already set in the session
        $state = isset($_SESSION['state']) ? $_SESSION['state'] : '';

        if ($state !== 'purchased') {
          // Display the "Buy Now" button
          echo '
          <form method="POST">
            <div class="buy-wrapper">
              <button id="buy" name="buy" class="btn btn-primary">Buy Now</button>
            </div>
          </form>
          ';
        } else {
          // Update the state in the session to 'purchased'
          $_SESSION['state'] = 'purchased';

       
          echo '
          
          <form method="POST">
            <div class="buy-wrapper">
              <button id="regret" name="regret" class="btn btn-primary">Regret</button>
              <button id="submit_sketch" name="submit_sketch" class="btn btn-primary">Submit your sketch</button>
            </div>
          </form>
          ';
        }
      }


if (isset($_POST['submit_sketch'])) {

  // Get the email of the person who had the project from your database or any other source
  $projectEmail = $_POST['email']; // Replace with the actual email address

  // Compose the email
  $to = $projectEmail;
  $subject = "Sketch Submission";
  $message = "Hello,\n\nYour sketch has been submitted successfully.";

  // Use PHPMailer to send the email
  require 'ForgotPasswordSystem/PHPMailer/PHPMailerAutoload.php'; // Replace with the actual path to PHPMailer
  $mail = new PHPMailer;
  $mail->setFrom('erajisafae2003@gmail.com', 'Sketchate'); // Replace with your email and name
  $mail->addAddress($to);
  $mail->Subject = $subject;
  $mail->Body = $message;

  // Check if the email was sent successfully
  if ($mail->send()) {
    echo "Email sent successfully.";
  } else {
    echo "Failed to send email. Error: " . $mail->ErrorInfo;
  }
}

      ?>

    
          </div>
        </div>
      </div>
  </div>

  <script src="js/script_2.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
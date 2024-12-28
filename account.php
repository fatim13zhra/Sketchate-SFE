<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Account</title>
	<link rel="stylesheet" type="text/css" href="styles/style_account.css">
	<!-- Added Ionicons CSS -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
	<!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
	.centered {
		text-align: center;
    
	}
    .logo-yellow {
            color: #ffc107;
    }
    .profile-picture {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      overflow: hidden;
      margin-bottom: 10px;
    }

    .profile-picture img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }



</style>
	
</head>
<body>
	<header>
		<h1 class="logo">Sket<span class="logo-yellow">Chate</span></h1>
	</header>

    <div class="wrapper">
  <div class="login-box">
    <h2>Update Profile</h2>
    <form method="post" action="account.php" enctype="multipart/form-data">
      <div class="form-group">
        <label for="file-input">
          <ion-icon name="cloud-upload-outline"></ion-icon>
        </label>
        <div class="profile-picture">
          <img id="profile-img" src="styles/images/profile.jpg" alt="Default Profile Picture" width="100">
          <input id="file-input" type="file" name="file">
        </div>
        <div id="preview"></div>
      </div>
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input id="fullname" type="text" name="fullname" class="form-control">
      </div>
      <div class="form-group">
        <label for="new-password">New Password</label>
        <input id="new-password" type="password" name="new-password" class="form-control">
      </div>

      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input id="confirm-password" type="password" name="confirm-password" class="form-control">
      </div>

      <input type="submit" name="submit" value="Update" class="btn btn-warning">
    </form>
  </div>
</div>

<script>
  document.getElementById("profile-img").addEventListener("click", function() {
    document.getElementById("file-input").click();
  });
</script>



	<script>
	const fileInput = document.querySelector('#file-input');
  const preview = document.querySelector('#preview');

fileInput.addEventListener('change', (e) => {
  const file = e.target.files[0];
  const reader = new FileReader();

  reader.onload = (e) => {
    const img = document.createElement('img');
    img.onload = () => {
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');
      const canvas2 = document.createElement('canvas');
      const ctx2 = canvas2.getContext('2d');
      const size = 100; // set your desired size here
      const cornerRadius = size / 2; // set your desired corner radius here

      canvas.width = size;
      canvas.height = size;

      ctx.drawImage(img, 0, 0, size, size);

      canvas2.width = size;
      canvas2.height = size;

      ctx2.beginPath();
      ctx2.moveTo(cornerRadius, 0);
      ctx2.lineTo(size - cornerRadius, 0);
      ctx2.quadraticCurveTo(size, 0, size, cornerRadius);
      ctx2.lineTo(size, size - cornerRadius);
      ctx2.quadraticCurveTo(size, size, size - cornerRadius, size);
      ctx2.lineTo(cornerRadius, size);
      ctx2.quadraticCurveTo(0, size, 0, size - cornerRadius);
      ctx2.lineTo(0, cornerRadius);
      ctx2.quadraticCurveTo(0, 0, cornerRadius, 0);
      ctx2.closePath();
      ctx2.clip();
      ctx2.drawImage(canvas, 0, 0);

      const roundedImg = document.createElement('img');
      roundedImg.src = canvas2.toDataURL('image/png');
      preview.innerHTML = '';
      preview.appendChild(roundedImg);
      preview.style.display = 'block';
    };

    img.src = e.target.result;
  };

  reader.readAsDataURL(file);
});
  </script>

<?php

require 'dbconfig/config.php';

if (isset($_POST['submit'])) {
    // Get file information
    $file_name = $_FILES["file"]["name"];
    $file_size = $_FILES["file"]["size"];
    $file_type = $_FILES["file"]["type"];
    $tmp_name = $_FILES["file"]["tmp_name"];

    $email = $_SESSION['email'];

    // Read file contents
    $profile_picture_data = file_get_contents($tmp_name);

    // Prepare the INSERT statement
    $stmt = $pdo->prepare("INSERT INTO images (file_name, file_type, file_size, data, email) VALUES (:file_name, :file_type, :file_size, :data, :email)");

    // Bind parameters
    $stmt->bindParam(':file_name', $file_name);
    $stmt->bindParam(':file_type', $file_type);
    $stmt->bindParam(':file_size', $file_size);
    $stmt->bindParam(':data', $profile_picture_data, PDO::PARAM_LOB);
    $stmt->bindParam(':email', $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo "File uploaded successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}


if (isset($_POST['submit'])) {
    // Get form inputs
    $current_password = $_POST['current-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    // Validate the inputs
    // ... add your validation logic here ...

    // Check if the new password matches the confirm password
    if ($new_password !== $confirm_password) {
        echo "New password and confirm password do not match.";
        exit;
    }

    // Get the email from the session
    $email = $_SESSION['email'];

    // Retrieve the user from the database
    $stmt = $pdo->prepare("SELECT * FROM register WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit;
    }

    // Verify the current password
    if (!password_verify($current_password, $user['password'])) {
        echo "Invalid current password.";
        exit;
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $pdo->prepare("UPDATE register SET password = :password WHERE email = :email");
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':email', $email);
    if ($stmt->execute()) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password: " . $stmt->errorInfo()[2];
    }
}
?>

	


</body>
</html>

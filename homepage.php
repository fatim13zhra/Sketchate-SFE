<?php

$host = 'localhost';
$dbname = 'sketchate-sfe';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['signup_btn'])) {
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $usertype = isset($_POST['usertype']) ? $_POST['usertype'] : 'client';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';
    $currentDate = date('Y-m-d H:i:s');
    $status = 0;

    if ($password == $cpassword) {

        if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[@#\$%\^\&*\(\)\[\]{}\-_+=~]/", $password)) {
            echo '<script type="text/javascript">
                    Swal.fire({
                      icon: "error",
                      title: "Password requirements not met",
                      text: "Please ensure your password is at least 8 characters long and includes uppercase and lowercase letters, numbers, and special characters.",
                      showConfirmButton: true,
                      confirmButtonText: "OK"
                    });
                  </script>';
            exit();
        }


        
        $query = "SELECT * FROM register WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo '<script type="text/javascript">
                      Swal.fire({
                        icon: "error",
                        title: "Email already taken",
                        text: "Please choose a different email"
                        showConfirmButton: true,
                        confirmButtonText: "OK"
                      });
                    </script>';
        } else {
            $query = "INSERT INTO register (id, fullname, email, usertype, password, status, registration_date) VALUES (NULL, :fullname, :email, :usertype, SHA2(:password, 256), :status, :registration_date)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':usertype', $usertype);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':registration_date', $currentDate);

            if ($stmt->execute()) {
                echo '<script type="text/javascript">
                        Swal.fire({
                          icon: "success",
                          title: "User registered",
                          text: "Go to the login page",
                          showConfirmButton: true,
                          confirmButtonText: "OK"
                        });
                      </script>';
            } else {
                echo '<script type="text/javascript">
                        Swal.fire({
                          icon: "error",
                          title: "Error",
                          text: "Failed to register user",
                          showConfirmButton: true,
                          confirmButtonText: "OK"
                        });
                      </script>';
            }
        }
    } else {
        echo '<script type="text/javascript">
                Swal.fire({
                  icon: "error",
                  title: "Passwords do not match",
                  showConfirmButton: true,
                  confirmButtonText: "OK"
                });
              </script>';
    }
}

$errorMessage = "";

if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = hash('sha256', $password);


    if ($email == 'sketchate@gmail.com' && $password == 'SketChate26') {
        $_SESSION['email'] = $email;
        header('location: admin.php');

    } else {
        echo '<script type="text/javascript">
                Swal.fire({
                    icon: "error",
                    title: "Invalid credentials for Admin",
                    showConfirmButton: true,
                    confirmButtonText: "OK"
                });
              </script>';
        exit();
    }

    $query = "SELECT * FROM register WHERE email = ? AND password = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email, $password_hash]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $_SESSION['email'] = $email;
        if ($result["usertype"] === "client") {
            //header("Location: homepage.php");
            $updateQuery = "UPDATE register SET status = 1 WHERE email = ?";
            $pdo->prepare($updateQuery)->execute([$email]);
            exit();

        } else if ($result["usertype"] === "architecte") {
            header("Location: architect_dashboard.php");
            $pdo->prepare($updateQuery)->execute([$email]);
            exit();
        } else {
            $errorMessage = "Invalid user type";
        }
    } else {
        $errorMessage = "Email or password do not match";
    }
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Site SketChate</title>
        <!--Bootstrap-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

        <!-- jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="styles/style.css">
    </head>
<body>
    <style>
    .profile-picture {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 5px;
    }

    </style>

    <div class="hero">
        <nav>
            <h1 class="logo" data-lang="logo">Sketchate</h1>
            <ul class="header-menu">
                <li><a href="#text-dreams" data-lang="home">Home</a></li>
                <li><a href="#about" data-lang="about">About</a></li>
                <li><a href="#contact" data-lang="contact">Contact</a></li>
                <li><a href="architect_dashboard.php" data-lang="contact">View sketches</a></li>
                <li>
                    <select id="language-selector" class="mt-2">
                    <option value="en" selected data-lang="english">English</option>
                    <option value="fr" data-lang="french">Français</option>
                    <option value="ar" data-lang="arabic">العربية</option>
                    </select>
                </li>
                <li><button class="btnLogin-popup">Login</button></li>

                <?php
                session_start();
                    if (isset($_SESSION['email'])) {
                        $email = $_SESSION['email'];
                            echo $email;

                    }

                    ?>

    
            </ul>
    
    
            <button type="button" onclick="toggleBtn()" id="btn">
                <span></span>
            </button>
        </nav>
        <div class="wrapper">
            <span class="icon-close"><ion-icon name="close-circle-outline"></ion-icon></span>
            <div class="form-box login">
                <h2  data-lang="login">Login</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="input-box">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input type="email" name="email" required>
                        <label data-lang="email">Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                        <input type="password" name="password" required>
                        <label data-lang="password">Password</label>
                    </div>
                    <div class="remember-forgot">
                        <!--<label data-lang="remember"><input type="checkbox">Remember me</label>-->
                        <a href="ForgotPasswordSystem/forgotPassword.php" data-lang="forgot">Forgot password?</a>
                    </div>
                    <button type="submit" class="btn" id="login_btn" name="login_btn" data-lang="login">Login</button>
                    <div class="login-register">
                        <p>Don't have an account yet? Create one!<a href="#" class="register-link" data-lang="register">Register</a></p>
                    </div>
                </form>
            </div>
    
            <div class="form-box register">
                <h2 data-lang="register">Registration</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row">
                        <div class="col">
                            <div class="input-box">
                                <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                                <input type="text" name="fullname" required>
                                <label data-lang="fullname">Full name</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="usertype">
                                <select  name="usertype" required>
                                    <option value="" disabled selected>You are ?</option>
                                    <option value="client">Client</option>
                                    <option value="architecte">Architecte</option>
                                </select>
                            </div>
                        </div>
                    </div>
                     <div class="input-box">
                        <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                        <input type="email" name="email" required>
                        <label data-lang="email">Email</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="input-box">
                                <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                                <input type="password" name="password" required>
                                <label data-lang="password">Password</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-box">
                                <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                                <input type="password" name="cpassword" required>
                                <label data-lang="password">Retype Password</label>
                            </div>
                        </div>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" required data-lang="agree">I agree to the terms and conditions</label>
                    </div>
                    <button type="submit" id="signup_btn" name="signup_btn" class="btn" data-lang="register">Register</button>
                    <div class="login-register">
                        <p>Already have an account?<a href="#" class="login-link" data-lang="login">Login</a></p>
                    </div>
    
                </form>
            </div>
        </div>
        <div id="text-dreams" class="text-container">
            <h1 data-lang="design"></h1>
            <p data-lang="dreams">Make your dreams come true</p>
            <a href="load.php" data-lang="create">Create your design</a>
        </div>
              
        <div class="lamp-container">
            <img src="styles/images/lamp.png" class="lamp">
            <img src="styles/images/light.png" class="light" id="light">
          </div>
          
        <footer>
        <section id="about" class="about">
        <h2>About</h2>
        <br>
        <p>Our mission is to support sustainability and continuity of business for our clients by avoiding duplication and providing unique and creative solutions. We also aim to support local Omani architects by giving them opportunities to showcase their talent and guarantee their rights and competitiveness in the industry. We ensure that our clients receive the best offers and ideas at different price points, ensuring that their design requests are met to the highest possible standards.</p>
    </section>
        <section class="contact" id="contact">
    
       <h1 class="heading"> Visit us </h1>
    
       <div class="row">
        <div class="map-container">
          <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d105994.60207763662!2d-5.620422435061455!3d33.881120097018325!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda044d23bfc49d1%3A0xfbbf80a99e4cde18!2sMeknes!5e0!3m2!1sen!2sma!4v1682696571718!5m2!1sen!2sma" allowfullscreen="" loading="lazy"></iframe>
        </div>
        
        <form action="" class="intouch">
          <h3>Get in touch</h3>
          <input type="text" placeholder="name" class="box">
      
          <input type="email" placeholder="email" class="box">
          <input type="number" placeholder="phone" class="box">
          <textarea name="" placeholder="message" class="box" id="" cols="30" rows="10"></textarea>
          <input type="submit" value="send message" class="btn">
        </form>
      </div>
      
    
    </section>
        <div class="contact-info">
      
        <div class="info">
          <i class="fas fa-phone"></i>
          <h3>Phone number : </h3>
          <p>000000000</p>
        </div>
        
        <div class="info">
          <i class="fas fa-envelope"></i>
          <h3>Email address : </h3>
          <p>service@Sketchate.com</p>
        </div>
        
        <div class="info">
          <i class="fas fa-map-marker-alt"></i>
          <h3>Office address : </h3>
          <p>ADD 12 865</p>
        </div>
        
        <div class="share">
          <a href="#" class="fab fa-facebook-f"></a>
          <a href="#" class="fab fa-twitter"></a>
          <a href="#" class="fab fa-instagram"></a>
          <a href="#" class="fab fa-linkedin"></a>
        </div>
      </div>
        <script src="js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    
    
    <script>
        var btn = document.getElementById("btn");
        var light = document.getElementById("light");
    
        function toggleBtn() {
            btn.classList.toggle("active");
            light.classList.toggle("on");
            document.body.classList.toggle("dark-theme");
        }
    </script>

        <script>
        var btn = document.getElementById("btn");
        var light = document.getElementById("light");
    
        function toggleBtn() {
            btn.classList.toggle("active");
            light.classList.toggle("on");
            document.body.classList.toggle("dark-theme");
        }

        var dropdownToggle = document.getElementById("dropdownMenuLink");
        dropdownToggle.addEventListener("click", function() {
            var dropdownMenu = document.getElementsByClassName("dropdown-menu")[0];
            dropdownMenu.classList.toggle("show");
        });

        var dropdownItems = document.getElementsByClassName("dropdown-item");
        for (var i = 0; i < dropdownItems.length; i++) {
            dropdownItems[i].addEventListener("click", function() {
                var dropdownMenu = document.getElementsByClassName("dropdown-menu")[0];
                dropdownMenu.classList.remove("show");
            });
        }
    var languageSelector = document.getElementById("language-selector");
    languageSelector.addEventListener("change", function() {
        var selectedLanguage = languageSelector.value;
        if (selectedLanguage === "ar") {
            document.documentElement.setAttribute("dir", "rtl");
            document.documentElement.setAttribute("lang", "ar");
        } else {
            document.documentElement.setAttribute("dir", "ltr");
            document.documentElement.setAttribute("lang", selectedLanguage);
        }
        translateContent(selectedLanguage);
    });
        function translateContent(language) {
        var translatableElements = document.querySelectorAll("[data-lang]");
        translatableElements.forEach(function(element) {
            var translationKey = element.getAttribute("data-lang");
            var translatedText = getTranslation(language, translationKey);
            element.textContent = translatedText;
        });
    }
        function getTranslation(language, key) {
        var lang = {
            en: {
                home: "Home",
                design: "Design your house",
                about: "About",
                contact: "Contact",
                login: "Login",
                dreams: "Make your dreams come true",
                create: "Create your design",
                logo: "Sketchate@",
                remember: "Remember me",
                forgot: "Forgot password?",
                register: "Register",
                firstname: "First name",
                lastname: "Last name",
                agree: "I agree to the terms and conditions",
                already_account: "Already have an account? Log in!",
                create_account: "Don't have an account yet? Create one!",
                english: "English",
                french: "Français"
            },            fr: {
                home: "Accueil",
                design: "Concevez votre maison",
                about: "À propos",
                contact: "Contact",
                login: "Connexion",
                dreams: "Réalisez vos rêves",
                create: "Créez votre design",
                logo: "Sketchate@",
                remember: "Se souvenir de moi",
                forgot: "Mot de passe oublié ?",
                register: "S'inscrire",
                firstname: "Prénom",
                lastname: "Nom de famille",
                agree: "J'accepte les termes et conditions",
                already_account: "Vous avez déjà un compte? Connectez-vous !",
                create_account: "Vous n'avez pas encore de compte? Créez-en un!",
                english: "English",
                french: "Français",
            }};
        if (lang.hasOwnProperty(language) && lang[language].hasOwnProperty(key)) {
            return lang[language][key];
        }
    
        return key;
    }
    
    translateContent(languageSelector.value);
    </script>

    <p id="services">copyright &copy; 2022, Meknes</p>
</footer>
</body>

</html>

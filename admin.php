<?php
session_start();
require 'dbconfig/config.php';

// Fetch user data from the "register" table
$query = "SELECT * FROM register";
$stmt = $pdo->query($query);

// Count the number of registered users
$totalUsers = $stmt->rowCount();

// Fetch active user data from the "register" table
$activeQuery = "SELECT * FROM register WHERE status = 1";
$activeStmt = $pdo->query($activeQuery);

// Count the number of active users
$activeUsers = $activeStmt->rowCount();

// Fetch all rows from the result set into an array
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="styles/admin_style.css">
    
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
         
    .hidden {
        display: none;
    }

    </style>

    <title>Admin Dashboard Panel</title> 
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="styles/images/profile.jpg" alt="">
            </div>

            <span class="logo_name">SketChate</span>
        </div>


        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-user"></i>
                    <span class="link-name" id="projects-link">Users</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name" id="projects-link">Projects</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
                    <i class="uil uil-file-edit-alt"></i>
                    <span class="link-name">Edit Profile</span>
                </a></li>

                <li><a href="#">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <img src="images/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-user-plus"></i>
                        <span class="text">Registered Users</span>
                        <span class="number"><?php echo $totalUsers; ?></span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-user"></i>
                        <span class="text">Active Users</span>
                        <span class="number"><?php echo $activeUsers; ?></span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-file"></i>
                        <span class="text">Number of Projects</span>
                        <span class="number"><?php echo '0';//echo $totalProjects; ?></span>
                    </div>
                </div>
            </div>

            <div class="activity" id="activity-section">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Activity</span>
                </div>

                <div class="activity-data">
                    <div class="data names">
                        <span class="data-title">Full name</span>
                        <?php foreach ($rows as $row): ?>
                            <span class="data-list"><?php echo $row['fullname']; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="data email">
                        <span class="data-title">Email</span>
                        <?php foreach ($rows as $row): ?>
                            <span class="data-list"><?php echo $row['email']; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="data type">
                        <span class="data-title">Type</span>
                        <?php foreach ($rows as $row): ?>
                            <span class="data-list"><?php echo $row['usertype']; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="data status">
                        <span class="data-title">Status</span>
                        <?php foreach ($rows as $row): ?>
                            <?php
                                $status = ($row['status'] === 1) ? 'active' : 'inactive';
                            ?>
                            <span class="data-list"><?php echo $status; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="data joined">
                        <span class="data-title">Joined</span>
                        <?php foreach ($rows as $row): ?>
                            <span class="data-list"><?php echo $row['registration_date']; ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="data joined">
                        <span class="data-title">Action</span>
                                <?php foreach ($rows as $row): ?>
                                <span class="data-list">
                                    <button class="btn btn-primary" href="edit.php">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteRecord(<?php echo $row['id']; ?>)">Delete</button>
                                </span>
                            <?php endforeach; ?>
                    </div>
                </div>
            </div>


            <div class="activity" id="projects">
                <div class="title">
                    <i class="uil uil-folder"></i>
                    <span class="text">Projects</span>
                </div>
                        <center>

                        <span class="data-title">No projects yet..</span>
                            <span class="data-list"></span></center>
                        
                    </div>

                    <div class="data type">
                        <span class="data-title"></span>
                            <span class="data-list"></span>
                        
                    </div>

                    <div class="data type">
                        <span class="data-title"></span>
                            <span class="data-list"></span>
                        
                    </div>
                    <div class="data type">
                        <span class="data-title"></span>
                            <span class="data-list">
                                <!--<button class="btn btn-danger">Delete</button>--->
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="js/script_1.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Get the Projects link element by its ID
        var projectsLink = document.getElementById("projects");

        // Get the activity section element by its ID
        var activitySection = document.getElementById("activity-section");

        // Add an event listener to the Projects link
        projectsLink.addEventListener("click", function() {
            // Toggle the visibility of the activity section
            activitySection.classList.toggle("hidden");
        });

    </script>

    <script>
function deleteRecord(recordId) {
    if (confirm("Are you sure you want to delete this record?")) {
        // Send an AJAX request to the server to delete the record
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Reload the page to update the records after deletion
                location.reload();
            }
        };
        xhr.send("id=" + recordId);
    }
}
</script>


</body>
</html>

<?php
require 'dbconfig/config.php';

session_start();
$email = $_SESSION['email'];
$id = ""; // Assign the ID value

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkboxes'])) {
        $competitors = $_POST['checkboxes'];
        $competitorList = implode(",", $competitors);

        try {
            // Prepare the SQL statement
            $sql = "INSERT INTO competitors (id, competitor, email) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Insert the competitor list into the table
            $stmt->execute([$id, $competitorList, $email]);

            // Redirect to further_detailed_options.php
            //header("Location: payment_for_platform.php");
            //exit(); // Stop executing further code

            header("Location: homepage1.php");
            exit(); // Stop executing further code
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No competitors selected";
        exit; // Stop executing further code
    }
}


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkbox Form</title>
    <!--CSS File-->
    <link rel="stylesheet" href="styles/creation_style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
</head>
<body>

    <form method="post" action="competitors.php" onsubmit="return validateForm();">
        <center>
            <div class="wrapper-inner">
                <small class="text-white text-wrap text-center" style="font-family: 'Courier New', Courier, monospace; color: black !important; font-size: 24px; font-weight: bold;">
                    Competitors of your project are :    
                </small>
            </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox1" name="checkboxes[]" value="Engineering Consultancies">
            <label class="form-check-label" for="checkbox1">
                Engineering Consultancies
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox2" name="checkboxes[]" value="Architecture Offices">
            <label class="form-check-label" for="checkbox2">
                Architecture Offices
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox2" name="checkboxes[]" value="Freelancing Architects">
            <label class="form-check-label" for="checkbox2">
                Freelancing Architects
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="checkbox2" name="checkboxes[]" value="ALL of ABOVE">
            <label class="form-check-label" for="checkbox2">
                ALL of ABOVE
            </label>
        </div>
        <button type="submit" id="launch" class="btn btn-primary">Launch the competition</button>
    </form>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script>
        function validateForm() {
            var checkboxes = document.getElementsByName("checkboxes[]");
            var checked = false;
            
            // Check if at least one checkbox is checked
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    checked = true;
                    break;
                }
            }

            // Display a SweetAlert if no checkbox is checked
            if (!checked) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Competitors Selected',
                    text: 'Please select at least one competitor.',
                });
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>
</html>

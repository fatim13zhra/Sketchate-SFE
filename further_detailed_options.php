<?php
require 'dbconfig/config.php';

session_start();
$email = $_SESSION['email'];
$id = ""; // Assign the ID value

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['checkboxes'])) {
        $details = $_POST['checkboxes'];
        $place = $_POST['place'];
        $detailsList = implode(",", $details);

        try {
            // Prepare the SQL statement
            $sql = "INSERT INTO details (id, place, details, email) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Insert the competitor list into the table
            $stmt->execute([$id, $place, $detailsList, $email]);

            // Redirect to competitors.php
            header("Location: competitors.php");
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
</head>
<body>
    <form method="post" action="further_detailed_options.php" onsubmit="return validateForm();">
        <center>
            <div class="wrapper-inner">
                <small class="text-white text-wrap text-center" style="font-family: 'Courier New', Courier, monospace; color: black !important; font-size: 24px; font-weight: bold;">
                    Some details :
                </small>
            </div>
            <div class="form-group">
              <label for="place">You are from:</label>
              <input type="text" class="form-control" id="place" name="place" placeholder="Enter your country, region..">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkbox1" name="checkboxes[]" value="I want to support Omani architects">
                <label class="form-check-label" for="checkbox1">
                    I want to support Omani architects.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkbox2" name="checkboxes[]" value="I only want to get contracts from consulting offices.">
                <label class="form-check-label" for="checkbox2">
                    I only want to get contracts from consulting offices.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkbox3" name="checkboxes[]" value="I would like to contract with an office in my state">
                <label class="form-check-label" for="checkbox3">
                    I would like to contract with an office in my state.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkbox4" name="checkboxes[]" value="I would like to contract with an office in the state where the land is located">
                <label class="form-check-label" for="checkbox4">
                    I would like to contract with an office in the state where the land is located.
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Next</button>
        </center>
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
                    title: 'Nothing is Selected',
                    text: 'Please select at least one detail.',
                });
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>
</body>
</html>

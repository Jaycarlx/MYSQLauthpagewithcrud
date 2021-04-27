<?php
// Check existence of id parameter before processing further
If(isset($_GET[“id”]) && !empty(trim($_GET[“id”]))){
    // Include config file
Require_once “config.php”;

    // Prepare a select statement
    $sql = “SELECT * FROM userss WHERE id = ?”;

    If($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(“I”, $param_id);

        // Set parameters
        $param_id = trim($_GET[“id”]);

        // Attempt to execute the prepared statement
        If($stmt->execute()){
            $result = $stmt->get_result();

            If($result->num_rows == 1){
                /* Fetch result row as an associative array. Since the result set
                Contains only one row, we don’t need to use while loop */
                $row = $result->fetch_array(MYSQLI_ASSOC);

                // Retrieve individual field value
                $Course_Name = $row[“Course_Name”];
                $Track = $row[“Track”];
                $Framework = $row[“Framework”];
            } else{
                // URL doesn’t contain valid id parameter. Redirect to error page
                Header(“location: error.php”);
                Exit();
            }

        } else{
            Echo “Oops! Something went wrong. Please try again later.”;
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else{
    // URL doesn’t contain id parameter. Redirect to error page
    Header(“location: error.php”);
    Exit();
}
?>

<!DOCTYPE html>
<html lang=”en”>
<head>
<meta charset=”UTF-8”>
<title>View Record</title>
<link rel=”stylesheet” href=https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css>
<style>
        .wrapper{
            Width: 600px;
            Margin: 0 auto;
        }
</style>
</head>
<body>
<div class=”wrapper”>
<div class=”container-fluid”>
<div class=”row”>
<div class=”col-md-12”>
<h1 class=”mt-5 mb-3”>View Record</h1>
<div class=”form-group”>
<label>Course_Name</label>
<p><b><?php echo $row[“Course_Name”]; ?></b></p>
</div>
<div class=”form-group”>
<label>Track</label>
<p><b><?php echo $row[“Track”]; ?></b></p>
</div>
<div class=”form-group”>
<label>Framework</label>
<p><b><?php echo $row[“Framework”]; ?></b></p>
</div>
<p><a href=”index.php” class=”btnbtn-primary”>Back</a></p>
</div>
</div>
</div>
</div>
</body>
</html>

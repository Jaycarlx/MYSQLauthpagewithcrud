<?php
// Process delete operation after confirmation
If(isset($_POST[“id”]) && !empty($_POST[“id”])){
    // Include config file
Require_once “config.php”;

    // Prepare a delete statement
    $sql = “DELETE FROM userss WHERE id = ?”;

    If($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(“I”, $param_id);

        // Set parameters
        $param_id = trim($_POST[“id”]);

        // Attempt to execute the prepared statement
        If($stmt->execute()){
            // Records deleted successfully. Redirect to landing page
            Header(“location: index.php”);
            Exit();
        } else{
            Echo “Oops! Something went wrong. Please try again later.”;
        }
    }

    // Close statement
    $stmt->close();

    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter
    If(empty(trim($_GET[“id”]))){
        // URL doesn’t contain id parameter. Redirect to error page
        Header(“location: error.php”);
        Exit();
    }
}
?>

<!DOCTYPE html>
<html lang=”en”>
<head>
<meta charset=”UTF-8”>
<title>Delete Record</title>
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
<h2 class=”mt-5 mb-3”>Delete Record</h2>
<form action=”<?php echo htmlspecialchars($_SERVER[“PHP_SELF”]); ?>” method=”post”>
<div class=”alert alert-danger”>
<input type=”hidden” name=”id” value=”<?php echo trim($_GET[“id”]); ?>”/>
<p>Are you sure you want to delete this user record?</p>
<p>
<input type=”submit” value=”Yes” class=”btnbtn-danger”>
<a href=”index.php” class=”btnbtn-secondary ml-2”>No</a>
</p>
</div>
</form>
</div>
</div>
</div>
</div>
</body>
</html>

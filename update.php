<?php
// Include config file
Require_once “config.php”;

// Define variables and initialize with empty values
$Course_Name = $Track = $Framework = “”;
$Course_Name_err = $Track_err = $Framework_err = “”;

// Processing form data when form is submitted
If(isset($_POST[“id”]) && !empty($_POST[“id”])){
    // Get hidden input value
    $id = $_POST[“id”];

    // Validate Course_Name
    $input_Course_Name = trim($_POST[“Course_Name”]);
    If(empty($input_Course_Name)){
        $Course_Name_err = “Please enter a name.”;
    } elseif(!filter_var($input_Course_Name, FILTER_VALIDATE_REGEXP, array(“options”=>array(“regexp”=>”/^[a-zA-Z\s]+$/”)))){
        $Course_Name = “Please enter a valid name.”;
    } else{
        $name = $input_name;
    }

    // Validate Track
    $input_Track = trim($_POST[“Track”]);
    If(empty($input_address)){
        $Track_err = “Please enter a Track.”;     
    } else{
        $Track = $input_Track;
    }

    // Validate Framework
    $input_Framework = trim($_POST[“Framework”]);
    If(empty($input_Framework)){
        $Framework_err = “Please enter a framework.”;     
    } elseif(!filter_var($input_Framework)){
        $Framework_err = “Please enter a valid Framework.”;
    } else{
        $Framework = $input_Framework;
    }

    // Check input errors before inserting in database
    If(empty($Course_Name) && empty($Track_err) && empty($Framework_err)){
        // Prepare an update statement
        $sql = “UPDATE userss SET Course_Name=?, Track=?, Framework=? WHERE id=?”;

        If($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(“sssi”, $param_Course_Name, $param_Track, $param_Framework, $param_id);

            // Set parameters
            $param_Course_Name = $Course_Name;
            $param_Track = $Track;
            $param_Framework = $Framework;
            $param_id = $id;

            // Attempt to execute the prepared statement
            If($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                Header(“location: index.php”);
                Exit();
            } else{
                Echo “Oops! Something went wrong. Please try again later.”;
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
} else{
    // Check existence of id parameter before processing further
    If(isset($_GET[“id”]) && !empty(trim($_GET[“id”]))){
        // Get URL parameter
        $id =  trim($_GET[“id”]);

        // Prepare a select statement
        $sql = “SELECT * FROM userss WHERE id = ?”;
        If($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(“I”, $param_id);

            // Set parameters
            $param_id = $id;

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
                    // URL doesn’t contain valid id. Redirect to error page
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
    }  else{
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
<title>Update Record</title>
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
<h2 class=”mt-5”>Update Record</h2>
<p>Please edit the input values and submit to update the user record.</p>
<form action=”<?php echo htmlspecialchars(basename($_SERVER[‘REQUEST_URI’])); ?>” method=”post”>
<div class=”form-group”>
<label>Course_Name</label>
<input type=”text” name=”Course_Name” class=”form-control <?php echo (!empty($Course_Name_err)) ? ‘is-invalid’ : ‘’; ?>” value=”<?php echo $Course_Name; ?>”>
<span class=”invalid-feedback”><?php echo $Course_Name_err;?></span>
</div>
<div class=”form-group”>
<label>Track</label>
<textarea name=”Track” class=”form-control <?php echo (!empty($Track_err)) ? ‘is-invalid’ : ‘’; ?>”><?php echo $Track; ?></textarea>
<span class=”invalid-feedback”><?php echo $Track_err;?></span>
</div>
<div class=”form-group”>
<label>Framework</label>
<input type=”text” name=”Framework” class=”form-control <?php echo (!empty($Framework_err)) ? ‘is-invalid’ : ‘’; ?>” value=”<?php echo $Framework; ?>”>
<span class=”invalid-feedback”><?php echo $Framework_err;?></span>
</div>
<input type=”hidden” name=”id” value=”<?php echo $id; ?>”/>
<input type=”submit” class=”btnbtn-primary” value=”Submit”>
<a href=”index.php” class=”btnbtn-secondary ml-2”>Cancel</a>
</form>
</div>
</div>
</div>
</div>
</body>
</html>

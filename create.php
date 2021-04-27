<?php
// Include config file
Require_once “config.php”;

// Define variables and initialize with empty values
$Course_Name = $Track = $Framework = “”;
$Course_Name_err = $Track_err = $Framework_err = “”;

// Processing form data when form is submitted
If($_SERVER[“REQUEST_METHOD”] == “POST”){
    // Validate Course_NAme
    $input_name = trim($_POST[“Course_Name”]);
    If(empty($input_Course_Name)){
        $Course_Name_err = “ Please enter Course Name.”;
    } elseif(!filter_var($input_Course_Name, FILTER_VALIDATE_REGEXP, array(“options”=>array(“regexp”=>”/^[a-zA-Z\s]+$/”)))){
        $Course_Name_err = “Please enter a valid name.”;
    } else{
        $Course_Name = $input_Course_Name;
    }

    // Validate Track
    $input_Track = trim($_POST[“Track”]);
    If(empty($input_Track)){
        $Track_err = “Please enter a Track.”;     
    } else{
        $Track = $input_Track;
    }

    // Validate Framwork
    $input_Framework = trim($_POST[“Framework”]);
    If(empty($input_Framework)){
        $Framework_err = “Please enter the Framework.”;     
    } elseif(!filter_var($input_salary)){
        $Framework_err = “Please enter a a valid Framework.”;
    } else{
        $Framework = $input_Framework;
    }

    // Check input errors before inserting in database
    If(empty($Course_Name_err) && empty($Track_err) && empty($Framework_err)){
        // Prepare an insert statement
        $sql = “INSERT INTO userss (Course_Name, Track, Framework) VALUES (?, ?, ?)”;

        If($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(“sss”, $param_Course_Name, $param_Track, $param_Framework);

            // Set parameters
            $param_Course_Name = $Course_Name;
            $param_Track = $Track;
            $param_Framework = $Framework;

            // Attempt to execute the prepared statement
            If($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang=”en”>
<head>
<meta charset=”UTF-8”>
<title>Create Record</title>
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
<h2 class=”mt-5”>Create Record</h2>
<p>Please fill this form and submit to add user record to the database.</p>
<form action=”<?php echo htmlspecialchars($_SERVER[“PHP_SELF”]); ?>” method=”post”>
<div class=”form-group”>
<label>Name</label>
<input type=”text” name=”Course_Name” class=”form-control <?php echo (!empty($Course_Name_err)) ? ‘is-invalid’ : ‘’; ?>” value=”<?php echo $Course_Name; ?>”>
<span class=”invalid-feedback”><?php echo $Course_Name_err;?></span>
</div>
<div class=”form-group”>
<label>Course_Name</label>
<textarea name=”Track” class=”form-control <?php echo (!empty($Track_err)) ? ‘is-invalid’ : ‘’; ?>”><?php echo $Track; ?></textarea>
<span class=”invalid-feedback”><?php echo $Track_err;?></span>
</div>
<div class=”form-group”>
<label>Framework</label>
<input type=”text” name=”Framework” class=”form-control <?php echo (!empty($Framework_err)) ? ‘is-invalid’ : ‘’; ?>” value=”<?php echo $Framework; ?>”>
<span class=”invalid-feedback”><?php echo $Framework_err;?></span>
</div>
<input type=”submit” class=”btnbtn-primary” value=”Submit”>
<a href=”index.php” class=”btnbtn-secondary ml-2”>Cancel</a>
</form>
</div>
</div>
</div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang=”en”>
<head>
<meta charset=”UTF-8”>
<title>Dashboard</title>
<link rel=”stylesheet” href=https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css>
<link rel=”stylesheet” href=https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
<script src=https://code.jquery.com/jquery-3.5.1.min.js></script>
<script src=https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js></script>
<script src=https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js></script>
<style>
        .wrapper{
            Width: 600px;
            Margin: 0 auto;
        }
        Table trtd:last-child{
            Width: 120px;
        }
</style>
<script>
        $(document).ready(function(){
            $(‘[data-toggle=”tooltip”]’).tooltip();   
        });
</script>
</head>
<body>
<div class=”wrapper”>
<div class=”container-fluid”>
<div class=”row”>
<div class=”col-md-12”>
<div class=”mt-5 mb-3 clearfix”>
<h2 class=”pull-left”>User Details</h2>
<a href=”create.php” class=”btnbtn-success pull-right”><I class=”fa fa-plus”></i> Add New User</a>
</div>
<?php
                    // Include config file
require_once “config.php”;

                    // Attempt select query execution
                    $sql = “SELECT * FROM userss”;
                    If($result = $mysqli->query($sql)){
                        If($result->num_rows> 0){
                            Echo ‘<table class=”table table-bordered table-striped”>’;
                                Echo “<thead>”;
                                    Echo “<tr>”;
                                        Echo “<th>#</th>”;
                                        Echo “<th>Course_Name</th>”;
                                        Echo “<th>Track</th>”;
                                        Echo “<th>Framework</th>”;
                                        Echo “<th>Action</th>”;
                                    Echo “</tr>”;
                                Echo “</thead>”;
                                Echo “<tbody>”;
                                While($row = $result->fetch_array()){
                                    Echo “<tr>”;
                                        Echo “<td>” . $row[‘id’] . “</td>”;
                                        Echo “<td>” . $row[‘Course_Name’] . “</td>”;
                                        Echo “<td>” . $row[‘Track’] . “</td>”;
                                        Echo “<td>” . $row[‘Framework’] . “</td>”;
                                        Echo “<td>”;
                                            Echo ‘<a href=”read.php?id=’. $row[‘id’] .’” class=”mr-3” title=”View Record” data-toggle=”tooltip”><span class=”fa fa-eye”></span></a>’;
                                            Echo ‘<a href=”update.php?id=’. $row[‘id’] .’” class=”mr-3” title=”Update Record” data-toggle=”tooltip”><span class=”fa fa-pencil”></span></a>’;
                                            Echo ‘<a href=”delete.php?id=’. $row[‘id’] .’” title=”Delete Record” data-toggle=”tooltip”><span class=”fa fa-trash”></span></a>’;
                                        Echo “</td>”;
                                    Echo “</tr>”;
                                }
                                Echo “</tbody>”;                            
                            Echo “</table>”;
                            // Free result set
                            $result->free();
                        } else{
                            Echo ‘<div class=”alert alert-danger”><em>No records were found.</em></div>’;
                        }
                    } else{
                        Echo “Oops! Something went wrong. Please try again later.”;
                    }

                    // Close connection
                    $mysqli->close();
                    ?>
</div>
</div>
</div>
</div>
</body>
</html>

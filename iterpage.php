<?php
	session_start();
	include_once('general_information.php');
	//********************Check Identity
	// $DESIGNER= $_SESSION['designer_id'];
	// $EXPERIMENT=$_SESSION["experimentID"];
	// $DESIGNER= 20;
	// if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	//	$EMAIL= $_SESSION['email'];
	//********************Check Identity

	// Connect to DB
	include_once('webpage-utility/db_utility.php');
   	$conn = connect_to_db();

	/******* Get All Project in Database ****
		Output: projects[]
	************************************/
   	if ($stmt = mysqli_prepare($conn, "SELECT * FROM Project")) {
        mysqli_stmt_execute($stmt);
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
	        $projects[]=$myrow;
	    }
         mysqli_stmt_close($stmt);
    }
    else {
    //No Designs found
        echo "Our system encounter some errors, please contact our staff Grace at yyen4@illinois.edu with error code: NoFeedback";
        mysqli_stmt_close($stmt);
        die();
    }


?>

<!DOCTYPE html>
<html>
<head>
	<?php include('webpage-utility/ele_header.php'); ?>

  	<title> Designer Page </title>
</head>

<body >
<?php include("webpage-utility/ele_nav.php") ;?>

	<!-- Button trigger modal -->
<div class="container">
<div class="main-section">
	<div style='margin-bottom: 20px'>
    <a href="index.php" class="btn btn-primary">Back to projects</a>
		<a href="newiter.php" class="btn btn-primary">Add new iteration</a>
	</div>
	<?php

		if(count($projects)>0){
			$count_design=1;
			foreach($projects as  $value){
				/*echo "project ".$count_design." title =".$value['title']."<br>";
 			    $count_design++;*/
			 	//******************* To do : Austin
					echo '<div class="card" style="width: 20rem; display:inline-block; float:left; padding: 10px; margin-right:35px; border:groove;">
					<img class="card-img-top" src="career.png" alt="Card image cap" style="width:175px;height:215px;"">
					<div class="card-body">
					<h4 class="card-title">Iteration #X</h4>
					<p class="card-text">Feedback: Moved picture to center, improved font, condensed wording of text.</p>
					<a href="" class="btn btn-primary">Go to iteration</a>
					</div>
					</div>';
 			    //For each project, just use any photo in the Card
 			    //*******************
			}
		}
		else
		{
			echo "<div style='margin-top:20px;'>Click 'Add Design' to upload your design.</div>";
		}

		mysqli_close($conn);

	?>

</div>
</div>



</body>
</html>

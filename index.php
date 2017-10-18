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
<?php include("webpage-utility/ele_navbar.php") ;?>

	<!-- Button trigger modal -->
	<div class="container">
		<div>
			<a type="button" class="btn-add" href=""> &nbsp&nbsp Add Design &nbsp&nbsp </a> 
		</div>		
	<?php
	//******************* To do : Austin
		if(count($projects)>0){		
			$count_design=1;
			foreach($projects as  $value){
			 	echo "project title=".$value['title'];
 			    $count_design++;
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
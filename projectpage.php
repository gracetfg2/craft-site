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
		<a href="index.php" class="btn btn-primary">Back</a>
	</div>
	<?php





  echo
  '
  <div class="jumbotron text-center">
    <div class="container">

      <h1>Designer Page</h1>
      <form action="">
        Project Title:<br>
        <input type="text" id="userinput" value="Title" margin-bottom: 10px>
        <br>
      </form>
			<form action="">
        <br> Upload your design image:<br>
      </form>
			<form action="">
				<label><input type="file" name="pic" align-self="center" accept="image/*"></label>
			</form>
      <select>
			<br>
        <option value="Website">Website</option>
        <option value="Poster/Flyer">Poster/Flyer</option>
        <option value="Mobile App">Mobile App</option>
        <option value="Logo">Logo</option>
      </select>
			<form action=""> <br>
				Design Description:<br>
				<textarea class="userinput" rows="4" cols="50"></textarea>
				<br>
			</form>
      <br> <br>
      <a type="button" class="btn btn-lg btn-default" href="index.php"> Submit </a>
    </div>
  </div>';





		mysqli_close($conn);

	?>

</div>
</div>



</body>
</html>

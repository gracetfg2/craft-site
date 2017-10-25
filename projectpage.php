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
		<button class="btn btn-success" href=""> &nbsp&nbsp Back &nbsp&nbsp </a>
	</div>
	<?php





  echo
  '

  <div class="jumbotron text-center">
    <div class="container">

      <h1>UIUC HCI Research</h1>
      <form action="">
        Project Title:<br>
        <input type="text" id="userinput" value="Title">
        <br>
        Email:<br>
        <input type="text" id="userinput" value="Email">
        <br><br>
      </form>

      <select>
        <option value="Website">Website</option>
        <option value="Poster/Flyer">Poster/Flyer</option>
        <option value="Mobile App">Mobile App</option>
        <option value="Logo">Logo</option>
      </select>
      <br> <br>
      <a type="button" class="btn btn-lg btn-default" href=""> Submit </a>
    </div>
  </div>
  <div class="container">
    <div class="alert alert-info text-center" role="alert">
      Please submit the above before moving down below.
    </div>
    <hr>
    <div class="jumbotron text-center">
      <div class="container">

        <h1>Part 2</h1>
        <p> Upload your design image </p>
        <form action="">
          <label><input type="file" name="pic" align-self="center" accept="image/*"></label>
        </form>

        <form action="">
          Design Description:<br>
          <textarea class="userinput" rows="4" cols="50"></textarea>
          <br>
          Questions for Feedback:<br>
          <textarea class="userinput" rows="4" cols="50"></textarea>
          <br>
        </form>

        <p> Received feedback: </p>
        <select>
          <option value="Website">Private</option>
          <option value="Poster/Flyer">Public</option>
        </select>
        <form action="">
          Desired Number of feedback:<br>
          <input type="text" value="">
          <br>
        </form>
        <br> <br>
        <a type="button" class="btn btn-lg btn-default" href=""> Submit </a>
      </div>
    </div>
     <div class="alert alert-info text-center" role="alert">
    Thanks for filling out the form!
    </div>
  </div> ';





		mysqli_close($conn);

	?>

</div>
</div>



</body>
</html>

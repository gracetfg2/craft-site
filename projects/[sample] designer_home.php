<?php 
	
	session_start();	
	//check session
	//$DESIGNER= $_SESSION['designer_id'];
	$EXPERIMENT=$_SESSION["experimentID"];
	$DESIGNER= 20;
	if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	
	$EMAIL= $_SESSION['email'];
	
	
	include_once('../webpage-utility/db_utility.php');
   	$conn = connect_to_db();

	/*Get Existed Project ID for this designer and store in session*/
   	$query= "SELECT * FROM Project INNER JOIN r_Experiment_Project ON Project.ProjectID=r_Experiment_Project.f_ProjectID WHERE r_Experiment_Project.f_DesignerID =".$DESIGNER." AND r_Experiment_Project.f_ExperimentID=".$EXPERIMENT;
    $result= mysqli_query($conn,$query);
   	if (mysqli_num_rows($result) > 0) 
   	{

   		$current_project = mysqli_fetch_assoc($result);
   		$_SESSION['project_id']=$current_project['ProjectID'];
   		
   		//Get designs belong to this project
   		$query2="Select * From Design WHERE f_ProjectID =".$current_project['ProjectID'];	
 		$result= mysqli_query($conn,$query2);
 		echo "Please wait...";
   		 if (mysqli_num_rows($result) > 0) {
	    // output data of each row
		  while ($row = mysqli_fetch_assoc($result)) {
			  $designs[] = $row;

		  }

		}
		else
		{
			echo "You don't have designs now";
		} 
	
	}
   	else
   	{
   		$_SESSION['project_id']=0; //New project
   		echo "You don't have designs now";
   	}

  
?>

<!DOCTYPE html>
<html>
<head>
	<?php include('../webpage-utility/ele_header.php'); ?>

  <title> Designer Page </title>
</head>
<style>
body{
background-color: #F0F0F0 ;

}


/* unvisited link Not used now*/
.dform:link {
    color: #0B3861;
}

/* visited link */
.dform:visited {
    color: #0B3861;
}

/* mouse over link */
.dform:hover {
    color: #0B243B;
}

/* selected link */
.dform:active {
    color: #0B3861;
}

.btn-add {
  background: #1a6b15;
  background-image: -webkit-linear-gradient(top, #1a6b15, #115724);
  background-image: -moz-linear-gradient(top, #1a6b15, #115724);
  background-image: -ms-linear-gradient(top, #1a6b15, #115724);
  background-image: -o-linear-gradient(top, #1a6b15, #115724);
  background-image: linear-gradient(to bottom, #1a6b15, #115724);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;
  font-family: Arial;
  color: #ffffff;
  font-size: 16px;
  padding: 10px 15px 10px 15px;
  text-decoration: none;
}

.btn-add:hover {
  background: #063806;
  background-image: -webkit-linear-gradient(top, #063806, #1a4223);
  background-image: -moz-linear-gradient(top, #063806, #1a4223);
  background-image: -ms-linear-gradient(top, #063806, #1a4223);
  background-image: -o-linear-gradient(top, #063806, #1a4223);
  background-image: linear-gradient(to bottom, #063806, #1a4223);
  text-decoration: none;
  color: #ffffff;
}

</style>
<body >
<?php include("../webpage-utility/ele_nav.php") ;?>



<div class="main-section">
	<!-- Button trigger modal -->
		<div class="container">
		<div>
		<a type="button" class="btn-add" href="design_form.php?design_id=0"> &nbsp&nbsp Add Design &nbsp&nbsp </a> 
		</div>
		
		<?php

		if(count($designs)>0){
			$count_design=1;
			foreach($designs as  $value){
			  
				if( ($count_design % 4)==1 ){echo "<div class='row' style='padding-top:30px;''>";}

			  //*************** Get Feedback number for each design**********//
			  $fbknum="SELECT * From `exp2_Feedback` WHERE `f_DesignID` =".$value['DesignID'];		  				 
			  $result2= mysqli_query($conn,$fbknum);
   			  $getnum=mysqli_num_rows($result2); 


			    echo " <div class='col-sm-4 col-md-3'> ";
			    echo "<div class='thumbnail' style='padding-top:10px;padding-right:10px;padding-left:10px;'>";

			   if($value['status']=="close")//Now we make it the same
		       {	//echo "<a href='rate_comment.php?design_id=".$value['DesignID']."'><img id='img-preview' border=0 src='../design/".$value['file']."' onmouseover='' style='cursor: pointer;'></a>";
		       		echo "<a href='rate_comment.php?design_id=".$value['DesignID']."'><img id='img-preview' border=0 src='../design/".$value['file']."' onmouseover='' style='cursor: pointer;'></a>";		        
		       }else{
		       		echo "<a href='rate_comment.php?design_id=".$value['DesignID']."'><img id='img-preview' border=0 src='../design/".$value['file']."' onmouseover='' style='cursor: pointer;'></a>";
		       } 
		        echo " <div style='padding-top:10px;padding-left:10px;'><h5><strong>".htmlspecialchars($value['title'])."</strong></h5></div>";

		        echo "<hr>";

		        echo "<div style='text-align:right;padding-bottom:10px;'>";		        
		        if($value['designer-posttime']==null )
		        {
		        	 echo "<a href='design_form.php?design_id=".$value['DesignID']."' > <span class='glyphicon glyphicon-edit'></span> Edit</a>&nbsp ";
		      	     echo "<a href='configure.php?design_id=".$value['DesignID']."'><span class='glyphicon glyphicon-share-alt'></span> Share </a>";
		          	 //echo " <a href='rate_comment.php?design_id=".$value['DesignID']."' > <span class='glyphicon glyphicon-comment'></span>&nbsp ".$getnum."</a> ";
	
		        	
		        }
		        else
		        {
		        	// echo "<a href='design_form.php?design_id=".$value['DesignID']."' > <span class='glyphicon glyphicon-edit'></span> Edit</a> &nbsp";
		      	     echo "<a href='link_info.php?design_id=".$value['DesignID']."'><span class='glyphicon glyphicon-share-alt'></span> Share </a> &nbsp";
		          	 echo " <a href='rate_comment.php?design_id=".$value['DesignID']."' > <span class='glyphicon glyphicon-comment'></span>&nbsp".$getnum."</a> ";
		           
		        }
		        echo "</div>";
		       // echo "</div>";
		        echo "</div>";
 			    echo "</div>";
 			    if($count_design%4==0){echo "</div>";}

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


</div>







<script>
  $(document).ready(function(){
		
	
		
   });

 

</script>


</body>
</html>
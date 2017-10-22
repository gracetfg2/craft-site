<?php 
session_start();
$designer_id=$_SESSION['designer_id'];


if(!$designer_id) { header("Location: ../index.php?role=1"); die(); }

if(is_null($_GET['design_id']) )
	{ header("Location: designer_home.php"); die();}

$design_id=$_GET['design_id'];
$project_id=$_SESSION['project_id'];

$title="";
$description="";
$stage="";
$filename="";

if($design_id==0){
	//New design

}
else
{
	//Existing design
	include_once('db_utility.php');
   	$conn = connect_to_db();
   	//check if the user have access to the design
   	$query="Select * From Design WHERE DesignID =".$design_id." AND f_DesignerID=".$designer_id ;
   	$result= mysqli_query($conn,$query);

   		if (mysqli_num_rows($result) > 0) {
	   		
	   		$row = mysqli_fetch_assoc($result);
			$title=$row['title'];

			$type=$row['stage'];
			$breaks = array("<br />");  
   		    $description = str_ireplace ($breaks, "\r\n", $row['description']);
			$filename=$row['file'];		

			echo $title;
		
		}
		else
		{
			//echo "alert('Specified design does not exist or not belong to you. Please select a design from your own list.')";
			header('Location:designer_home.php');
			die();
		}
	
}

    

?>

<!DOCTYPE html>
<html>
<head>

	<?php include('ele_header.php'); ?>
  <title> Designer Page </title>

<style>
em{
	color:red;
}
.btn-submit {
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

.btn-submit:hover {
  background: #063806;
  background-image: -webkit-linear-gradient(top, #063806, #1a4223);
  background-image: -moz-linear-gradient(top, #063806, #1a4223);
  background-image: -ms-linear-gradient(top, #063806, #1a4223);
  background-image: -o-linear-gradient(top, #063806, #1a4223);
  background-image: linear-gradient(to bottom, #063806, #1a4223);
  text-decoration: none;
  color: #ffffff;
}
.btn-cancel {
  background: #e0eddf;
  background-image: -webkit-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: -moz-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: -ms-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: -o-linear-gradient(top, #e0eddf, #c5d9cb);
  background-image: linear-gradient(to bottom, #e0eddf, #c5d9cb);
  -webkit-border-radius: 28;
  -moz-border-radius: 28;
  border-radius: 28px;
  -webkit-box-shadow: 0px 1px 3px #666666;
  -moz-box-shadow: 0px 1px 3px #666666;
  box-shadow: 0px 1px 3px #666666;
  font-family: Arial;
  color: #6d756e;
  font-size: 16px;
  padding: 10px 15px 10px 15px;
  text-decoration: none;
}

.btn-cancel:hover {
  background: #d2dbd2;
  background-image: -webkit-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: -moz-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: -ms-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: -o-linear-gradient(top, #d2dbd2, #d9e0da);
  background-image: linear-gradient(to bottom, #d2dbd2, #d9e0da);
  text-decoration: none;
    color: #6d756e;
}

</style>
</head>

<body >
<?php include("ele_navbar.php") ;?>


<div class="main-section">
	<div class="container">
	  


		<form class="form-horizontal" name="design_form" id="design_form" method="post" action="save_design.php?design_id=<?php echo $design_id;?>" enctype="multipart/form-data">

			   <div class="form-group"  style="padding-bottom:10px;">
			    <div class="col-sm-2"></div>
			    <div class="col-sm-10">
			      <h2 style="color:#0B3B0B"><strong>Describe Your Design</strong></h2>
			      <div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  Please fill out the empty fields.
					</div>
			    </div>
			  </div>

			  <div class="form-group required" id="form-group-title">
			    <label for="title" class="col-sm-2 control-label" >Title<em>*</em></label>
			    <div class="col-sm-10">
			    
			      <input type="text" class="form-control" name="title" id="title" placeholder="Design Title" maxlength="80" value='<?php print htmlentities($title, ENT_QUOTES); ?>' />
			    </div>
			  </div>

			  <div class="form-group required" id="form-group-stage">
			  	<label for="stage" class="col-sm-2 control-label">Stage<em>*</em></label>
				    <div class="col-sm-10">
							<label class="radio-inline">
							  <input type="radio" name="stage" id="EARLY" value="EARLY" <?php if($type=="early") echo "checked";?>> First iteration
							</label>
							<label class="radio-inline">
							  <input type="radio" name="stage" id="LATE" value="LATE" <?php if($type=="late") echo "checked";?>> Second iteration
							</label>
				    </div>
			  </div>

			  <div class="form-group required" id="form-group-description">
			    <label for="tdescription" class="col-sm-2 control-label">Description<em>*</em></label>
			    <div class="col-sm-10">
			      <textarea class="form-control" rows="5" name="tdescription" id="tdescription"><?php echo htmlspecialchars($description); ?></textarea>
			      <p style="color:grey;">Please describe your goals and intentions of this design so that people outside the domain could understand and provide feedback for you. </p>
			    </div>
			   
			  </div>

			  <div class="form-group" id="form-group-file">
			    <label for="fileToUpload" class="col-sm-2 control-label"><?php if ($filename!=""){ echo "Change File";}else { echo "Upload File";}?><em>*</em></label>
			    <div class="col-sm-10">
				    <input class="input-file" id="fileToUpload" name="fileToUpload" type="file" onChange="javascript:fileUpdate(this);">
				    <p class="help-block">Only JPG, JPEG, PNG, and GIF files are allowed, the image size should be less than 5MB</p>
				   <?php if ($filename!="") { echo "<img id='pre-image' style='width:auto;height:300px' src='../design/".$filename."'>";} ?>   
				    <input type="hidden" id="exist_file" name="exist_file" value=<?php if ($filename!="") { echo "'true'"; }else { echo "'false'";}  ?> >               
				</div>

			  </div>

			
			    <input type="hidden" id="update_file" name="update_file" value="false">
			    <input type="hidden" id="action" name="action">
			    <input type="hidden" id="description" name="description">
	
			  
			
		</form>

		<div class="container" style="text-align:right; padding-bottom:20px;">		 	
		 	 <button type="submit" class="btn-submit" id="submit-bn" onClick="javascript:save('save')"> Save </button>&nbsp
			 <button href='designer_home.php' class="btn-cancel" onClick="javascript:cancel();"> Cancel </button>
		 </div>
	</div>
</div>



<script>
	 isOkay = true;
	 
	 jQuery(function() {

	 	$("#title").bind("keydown", function(){
			  $("#form-group-title").removeClass("has-error");
		});
		$("input[name='stage']").bind("click", function(){
		    $('#form-group-stage').removeClass("has-error");
		});
		$("#tdescription").bind("keydown", function(){
		    $('#form-group-description').removeClass("has-error");
		});



	  }); // jQuery(function(){})


	 function fileUpdate(input) {
	 	  //check whether browser fully supports all File API
	    if (window.File && window.FileReader && window.FileList && window.Blob)
	    {
	 
	        //get the file size and file type from file input field
	        var fsize = $('#fileToUpload')[0].files[0].size;
	        var ftype = $('#fileToUpload')[0].files[0].type;
	        var fname = $('#fileToUpload')[0].files[0].name;


	        //Check Size
	        if(fsize>5242880) //do something if file size more than 5 mb (5242880)
	        {
	            alert("Type :"+ ftype +" | "+ fsize +" bites\n(File: "+fname+") Too big!");
	        }
	        else{

	        	 //Check Type
			       switch(ftype)
			        {
			            case 'image/png':
			            case 'image/gif':
			            case 'image/jpeg':
			            case 'image/jpg':
			            case 'image/pjpeg':
			 				$('#update_file').val("true");
			 				var reader = new FileReader();
				            reader.onload = function (e) {
		        	        $('#pre-image')
		            	        .attr('src', e.target.result)
		                	    .width('auto')
		                	    .height(300);
		            		};
		          			reader.readAsDataURL(input.files[0]);
			                break;
			            default:
			                alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
			          
			                break;
			        }

	        }

	    }else{

	         alert("Your broswer dosen't support file uploading, please use Google Chrome 6, Firefox 3.6, Safari 6 or IE 10+ versoin");

	        $("#fileToUpload").attr("disabled", true);
	    }




	 }

	 function save(_action) {
		  
		  $("#error_alert").hide();
		  $(".has-error").removeClass("has-error");
		  isOkay = true;



	 	$('input#title').val($.trim($('input#title').val() )  );		
		if ($('input#title').val() == "") {
			 $('input#title').parents('.form-group:first').addClass("has-error");
			  isOkay = false;
		}
		

	
		$('#tdescription').val($.trim($('#tdescription').val() ) );	
		if( $('#tdescription').val() == "" ){
			 $('#tdescription').parents('.form-group:first').addClass("has-error");
			  isOkay = false;
		}

		if ($("input[name='stage']:checked").size() == 0 ) {
			  $("#form-group-stage").addClass("has-error");
			  isOkay = false;
		}

		if( ( $('#update_file').val()=="false") && ($('#exist_file').val()=="false")) 
		{
			  $("#form-group-file").addClass("has-error");
			  isOkay = false;
		}


	    if(isOkay==true)
		{

			var multiline= $('#tdescription').val().replace(/\r?\n/g, '<br />');
	 		$('#description').val( $.trim( multiline )  );
			
			$('#action').val(_action);
			$('#design_form').submit();
		}
		else{
			 $("#error_alert").show();
		}



	  
	
	}
	function cancel() {
		window.location.href="designer_home.php";
	}

</script>


</body>
</html>





 
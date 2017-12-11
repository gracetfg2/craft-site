<?php
    session_start();
    include_once('general_information.php');
    //********************Check Identity
    // $DESIGNER= $_SESSION['designer_id'];
    // $EXPERIMENT=$_SESSION["experimentID"];
    // $DESIGNER= 20;
    // if(!$DESIGNER) { header("Location: ../index.php"); die(); }
    //  $EMAIL= $_SESSION['email'];
    //********************Check Identity

    // Connect to DB
    include_once('webpage-utility/db_utility.php');
    $conn = connect_to_db();

    /******* Get Feedback from Database ****
        Output: feedback[]
    ************************************/
    if ($stmt = mysqli_prepare($conn, "SELECT * FROM ExpertFeedback")) {
        mysqli_stmt_execute($stmt);
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $feedback[]=$myrow;
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
<html lang="en">
<head>
    <style>
        .droptarget {
            float: left; 
        width: 300px; 
        height: 300px;
        margin: 15px;
        padding: 10px;
        border: 1px solid #aaaaaa;
        clear: left;
}
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
    <script type="text/javascript" src="behavior_record_updated.js"></script>
    <!---->
    <title>Prototype</title>
    <!-- Custom styles for this template -->
    <?php include('webpage-utility/ele_header.php'); ?>

</head>


<body>
    <?php include('webpage-utility/ele_nav.php');?>

<div class="container" style="line-height: 2em;">

<div class="main-section">
    <div class="alert alert-info" id="instruction">
        <h3>Review Feedback</h3>
         <p>We have collected feedback from three independent reviewers to help you revise your design. These reviewers are from the target audiences and all have more than three years of professional experience in design. Please review the feedback and highlight the part that you think its useful for improving your design. After that, please click "Next" to go to the next step.</p>
        <br>
    </div><!--End alert section for instruction-->

<div class='row'>
    <div class='col-md-8'>

       
        <?php
         
            if(count($feedback)<1){
                echo "<div style='text-align:center'><p>Your feedback is not ready yet, please contact Grace Yen at <em>design4uiuc@gmail.com</em></p></div>";
    
            }else{

                
                echo "<table class='table table-hover table-nonfluid'>";
                echo "<tbody>";
                //$element = "<div id =";
                $feedbackNum = 0;
                foreach ($feedback as $value)
                {
                    $feedbackNum += 1;
                    $content=htmlspecialchars($value['edited_content']);
                   // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
                    $arr = explode(".", $content);
                    //echo "<br>";
                    
 
                    for($id = 0; $id<count($arr); $id++) 
                    {
                    	echo "<div style =' border-style: solid; background-color: orange' ondragstart='dragStart(event)'; draggable='true';  id = '$id + $feedbackNum' >$arr[$id]</div>";

                    } 
                   /* echo "<tr id='div-".$value['FeedbackID']."' >
                            <td><strong>#".$feedbackNum."</strong></td>

                            <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($content)."
                            </td>  
                    </tr>"; */
                    echo "---------------------------------------------------------------------<br>";
                }
                echo "</tbody></table>";
                
            }
               
                
        ?>



<?php include("webpage-utility/footer.php") ?>
</div> 

    <div class='col-md-4'>
        
        <button onclick="saveTextAsFile()">Next Page</button>

       	<div id = "mainData">
        <div class='droptarget' id = 'inputTextToSave-1' ondrop='drop(event)' ondragover='allowDrop(event)' >
        	<input type="text" id="myText" value="Some text...">
        </div>

        
        <div class='droptarget' id = 'inputTextToSave-2' ondrop='drop(event)' ondragover='allowDrop(event)'>
            <input type="text" id="myText" value="Some text...">
        </div>
       
        <div class='droptarget' id = 'inputTextToSave-3' ondrop='drop(event)' ondragover='allowDrop(event)'>
        	<input type="text" id="myText" value="Some text...">
        </div>
        </div>
    </div>      
    </div><!End Task Section -->
    
    
</div><!--End Main Section-->

</div><!--End Container-->

<!--Begin Script-->       
<script>

var tracker;
function changeColor(color)
{  
    tracker = color;

}
var glob;

function mouseUp() {
  var sel, range, node;
    if (window.getSelection) {
        sel = window.getSelection();
        console.log(sel);
        glob = sel;
        replace(glob);
        
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        range.collapse(false);
        range.pasteHTML(html);
    }

}

/*function replace(sel){
    if (sel.getRangeAt && sel.rangeCount) {
            range = window.getSelection().getRangeAt(0);
            
            
            //var spanner = document.createElement('span');
            //spanner.innerHTML = range;
            //spanner.style.backgroundColor = tracker;
            //spanner.addEventListener("ondragstart",dragStart(event));
            //spanner.addEventListener("draggable",true);
            //spanner.id = "dragtarget";

            var html = '<span style="background-color:' + tracker + ';" ondragstart="dragStart(event)" draggable="true" id="dragtarget">' + range + '</span>';
            range.deleteContents();


            
            //var dropdown = '<div class="dropdown"><button class="dropbtn">Dropdown</button><div class="dropdown-content"><p>Hello World!</p></div></div>';
            //html += dropdown;

            var el = document.createElement("div");
            el.innerHTML = html;

            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);
            //console.log(document.documentElement.innerHTML.getIndex(sel));
        }
}*/

function dragStart(event) {
    event.dataTransfer.setData("Text", event.target.id);

}


function allowDrop(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    var data = event.dataTransfer.getData("Text");
    event.target.appendChild(document.getElementById(data));
}

function saveTextAsFile()
{
    //document.getElementById("inputTextToSave").value;
    //document.getElementsByClass('droptarget').first()
    var textToSave = "<div style = 'float: right;'><textarea id='myText' style='height: 300px; display: block; margin: 15px 200px 25px 25px; width: 834px;'></textarea><textarea id='myText' style='height: 300px; display: block; margin: 15px 200px 25px 25px; width: 834px;'></textarea><textarea id='myText' style='height: 300px; display: block; margin: 15px 200px 25px 25px; width: 834px;'></textarea></div>";
    textToSave += document.getElementById('mainData').innerHTML;
    //document.body.getElementsByClassName("droptarget").text();
   // textToSave += document.getElementById('inputTextToSave-2').innerHTML;
    //textToSave += document.getElementById('inputTextToSave-3').innerHTML;
    
    document.body.innerHTML=textToSave;
   /* var textToSaveAsBlob = new Blob([textToSave], {type:"text/plain"});
    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
    var fileNameToSaveAs = "fileResult.txt";
   var downloadLink = document.createElement("a");
    downloadLink.download = fileNameToSaveAs;
    downloadLink.innerHTML = "Download File";
    downloadLink.href = textToSaveAsURL;
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
 	
    downloadLink.click();*/
}
 
function destroyClickedElement(event)
{
    document.body.removeChild(event.target);
}

</script>




</body>

</html>
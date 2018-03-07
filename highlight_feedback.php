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
        height: 3500px;
        margin: 15px;
        padding: 10px;
        border: 1px solid #aaaaaa;
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
    <div class='col-md-12'>
        <button onclick="saveTextAsFile()">Create New Label</button>
        <input type="text" id="fname">
        <label for="colorWell">Choose color for the label:</label>
        <input type="color" value="#ff0000" id="colorWell">
       

    <div onmouseup="mouseUp()">
        <!-- <button onclick="changeColor('green')"> Green </button>
        <button onclick="changeColor('yellow')"> Yellow </button> -->
        <input type="button" id="btnAdd" value="Save the new label">
        <p id="fooBar">Current Labels:</p>
        <?php
         
            if(count($feedback)<1){
                echo "<div style='text-align:center'><p>Your feedback is not ready yet, please contact Grace Yen at <em>design4uiuc@gmail.com</em></p></div>";
    
            }else{

                
                echo "<table class='table table-hover table-nonfluid' id='inputTextToSave'>";
                echo "<tbody>";

                $feedbackNum = 0;
                foreach ($feedback as $value)
                {
                    $feedbackNum += 1;
                    $content=htmlspecialchars($value['edited_content']);
                   // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);

                    echo "<tr id='div-".$value['FeedbackID']."' >
                            <td><strong>#".$feedbackNum."</strong></td>

                            <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($content)."
                            </td>  
                    </tr>";

                }
                echo "</tbody></table>";
                
            }
               
                
        ?>


    
    </div>

</div> 
        

    
    
</div><!--End Main Section-->
<?php include("webpage-utility/footer.php") ?>
</div><!--End Container-->

<!--Begin Script-->       
<script>
var tracker;
function changeColor(color)
{  
    tracker = color;

}
function mouseUp() {
  var sel, range, node;
    if (window.getSelection) {
        sel = window.getSelection();

        if (sel.getRangeAt && sel.rangeCount) {
            range = window.getSelection().getRangeAt(0);
            
            
            //var spanner = document.createElement('span');
            //spanner.innerHTML = range;
            //spanner.style.backgroundColor = tracker;
            //spanner.addEventListener("ondragstart",dragStart(event));
            //spanner.addEventListener("draggable",true);
            //spanner.id = "dragtarget";

            var html = '<span style="background-color:' + tracker + ';" >' + range + '</span>';
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
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        range.collapse(false);
        range.pasteHTML(html);
    }

}
/*
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
} */
function saveTextAsFile()
{
    //document.getElementById("inputTextToSave").value;
    //document.getElementsByClass('droptarget').first()
    var textToSave = document.getElementById('inputTextToSave').innerHTML;
    //document.body.getElementsByClassName("droptarget").text();
    var textToSaveAsBlob = new Blob([textToSave], {type:"text/plain"});
    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);
    var fileNameToSaveAs = "fileResult.txt";
 
    var downloadLink = document.createElement("a");
    downloadLink.download = fileNameToSaveAs;
    downloadLink.innerHTML = "Download File";
    downloadLink.href = textToSaveAsURL;
    downloadLink.onclick = destroyClickedElement;
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
 
    downloadLink.click();
}
 
function destroyClickedElement(event)
{
    document.body.removeChild(event.target);
}
var colorWell;
var defaultColor = "#0000ff";

window.addEventListener("load", startup, false);
function startup() {
  colorWell = document.querySelector("#colorWell");
  colorWell.value = defaultColor;
  colorWell.addEventListener("input", updateFirst, false);
  colorWell.select();
}
var colorer = "blue";
function updateFirst(event) {
    colorer = event.target.value;
  }
function add(type) {
  //Create an input type dynamically.   
  var element = document.createElement("input");
  //Assign different attributes to the element. 
  element.type = type;
  element.value = document.getElementById("fname").value;
  element.name = type; // And the name too?
  element.style.backgroundColor = colorer;
  element.onclick = function() { // Note this is a function
    tracker = element.style.backgroundColor;
  };

  var foo = document.getElementById("fooBar");
  //Append the element in page (in span).  
  foo.appendChild(element);
}
document.getElementById("btnAdd").onclick = function() {
  add("button");
};

</script>




</body>

</html>

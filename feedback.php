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

    <div onmouseup="mouseUp()">
        <button onclick="changeColor('green')"> Green </button>
        <button onclick="changeColor('yellow')"> Yellow </button>
        <?php
         
            if(count($feedback)<1){
                echo "<div style='text-align:center'><p>Your feedback is not ready yet, please contact Grace Yen at <em>design4uiuc@gmail.com</em></p></div>";
    
            }else{

                
                echo "<table class='table table-hover table-nonfluid'>";
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
         
    </div><!--End Task Section-->
    
    <?php include("webpage-utility/footer.php") ?>
</div><!--End Main Section-->
<div class='droptarget' ondrop='drop(event)' ondragover='allowDrop(event)'></div>
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
            
            
            var html = '<span style="background-color:' + tracker + ';" ondragstart="dragStart(event)" ondrag="dragging(event)" draggable="true" id="dragtarget">' + range + '</span>';
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
function dragStart(event) {
    event.dataTransfer.setData("Text", event.target.id);
}

function dragging(event) {
    document.getElementById("demo").innerHTML = "The p element is being dragged";
}

function allowDrop(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    var data = event.dataTransfer.getData("Text");
    event.target.appendChild(document.getElementById(data));
    document.getElementById("demo").innerHTML = "The p element was dropped";
}

</script>




</body>

</html>
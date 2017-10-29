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
</div><!--End Container-->

<!--Begin Script-->       
<script>
function mouseUp() {
  var sel, range, node;
    if (window.getSelection) {
        sel = window.getSelection();

        if (sel.getRangeAt && sel.rangeCount) {
            range = window.getSelection().getRangeAt(0);
            
            color = document.queryCommandValue("backColor");
            
            var html = '<span style="background-color:yellow;">' + range + '</span>';
            range.deleteContents();
            
            var dropdown = '<div class="dropdown"><button class="dropbtn">Dropdown</button><div class="dropdown-content"><p>Hello World!</p></div></div>';
            html += dropdown;

            var el = document.createElement("div");
            el.innerHTML = html;

            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

        }
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        range.collapse(false);
        range.pasteHTML(html);
    }

}
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}
function dropdown()
{
    var select = document.getElementById("ddl");
    var option = document.createElement("option");
    option.text = "yay";
    select.add(option);
    return select;
}
</script>


<style>
/* Style The Dropdown Button */
    .dropbtn 
    {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

/* The container <div> - needed to position the dropdown content */
    .dropdown 
    {
        position: relative;
        display: inline-block;
    }

/* Dropdown Content (Hidden by Default) */
    .dropdown-content 
    {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

/* Links inside the dropdown */
    .dropdown-content a 
    {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

/* Change color of dropdown links on hover */
    .dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content 
    {
        display: block;
    }

/* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn 
    {
        background-color: #3e8e41;
    }
</style>

</body>

</html>
<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
//connection noted as $db
require_once("../includes/db.php");
$testid = 2;
$popsql = "";
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="icon" href="fauowl.gif" type="image/gif" sizes="16x16">
        <title>Administration</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/admin_css.css" rel="stylesheet">
    </head>

    <body>

        <div id="wrapper">

            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <div id="sidebar-wrapper">
                        <ul class="sidebar-nav">
                            <li>
                                <img src="logo-image.svg" class="img-responsive" alt="FAU logo">
                            </li>
                            <li>
                                <a href="admin_homepage.php">Home Page</a>
                            </li>
                            <li>
                                <a href="admin_archives.php">Archived Databases</a>
                            </li>
                            <li>
                                <a href="admin_setorientationdate.php">Create Orientation Date</a>
                            </li>
                            <li>
                                <a href="admin_editorientationdate.php">Edit Orientation Date</a>
                            </li>
                            <li>
                                <a href="admin_viewquestionnaire.php">View Questionnaire</a>
                            </li>
                            <li>
                                <a href="admin_edit_questionnaire.php">Edit Questionnaire</a>
                            </li>
                            <li>
                                <a href="admin_viewQuesAnswers.php">View Questionnaire Answers</a>
                            </li>
                            <li>
                                <a href="../student_view/logout_student.php" class="logout">Logout</a>                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->


            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <h1>Edit Questionnaire</h1>
                    <p>Here are the current questions in the student questionnaire:</p>
                    <div id= "display_block_questions">
                        <?php
                        if(isset($_POST['submitQuestEdit'])){
                            $count = sizeof($_POST['responses']);

                            echo '<h1>'.$count.'</h1>';

                            for($i=0; $i<$count; $i++){ //update each table entry
                                $filtered = str_replace("'","\'",$_POST['responses'][$i]);
                                $updatesql= "UPDATE questions SET questionText='".$filtered."', inputType='".$_POST['resptype'][$i]."' WHERE id=".($i+1).";";
                                $updatequery=mysqli_query($db,$updatesql);
                                if(!$updatequery){
                                    echo 'ERROR'.mysqli_error($db);
                                }

                            }
                            //if ($_POST['newquestions']){
                            $newcount = sizeof($_POST['newresponses']); //submit new questions //NEED TO UPDATE STUDENTANSwERS TABLE
                            echo '<h2>'.$newcount.'</h2>';
                            for($l=0;$l<$newcount;$l++){
                                $insertsql = "INSERT INTO questions (questionText,inputType) VALUES('".$_POST['newresponses'][$l]."', '".$_POST['newresptype'][$l]."');";
                                $insertquery = mysqli_query($db,$insertsql);
                                if($insertquery){
                                    $selectnewqsql = "SELECT * FROM questions where questionText='".$_POST['newresponses'][$l]."';";
                                    $newquery=mysqli_query($db,$selectnewqsql);
                                    $newrow=mysqli_fetch_assoc($newquery);
                                    $colchecksql = "SHOW COLUMNS FROM QuestionnaireAnswers LIKE '".$newrow['id']."';";
                                    $colcheckquery = mysqli_query($db,$colchecksql);
                                    if(!mysqli_num_rows($colcheckquery)){
                                        $updatestudentssql= "ALTER TABLE QuestionnaireAnswers ADD Ques".$newrow['id']." VARCHAR( 300 ) NULL AFTER Ques".($newrow['id']-1).";";
                                        $updatestudentquery= mysqli_query($db,$updatestudentssql);
                                        if(!$updatestudentquery){
                                            echo 'ERROR'.mysqli_error($db);
                                        }
                                    }
                                }else{
                                    echo 'ERROR'.mysqli_error($db);
                                }
                            }
                            //}
                        }
                        ?>
                        <form name="editForm" method="post">
                            <?php
                            $allquestionsql = "SELECT * FROM questions;";
                            $allquestquery = mysqli_query($db, $allquestionsql);
                            $questioncount = mysqli_num_rows($allquestquery);
                            if ($allquestquery){
                                while($row=mysqli_fetch_assoc($allquestquery)){ //populate with all existing questions
                                    $arrayId = $row['id'] - 1;
                                    echo'<div class="questionBlock" id="quest'.$row['id'].'">';
                                    echo '<input type="text" name=responses['.$arrayId.'] value="'.$row['questionText'].'">';//fill with question text
                                    echo '<select name=resptype['.$arrayId.']>';
                                    if ($row['inputType'] == "R"){ //select the questiontype in the table entry
                                        echo '<option value="R" selected>Yes/No</option>';
                                        echo '<option value="T">Text Response</option>';
                                    }else{
                                        echo '<option value="R">Yes/No</option>';
                                        echo '<option value="T" selected>Text Response</option>';
                                    }
                                    echo '</select>';
                                    echo '<strong>Delete</strong> <input type="checkbox" name="entries[]" value="'.$row['id'].'">';//add checkbox for deleting
                                    echo'</div>';
                                } //save new questions and responses in seprate arrays and add them that way.

                                echo "<div id='newQuestions' name='newQuestions'>";
                            ?>
                            <?php
                                if(isset($_POST['newquestbutton'])){ //display fields for new questions
                                    echo '<h1>'.$_POST['newquestions'].'</h1>';
                                    for($k=0; $k<$_POST['newquestions']; $k++){
                                        echo '<div class="questionBlock">';    
                                        echo '<input type="text" name=newresponses['.$k.']>';
                                        echo '<select name=newresptype['.$k.']>';
                                        echo '<option value="R">Yes/No</option>';
                                        echo '<option value="T">Text Response</option>';
                                        echo '</select>';
                                        echo '</div>';
                                    }
                                }
                            ?>
                            <?php
                                if (isset($_POST['deletequestbutton'])){ //delete questions from table by ID
                                    foreach ($_POST['entries'] as $check){
                                        if ($check == true){
                                            $delsql = 'DELETE FROM questions WHERE id = "'.$check.'";';
                                            mysqli_query($db,$delsql);
                                            echo"<script type='text/javascript'> $('#quest".$check."').hide();</script>";//WHY WONT THIS WORK
                                            echo "Deleted question ".$check."</br>";
                                        }
                                    }
                                    //echo '<h2>jkgjgjkgf</h2>';
                                    $dropidsql = "ALTER TABLE questions DROP id;";//drop id column
                                    $dropquery = mysqli_query($db, $dropidsql);
                                    if(!$dropquery){
                                        echo 'ERROR'.mysqli_error($db);
                                    }//re-add id table to eliminate gaps in the id numbers 
                                    $addidsql = 'ALTER TABLE questions ADD id int( 15 ) NOT NULL AUTO_INCREMENT AFTER inputType, ADD PRIMARY KEY(id);';
                                    $addquery = mysqli_query($db, $addidsql);
                                    if($addquery){//REFRESH WONT WORK :(((
                                        //echo'<script type="text/javascript">',
                                        //  'window.location.reload(true);',
                                        //'</script>';

                                    }else{
                                        echo 'ERROR'.mysqli_error($db);
                                    }
                                }

                            ?>
                            <?php  
                                echo"</div>";
                                echo'Add new questions:  ';

                                echo'<select name=newquestions>'; //dropdown for how many questions you want to add
                                for($j=0; $j<=5; $j++){
                                    echo '<option value='.$j.'>'.$j.'</option>';
                                }
                                echo '</select>';
                                echo '<button type="submit" name="newquestbutton" value="NEW">Add questions</button>';//form="addnew"
                                echo '<button type="submit" name="deletequestbutton" value="DEL">Delete selected questions</button>';
                                echo '<br><button type="submit" name="submitQuestEdit">Submit</button>';//form="editForm"
                            }
                            ?>

                        </form>


                    </div>

                </div>
            </div>
            <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/popper/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    </body>

</html>

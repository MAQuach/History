<?php
//connection noted as $db
require_once("../includes/db.php");
$testid = 2;
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
                                <a href="../student_view/logout_student.php" class="logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </ul>
            </div>
            <!-- /#sidebar-wrapper -->


            <!-- Page Content -->
            <div id="page-content-wrapper">
                <div class="container-fluid">
                    <h1>View Questionnaire</h1>
                    <p>Here are the current questions in the student questionnaire:</p>
                    <div>
                        <table>
                            <tr> 
                                <th>Question</th> 
                                <th>Response Type</th>
                            </tr>

                            <?php
                            $allquestionsql = "SELECT * FROM questions;";
                            $allquestquery = mysqli_query($db, $allquestionsql);
                            if ($allquestquery){
                                while($row=mysqli_fetch_assoc($allquestquery)){
                                    echo'<tr>';
                                    echo '<td>'.$row['questionText'].'</td>';
                                    if ($row['inputType'] == "R"){
                                        echo '<td>Yes/No</td>';
                                    }else{
                                        echo '<td>Text Response</td>';
                                    }
                                    echo'</tr>';
                                }
                            }
                            ?>

                        </table>


                        <a href="admin_edit_questionnaire.php">Click here to edit the questionnaire</a>

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

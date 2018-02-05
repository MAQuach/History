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
                    <h1>Archived Databases</h1>
                    <div class="container">   
                        <p></p>
                        <div class="dropdown">

                            <form name="filterForm" method="post" class="form-inline">
                                <select name="year" class="form-control">
                                    <option class="dropdown-item" value="">Year</option>
                                    <?php
                                    $yearsql = "SELECT DISTINCT termYear FROM OrientationStudents ORDER BY termYear;";
                                    $yearquery = mysqli_query($db, $yearsql);
                                    if ($yearquery){
                                        while ($yearrow = mysqli_fetch_assoc($yearquery)){
                                            echo '<option class="dropdown-item" value="'.$yearrow['termYear'].'">'.$yearrow['termYear'].'</option>';  //displays year...maybe...
                                        }
                                    } else {
                                        echo "NOOOOOO".mysqli_error($db);
                                    }
                                    ?>

                                </select>

                                <select name="term" class="form-control">
                                    <option class="dropdown-item" value="">Term</option>
                                    <?php
                                    $termsql = "SELECT DISTINCT semesterTerm FROM OrientationStudents ORDER BY semesterTerm;";
                                    $termquery = mysqli_query($db, $termsql);
                                    if ($termquery){
                                        while ($termrow = mysqli_fetch_assoc($termquery)){
                                            echo '<option class="dropdown-item" value="'.$termrow['semesterTerm'].'">'.$termrow['semesterTerm'].'</option>';  //displays year...maybe...
                                        }
                                    } else {
                                        echo "NOOOOOO".mysqli_error($db);
                                    }
                                    ?>

                                </select>

                                <select name="completed" class="form-control">
                                    <option class="dropdown-item" value="">Submission Status</option>
                                    <?php
                                    $completedsql = "SELECT DISTINCT finalized FROM OrientationStudents ORDER BY finalized;";
                                    $completedquery = mysqli_query($db, $completedsql);
                                    if ($completedquery){
                                        while ($completedrow = mysqli_fetch_assoc($completedquery)){
                                            echo '<option class="dropdown-item" value="'.$completedrow['finalized'].'">'.$completedrow['finalized'].'</option>';  
                                        }
                                    } else {
                                        echo "NOOOOOO".mysqli_error($db);
                                    }
                                    ?>

                                </select>

                                <select name="orientationDate" class="form-control">
                                    <option class="dropdown-item" value="">Orientation Date</option>
                                    <?php
                                    $orientationsql = "SELECT DISTINCT id,`date` FROM orientationDates ORDER BY `date`;";
                                    $orientationquery = mysqli_query($db,$orientationsql);
                                    if ($orientationquery){
                                        while ($completedrow = mysqli_fetch_assoc($orientationquery)){
                                            echo '<option class="dropdown-item" value="'.$completedrow['id'].'">'.$completedrow['date'].'</option>'; 
                                        }
                                    }else{
                                        echo'<option>Not Registered</option>';
                                    }
                                    ?>

                                </select>

                                <button name="filterButton" class="next btn btn-primary" type="submit">Filter</button>
                            </form>
                        </div>


                        <?php
                        if(isset($_POST['filterButton'])){
                            if ($_POST['year']||$_POST['term']||$_POST['completed']||$_POST['orientationDate']){
                                $popsql = "SELECT * FROM OrientationStudents WHERE";
                                if($_POST['year']){
                                    $popsql .= ' termYear="'.$_POST['year'].'"';
                                    if ($_POST['term']||$_POST['completed']||$_POST['orientationDate']){
                                        $popsql .= ' AND ';
                                    }
                                }
                                if($_POST['term']){
                                    $popsql .= ' semesterTerm="'.$_POST['term'].'"';
                                    if ($_POST['completed']||$_POST['orientationDate']){
                                        $popsql .= ' AND ';
                                    }
                                }
                                if($_POST['completed']){
                                    $popsql .= ' finalized="'.$_POST['completed'].'"';
                                    if ($_POST['orientationDate']){
                                        $popsql .= ' AND ';
                                    }
                                }

                                if($_POST['orientationDate']){
                                    $popsql .= ' orientationDate="'.$_POST['orientationDate'].'"';
                                }

                                $popsql .=";";   //" ORDER BY termYear, semesterTerm;";

//                                echo $popsql.'<br>';
                            }else{
                                $popsql = "SELECT * FROM OrientationStudents ORDER BY termYear, semesterTerm;";
                            }
                        }
                        ?>




                        <p></p>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Term</th>
                                    <th>Year</th>
                                    <th>Submission Status</th>
                                    <th>Campus</th>
                                    <th>Orientation Date</th>
                                    <th>Paid</th>
                                    <th>zNumber</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!$popsql){

                                    $popsql = "SELECT * FROM OrientationStudents ORDER BY termYear, semesterTerm;";
                                }
                                $popquery = mysqli_query($db, $popsql);
                                if($popquery){
                                    $rowcount = mysqli_num_rows($popquery);
                                    if ($rowcount>0){
                                        echo $rowcount . " student(s) found";
                                        while($poprow = mysqli_fetch_assoc($popquery)){
                                            echo'<tr>';
                                            echo'<td>'.$poprow['firstname'].'</td>';
                                            echo'<td>'.$poprow['lastname'].'</td>';
                                            echo'<td>'.$poprow['studentcode'].'</td>';
                                            echo'<td>'.$poprow['nonFAUemail'].'</td>';
                                            echo'<td>'.$poprow['semesterTerm'].'</td>';
                                            echo'<td>'.$poprow['termYear'].'</td>';
                                            echo'<td>'.$poprow['finalized'].'</td>';
                                            echo'<td>'.$poprow['Campus'].'</td>';
                                            $orientationsql = "SELECT * FROM orientationDates WHERE id='".$poprow['orientationDate']."';";
                                            $orientationquery = mysqli_query($db,$orientationsql);
                                            if (mysqli_num_rows($orientationquery)>0){
                                                $date = mysqli_fetch_assoc($orientationquery);
                                                echo'<td>'.$date['date'].'</td>';
                                            }else{
                                                echo'<td>Not Registered</td>';
                                            }
                                            echo'<td>'.$poprow['paid'].'</td>';
                                            echo'<td>'.$poprow['zNumber'].'</td>';
                                            echo '</tr>';
                                        }
                                    }else{
                                        echo "No Students Found!";
                                    }
                                } 
                                else {
                                    echo "NOOOOOO".mysqli_error($db);
                                }
                                ?>
                            </tbody>
                        </table>
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

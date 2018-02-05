<?php
    require_once("../includes/db.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
                    <a href="admin_setorientationdate.php">Set Orientation Date</a>
                </li>
                 <li>
                    <a href="admin_viewquestionnaire.php">View Questionnaire</a>
                </li>
                 <li>
                    <a href="admin_edit_questionnaire.php">Edit Questionnaire</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->


        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>Set Orientation Date</h1>
                <br>
                <br>

                <?php
                    if(isset($_POST['dateSub'])){
                        if($_POST['orientationDate']&&$_POST['fauCampus']&&$_POST['orientationType']){
                            $datearr = explode('-',$_POST['orientationDate']);//explode the date and assign each piece to a variable
                            $year =  $datearr[0];
                            $monthNum = $datearr[1];
                            $day =   $datearr[2];
                            
                            if($_POST['capacity']){ //if capacity declared, use it. otherwise default to 50
                                $capacity = $_POST['capacity'];
                            }else{
                                $capacity = 50;
                            }
                            
                            if($monthNum<5){ //determine the term
                                $term = "Spring";
                            }elseif ($monthNum>=5 && $monthNum<8){
                                $term = "Summer";
                            }else{
                                $term = "Fall";
                            }
                            
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum); //convert month number to full name
                            $monthName = $dateObj->format('F'); 
                            $datestr = $monthName." ".$day.", ".$year;
                        
                            //echo $_POST['orientationType'][0];
                            $insertsql = "INSERT INTO orientationDates (date, term, year, campus, orientationType,capacity) VALUES(";
                            $insertsql .= "'".$datestr."','".$term."','".$year."','".$_POST['fauCampus']."','".$_POST['orientationType'][0]."','".$capacity."');";//construct sql query
                            //echo '<h1>'.$insertsql.'</h1>';
                            $insertquery = mysqli_query($db,$insertsql);
                            if($insertquery){//insert into db
                                echo"Date successfully submitted";
                            }else{
                                echo 'ERROR'.mysqli_error($db);
                            }
                        }
                    }else{ //if not all fields set
                        echo "All Fields Mandatory";
                    }
                ?>
                                                
                <form name="dateform" method="post">
                <h3>Campus:</h3>
                         <select size="1" class="form-control" name="fauCampus">
                        <option value="BocaRaton">Boca Raton</option>
                        <option value="Jupiter">Jupiter</option>
                        <option value="Davie">Davie</option>
                        <option value="FortLauderdale">Fort Lauderdale</option>
                    </select>  
                    <br>
                   <h3>Date:</h3>
                      <input class="form-control" type="date" name="orientationDate">
                <br>    
                <h3> Select Student Type:</h3>
                <br>    
                <div class="row">
                    <div class="col-sm-3"><input class="checkbox_style" type="checkbox" name="orientationType[]" value="J"><span class="label_text">Transfers Inside Florida</span><br></div>
                <div class="col-sm-3"><input class="checkbox_style" type="checkbox" name="orientationType[]" value="U"><span class="label_text">Transfers Outside Florida</span><br></div>
                    <div class="col-sm-3"><input class="checkbox_style" type="checkbox" name="orientationType[]" value="B"><span class="label_text">FTIC Beginners</span><br></div>
                <div class="col-sm-3"><input class="checkbox_style" type="checkbox" name="orientationType[]" value="E"><span clas="label_text">FTIC Early Admits</span><br></div>
                </div>    
                <br>         
                <h3>Capacity:</h3>
                <input size="1" class = "form-control"type="text" name="capacity" placeholder="specify capacity...">       
                <br>    
                 <input type="submit" name='dateSub'>      
                </form>
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

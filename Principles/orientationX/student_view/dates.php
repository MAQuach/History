<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
    //connection noted as $db
    require_once("../includes/db.php");
    $testid =  $_SESSION['id'];
    $sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
    $studentquery = mysqli_query($db,$sql);
    $student = mysqli_fetch_assoc($studentquery);
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=800" /> 
        <title>dates</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
        <script src="js/studentView.js"></script>
    </head>
<body>
	
	
	<?php
        $datesql = "SELECT * FROM orientationDates;";
        $pop = mysqli_query($db,$datesql);
        if (mysqli_num_rows($pop) > 0){
          while($row = mysqli_fetch_assoc($pop)){
              
             $studenttypearr = array_filter(explode(',',$row['orientationType'])); 
              if ( ! isset($studenttypearr[1])) {
                   $studenttypearr[1] = null;
                }
                if ($studenttypearr[0] == 'B' && $studenttypearr[1] == 'J') {
                    $output = ' Freshman & Transfer';
                } elseif ($studenttypearr[0] == 'J') {
                    $output = ' Transfer';
                } else {
                    $output = ' Freshman';
                }

              
            echo '<div id="'.$row["id"].'">';
                echo '<p>Type: '.$row['campus'].$output.' Orientation</p>';
                echo '<p> Time: '.$row['start'].' - '.$row['end'].'</p>';        
                echo '<p>Capacity: '.$row['registered'].'/'.$row['capacity'].'</p>';
            echo '</tr>';
            echo'</div>';
           }
        }
    ?>
	
	
<!--
	<div id="date1">
	    <p> Type:<span>Boca Transfer Orientation</span></p>
                            
        <p> Time:<span>8:00 AM </span> - <span>5:00 PM</span></p>
                            
        <p> Capacity:<span>124</span>/<span>200</span></p>
                            
                            
        
	</div>
	<div id="date2">
        <p> Type:<span>Davey Transfer Orientation</span></p>
                            
        <p> Time:<span>8:00 AM </span> - <span>5:00 PM</span></p>
                            
        <p> Capacity:<span>100</span>/<span>100</span></p>
	</div>
    
	<div id="date3">
    <p> Type:<span>Jupiter Transfer Orientation</span></p>
                            
    <p> Time:<span>12:00 AM </span> - <span>5:00 PM</span></p>
                            
    <p> Capacity:<span>78</span>/<span>100</span></p>
        
	</div>
-->
	
</body>
</html>
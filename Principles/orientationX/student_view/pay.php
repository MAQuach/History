<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
//connection noted as $db
require_once("../includes/db.php");
$testid =  $_SESSION['id'];

?>
<?php    
    $sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
    $studentquery = mysqli_query($db,$sql);
    $student=mysqli_fetch_assoc($studentquery);
    if($student){
            echo "<span id='semester'>".$student['semesterTerm']." ".$student['termYear']."</span>";
    }else{
        echo"Unable to Retreive from Database";
    }
?>


<!DOCTYPE html>
<html>
<head>
    
</head>

<body>
   <?php
        if(isset($_POST['PaymentSubmission'])){
            $paysql = "UPDATE OrientationStudents SET paid='yes' WHERE ID='".$student['ID']."';"; 
            $payquery = mysqli_query($db, $paysql);
            if($payquery){
                echo "Submitted Successfully";
                header("Location: pay_TouchNet.php"); /* Redirect browser */
                exit();
            }else{
                echo"ERROR".mysqli_error($db);
            }
        }
        
   ?>
   
   
   
   
    <div>
        <form name="paymentsub" method="post">
        <h1>IF WE KNEW WHAT TOUCHNET WAS THIS IS WHERE YOU WOULD PAY. INSTEAD, HIT THE BUTTON TO SIMULATE PAYMENT.</h1>
            <br><br>
        <button name="PaymentSubmission" type="submit" value="SUBMITTED">Submit Payment</button>
        </form>
    </div>
</body>
</html>
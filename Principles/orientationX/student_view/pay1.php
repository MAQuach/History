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
    echo"Unable to Retrieve from Database";
}
?>


<?php
if(isset($_POST['PaymentSubmission'])){
    $paysql = "UPDATE OrientationStudents SET paid='yes' WHERE ID='".$student['ID']."';"; 
    $payquery = mysqli_query($db, $paysql);
    if($payquery){
        echo "Submitted successfully";
        header("Location: pay_TouchNet.php"); /* Redirect browser */
        exit();
    }else{
        echo"ERROR: ".mysqli_error($db);
    }
}

?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>"TouchNet"</title>

        <!-- Bootstrap core CSS -->
        <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="offcanvas.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>


    <body>


        <div class="container">

            <div class="row row-offcanvas row-offcanvas-right">

                <div class="col-xs-12">
                    <p class="pull-right visible-xs">
                        <img src="http://www.shsu.edu/dept/it@sam/technology-tutorials/images/touchnet/touchnet%20logo.jpg" width="300px" height="100px" align="middle">
                    </p>

                    *THIS IS A TESTING PAGE FOR DEMO PURPOSES IF TOUCHNET WAS CONNECTED...*


                    <div class="row">
                        <div class = "col-md-6">
                            <div class="jumbotron">
                                <div class="well col-xs-10 ">
                                    <div class="row">
                                        <div style="text-align:center">
                                            <p>
                                                <em>Date: December 6, 2017</em>
                                            </p>
                                            <p>
                                                <em>Receipt #: 34522677W</em>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="text-center">
                                            <h1>Receipt</h1>
                                        </div>
                                        <table class="table table-hover">
                                            <thead>

                                                <tr>
                                                    <th>Product</th>
                                                    <th>#</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="col-md-9"><em>Orientation</em></td>
                                                    <td class="col-md-1" style="text-align: center"> 1 </td>
                                                    <td class="col-md-1 text-center">$104</td>
                                                    <td class="col-md-1 text-center">$104</td>

                                                </tr>



                                                <tr>
                                                    <td>   </td>
                                                    <td>   </td>
                                                    <td class="text-right">
                                                        <p>
                                                            <strong>Subtotal: </strong>
                                                        </p>
                                                        <p>
                                                            <strong>Tax: </strong>
                                                        </p></td>
                                                    <td class="text-center">
                                                        <p>
                                                            <strong>$104.00</strong>
                                                        </p>
                                                        <p>
                                                            <strong>$0</strong>
                                                        </p></td>
                                                </tr>
                                                <tr>
                                                    <td>   </td>
                                                    <td>   </td>
                                                    <td class="text-right"><h4><strong>Total: </strong></h4></td>
                                                    <td class="text-center text-danger"><h4><strong>$104.00</strong></h4></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class = "col-md-6">
                            <div class="jumbotron">
                                <div class="panel panel-default credit-card-box">
                                    <div class="panel-heading display-table" >
                                        <div class="row display-tr" >
                                            <h3 class="panel-title display-td" >Payment Details</h3>
                                            <div class="display-td" >                            
                                                <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                            </div>
                                        </div>                    
                                    </div>
                                    <div class="panel-body">
                                        <form role="form" id="payment-form" method="POST" action="javascript:void(0);">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="form-group">
                                                        <label for="cardNumber">CARD NUMBER</label>
                                                        <div class="input-group">
                                                            <input 
                                                                   type="tel"
                                                                   class="form-control"
                                                                   name="cardNumber"
                                                                   placeholder="Valid Card Number"
                                                                   autocomplete="cc-number"
                                                                   required autofocus 
                                                                   />
                                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                                        </div>
                                                    </div>                            
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-7 col-md-7">
                                                    <div class="form-group">
                                                        <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
                                                        <input 
                                                               type="tel" 
                                                               class="form-control" 
                                                               name="cardExpiry"
                                                               placeholder="MM / YY"
                                                               autocomplete="cc-exp"
                                                               required 
                                                               />
                                                    </div>
                                                </div>
                                                <div class="col-xs-5 col-md-5 pull-right">
                                                    <div class="form-group">
                                                        <label for="cardCVC">CV CODE</label>
                                                        <input 
                                                               type="tel" 
                                                               class="form-control"
                                                               name="cardCVC"
                                                               placeholder="CVC"
                                                               autocomplete="cc-csc"
                                                               required
                                                               />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none;">
                                                <div class="col-xs-12">
                                                    <p class="payment-errors"></p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>            


                            </div>

                            <div>





                                <form name="paymentsub" method="post">
                                    <button name="PaymentSubmission" type="submit" value="SUBMITTED">Submit Payment</button>
                                </form>
                            </div>

                            <img class="logo_student_view" src="images/student_view_logo.svg" width="300px" style="float:right">

                        </div>
                    </div>



                </div><!--/.col-xs-12.col-sm-9-->

            </div><!--/row-->

            <hr>


        </div><!--/.container-->


        <!-- Bootstrap core JavaScript
================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
        <script src="offcanvas.js"></script>
    </body>
</html>

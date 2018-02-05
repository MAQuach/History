
<?php
session_start();
if(!isset($_SESSION['id'])){ //if login in session is not set
    header("Location: ../index.php");
}
//connection noted as $db
require_once("../includes/db.php");
$testid = $_SESSION['id'];
$sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
$studentquery = mysqli_query($db,$sql);
$student = mysqli_fetch_assoc($studentquery);

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=800" /> 
        <title>Questionnaire</title>    
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
        <script src="js/studentView.js"></script>
    </head>





    <body id="student_view_body">
        <header class="student_header">

            <h2 class="term">


            <?php    
                if($student){ //if student is loaded, display term and year
                    echo "<span id='semester'>".$student['semesterTerm']." ".$student['termYear']."</span>";
                }else{
                    echo"Unable to Retreive from Database";
                }
            ?>


                <br><span>Orientation Registration</span></h2>
            <img class="logo_student_view" src="images/student_view_logo.svg">
            
            
            <div class="button_panel">
            <a id="helpBtn" href="https://helpdesk.fau.edu/TDClient/Home/" target="_blank">Help Desk</a>
                <!--JB: IF STUDENT CHOOSES TO LOGOUT THEIR INFOMATION WILL BE SAVED AND BE REDIRECTED TO LOGOUT PAGE TO GIVE CHECKLIST OF THINGS NEED TO DO AND DEADLINE -->
            <a href="logout_student.php" class="logout">Logout</a>
            </div>
        </header>  

        <div class="student_container">

            <br><br><br><br><br><br><br>


            <!--            <form id="msform" action="orientation_Date.php"method="post">-->
            <form id="msform"method="post">


                <div id="name">
                    <!--JB: SHOWS NAME OF WHICH EVER STUDENT IS LOGGED IN-->
                    <h2>Welcome <?php    
                        $sql = "SELECT * FROM OrientationStudents WHERE id='".$testid."';";  //$_SESSION['id']."';";
                        $studentquery = mysqli_query($db,$sql);
                        $student=mysqli_fetch_assoc($studentquery);
                        if($student){
                            if ($student){
                                echo "<span id='name'>".$student['firstname']." ".$student['lastname'];
                            }
                        }else{
                            echo"Unable to Retreive from Database";
                        }
                        ?>!</h2>

                </div>

                <br>        

                <!-- progressbar -->
                <div class="progressFormatting">
                    <ul id="progressbar">
                        <li class="active">Personal Info</li>
                        <li class="active">Questionnaire</li>
                        <li>Orientation Date</li>
                        <li>Finalize</li>
                        <li>Pay</li>
                        <li>Confirmation</li>
                    </ul>
                </div>
                <!-- fieldsets -->
                <fieldset>
                    <br>
                    <br>
                    <h2 class="fs-title">Questionnaire</h2>
                    <h3 class="fs-subtitle">Please fill out all questions</h3>

                    <!--JOE: POPULATING THE ANSWERS INTO THE DATATABLES - IF ANSWERS ARE NOT THERE INSERT AND IF THEY ARE THEN UPDATE DATATABLE-->
                    <?php
                    if (isset($_POST["submitQuestionaire"]))
                    {
                        $count = sizeof($_POST['responses']); // first check to see if this form has been previously submitted
                        $rowcountsql = "SELECT * FROM QuestionnaireAnswers WHERE ID='".$student['zNumber']."';";
                        $rowcheck = mysqli_query($db,$rowcountsql);
                        $numrows = mysqli_num_rows($rowcheck);
                        //echo '<h1>'.$count.'</h1>';    

                        if($numrows == 0)//if no, insert into table
                        { //construct sql query
                            $subsql = "INSERT INTO QuestionnaireAnswers (";//;Ques1,Ques2,Ques3,Ques4,Ques5,Ques6,ID) VALUES (";
                            for ($j=0; $j<$count ;$j++){
                                $subsql .= "Ques".($j+1);
                                $subsql .= ",";
                            }
                            $subsql.= "ID) VALUES (";
                            for ($i=0; $i<$count ;$i++){
                                //print_r($_POST['responses']);
                                $subsql .= '"'.$_POST['responses'][$i].'"';
                                $subsql .= ",";
                            }
                            $subsql .= '"'. $student['zNumber'].'");';
                            //echo $subsql;
                            $query = mysqli_query($db,$subsql);
                        }
                        
                        
                        else //if yes, upate
                        {   //construct sql query
                            $editsql = 'UPDATE QuestionnaireAnswers SET ';
                            for ($i=0; $i<$count ;$i++){
                                $editsql .= 'Ques'.($i+1).'="'.$_POST['responses'][$i].'"';
                                if ($i != $count-1){
                                    $editsql.=',';
                                }
                            }
                            $editsql .= 'WHERE ID='.$student['zNumber'].';';
                            $query = mysqli_query($db,$editsql);
                        }


                        if ($query){ //check status of mysqli query
                            echo "Submitted Successfully";
                        }else{
                            echo"Error Submitting".mysqli_error($db);
                        }
                    }
                    ?>


                    <!--                    <h2>Autopopulated Questions</h2>-->

                    <?php
                    $questsql = "SELECT * FROM questions;"; //retreive all questions from table
                    $popQuery = mysqli_query($db,$questsql);
                    $rowcheck = mysqli_num_rows($popQuery);
                    if($rowcheck>0){
                        echo '<form name="questionaire" method="post">';//build form
                        while($row = mysqli_fetch_assoc($popQuery)){
                            echo '<div id="questionBlock">';
                            echo '<p>'.$row['questionText'].'</p>';
                            echo '</div>';
                            echo '<div id="AnswerBlock">'; //print question, and provide appropriate html based on 
                            //on the question's response type (R = radiobutton, T=text)
                            //print_r($row);
                            if ($row['inputType'] == 'R'){
                                $arrayId = $row['id'] - 1;
                                echo '<input type="radio" name=responses['. $arrayId .'] id="Q'.$row['id'].'" value="Yes"> Yes';
                                echo'&nbsp; &nbsp;';
                                echo '<input type="radio" name=responses['. $arrayId.'] id="Q'.$row['id'].'" value="No"> No';    
                            }else if($row['inputType'] == 'T'){
                                $arrayId = $row['id']- 1;
                                echo '<input type="text" name=responses['. $arrayId .'] id="Q'.$row['id'].'">';
                            }
                            echo '</div>';
                            echo'</br></br>';
                        }
                        echo '<button class="submit-button" type="submit" name="submitQuestionaire">Save</button>';    
                    }else{
                        echo"No questions found!";
                    }
                    ?>

                    <!--
<h2>Non Autopop</h2>
<div id="questionBlock">
<p>Are you a current member of the US Military or a US Military Veteran?</p>

<div id="AnswerBlock">   
<span>Yes</span> <input id="milVetYes" type="radio"  name="milVetFieldOne" value="yes">
&nbsp;
&nbsp;
<span>No</span> <input id="milvetNo"  type="radio" name="milvetFieldTwo"  value="no" >
</div>
<br>
<br>  
</div>
<div id="questionBlock">
<p>Are you dependant recieving VA Benefits?</p>

<div id="AnswerBlock">   
<span>Yes</span> <input id="vaBenefitsYes" type="radio" name="vaBenefitsFieldOne"  value="yes">
&nbsp;
&nbsp;
<span>No</span> <input id="vaBenefitsNo" type="radio" name="vaBenefitsFieldTwo"  value="no">
</div>
</div>    
<br>
<br>   

<div id="questionBlock">
<p>Would you like to be contacted regarding information on leadership oppurtunities?</p>

<div id="AnswerBlock">   
<span>Yes</span> <input id="leadershipYes" type="radio" name="leadershipFieldOne" value="yes">
&nbsp;
&nbsp;
<span>No</span> <input id="leadershipNo" type="radio" name="leadershipFieldTwo" value="no">
</div>
</div>    
<br>
<br>   

<div id="questionBlock">
<p>Would you like to be contacted regarding regarding one of Fau's spiritual or faith based organizations?</p>

<div id="AnswerBlock">   
<span>Yes</span> <input id="faithYes" type="radio" name="faithFieldOne"  value="yes">
&nbsp;
&nbsp;
<span>No</span> <input id="faithNo" type="radio" name="faithFieldTwo"  value="no">
</div>
</div>    
<br>
<br> 


<div id="questionBlock">
<p>Would you be interested in the Student Alumni Association?</p>


<div id="AnswerBlock">   
<span>Yes</span> <input id="alumniYes" type="radio" name="alumniFieldOne"  value="yes">
&nbsp;
&nbsp;
<span>No</span> <input id="alumniNo" type="radio" name="alumniFieldTwo"  value="no" >
</div>
</div>    
<br>
<br>  


<div id="questionBlock">
<p>Would you lke the join the Owl parents Association?</p>


<div id="AnswerBlock">   
<span>Yes</span> <input id="owlParentYes" type="radio" name="owlParentFieldOne"  value="yes" >
&nbsp;
&nbsp;
<span>No</span> <input id="owlParentNo"  type="radio" name="owlParentFieldTwo" value="no">
</div>
</div>    
-->

                                       <!--JB: THIS MAKES SURE THE USER IS NOT ALLOWED TO MOVE ON TO THE NEXT PAGE (ORIENTATION_DATE.PHP) UNTIL THEY ANSWER QUESTIONS-->
                    <?php
                    if (isset($_POST["submitQuestionaire"]))
                    {
                        // first check to see if this form has been previously submitted
                        $count = sizeof($_POST['responses']); 
                        $rowcountsql = "SELECT * FROM QuestionnaireAnswers WHERE ID='".$student['zNumber']."';";
                        $rowcheck = mysqli_query($db,$rowcountsql);
                        $numrows = mysqli_num_rows($rowcheck);

                        //JB: if not previous submitted do not show next button
                        if($numrows == 0){
                            echo '<input type="button" id="nextButton2" class="next" value="Next" disabled="true">';
                        }

                        //JB: if yes show next button
                        else {   
                            echo '<input type="button" id="nextButton2" class="next" value="Next">'; 
                        }

                    }
                    ?>

                    
                    <a href="personal_info.php" class="previous">Previous</a>
                    <!--<a href="orientation_Date.php" class="next">Next</a>-->
                    



                </fieldset>   

                <br><br>

            </form>
        </div>   
    </body>       
</html>
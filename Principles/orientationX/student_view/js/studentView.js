$(document).ready(function(){


    //JB: alert student that their campus selection is saved on submit buttons
    $(".submit-button").click(function(){
        alert("Selection saved.");

    });


    //JB: edit button clicked to edit campus on finalize.php
    //    $('#editCampus').click(function(){
    //        $('#choseCampus').css('display','block');
    //    });

});

window.onload = function() {

    document.getElementById("nextButton1").onclick = function () {
        window.location.href = "questionnare.php";
    };

    document.getElementById("nextButton2").onclick = function () {
        window.location.href = "orientation_Date.php";
    };

    document.getElementById("nextButton3").onclick = function () {
        window.location.href = "finalize.php";
    };


    function showNext() {
        document.getElementById('FinalizeNext').style.display = "block";
    }

}


$(document).ready(function(){
	$("#cancel_register_button").on("click", function(){
        window.location.replace("index.php");
    });

    $("#register_button_consumer").on("click", function(){
        var $firstName = $("#firstName");
        var $lastName = $("#lastName");
        var $newUserName = $("#newusername")
        var $email = $("#email");
        var $p1 = $("#p1");
        var $p2 = $("#p2");
        var $country = $("#country");
        var $gender = 0;

        if ($firstName.val() == "" || $lastName.val() == "" || $newUserName.val() == "" 
            || $email.val() == "" || $p1.val() == "" || $p2.val() == ""  || $country.val() == 0 
            || (!(($("#g1").is(":checked") || $("#g2").is(":checked"))))) {

            alert("Please add the information needed");
        }
        else {
            if ($p1.val() != $p2.val()){
                $("#errorLabelPasswordConfirmationMatch").text("Your passwords do not match");
            }
            else{
                $("#errorLabelPasswordConfirmationMatch").text("");
                if ($("#g1").is(":checked")) {
                    $gender = "male";
                } 
                else {
                    $gender = "female";
                }

                var jsonObject = {
                    "action" : "REGISTER",
                    "userFirstName" :  $("#firstName").val(),
                    "userLastName" : $("#lastName").val(),
                    "username" : $("#newusername").val(),
                    "userEmail" : $("#email").val(),
                    "userPassword1" : $("#p1").val(),
                    "userPassword2" : $("#p2").val(),
                    "userCountry" : $("#country").val(),
                    "userGender" : $gender
                };     
                $.ajax({
                    url : "data/applicationLayer.php",
                    type : "POST" , 
                    data : jsonObject , 
                    dataType : "json" , 
                    contentType : "application/x-www-form-urlencoded",
                    success : function(jsonResponse) {
                        alert(jsonResponse.message);
                        window.location.replace("home.php");
                    },
                    error : function(errorMessage){
                        alert(errorMessage.responseText);
                    }
                });
            }
        }
    });  
   
})
$(document).ready(function(){

    activeSession(); // Redirect to homepage if the session is active

    $("#password").keyup(function(event){
    	if(event.keyCode == 13){
    		$("#loginButton").click();
    	}
    });

    $("#userName").keyup(function(event){
    	if(event.keyCode == 13){
    		$("#loginButton").click();
    	}
    });

    $("#loginButton").on("click", function(){
    	var $userName = $("#userName");
    	var $password = $("#password");
    	if ($userName.val() == "" || $password.val() == "" || (!(($("#t1").is(":checked") || $("#t2").is(":checked"))))){
    		alert("Please insert username and password");
    	}
    	else {
    		if ($("#t1").is(":checked")) {
    			$typeuser = "consumer";
    		} 
    		else {
    			$typeuser = "manager";
    		}
    		var jsonToSend = {
    			"action" : "LOGIN",
    			"username" : $userName.val(),
    			"userPassword" : $password.val(),
    			"remember" : $("#remember").is(":checked"),
    			"typeUser" : $typeuser
    		};
    		//console.log(jsonToSend);
    		$.ajax({
    			url : "data/applicationLayer.php",
    			type : "POST",
    			data : jsonToSend,
    			dataType : "json",
    			contentType : "application/x-www-form-urlencoded",
    			success : function(jsonResponse){
    				alert(jsonResponse.message);
    				window.location.replace("home.php");
    			},
    			error : function(errorMessage){
    				alert(errorMessage.responseText);
    			}
    		});
    	}
    });

    function activeSession(){
    	var jsonToSend = {
    		"action" : "ACTIVESESSION"
    	};

    	$.ajax({
    		url : "data/applicationLayer.php",
    		type : "POST",
    		data : jsonToSend,
    		dataType : "json",
    		contentType : "application/x-www-form-urlencoded",
    		success : function(jsonResponse){
    			window.location.replace("home.php");
    		},
    		error : function(errorMessage){
                //
            }
        });
    }
});
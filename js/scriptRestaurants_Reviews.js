$(document).ready(function(){
    var jsonToSend ={
        "action" : "GETUSERREVIEWS"
    };

    alert("Hello");

    // $.ajax({
    //     url : "data/applicationLayer.php",
    //     type : "POST",
    //     //data : jsonToSend,
    //     dataType : "json",
    //     contentType : "application/x-www-form-urlencoded",
    //     success : function(jsonResponse){
    //         alert("HELLO");
    //         // for(var i = 0; i < jsonResponse.length; i++)
    //         // {
    //         //     $("#customersReviewsBody").append(
    //         //         '<tr> <td>' + jsonResponse[i].username + '</td> <td>' + jsonResponse[i].review + '</td> <td>' + jsonResponse[i].rating + '</td> </tr>');
    //         // }
    //     },
    //     error : function(errorMessage){
    //         alert(errorMessage.responseText);
    //         // if(errorMessage.responseText == 'Expired Session')
    //         // {
    //         //     window.location.replace("index.php");
    //         // }
    //     }

    // });

    // function phpCall()
    // {
    //     var jsonObject = {
    //         "action" : "INSRTUSERREVIEW",
    //         "review" : $("#add_review").val()
    //     };

    //     $.ajax({
    //         url: "data/applicationLayer.php",
    //         type: "POST",
    //         data : jsonObject,
    //         dataType : "json",
    //         contentType : "application/x-www-form-urlencoded",
    //         success: function(jsonData) {
    //             //alert(jsonData.message);
    //             $('#restaurantsReviewsBody tr:last').after('<tr> <td>' + jsonResponse[i].username + 
    //                 '</td> <td>' + jsonResponse[i].review + '</td> <td>' + jsonResponse[i].rating + '</td> </tr>');
    //         },
    //         error: function(errorMsg){
    //             alert(errorMsg.statusText);
    //         }
    //     });

    //     $("#add_review").val("");
    // }

    // $("#btn_send_review").on("click", function(){
    //     var review = $("#add_review").val();

    //     if(review != "")
    //     {
    //         phpCall();
    //     }
    // });

});

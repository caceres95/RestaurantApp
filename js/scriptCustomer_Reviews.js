$(document).ready(function(){
    var jsonToSend ={
        "action" : "GETCUSTOMERSREVIEWS"
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

});


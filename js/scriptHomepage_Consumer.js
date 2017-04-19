$(document).ready(function(){
	
	var jsonToSend = {
		"action" : "LOADRESTAURANTS"
	};
	$.ajax({
		url : "data/applicationLayer.php",
		type : "POST",
		data : jsonToSend, 
		dataType : "json",
		contentType : "application/x-www-form-urlencoded",
		success: function(jsonResponse){			
			var newHtml = "";
			for (var i = 0; i < jsonResponse.length; i++){
				newHtml += '<tr> <td> <th><input type="checkbox" id="check-all" class="flat"></th></td><td>';
				var name = jsonResponse[i].username;
				var rating = jsonResponse[i].comment;
				var location = jsonResponse[i].comment;
				var availability = jsonResponse[i].comment;
				var page = jsonResponse[i].comment;
				newHtml += '<td>' + name + '</td><td>' + rating + '</td><td>' 
					+ location + '</td><td>' + availability + '</td><td>' + page + '</td><td>';
				newHtml += "</tr>";
			}
			$("#datatable-checkbox").append(newHtml);
		},
		error: function(errorMessage){
			alert(errorMessage.responseText);
			window.location.replace("index.php");
		}
	});

});

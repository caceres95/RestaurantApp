<?php

header('Content-type: application/json');
require_once __DIR__ . '/dataLayer.php';

$action = $_POST["action"];

switch($action){
	case "LOGIN" : loginFunction();
		break;
	case "REGISTERCONSUMER" : registerConsumerFunction();
		break;
	case "REGISTERRESTAURANT" : registerRestaurantFunction();
		break;
	case "ACTIVESESSION" : activeSessionFunction();
		break;
	case "ENDSESSION" : endSessionFunction();
		break;
	case "LOADRESTAURANTS" : loadRestaurantsFunction();
		break;
	
}

function loginFunction(){

	$userName = $_POST['username'];
	$userPassword = $_POST['userPassword'];
	$typeUser = $_POST['typeUser'];

	$result = attemptLogin($userName, $userPassword, $typeUser);

	if ($result["status"] == "SUCCESS"){
		$remember = $_POST["remember"];

		if($remember == "true"){
			setcookie("user", "$userName", time() + (86400 * 30), "/", "", 0);
		}

		session_start();
		$_SESSION['user'] = $userName;
		$_SESSION['loginTime'] = time();
		$_SESSION['typeUser'] = $typeUser;

		echo json_encode(array("message" => $typeUser));
	}	
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}	
}

function registerConsumerFunction(){

	$userName = $_POST['username'];
	$typeUser = $_POST['typeUser'];

	$result = attemptValidateUser($userName, $typeUser);

	if ($result["status"] == "SUCCESS"){

		session_start();
		$_SESSION['user'] = $userName;
		$_SESSION['loginTime'] = time();
		$_SESSION['typeUser'] = $typeUser;

		$userPassword = $_POST['userPassword1'];
		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];
		$userEmail = $_POST['userEmail'];
		$userCountry= $_POST['userCountry'];
		$userGender= $_POST['userGender'];
		$userBDay = $_POST['day'];
		$userBMonth = $_POST['month'];
		$userBYear = $_POST['year'];

		$completeResult = attemptRegisterConsumer($userName, $userPassword, $userFirstName, $userLastName, $userEmail, $userCountry, $userGender, $userBDay, $userBMonth, $userBYear);

		if ($completeResult["status"] == "SUCCESS"){
			echo json_encode(array("message" => "New record created successfully!")); 

		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($completeResult["status"]);
		}
	}
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
}

function registerRestaurantFunction(){

	$userName = $_POST['newUsernameRestaurant'];
	$typeUser = $_POST['typeUser'];

	$result = attemptValidateUser($userName, $typeUser);

	if ($result["status"] == "SUCCESS"){

		session_start();
		$_SESSION['user'] = $userName;
		$_SESSION['loginTime'] = time();
		$_SESSION['typeUser'] = $typeUser;

		$RestaurantName = $_POST["RestaurantName"];
		$newUsernameRestaurant = $_POST["newUsernameRestaurant"];
		$email = $_POST["RestaurantEmail"];
		$restaurantAddress = $_POST["restaurantAddress"];
		$RestaurantPassword = $_POST["RestaurantPassword1"];
		$restaurantPhone = $_POST["restaurantPhone"];
		$restaurantWebpage = $_POST["restaurantWebpage"];
		$openHour = $_POST["openHour"];
		$openMin = $_POST["openMin"];
		$closeHour  = $_POST["closeHour"];
		$closeMin = $_POST["closeMin"];
		$securityKey = $_POST["securityKey"];
		$maxCapacity = $_POST["maxCapacity"];

		$completeResult = attemptRegisterRestaurant($userName, $RestaurantName, $newUsernameRestaurant, $email, $restaurantAddress, $RestaurantPassword, $restaurantPhone, $restaurantWebpage, $openHour, $openMin, $closeHour, $closeMin, $securityKey, $maxCapacity);

		if ($completeResult["status"] == "SUCCESS"){
			echo json_encode(array("message" => "New record created successfully!")); 

		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($completeResult["status"]);
		}
	}
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);
	}
}

function activeSessionFunction(){

	session_start();

	if(isset($_SESSION['user']) && $_SESSION['typeUser'] == "consumer"  && time() - $_SESSION['loginTime'] < 1800){ 
		echo json_encode(array("message" => "consumer"));
	}
	elseif(isset($_SESSION['user']) && $_SESSION['typeUser'] == "manager" && time() - $_SESSION['loginTime'] < 1800){ 
		echo json_encode(array("message" => "manager"));
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}
}

function endSessionFunction(){

	session_start();
	
	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 
		session_unset();
		session_destroy();
		echo json_encode(array("message" => "End Session"));
	}
	else {
		header('HTTP/1.1 410 Something went wrong');
		die("Something went wrong");
	}

}

function loadRestaurantsFunction(){
	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$result = attemptGetRestaurants();

		if ($result["status"] == "SUCCESS"){
			echo json_encode($result["arrayRestaurants"]);
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}

/*
function getCommentsFunction(){

	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$result = attemptGetComments();

		if ($result["status"] == "SUCCESS"){
			echo json_encode($result["arrayCommentsBox"]);
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}
}

function addCommentFunction(){

	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];
		$comment = $_POST['comment'];

		$result = attemptAddComments($username, $comment);

		if ($result["status"] == "SUCCESS"){
			echo json_encode(array("comment" => $comment, "username" => $username, "message" => "Comment added succesfully!"));
		}	
		else{
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}
}

function loadProfileFunction(){

	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];

		$result = attemptLoadProfile($username);

		if ($result["status"] == "SUCCESS"){
			echo json_encode($result["profileData"]);
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}

function activeSessionFunction(){

	session_start();

	if(isset($_SESSION['user']) && $_SESSION['typeUser'] == "consumer"  && time() - $_SESSION['loginTime'] < 1800){ 
		echo json_encode(array("message" => "Consumer"));
	}
	elseif(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 
		echo json_encode(array("message" => "Manager"));
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}
}

function endSessionFunction(){

	session_start();
	
	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 
		session_unset();
		session_destroy();
		echo json_encode(array("message" => "End Session"));
	}
	else {
		header('HTTP/1.1 410 Something went wrong');
		die("Something went wrong");
	}

}

function getFriendsFunction(){
	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];

		$result = attemptGetFriends($username);

		if ($result["status"] == "SUCCESS"){
			echo json_encode($result["arrayFriendsList"]);
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}
}

function searchUsersFunction(){
	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];
		$searchBox = $_COOKIE['search'];

		$result = attemptSearchUsers($username, $searchBox);

		if ($result["status"] == "SUCCESS"){
			echo json_encode($result["arrayUsersList"]);
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}

function createSearchCookie(){
	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$searchBox = $_POST['searchUser'];

		setcookie("search", "$searchBox", time() + 20, "/", "",0);
		echo json_encode(array("message" => "SUCCESS"));
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}

function getFriendsRequestFunction(){
	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];

		$result = attemptGetFriendsRequests($username);

		if ($result["status"] == "SUCCESS"){
			echo json_encode($result["arrayFriendsList"]);
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}

function acceptFriendsRequestFunction(){
	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];
		$newFriendUsername = $_POST['username'];

		$result = attemptAcceptFriends($username, $newFriendUsername);

		if ($result["status"] == "SUCCESS"){
			echo json_encode(array("message" => "FRIEND ADDED"));
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}

function declineFriendsRequestFunction(){

	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];
		$newUsername = $_POST['username'];

		$result = attemptDeclineFriends($username, $newUsername);

		if ($result["status"] == "SUCCESS"){
			echo json_encode(array("message" => "FRIEND REQUEST DECLINED"));
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}

function addNewFriends(){
	session_start();

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

		$username = $_SESSION['user'];
		$newUsername = $_POST['username'];

		$result = attemptSendFriendRequest($username, $newUsername);

		if ($result["status"] == "SUCCESS"){
			echo json_encode(array("message" => "FRIEND REQUEST SENT"));
		}
		else {
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);
		}
	}
	else {
		header('HTTP/1.1 410 Session has expired');
		die("Session has expired");
	}

}*/




?>
<?php

header('Content-type: application/json');
require_once __DIR__ . '/dataLayer.php';

$action = $_POST["action"];

switch($action){
	case "LOGIN" : loginFunction();
	break;
	case "ADDCOMMENT" : addCommentFunction();
	break;
	case "GETCUSTOMERSREVIEWS" : getCustomerReviewsFunction();
	break;
	case "LOADPROFILE" : loadProfileFunction();
	break;
	case "REGISTER" : registerFunction();
	break;
	case "ACTIVESESSION" : activeSessionFunction();
	break;
	case "ENDSESSION" : endSessionFunction();
	break;
	case "GETFRIENDS" : getFriendsFunction();
	break;
	case "SEARCHCOOKIE" : createSearchCookie();
	break;
	case "SEARCHUSER" : searchUsersFunction();
	break;
	case "GETREQUESTS" : getFriendsRequestFunction();
	break;
	case "ACCEPTREQUESTS" : acceptFriendsRequestFunction();
	break;
	case "DECLINEREQUESTS" : declineFriendsRequestFunction();
	break;
	case "SENDFRIENDREQUEST" : addNewFriends();
	break;
}

function loginFunction(){

	$userName = $_POST['username'];

	$result = attemptVerifyUser($userName);

	if ($result["status"] == "SUCCESS"){
		$decryptedPassword = decryptPassword($result['password']);

		$password = $_POST['userPassword'];

		if ($decryptedPassword === $password){
			$remember = $_POST["remember"];

			if($remember == "true"){
				setcookie("user", "$userName", time() + (86400 * 30), "/", "", 0);
			}

			session_start();
			$_SESSION['user'] = $userName;
			$_SESSION['loginTime'] = time();

			echo json_encode(array("message" => "Login Successful"));
		}
		else{
			header('HTTP/1.1 500' . $result["status"]);
			die($result["status"]);	
		}
	}
	else{
		header('HTTP/1.1 500' . $result["status"]);
		die($result["status"]);	
	}
}

function decryptPassword($password) {
	$key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

	$ciphertext_dec = base64_decode($password);
	$iv_dec = substr($ciphertext_dec, 0, $iv_size);
	$ciphertext_dec = substr($ciphertext_dec, $iv_size);

	$password = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);


	$count = 0;
	$length = strlen($password);

	for ($i = $length - 1; $i >= 0; $i --)
	{
		if (ord($password{$i}) === 0)
		{
			$count ++;
		}
	}

	$password = substr($password, 0,  $length - $count); 

	return $password;
}

function registerFunction(){

	$userName = $_POST['username'];

	$result = attemptValidateUser($userName);

	if ($result["status"] == "SUCCESS"){

		$userFirstName = $_POST['userFirstName'];
		$userLastName = $_POST['userLastName'];
		$userEmail = $_POST['userEmail'];
		$userCountry= $_POST['userCountry'];
		$userGender= $_POST['userGender'];
		$userName = $_POST['username'];

		$userPassword = encryptPassword();

		$completeResult = attemptRegister($userName, $userPassword, $userFirstName, $userLastName, $userEmail, $userCountry, $userGender);

		if ($completeResult["status"] == "SUCCESS"){
			session_start();
			$_SESSION['user'] = $userName;
			$_SESSION['loginTime'] = time();
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

function encryptPassword() {
	$userPassword = $_POST['userPassword1'];

	$key = pack('H*', "bcb04b7e103a05afe34763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	$key_size =  strlen($key);

	$plaintext = $userPassword;

	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

	$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
	$ciphertext = $iv . $ciphertext;

	$userPassword = base64_encode($ciphertext);

	return $userPassword;
}

function getCustomerReviewsFunction(){

	// session_start();

	// if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 

	// 	$result = attemptGetComments();

	// 	if ($result["status"] == "SUCCESS"){
	// 		echo json_encode($result["arrayCommentsBox"]);
	// 	}
	// 	else {
	// 		header('HTTP/1.1 500' . $result["status"]);
	// 		die($result["status"]);
	// 	}
	// }
	// else {
	// 	header('HTTP/1.1 410 Session has expired');
	// 	die("Session has expired");
	// }
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

	if(isset($_SESSION['user']) && time() - $_SESSION['loginTime'] < 1800){ 
		echo json_encode(array("message" => "Session is active"));
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

}




?>
<?php

function connectionToDataBase(){
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "restaurant_app_database";

	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error){
		return null;
	}
	else{
		return $conn;
	}
}

function attemptLogin($userName, $userPassword, $typeUser){

	$conn = connectionToDataBase();

	if ($conn != null){
		if ($typeUser == "consumer") {
			$sql = "SELECT username, passwrd FROM user_information WHERE username = '$userName' AND passwrd = '$userPassword'";

			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$conn -> close();
				return array("status" => "SUCCESS");
			}
			else {
				$conn -> close();
				return array("status" => "WRONG CREDENTIALS!");
			}
		}
		else {
			$sql = "SELECT rUsername, passwrd FROM restaurant_information WHERE rUsername = '$userName' AND passwrd = '$userPassword'";

			$result = $conn->query($sql);

			if ($result->num_rows > 0)
			{
				$conn -> close();
				return array("status" => "SUCCESS");
			}
			else{
				$conn -> close();
				return array("status" => "WRONG CREDENTIALS!");
			}
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}
}

function attemptValidateUser($username, $typeUser){

	$conn = connectionToDataBase();

	if ($conn != null){
		if ($typeUser == "consumer") {
			$sql = "SELECT username FROM user_information WHERE username = '$username'";

			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$conn -> close();
				return array("status" => "USERNAME ALREADY IN USE");
			}
			else{
				$conn -> close();
				return array("status" => "SUCCESS");
			}
		}
		else {
			$sql = "SELECT rUsername FROM restaurant_information WHERE rUsername = '$username'";

			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$conn -> close();
				return array("status" => "USERNAME ALREADY IN USE");
			}
			else{
				$conn -> close();
				return array("status" => "SUCCESS");
			}
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}

}

function attemptRegisterConsumer($userName, $userPassword, $userFirstName, $userLastName, $userEmail, $userCountry, $userGender, $userBDay, $userBMonth, $userBYear){

	$conn = connectionToDataBase();

	if ($conn != null){
		$last_id = $conn->insert_id;
		$sql = "INSERT INTO user_information (idUser, fName, lName, username, passwrd, email, country, gender, birthDay, birthMonth, birthYear) VALUES ('$last_id', '$userFirstName', '$userLastName', '$userName', '$userPassword', '$userEmail', '$userCountry', '$userGender', '$userBDay','$userBMonth', '$userBYear')";

		$result = $conn->query($sql);

		if ($result) {
			$conn -> close();
			return array("status" => "SUCCESS");
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}

}

function attemptRegisterRestaurant($userName, $RestaurantName, $newUsernameRestaurant, $email, $restaurantAddress, $RestaurantPassword, $restaurantPhone, $restaurantWebpage, $openHour, $openMin, $closeHour, $closeMin, $securityKey, $maxCapacity){

	$conn = connectionToDataBase();

	if ($conn != null){
		$last_id = $conn->insert_id;
		$sql = "INSERT INTO restaurant_information (idRestaurant, rName, rUsername, passwrd, address, phone, email, webpage, openHour, openMin, closeHour, closeMin, securityKey, maxCapacity) VALUES ('$last_id', '$userName', '$RestaurantName', '$newUsernameRestaurant', '$RestaurantPassword', '$restaurantAddress', '$restaurantPhone', '$email', '$restaurantWebpage', '$openHour', '$openMin', '$closeHour', '$closeMin', '$securityKey', '$maxCapacity')";

		$result = $conn->query($sql);

		if ($result) {
			$conn -> close();
			return array("status" => "SUCCESS");
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}

}

function attemptGetRestaurants(){
	$conn = connectionToDataBase();

	if ($conn != null){

		$sql = "SELECT rUsername, address, webpage FROM restaurant_information";
		$result = $conn->query($sql);
		$commentsBox = array();
		while($row = $result->fetch_assoc()) {
			$response = array('username' => $row['username'], 'comment' => $row['comment']);  
			array_push($commentsBox, $response);
		}
		$conn -> close();
		return array("status" => "SUCCESS", "arrayCommentsBox" => $commentsBox);
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}
}

function attemptAddComments($username, $comment){

	$conn = connectionToDataBase();

	if ($conn != null){

		$last_id = $conn->insert_id;

		$sql = "INSERT INTO CommentsBox (idComment, comment, username) VALUES ('$last_id', '$comment', '$username')";	

		$result = $conn->query($sql);

		if ($result) {
			$conn -> close();
			return array("status" => "SUCCESS");
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}

}

function attemptLoadProfile($username){

	$conn = connectionToDataBase();

	if ($conn != null){

		$sql = "SELECT * FROM UsersDatabase WHERE username = '$username'";

		$result = $conn->query($sql);

		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				$response = array('fName' => $row['fName'], 'lName' => $row['lName'], 'username' => $row['username'], 'email' => $row['email'], 'gender' => $row['gender'], 'country' => $row['country']); 
			}
			$conn -> close();
			return array("status" => "SUCCESS", "profileData" => $response);
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}
}

function attemptGetFriends($username){
	$conn = connectionToDataBase();

	if ($conn != null){
		$getIDsql = "SELECT idUser FROM UsersDatabase WHERE username = '$username'";
		$resultID = $conn->query($getIDsql);

		while($row = $resultID->fetch_assoc()) {
			$usernameID = $row['idUser'];
		}

		$sql = "SELECT * FROM UsersRelationships WHERE (idUser1 = '$usernameID' OR idUser2 = '$usernameID') AND status = 1";

		$result = $conn->query($sql);
		$friendsList = array();

		if ($result->num_rows > 0){

			$rows = $result->num_rows;

			while($row = $result->fetch_assoc()) {

				$usernameIDFriend1 = $row['idUser1'];
				$usernameIDFriend2 = $row['idUser2'];

				$getUsernameSql = "SELECT username FROM UsersDatabase WHERE (idUser = '$usernameIDFriend1' OR idUser = '$usernameIDFriend2') AND idUser != '$usernameID' ";
				$resultUsername = $conn->query($getUsernameSql);
				while($row = $resultUsername->fetch_assoc()) {
					$usernameFriend = $row['username'];
				}

				$sqlGetFriends = "SELECT username, fName, lName FROM UsersDatabase WHERE username = '$usernameFriend'";
				$resultFriends = $conn->query($sqlGetFriends);

				if ($resultFriends->num_rows > 0){
					while($row = $resultFriends->fetch_assoc()) {
						$response = array('username' => $row['username'], 'fName' => $row['fName'], 'lName' => $row['lName']);  
						array_push($friendsList, $response);
					}
				}
				else{
					$conn -> close();
					return array("status" => "ERROR");
				}	
			}
			$conn -> close();
			return array("status" => "SUCCESS", "arrayFriendsList" => $friendsList);
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}
}

function attemptSearchUsers($username, $searchBox){
	$conn = connectionToDataBase();

	if ($conn != null){
		$getIDsql = "SELECT idUser FROM UsersDatabase WHERE username = '$username'";
		$resultID = $conn->query($getIDsql);

		while($row = $resultID->fetch_assoc()) {
			$usernameID = $row['idUser'];
		}
		$sql = "SELECT idUser FROM UsersDatabase WHERE idUser != '$usernameID' AND  idUser NOT IN (SELECT idUser2 FROM UsersRelationships WHERE idUser1 = '$usernameID') AND idUser NOT IN (SELECT idUser1 FROM UsersRelationships WHERE idUser2 = '$usernameID') AND (username LIKE '%$searchBox%' OR email LIKE '%$searchBox%')";
		$result = $conn->query($sql);
		$userList = array();

		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				$usernameID = $row['idUser'];

				$sqlGetFriends = "SELECT * FROM UsersDatabase WHERE idUser = '$usernameID'";
				$resultFriends = $conn->query($sqlGetFriends);

				if ($resultFriends->num_rows > 0){
					while($row = $resultFriends->fetch_assoc()) {
						$response = array('username' => $row['username'], 'fName' => $row['fName'], 'lName' => $row['lName']);  
						array_push($userList, $response);
					}
				}
				else{
					$conn -> close();
					return array("status" => "ERROR1");
				}	
			}
			$conn -> close();
			return array("status" => "SUCCESS", "arrayUsersList" => $userList);
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}
}

function attemptGetFriendsRequests($username){
	$conn = connectionToDataBase();

	if ($conn != null){
		$getIDsql = "SELECT idUser FROM UsersDatabase WHERE username = '$username'";
		$resultID = $conn->query($getIDsql);

		while($row = $resultID->fetch_assoc()) {
			$usernameID = $row['idUser'];
		}

		$sql = "SELECT * FROM UsersRelationships WHERE (idUser1 = '$usernameID' OR idUser2 = '$usernameID') AND status = 0 AND idActionUser != '$usernameID' ";

		$result = $conn->query($sql);
		$friendsList = array();

		if ($result->num_rows > 0){

			$rows = $result->num_rows;

			while($row = $result->fetch_assoc()) {

				$usernameIDFriend1 = $row['idUser1'];
				$usernameIDFriend2 = $row['idUser2'];

				$getUsernameSql = "SELECT username FROM UsersDatabase WHERE (idUser = '$usernameIDFriend1' OR idUser = '$usernameIDFriend2') AND idUser != '$usernameID' ";
				$resultUsername = $conn->query($getUsernameSql);
				while($row = $resultUsername->fetch_assoc()) {
					$usernameFriend = $row['username'];
				}

				$sqlGetFriends = "SELECT username, fName, lName FROM UsersDatabase WHERE username = '$usernameFriend'";
				$resultFriends = $conn->query($sqlGetFriends);

				if ($resultFriends->num_rows > 0){
					while($row = $resultFriends->fetch_assoc()) {
						$response = array('username' => $row['username'], 'fName' => $row['fName'], 'lName' => $row['lName']);  
						array_push($friendsList, $response);
					}
				}
				else{
					$conn -> close();
					return array("status" => "ERROR");
				}	
			}
			$conn -> close();
			return array("status" => "SUCCESS", "arrayFriendsList" => $friendsList);
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}
}

function attemptAcceptFriends($username, $newFriendUsername){
	$conn = connectionToDataBase();

	if ($conn != null){

		$getIDsql1 = "SELECT idUser FROM UsersDatabase WHERE username = '$username'";
		$resultID1 = $conn->query($getIDsql1);

		while($row = $resultID1->fetch_assoc()) {
			$usernameID1 = $row['idUser'];
		}

		$getIDsql2 = "SELECT idUser FROM UsersDatabase WHERE username = '$newFriendUsername'";
		$resultID2 = $conn->query($getIDsql2);

		while($row = $resultID2->fetch_assoc()) {
			$usernameID2 = $row['idUser'];
		}

		$sql = "UPDATE UsersRelationships SET status = 1 WHERE (idUser1 = '$usernameID1' OR idUser2 = '$usernameID1') AND (idUser1 = '$usernameID2' OR idUser2 = '$usernameID2')";	

		$result = $conn->query($sql);

		if ($result) {
			$conn -> close();
			return array("status" => "SUCCESS");
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}

}

function attemptDeclineFriends($username, $newUsername){
	$conn = connectionToDataBase();

	if ($conn != null){

		$getIDsql1 = "SELECT idUser FROM UsersDatabase WHERE username = '$username'";
		$resultID1 = $conn->query($getIDsql1);

		while($row = $resultID1->fetch_assoc()) {
			$usernameID1 = $row['idUser'];
		}

		$getIDsql2 = "SELECT idUser FROM UsersDatabase WHERE username = '$newUsername'";
		$resultID2 = $conn->query($getIDsql2);

		while($row = $resultID2->fetch_assoc()) {
			$usernameID2 = $row['idUser'];
		}

		$sql = "DELETE FROM UsersRelationships WHERE (idUser1 = '$usernameID1' OR idUser2 = '$usernameID1') AND (idUser1 = '$usernameID2' OR idUser2 = '$usernameID2')";	

		$result = $conn->query($sql);

		if ($result) {
			$conn -> close();
			return array("status" => "SUCCESS");
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}

}

function attemptSendFriendRequest($username, $newUsername){
	$conn = connectionToDataBase();

	if ($conn != null){

		$getIDsql1 = "SELECT idUser FROM UsersDatabase WHERE username = '$username'";
		$resultID1 = $conn->query($getIDsql1);

		while($row = $resultID1->fetch_assoc()) {
			$usernameID1 = $row['idUser'];
		}

		$getIDsql2 = "SELECT idUser FROM UsersDatabase WHERE username = '$newUsername'";
		$resultID2 = $conn->query($getIDsql2);

		while($row = $resultID2->fetch_assoc()) {
			$usernameID2 = $row['idUser'];
		}

		$sql = "INSERT INTO UsersRelationships VALUES ('$usernameID1', '$usernameID2', 0, '$usernameID1')";	

		$result = $conn->query($sql);

		if ($result) {
			$conn -> close();
			return array("status" => "SUCCESS");
		}
		else{
			$conn -> close();
			return array("status" => "ERROR");
		}
	}
	else{
		$conn -> close();
		return array("status" => "CONNECTION WITH DB WENT WRONG");
	}

}

?>
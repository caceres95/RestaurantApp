CREATE TABLE IF NOT EXISTS `user_information` (
	idUser INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	fName VARCHAR(30) NOT NULL,
    lName VARCHAR(30) NOT NULL,
    username VARCHAR(50) NOT NULL,
    passwrd VARCHAR(300) NOT NULL,
    email VARCHAR(100) NOT NULL,
    country VARCHAR(20) NOT NULL,
    gender VARCHAR(15) NOT NULL,
    birthDay INT(5) NOT NULL,
    birthMonth VARCHAR(35) NOT NULL,
    birthYear INT(10) NOT NULL,
    UNIQUE (username)
);

CREATE TABLE IF NOT EXISTS `restaurant_information` (
	idRestaurant INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	rName VARCHAR(30) NOT NULL,
    rUsername VARCHAR(50) NOT NULL,
    passwrd VARCHAR(300) NOT NULL,
    address VARCHAR(50) NOT NULL,
    phone INT(20) NOT NULL,    
    email VARCHAR(100) NOT NULL,
    webpage VARCHAR(200) NOT NULL,
    openHour INT(5) NOT NULL,
    openMin INT(5) NOT NULL,
    closeHour INT(5) NOT NULL,
    closeMin INT(5) NOT NULL,
    UNIQUE (rUsername)
);

CREATE TABLE IF NOT EXISTS `promotions` (
	idPromotions INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    rUsername VARCHAR(50) NOT NULL,
	name VARCHAR(50) NOT NULL,
	imageURL VARCHAR(500) NOT NULL,
	startDay INT(5) NOT NULL,
    startMonth VARCHAR(35) NOT NULL,
    startYear INT(10) NOT NULL,
    endDay INT(5) NOT NULL,
    endMonth VARCHAR(35) NOT NULL,
    endYear INT(10) NOT NULL,
	FOREIGN KEY(rUsername) REFERENCES restaurant_information(rUsername)
);

CREATE TABLE IF NOT EXISTS `restaurant_reviews` (
	idReview INT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    rUsername VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
	reviewText VARCHAR(300) NOT NULL,
	rating VARCHAR(100) NOT NULL,
	FOREIGN KEY(rUsername) REFERENCES restaurant_information(rUsername),
	FOREIGN KEY(username) REFERENCES user_information(username)
);

CREATE TABLE IF NOT EXISTS `consumer_fav_restaurants` (
	idRestaurant INT(8) UNSIGNED NOT NULL,
    idUser INT(8) UNSIGNED NOT NULL,
	FOREIGN KEY(idRestaurant) REFERENCES restaurant_information(idRestaurant),
	FOREIGN KEY(idUser) REFERENCES user_information(idUser)
);

ALTER TABLE `consumer_fav_restaurants`
ADD UNIQUE KEY `usersFavsResID` (`idRestaurant`,`idUser`);

CREATE TABLE IF NOT EXISTS `consumer_visits` (
	idVisit INT(8) UNSIGNED NOT NULL,
    rUsername VARCHAR(50) NOT NULL,
    username VARCHAR(50) NOT NULL,
    visitDay INT(5) NOT NULL,
    visitMonth VARCHAR(35) NOT NULL,
    visitYear INT(10) NOT NULL,
    numVisits INT(20) NOT NULL,
    timeArrived DATETIME(30) NULL,
    timeLeft DATETIME(30) NULL,
	FOREIGN KEY(rUsername) REFERENCES restaurant_information(rUsername),
	FOREIGN KEY(username) REFERENCES user_information(username)
);

INSERT INTO `UsersDatabase` (`idUser`, `fName`, `lName`, `username`, `passwrd`, `email`, `country`, `gender`) VALUES
(1, 'Alfredo', 'Salazar', 'alfredo08', 'alfred90', 'alfred@gmail.com', 'Mexico', 'male'),
(2, 'Alicia', 'Rojas', 'aliceStar', 'aliceWonder', 'alithia@live.com.mx', 'China', 'female'),
(3, 'Andres', 'Castro', 'andresito', 'ac146', 'acastro@hotmail.com', 'Singapur', 'male'),
(4, 'Andrea', 'Sanchez', 'andypandy1', 'andy1', 'andy@gmail.com', 'South Korea', 'female'),
(5, 'Beto', 'Ramirez', 'beto', '12', 'betito@gmail.com', 'India', 'male'),
(6, 'Carolina', 'Romo', 'caroromo1', 'romo94', 'cromop1@gmail.com', 'Mexico', 'female'),
(7, 'Carlos', 'Caceres', 'cbca', 'cbca952', 'cbca95@gmail.com', 'Mexico', 'male'),
(8, 'Ivan', 'Romo', 'ivan0208', 'ivanleonardo', 'ivan.romo@hotmail.com', 'USA', 'male'),
(9, 'Jacquelin', 'Romo', 'jacquitha', 'pato', 'jacky@gmail.com', 'Japan', 'female'),
(10, 'Kin', 'Yun', 'ky789', '4567', 'kyu@gmail.com', 'Japan', 'male'),
(11,'Laila', 'Porte', 'laila123', '123', 'lai@gmail.com', 'South Korea', 'female'),
(12,'Leo', 'Romo', 'leoRomo', 'leo1224', 'leo@gmail.com', 'India', 'male'),
(13,'Miguel', 'Rodríguez', 'miguelrod', 'miwo', 'miguel@hotmail.com', 'Mexico', 'male'),
(14,'Paola', 'Villareal', 'pao', '123', 'pao@gmail.com', 'USA', 'female'),
(15,'Daniel', 'Pro', 'pro1', 'dpc', 'pro@gmail.com', 'USA', 'male'),
(16,'Ruben', 'de la Pena', 'rubs', 'rubs', 'rub@gmail.com', 'Spain', 'male'),
(17,'Roberto', 'Navarro', 'Snake13', 'betito', 'beto@hotmail.com', 'Germany', 'male'),
(18,'Sofia', 'Romero', 'sofiQueen', 'sofisofi', 'sofia-romero@gmail.com', 'Spain', 'female'),
(19,'Susy', 'Berrones', 'SusyB', 'susyf', 'susyflor@gmail.com', 'Italy', 'female'),
(20,'Pamela', 'Rodriguez', 'thePam22', '22mapeht', 'pame@gmail.com', 'Mexico', 'female');

INSERT INTO `UsersRelationships` (`idUser1`, `idUser2`, `status`, `idActionUser`) VALUES
(1, 2, 1, 1),
(1, 3, 1, 3),
(1, 4, 1, 4),
(1, 5, 0, 5),
(1, 6, 0, 1),
(2, 3, 1, 2),
(2, 4, 1, 4),
(3, 5, 1, 3),
(3, 6, 0, 3),
(4, 6, 1, 4),
(5, 6, 1, 5),
(6, 7, 1, 6),
(6, 8, 1, 6),
(6, 9, 1, 9),
(6, 11, 0, 11),
(6, 12, 1, 12),
(6, 13, 0, 13),
(6, 14, 0, 14),
(6, 15, 0, 6);

-- status meaning
-- 0	Pending
-- 1	Accepted
-- 2	Declined

INSERT INTO `CommentsBox` (`idComment`, `comment`, `username`) VALUES
(1, 'Mi pelicula favorita es La La Land', 'caroromo1'),
(2, 'A mi me gusta el helado de vainilla', 'caroromo1'),
(3, 'Me gusta jugar Mario Kart', 'cbca'),
(4, 'Amo a mi novia', 'miguelrod'),
(5, 'Hola me gusta Star Wars', 'miguelrod'),
(6, 'Me gusta leer', 'cbca');



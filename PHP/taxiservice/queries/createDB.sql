CREATE DATABASE taxiservice DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

CREATE TABLE orders(
	id int (11) NOT NULL AUTO_INCREMENT,
	fio TINYTEXT NOT NULL,
	email VARCHAR(320) NOT NULL,
	departure TINYTEXT NOT NULL,
	destination TINYTEXT NOT NULL,
	departure_time DATETIME NOT NULL,
	car ENUM('economy', 'comfort', 'business') DEFAULT 'economy' NOT NULL,
	status BOOLEAN NOT NULL DEFAULT FALSE,
	PRIMARY KEY(id)
);
	
/*созданиебазыданных Autoservices*/
CREATE DATABASE Autoservices CHARACTER SET utf8 COLLATE
utf8_general_ci;
/*Созданиетаблицы Shop*/
CREATE TABLE Shop(
id_Shop INT(11) NOT NULL AUTO_INCREMENT,
description TEXT DEFAULT NULL,
address TINYTEXT NOT NULL,
PRIMARY KEY(id_Shop)
);
/*Созданиетаблицы Master*/
CREATE TABLE Master(
id_Master INT(11) NOT NULL AUTO_INCREMENT,
fio TINYTEXT NOT NULL,
document INT(7) NOT NULL,
id_Shop INT(11) NOT NULL,
PRIMARY KEY(id_Master),
FOREIGN KEY(id_Shop) REFERENCES Shop(id_Shop)
);
/*Созданиетаблицы Works*/
CREATE TABLE Works(
id_Works INT(11) NOT NULL AUTO_INCREMENT,
workname TINYTEXT NOT NULL,
description TEXT DEFAULT NULL,
dat INT(3) NOT NULL,
type_dat ENUM('minutes', 'hours', 'days') NOT NULL DEFAULT
'minutes',
price DECIMAL(10,2) NOT NULL,
PRIMARY KEY(id_Works)
);
/*Созданиетаблицы MasterWorks*/
CREATE TABLE MasterWorks(
id_MasterWorks INT(11) NOT NULL AUTO_INCREMENT,
id_Master INT(11) NOT NULL,
id_Works INT(11) NOT NULL,
PRIMARY KEY(id_MasterWorks),
FOREIGN KEY(id_Master) REFERENCES Master(id_Master),
FOREIGN KEY(id_Works) REFERENCES Works(id_Works)
);
/*Созданиетаблицы Material*/
CREATE TABLE Material(
id_Material INT(11) NOT NULL AUTO_INCREMENT,
name TINYTEXT NOT NULL,
description TEXT,
price DECIMAL(10,2) NOT NULL,
PRIMARY KEY(id_Material)
);
/*Созданиетаблицы MaterialWorks*/
CREATE TABLE MaterialWorks(
id_MaterialWorks INT(11) NOT NULL AUTO_INCREMENT,
id_Works INT(11) NOT NULL,
id_Material INT(11) NOT NULL,
PRIMARY KEY(id_MaterialWorks),
FOREIGN KEY(id_Works) REFERENCES Works(id_Works),
FOREIGN KEY(id_Material) REFERENCES Material(id_Material)
);
/*Созданиетаблицы Orders*/
CREATE TABLE Orders(
id_Orders INT(11) NOT NULL AUTO_INCREMENT,
id_Client INT(11) NOT NULL,
id_Auto INT(11) NOT NULL,
status BOOLEAN DEFAULT FALSE,
dat DATETIME,
id_Shop INT(11) NOT NULL,
PRIMARY KEY(id_Orders),
FOREIGN KEY(id_Auto) REFERENCES Auto(id_Auto),
FOREIGN KEY(id_Client) REFERENCES Client(id_Client),
FOREIGN KEY(id_Shop) REFERENCES Shop(id_Shop)
);
/*Созданиетаблицы WorksOrders*/
CREATE TABLE WorksOrders(
id_WorksOrders INT(11) NOT NULL AUTO_INCREMENT,
id_Works INT(11) NOT NULL,
id_Orders INT(11) NOT NULL,
PRIMARY KEY(id_WorksOrders),
FOREIGN KEY(id_Works) REFERENCES Works(id_Works),
FOREIGN KEY(id_Orders) REFERENCES Orders(id_Orders)
);
/*Созданиетаблицы Client*/
CREATE TABLE Client(
id_Client INT(11) NOT NULL AUTO_INCREMENT,
fio TINYTEXT NOT NULL,
document TINYTEXT NOT NULL,
phone1 TINYTEXT NOT NULL,
phone2 TINYTEXT DEFAULT NULL,
PRIMARY KEY(id_Client)
);
/*Созданиетаблицы Auto*/
CREATE TABLE Auto(
id_Auto INT(11) NOT NULL AUTO_INCREMENT,
VIN TINYTEXT NOT NULL,
model TINYTEXT NOT NULL,
st_num TINYTEXT NOT NULL,
id_Client INT(11) NOT NULL,
PRIMARY KEY(id_Auto),
FOREIGN KEY(id_Client) REFERENCES Client(id_Client)
);

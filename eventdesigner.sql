
CREATE TABLE `actors` (
`id` INT(11) NOT NULL  AUTO_INCREMENT,
`firstname` VARCHAR( 50 ) NOT NULL ,
`lastname` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);


CREATE TABLE `locations` (
`id` INT NOT NULL AUTO_INCREMENT ,
`locationname` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`latitude` VARCHAR( 50 ) NOT NULL ,
`longitude` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `equipments` (
`id` INT NOT NULL AUTO_INCREMENT ,
`equipmentname` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`owner` VARCHAR( 50 ) NOT NULL ,
`costofrent` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `characters` (
`id` INT NOT NULL AUTO_INCREMENT ,
`charactername` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`notes` TEXT NOT NULL ,
`actorid` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `franchisee` (
`id` INT NOT NULL AUTO_INCREMENT ,
`franchiseename` VARCHAR( 150 ) NOT NULL ,
`franchiseecode` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`notes` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
);


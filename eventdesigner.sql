
CREATE TABLE `actors` (
`id` INT(11) NOT NULL  AUTO_INCREMENT,
`clientid` INT(11) NOT NULL ,
`firstname` VARCHAR( 50 ) NOT NULL ,
`lastname` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);


CREATE TABLE `locations` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientid` INT(11) NOT NULL ,
`locationname` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`latitude` VARCHAR( 50 ) NOT NULL ,
`longitude` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `equipments` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientid` INT(11) NOT NULL ,
`equipmentname` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`owner` VARCHAR( 50 ) NOT NULL ,
`costofrent` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `characters` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientid` INT(11) NOT NULL ,
`charactername` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`notes` TEXT NOT NULL ,
`actorid` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `clients` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientname` VARCHAR( 150 ) NOT NULL ,
`clientcode` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NOT NULL ,
`notes` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
);



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

CREATE TABLE `tasks` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientid` INT(11) NOT NULL ,
`starttime` DATETIME NOT NULL ,
`endtime` DATETIME NOT NULL ,
`taskname` VARCHAR( 150 ) NOT NULL ,
`description` VARCHAR( 150 ) NOT NULL ,
`responsible` VARCHAR( 150 ) NOT NULL ,
`cost` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `actions` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientid` INT(11) NOT NULL ,
`duration` INT(11) NOT NULL ,
`timelag` INT(11) NOT NULL ,
`actionname` VARCHAR( 150 ) NOT NULL ,
`description` VARCHAR( 150 ) NOT NULL ,
`equipments` TEXT NOT NULL ,
`roles` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `scenarios` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientid` INT(11) NOT NULL ,
`scenarioname` VARCHAR( 150 ) NOT NULL ,
`description` VARCHAR( 150 ) NOT NULL ,
`actionpoints` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
);

CREATE TABLE `actionpoints` (
`id` INT NOT NULL AUTO_INCREMENT ,
`clientid` INT(11) NOT NULL ,
`actionpointname` VARCHAR( 150 ) NOT NULL ,
`editable` VARCHAR( 150 ) NOT NULL ,
`type` TEXT NOT NULL ,
`description` VARCHAR( 150 ) NOT NULL ,
`location` INT(11) NOT NULL ,
`action` TEXT NOT NULL ,
PRIMARY KEY ( `id` )
);


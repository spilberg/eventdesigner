# MySQL-Front Dump 2.5
#
# Host: localhost   Database: eventdesigner
# --------------------------------------------------------
# Server version 5.0.45-community-nt


#
# Table structure for table 'actionpoints'
#

DROP TABLE IF EXISTS actionpoints;
CREATE TABLE IF NOT EXISTS actionpoints (
  id int(11) NOT NULL auto_increment,
  clientid int(11) NOT NULL ,
  actionpointname varchar(150) NOT NULL ,
  editable varchar(150) NOT NULL ,
  type varchar(150) NOT NULL ,
  description varchar(150) NOT NULL ,
  location text NOT NULL ,
  action text NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'actionpoints'
#

INSERT INTO actionpoints VALUES("1", "1", "Magic forest", "true", "state", "Magic forest", "1", "1");
INSERT INTO actionpoints VALUES("2", "1", "Forest way", "true", "flow", "Forest way", "1", "2");


#
# Table structure for table 'actions'
#

DROP TABLE IF EXISTS actions;
CREATE TABLE IF NOT EXISTS actions (
  id int(11) NOT NULL auto_increment,
  clientid int(11) NOT NULL ,
  duration int(11) NOT NULL ,
  timelag int(11) NOT NULL ,
  actionname varchar(150) NOT NULL ,
  description varchar(150) NOT NULL ,
  equipments text NOT NULL ,
  roles text NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'actions'
#

INSERT INTO actions VALUES("1", "1", "10", "0", "Sharpshooter archer", "Archery Targets", "1,5", "4");
INSERT INTO actions VALUES("2", "1", "15", "0", "Meeting with a monster", "Meeting with a monster", "2,4", "2");


#
# Table structure for table 'actors'
#

DROP TABLE IF EXISTS actors;
CREATE TABLE IF NOT EXISTS actors (
  id int(11) NOT NULL auto_increment,
  clientid int(11) unsigned ,
  firstname varchar(50) NOT NULL ,
  lastname varchar(50) NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'actors'
#

INSERT INTO actors VALUES("1", "1", "Nick", "Korbut");
INSERT INTO actors VALUES("3", "1", "Slava", "Korbut");


#
# Table structure for table 'characters'
#

DROP TABLE IF EXISTS characters;
CREATE TABLE IF NOT EXISTS characters (
  id int(11) NOT NULL auto_increment,
  clientid int(11) unsigned ,
  charactername varchar(150) NOT NULL ,
  description text NOT NULL ,
  notes text NOT NULL ,
  actorid varchar(50) NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'characters'
#

INSERT INTO characters VALUES("1", "1", "Baba-Yaga", "baba", "baba", "1");
INSERT INTO characters VALUES("2", "1", "Koshchey", "kosha", "kosha", "2");
INSERT INTO characters VALUES("3", "1", "Monster", "Monster", "Monster", "2");
INSERT INTO characters VALUES("4", "1", "Archer", "Archer", "Archer", "1");


#
# Table structure for table 'clients'
#

DROP TABLE IF EXISTS clients;
CREATE TABLE IF NOT EXISTS clients (
  id int(11) NOT NULL auto_increment,
  clientname varchar(150) NOT NULL ,
  clientcode varchar(150) NOT NULL ,
  description text NOT NULL ,
  notes text NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'clients'
#

INSERT INTO clients VALUES("1", "Fantasia", "1111", "Fantasia", "Fantasia");


#
# Table structure for table 'equipments'
#

DROP TABLE IF EXISTS equipments;
CREATE TABLE IF NOT EXISTS equipments (
  id int(11) NOT NULL auto_increment,
  clientid int(11) unsigned ,
  equipmentname varchar(150) NOT NULL ,
  description text NOT NULL ,
  owner varchar(50) NOT NULL ,
  costofrent varchar(50) NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'equipments'
#

INSERT INTO equipments VALUES("1", "1", "target", "target for archer", "Ivan Petrovich", "5");
INSERT INTO equipments VALUES("2", "1", "sword", "sword", "Nick", "10");
INSERT INTO equipments VALUES("3", "1", "dragon Egg", "dragon Egg", "Nick", "8");
INSERT INTO equipments VALUES("4", "1", "monster costume", "monster costume", "Nick", "15");
INSERT INTO equipments VALUES("5", "1", "bow", "bow", "Nick", "10");


#
# Table structure for table 'locations'
#

DROP TABLE IF EXISTS locations;
CREATE TABLE IF NOT EXISTS locations (
  id int(11) NOT NULL auto_increment,
  clientid int(11) unsigned ,
  locationname varchar(150) NOT NULL ,
  description text NOT NULL ,
  latitude varchar(50) NOT NULL ,
  longitude varchar(50) NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'locations'
#

INSERT INTO locations VALUES("1", "1", "Gidropark", "Gidropark location", "50.50198526955379", "30.5474853515625");
INSERT INTO locations VALUES("2", "1", "PDN", "PDN location", "50.50198526955379", "30.5474853515625");


#
# Table structure for table 'scenarios'
#

DROP TABLE IF EXISTS scenarios;
CREATE TABLE IF NOT EXISTS scenarios (
  id int(11) NOT NULL auto_increment,
  clientid int(11) NOT NULL ,
  scenarioname varchar(150) NOT NULL ,
  description varchar(150) NOT NULL ,
  actionpoints text NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'scenarios'
#

INSERT INTO scenarios VALUES("1", "1", "Dragon\'s Egg", "scenario", "1,2");


#
# Table structure for table 'tasks'
#

DROP TABLE IF EXISTS tasks;
CREATE TABLE IF NOT EXISTS tasks (
  id int(11) NOT NULL auto_increment,
  clientid int(11) NOT NULL ,
  starttime datetime NOT NULL ,
  endtime datetime NOT NULL ,
  taskname varchar(150) NOT NULL ,
  description varchar(150) NOT NULL ,
  responsible varchar(150) NOT NULL ,
  cost varchar(50) NOT NULL ,
  PRIMARY KEY (id)
);



#
# Dumping data for table 'tasks'
#


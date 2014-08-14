-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Авг 14 2014 г., 23:49
-- Версия сервера: 5.0.45
-- Версия PHP: 5.2.4
-- 
-- БД: `eventdesigner`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `actors`
-- 

DROP TABLE IF EXISTS `actors`;
CREATE TABLE `actors` (
  `id` int(11) NOT NULL auto_increment,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `actors`
-- 

INSERT INTO `actors` VALUES (1, 'Nick', 'Korbut');
INSERT INTO `actors` VALUES (2, 'Nick', 'Korbut');
INSERT INTO `actors` VALUES (3, 'Slava', 'Korbut');

-- --------------------------------------------------------

-- 
-- Структура таблицы `equipments`
-- 

DROP TABLE IF EXISTS `equipments`;
CREATE TABLE `equipments` (
  `id` int(11) NOT NULL auto_increment,
  `equipmentname` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `owner` varchar(50) NOT NULL,
  `costofrent` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `equipments`
-- 

INSERT INTO `equipments` VALUES (1, 'target', 'target for archer', 'Ivan Petrovich', '5');

-- --------------------------------------------------------

-- 
-- Структура таблицы `locations`
-- 

DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL auto_increment,
  `locationname` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `locations`
-- 

INSERT INTO `locations` VALUES (1, 'Gidropark', 'Gidropark location', '10', '20');
INSERT INTO `locations` VALUES (2, 'PDN', 'PDN location', '30', '40');
        
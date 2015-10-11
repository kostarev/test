-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 11 2015 г., 21:27
-- Версия сервера: 5.5.41-log
-- Версия PHP: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `dota`
--

-- --------------------------------------------------------

--
-- Структура таблицы `dota_heroes`
--

CREATE TABLE IF NOT EXISTS `dota_heroes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `dota_heroes`
--

INSERT INTO `dota_heroes` (`id`, `name`, `url`) VALUES
(0, 'error0', 'error0'),
(1, 'antimage', 'Anti-Mage'),
(2, 'axe', 'Axe'),
(3, 'bane', 'Bane'),
(4, 'bloodseeker', 'Bloodseeker'),
(5, 'maiden', 'Crystal_Maiden'),
(6, 'ranger', 'Drow_Ranger'),
(7, 'earthshaker', 'Earthshaker'),
(8, 'juggernaut', 'Juggernaut'),
(9, 'mirana', 'Mirana'),
(10, 'morphling', 'Morphling'),
(11, 'nevermore', 'Shadow_Fiend'),
(12, 'lancer', 'Phantom_Lancer'),
(13, 'puck', 'Puck'),
(14, 'pudge', 'Pudge'),
(15, 'razor', 'Razor'),
(16, 'king', 'Sand_King'),
(17, 'spirit', 'Storm_Spirit'),
(18, 'sven', 'Sven'),
(19, 'tiny', 'Tiny'),
(20, 'vengefulspirit', 'Vengeful_Spirit'),
(21, 'windrunner', 'Windranger'),
(22, 'zuus', 'Zeus'),
(23, 'kunkka', 'Kunkka'),
(24, 'error24', 'error24'),
(25, 'lina', 'Lina'),
(26, 'lion', 'Lion'),
(27, 'shaman', 'Shadow_Shaman'),
(28, 'slardar', 'Slardar'),
(29, 'tidehunter', 'Tidehunter'),
(30, 'doctor', 'Witch_Doctor'),
(31, 'lich', 'Lich'),
(32, 'riki', 'Riki'),
(33, 'enigma', 'Enigma'),
(34, 'tinker', 'Tinker'),
(35, 'sniper', 'Sniper'),
(36, 'necrolyte', 'Necrophos'),
(37, 'warlock', 'Warlock'),
(38, 'beastmaster', 'Beastmaster'),
(39, 'queenofpain', 'Queen_of_Pain'),
(40, 'venomancer', 'Venomancer'),
(41, 'void', 'Faceless_Void'),
(42, 'skeleton_king', 'Wraith_King'),
(43, 'prophet', 'Death_Prophet'),
(44, 'assassin', 'Phantom_Assassin'),
(45, 'pugna', 'Pugna'),
(46, 'assassin', 'Templar_Assassin'),
(47, 'viper', 'Viper'),
(48, 'luna', 'Luna'),
(49, 'knight', 'Dragon_Knight'),
(50, 'dazzle', 'Dazzle'),
(51, 'rattletrap', 'Clockwerk'),
(52, 'leshrac', 'Leshrac'),
(53, 'furion', 'Natures_Prophet'),
(54, 'life_stealer', 'Lifestealer'),
(55, 'seer', 'Dark_Seer'),
(56, 'clinkz', 'Clinkz'),
(57, 'omniknight', 'Omniknight'),
(58, 'enchantress', 'Enchantress'),
(59, 'huskar', 'Huskar'),
(60, 'stalker', 'Night_Stalker'),
(61, 'broodmother', 'Broodmother'),
(62, 'hunter', 'Bounty_Hunter'),
(63, 'weaver', 'Weaver'),
(64, 'jakiro', 'Jakiro'),
(65, 'batrider', 'Batrider'),
(66, 'chen', 'Chen'),
(67, 'spectre', 'Spectre'),
(68, 'ancient_apparition', 'Ancient_Apparition'),
(69, 'doom_bringer', 'Doom'),
(70, 'ursa', 'Ursa'),
(71, 'spirit_breaker', 'Spirit_Breaker'),
(72, 'gyrocopter', 'Gyrocopter'),
(73, 'alchemist', 'Alchemist'),
(74, 'invoker', 'Invoker'),
(75, 'silencer', 'Silencer'),
(76, 'obsidian_destroyer', 'Outworld_Devourer'),
(77, 'lycan', 'Lycan'),
(78, 'brewmaster', 'Brewmaster'),
(79, 'demon', 'Shadow_Demon'),
(80, 'druid', 'Lone_Druid'),
(81, 'knight', 'Chaos_Knight'),
(82, 'meepo', 'Meepo'),
(83, 'treant', 'Treant_Protector'),
(84, 'magi', 'Ogre_Magi'),
(85, 'undying', 'Undying'),
(86, 'rubick', 'Rubick'),
(87, 'disruptor', 'Disruptor'),
(88, 'assassin', 'Nyx_Assassin'),
(89, 'siren', 'Naga_Siren'),
(90, 'light', 'Keeper_of_the_Light'),
(91, 'wisp', 'Io'),
(92, 'visage', 'Visage'),
(93, 'slark', 'Slark'),
(94, 'medusa', 'Medusa'),
(95, 'warlord', 'Troll_Warlord'),
(96, 'centaur', 'Centaur_Warrunner'),
(97, 'magnataur', 'Magnus'),
(98, 'shredder', 'Timbersaw'),
(99, 'bristleback', 'Bristleback'),
(100, 'tusk', 'Tusk'),
(101, 'mage', 'Skywrath_Mage'),
(102, 'abaddon', 'Abaddon'),
(103, 'titan', 'Elder_Titan'),
(104, 'commander', 'Legion_Commander'),
(105, 'techies', 'Techies'),
(106, 'spirit', 'Ember_Spirit'),
(107, 'spirit', 'Earth_Spirit'),
(108, 'underlord', 'AbyssalUnderlord'),
(109, 'terrorblade', 'Terrorblade'),
(110, 'phoenix', 'Phoenix'),
(111, 'oracle', 'Oracle'),
(112, 'wyvern', 'Winter_Wyvern');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

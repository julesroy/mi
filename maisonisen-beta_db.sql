-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql-maisonisen-beta.alwaysdata.net
-- Generation Time: May 27, 2025 at 03:14 PM
-- Server version: 10.11.11-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maisonisen-beta_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `actus`
--

CREATE TABLE `actus` (
  `idActu` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `titre` varchar(32) NOT NULL,
  `contenu` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0: Actus , 1: FestiVendredi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carteElements`
--

CREATE TABLE `carteElements` (
  `idElement` int(11) NOT NULL,
  `nom` varchar(32) DEFAULT NULL,
  `typePlat` int(11) DEFAULT NULL COMMENT '0 : Plat\r\n1 : Snack\r\n2 : Boisson\r\n3 : Menu\r\n4 : Menu event\r\n5 : Menu spécial (vendredi)',
  `ingredientsElements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Tableau de tableaux (un pour chaque élément) sous la forme :\r\n[[idIngredient, quantite, obligatoire, nombrePortions, points]]',
  `prix` float DEFAULT NULL,
  `prixServeur` float DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ref` text DEFAULT NULL,
  `categoriePlat` int(11) DEFAULT NULL COMMENT '0 : Froid 1 : Hot-dog 2 : Chaud'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carteElements`
--

INSERT INTO `carteElements` (`idElement`, `nom`, `typePlat`, `ingredientsElements`, `prix`, `prixServeur`, `description`, `ref`, `categoriePlat`) VALUES
(25, 'Sandwich', 0, '1,1,2;2,2,0;3,2,0;4,1,0;5,1,0;6,1,1;7,2,0;8,2,0;24,2,0;25,2,0;26,2,0;75,2,0;76,1,0;77,1,0;119,1,0', 2.1, 2.1, 'Sandwich', 'Plat', 0),
(26, 'Panini', 0, '1,1,2;2,2,0;3,2,0;6,1,1;7,2,0;8,2,0;23,2,0;24,2,0;25,2,0;26,2,0;75,2,0;92,2,0;119,1,0', 2.1, 2.1, 'Panini', 'Plat', 2),
(27, 'Croque-Monsieur', 0, '58,1,2;6,1,1;2,1,0;3,1,0;7,1,0;8,1,0;23,1,0;24,1,0;25,1,0;26,1,0;75,1,0;77,1,0;76,1,0;92,1,0;119,1,0', 1.1, 1.1, 'Croque-Monsieur', 'Plat', 2),
(28, 'Hot-Dog', 0, '57,1,2;59,1,2;48,1,1;27,1,0;28,1,0;29,1,0;30,1,0;31,1,0;32,1,0;77,1,0;76,1,0;83,1,0', 1.1, 1.1, 'Hot-Dog', 'Plat', 1),
(30, 'Chips Nature', 1, '33,1,2', 0.8, 0.8, 'Chips', 'Snack', NULL),
(34, 'Chips Poulet', 1, '37,1,2', 0.8, 0.8, 'Chips', 'Snack', NULL),
(35, 'Bueno', 1, '38,1,2', 0.8, 0.8, 'Kinder', 'Snack', NULL),
(36, 'Bueno White', 1, '39,1,2', 0.8, 0.8, 'Kinder', 'Snack', NULL),
(37, 'Kinder Delice', 1, '40,1,2', 0.8, 0.65, 'Kinder', 'Snack', NULL),
(38, 'Granola', 1, '41,1,2', 0.8, 0.8, 'Granola', 'Snack', NULL),
(39, 'Maltesers', 1, '42,1,2', 0.8, 0.65, 'Maltesers', 'Snack', NULL),
(40, 'M&M\'s', 1, '43,1,2', 0.8, 0.65, 'MAndMs', 'Snack', 0),
(41, 'Twix', 1, '44,1,2', 0.8, 0.65, 'Twix', 'Snack', NULL),
(43, 'KitKat', 1, '46,1,2', 0.8, 0.65, 'KitKat', 'Snack', NULL),
(44, 'Eau', 2, '47,1,2', 0.5, 0.3, 'Eau', 'Boisson', NULL),
(45, 'Oasis Tropical', 2, '49,1,2', 0.8, 0.65, 'Oasis', 'Boisson', NULL),
(46, 'Oasis PCF', 2, '50,1,2', 0.8, 0.65, 'Oasis', 'Boisson', NULL),
(47, 'Coca Cola', 2, '51,1,2', 0.8, 0.65, 'Coca', 'Boisson', NULL),
(49, 'Coca Cherry', 2, '53,1,2', 0.8, 0.8, 'Coca', 'Boisson', NULL),
(50, 'Fanta Orange', 2, '54,1,2', 0.8, 0.65, 'Fanta', 'Boisson', NULL),
(51, 'Fanta Citron', 2, '55,1,2', 0.8, 0.65, 'Fanta', 'Boisson', NULL),
(52, 'Fanta Dragon', 2, '56,1,2', 0.8, 0.65, 'Fanta', 'Boisson', NULL),
(57, 'Redbull', 2, '60,1,2', 1.3, 1.3, 'Redbull', 'Redbull', NULL),
(58, 'Redbull Myrtille', 2, '61,1,2', 1.5, 1.5, 'Redbull Myrtille', 'Redbull', NULL),
(59, 'Redbull Drag', 2, '62,1,2', 1.5, 1.5, 'Redbull Drag', 'Redbull', NULL),
(60, 'Redbull Abricot', 2, '63,1,2', 1.5, 1.5, 'Redbull Abricot', 'Redbull', NULL),
(61, 'Minute Maid', 2, '64,1,2', 0.8, 0.8, 'Minute Maid', 'Boisson', NULL),
(62, 'Chips Ancienne', 1, '74,1,2', 0.8, 0.8, 'Chips', 'Snack', NULL),
(63, 'Gaufre', 1, '66,1,2', 0.8, 0.65, 'Gaufre', 'Snack', NULL),
(64, 'Lion', 1, '67,1,2', 0.8, 0.65, 'Lion', 'Snack', NULL),
(65, 'FuzeTea', 2, '72,1,2', 0.8, 0.65, 'FuzeTea', 'Boisson', NULL),
(66, 'Oasis Pomme', 2, '78,1,2', 0.8, 0.65, 'Oasis', 'Boisson', NULL),
(67, 'Sprite', 2, '80,1,2', 0.8, 0.65, 'Sprite', 'Boisson', NULL),
(81, 'Chips Barbecue', 1, '34,1,2', 0.8, 0.8, 'Chips', 'Snack', NULL),
(86, 'Ramen', 0, '68,1,0;68,1,0;69,1,0;69,1,0;70,1,0;70,1,0;71,1,0;71,1,0;106,1,0;106,1,0;110,1,0;110,1,0', 1.1, 1.1, 'Ramen', 'Ramen', NULL),
(89, 'Coca Zero', 2, '52,1,2', 0.8, 0.65, 'Coca Zero', 'Boisson', NULL),
(90, 'Eau pétillante', 2, '103,1,2', 0.5, 0.5, 'Boisson', 'Boisson', NULL),
(93, 'Mars', 1, '107,1,2', 0.8, 0.65, 'Mars', 'Mars', NULL),
(94, 'Arizona pêche', 2, '112,1,2', 1.3, 1.1, 'Boisson', 'Boisson', NULL),
(95, 'Arizona thé vert', 2, '113,1,2', 1.3, 1.1, 'Boisson', 'Boisson', NULL),
(96, 'Arizona pomme grenade', 2, '114,1,2', 1.3, 1.1, 'Boisson', 'Boisson', NULL),
(99, 'Dada Litchi', 2, '122,1,0', 0.8, 0.65, 'Dada', 'Boisson', NULL),
(101, 'Dada Fraise', 2, '125,1,0', 0.8, 0.65, 'Dada', 'Boisson', NULL),
(102, 'Glace Vanille/Fraise', 1, '126,Quantité,0', 0.8, 0.8, 'Glace', 'Snack', NULL),
(103, 'Dada Mangue', 2, '121,1,0', 0.8, 0.65, 'Dada', 'Boisson', NULL),
(104, 'Glace Vanille/Chocolat', 1, '127,1,0', 0.8, 0.6, 'Glace', 'Snack', NULL),
(112, 'RedBull Pêche', 2, '135,1,2', 1.5, 1.5, 'RedBull Pêche', 'RedBull', NULL),
(115, 'SUPPLEMENT RB GOUT PECHE', 2, 'Ingrédient,Quantité,0', 0.7, 0.7, 'boun&#039;s records', 'JE LAI', NULL),
(116, 'SUPPLEMENT RB GOUT', 2, 'Ingrédient,Quantité,0', 0.2, 0.2, 'boun&#039;s records', 'JE LAI', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carteMenus`
--

CREATE TABLE `carteMenus` (
  `idMenu` int(11) NOT NULL,
  `nom` text NOT NULL,
  `elementsMenu` text NOT NULL,
  `prix` float NOT NULL,
  `typeMenu` int(11) NOT NULL DEFAULT 0 COMMENT '0 : Menu classique\r\n1 : Event\r\n2 : Festi''vendredi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carteMenus`
--

INSERT INTO `carteMenus` (`idMenu`, `nom`, `elementsMenu`, `prix`, `typeMenu`) VALUES
(1, 'Ch\'tite Faim', '0,4,4', 3.3, 0),
(2, 'T\'Cho Biloute', '0,0', 4.1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

CREATE TABLE `commandes` (
  `idCommande` int(11) NOT NULL,
  `numeroCommande` varchar(10) NOT NULL,
  `prix` float NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'valeur par défaut',
  `etat` int(11) NOT NULL DEFAULT 0 COMMENT '0 : Commande non payée et non envoyée en cuisine\r\n1 : Commande payée -> en préparation\r\n2 : Commande prête -> on la sort de l''affichage cuisine pour ne pas encombrer\r\n3 : Commande servie\r\n4 : Commande annulée',
  `stock` text NOT NULL COMMENT 'Liste des articles à retirer du stock',
  `menu` text NOT NULL COMMENT '0 : non\r\n1 : 3,30\r\n2 : 3,80\r\n3 : 4,10',
  `commentaire` text NOT NULL,
  `idUtilisateur` int(11) DEFAULT NULL,
  `categorieCommande` int(11) NOT NULL COMMENT '0 : Froid\r\n1 : Hot-dog\r\n2 : Chaud\r\n3 : Snack',
  `idPaiement` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`idCommande`, `numeroCommande`, `prix`, `date`, `etat`, `stock`, `menu`, `commentaire`, `idUtilisateur`, `categorieCommande`, `idPaiement`) VALUES
(2104, 'YO2I7X', 1.1, '2025-05-22 16:27:45', 3, '70,1,0;69,1,0', '2', 'blbllblbl', 182, 99, 0),
(2105, 'YO2I7X', 1.1, '2025-05-23 16:27:45', 1, '8,1,0;25,1,0;58,1,2', '2', '', 182, 2, 0),
(2106, 'R0LVLN', 1.1, '2025-05-23 17:23:32', 3, '28,1,0;57,1,2;59,1,2', '1', '', 182, 1, 0),
(2107, 'R0LVLN', 0.5, '2025-05-22 17:23:32', 3, '47,1,2', '1', '', 182, 3, 0),
(2108, 'R0LVLN', 0.8, '2025-05-22 17:23:32', 3, '38,1,2', '1', '', 182, 3, 0),
(2109, 'N7EJEZ', 1.1, '2025-05-22 17:32:56', 3, '68,1,0;68,1,0', '2', '', 182, 99, 0),
(2110, 'N7EJEZ', 2.1, '2025-05-22 17:32:56', 3, '2,2,0;26,2,0;1,1,2', '2', '', 182, 0, 0),
(2111, '244', 2.1, '2025-05-22 20:42:05', 0, '2,2,0;3,2,0;4,1,0;5,1,0;6,1,1;1,1,2', '1', '', 379, 0, 0),
(2112, '244', 0.8, '2025-05-22 20:42:05', 3, '80,1,2', '1', '', 379, 3, 0),
(2113, '244', 0.8, '2025-05-22 20:42:05', 3, '44,1,2', '1', '', 379, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `idEvent` int(11) NOT NULL,
  `nom` text NOT NULL,
  `date` date NOT NULL,
  `typeEvent` int(11) NOT NULL COMMENT '0 : event classique\r\n1 : Festi''vendredi',
  `prix` float NOT NULL,
  `composition` text NOT NULL,
  `info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`idEvent`, `nom`, `date`, `typeEvent`, `prix`, `composition`, `info`) VALUES
(1, 'Festi\'vendredi', '2030-05-10', 1, 3.3, 'Crêpes + soft (au choix)', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `inventaire`
--

CREATE TABLE `inventaire` (
  `idIngredient` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `quantite` int(11) NOT NULL,
  `categorieIngredient` int(11) NOT NULL COMMENT '0: Ingrédient\r\n1: Viande\r\n2: Extra\r\n3: snack/boisson',
  `commentaire` text DEFAULT NULL,
  `estimationPrix` decimal(10,2) DEFAULT NULL,
  `marque` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventaire`
--

INSERT INTO `inventaire` (`idIngredient`, `nom`, `quantite`, `categorieIngredient`, `commentaire`, `estimationPrix`, `marque`) VALUES
(1, 'Baguette', 0, 0, '', NULL, NULL),
(2, 'Jambon', 36, 1, '1 portion = 1/2 tranche de jambon', NULL, NULL),
(3, 'Emmental', 53, 0, '1 portion = 1 tranche Paquets de 50 tranches', NULL, NULL),
(4, 'Salade', 10, 2, '1 paquet = 15 portions', NULL, NULL),
(5, 'Tomate', 5, 2, '1 portion = 1/4 tomates', NULL, NULL),
(6, 'Beurre', 8, 2, '', NULL, NULL),
(7, 'Poulet Curry', 0, 1, '1 boîte = 60 portions', NULL, NULL),
(8, 'Poulet Andalouse', 0, 1, '1 boîte = 60 portions', NULL, NULL),
(23, 'Pesto Chevre', 0, 1, '1 boîte = 60 portions', NULL, NULL),
(24, 'Chorizo', 18, 1, '1 portion = 3 tranche', NULL, NULL),
(25, 'Raclette', 27, 0, '1 portion = 1 tranche', NULL, NULL),
(26, 'Maroilles', 100, 0, '1 Tranche = 1 portions 1 Boite = 40 portions', NULL, NULL),
(27, 'Ketchup', 100, 0, '', NULL, NULL),
(28, 'Samouraï', 779, 0, '', NULL, NULL),
(29, 'Moutarde', 426, 0, '', NULL, NULL),
(30, 'Andalouse', 100, 0, '', NULL, NULL),
(31, 'Mayonnaise', 100, 0, '', NULL, NULL),
(32, 'Barbecue', 100, 0, '', NULL, NULL),
(33, 'Chips Nature', 20, 3, '', NULL, NULL),
(34, 'Chips Barbecue', 40, 3, '', NULL, NULL),
(37, 'Chips Poulet', 23, 3, '', NULL, NULL),
(38, 'Bueno', 99, 3, '', NULL, NULL),
(39, 'Bueno White', 63, 3, '', NULL, NULL),
(40, 'Kinder Delice', 75, 3, '', NULL, NULL),
(41, 'Granola', 64, 3, '1 pack = 18 portions', NULL, NULL),
(42, 'Maltesers', 7, 3, '', NULL, NULL),
(43, 'MandMs', 66, 3, '', NULL, NULL),
(44, 'Twix', 41, 3, '', NULL, NULL),
(46, 'Kitkat', 68, 3, '', NULL, NULL),
(47, 'Eau', 42, 3, '', NULL, NULL),
(48, 'Of', 200, 2, '1 pot = 100 portions', NULL, NULL),
(49, 'Oasis Tropical', 55, 3, '', NULL, NULL),
(50, 'Oasis PCF', 61, 3, NULL, NULL, NULL),
(51, 'Coca', 54, 3, NULL, NULL, NULL),
(52, 'Coca Zero', 9, 3, NULL, NULL, NULL),
(53, 'Coca Cherry', 56, 3, '', NULL, NULL),
(54, 'Fanta Orange', 63, 3, '', NULL, NULL),
(55, 'Fanta Citron', 60, 3, '', NULL, NULL),
(56, 'Fanta Dragon', 59, 3, '', NULL, NULL),
(57, 'Pain HD', 20, 0, '1 portion = 1 hot dog', NULL, NULL),
(58, 'Pain Croque', 82, 0, '1 portion = 2 Tranche', NULL, NULL),
(59, 'Saucisse', 25, 1, '1 portion = 1 saucisse', NULL, NULL),
(60, 'Redbull', 68, 3, '', NULL, NULL),
(61, 'Redbull Myrtille', 0, 3, '', NULL, NULL),
(62, 'Redbull Dragon', 17, 3, '', NULL, NULL),
(63, 'Redbull Abricot', 19, 3, '', NULL, NULL),
(64, 'Minute Maid', 6, 3, '', NULL, NULL),
(66, 'Gaufre', 0, 3, NULL, NULL, NULL),
(67, 'Lion', 53, 3, '', NULL, NULL),
(68, 'Ramen Canard', 0, 0, '', NULL, NULL),
(69, 'Ramen Poulet', 0, 0, '', NULL, NULL),
(70, 'Ramen Crevette', 0, 0, '', NULL, NULL),
(71, 'Ramen Curry', 0, 0, '', NULL, NULL),
(72, 'FuzeTea', 67, 3, '', NULL, NULL),
(74, 'Chips Ancienne', 32, 3, '', NULL, NULL),
(75, 'Prépa poulet', 0, 1, '1 paquet = 60', NULL, NULL),
(76, 'Chef', 0, 2, '', NULL, NULL),
(77, 'ChefEpice', -2, 2, '', NULL, NULL),
(78, 'Oasis Pomme Poire', 54, 3, NULL, NULL, NULL),
(80, 'Sprite', 33, 3, NULL, NULL, NULL),
(82, 'Rosette', 0, 1, '', NULL, NULL),
(83, 'Hannibal', 2147483635, 0, NULL, NULL, NULL),
(86, 'Cheddar', 336, 0, '1 tranche = 1 portion', NULL, NULL),
(88, 'Sauce', 6560, 2, '1', NULL, NULL),
(91, 'Pesto', 100, 1, '', NULL, NULL),
(92, 'Chèvre', 0, 0, NULL, NULL, NULL),
(94, 'Wraps', 54, 0, '', NULL, NULL),
(95, 'Poulet', 0, 1, '', NULL, NULL),
(96, 'Poivrons', -3, 2, '', NULL, NULL),
(97, 'Sauce Burritos', 0, 2, '', NULL, NULL),
(98, 'Crème fraîche', 0, 2, '', NULL, NULL),
(99, 'Chips', 0, 2, '', NULL, NULL),
(101, 'Burger', 0, 1, '', NULL, NULL),
(103, 'Eau pétillante', 28, 3, '', NULL, NULL),
(106, 'Ramen Spicy', 0, 0, '', NULL, NULL),
(107, 'Mars', 0, 3, NULL, NULL, NULL),
(108, 'Coca Vanille', 0, 3, '', NULL, NULL),
(109, 'Ramen Curry', 0, 0, NULL, NULL, NULL),
(110, 'Ramen Boeuf', 0, 0, '', NULL, NULL),
(112, 'Arizona pêche', 2, 3, NULL, NULL, 'Arizona'),
(113, 'Arizona thé vert', 0, 3, '', NULL, NULL),
(115, 'Pom Pot', 0, 3, '', NULL, NULL),
(117, 'Jambon Cru', 0, 1, NULL, NULL, NULL),
(118, 'Iced tea pastèque menthe', 0, 3, NULL, NULL, NULL),
(119, 'Prépa américaine', 0, 1, '', NULL, NULL),
(120, 'Crêpes salée', 0, 0, '', NULL, NULL),
(121, 'Dada mangue', 0, 3, '', NULL, NULL),
(122, 'Dada litchi', 13, 3, '', NULL, NULL),
(123, 'Candy&#039;Up Fraise', 30, 3, '', NULL, NULL),
(124, 'Candy&#039;Up Vanille', 23, 3, '', NULL, NULL),
(125, 'Dada Fraise', 0, 3, '', NULL, NULL),
(126, 'Glace Vanille/Fraise', 0, 3, '', NULL, NULL),
(127, 'Glace Vanille/Chocolat', 0, 3, '', NULL, NULL),
(128, 'Dada cherry', 22, 3, '', NULL, NULL),
(129, 'Seven UP', 43, 3, '', NULL, NULL),
(130, 'Dada Melon', 24, 3, '', NULL, NULL),
(131, 'FuzeTea Vert', 24, 3, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdpReset`
--

CREATE TABLE `mdpReset` (
  `email` varchar(64) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paiements`
--

CREATE TABLE `paiements` (
  `idPaiement` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `idUtilisateur` int(11) DEFAULT NULL COMMENT 'Si commande faite sans compte utilisateur, on met la valeur NULL',
  `montant` float NOT NULL,
  `type` int(11) NOT NULL COMMENT '0 : Espèces\n1 : CB\n2 : Compte'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paiements`
--

INSERT INTO `paiements` (`idPaiement`, `date`, `idUtilisateur`, `montant`, `type`) VALUES
(0, '2025-05-01 12:15:00', 317, 20, 1),
(1002, '2025-05-07 18:30:00', 230, 12.5, 0),
(1003, '2025-05-12 13:45:00', 230, 15, 2),
(1004, '2025-05-17 16:00:00', 230, 3.3, 1),
(1005, '2024-05-01 12:10:00', 230, 12.5, 0),
(1006, '2024-05-03 18:20:00', 230, 24, 1),
(1007, '2024-05-04 13:30:00', 230, 8.9, 2),
(1008, '2024-05-10 09:15:00', 230, 15, 0),
(1009, '2024-05-12 14:45:00', 230, 6.5, 1),
(1010, '2024-05-15 19:00:00', 230, 18.75, 2),
(1011, '2024-05-16 11:25:00', 230, 9.99, 0),
(1012, '2024-05-16 17:50:00', 230, 21.3, 1),
(1013, '2024-05-17 08:05:00', 230, 7.8, 2),
(1014, '2024-05-17 20:15:00', 230, 13.2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `parametres`
--

CREATE TABLE `parametres` (
  `idParametre` int(11) NOT NULL,
  `titreHeader` varchar(16) NOT NULL,
  `horairesDebutCommandes` time NOT NULL,
  `horairesFinCommandes` time NOT NULL,
  `service` tinyint(1) NOT NULL COMMENT '1 : Service\r\n0 : Pas de service',
  `modeEvent` tinyint(1) NOT NULL COMMENT '1 : Event\r\n0 : Pas en mode Event'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parametres`
--

INSERT INTO `parametres` (`idParametre`, `titreHeader`, `horairesDebutCommandes`, `horairesFinCommandes`, `service`, `modeEvent`) VALUES
(1, 'Par\'MI\'Giano', '12:00:00', '13:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `planning`
--

CREATE TABLE `planning` (
  `idInscription` int(11) NOT NULL,
  `poste` int(11) NOT NULL COMMENT '0 : Devant\r\n1 : Derrière\r\n2 : Transit\r\n3 : Courses Match',
  `date` date NOT NULL,
  `idUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `planning`
--

INSERT INTO `planning` (`idInscription`, `poste`, `date`, `idUtilisateur`) VALUES
(3, 0, '2025-05-22', 317),
(6, 2, '2025-05-15', 210),
(12, 3, '2025-05-15', 230),
(14, 2, '2025-05-16', 244),
(16, 1, '2025-05-16', 156),
(17, 3, '2025-05-16', 152),
(18, 3, '2025-05-12', 152),
(19, 0, '2025-05-14', 317),
(20, 1, '2025-05-14', 215),
(21, 3, '2025-05-14', 185),
(22, 2, '2025-05-14', 162),
(23, 0, '2025-05-14', 91),
(24, 0, '2025-05-13', 153),
(25, 1, '2025-05-13', 178),
(27, 3, '2025-05-22', 182);

-- --------------------------------------------------------

--
-- Table structure for table `salleEtSecurite`
--

CREATE TABLE `salleEtSecurite` (
  `idReleve` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0 : Relevé de température\n1 : Relevé de nettoyage',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `temperature1` float NOT NULL,
  `temperature2` float NOT NULL,
  `idUtilisateur` int(11) NOT NULL COMMENT 'Pour identifier le membre ayant effectué le relevé',
  `commentaire` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salleEtSecurite`
--

INSERT INTO `salleEtSecurite` (`idReleve`, `type`, `date`, `temperature1`, `temperature2`, `idUtilisateur`, `commentaire`) VALUES
(4, 0, '2025-05-15 07:18:22', 3.5, 2, 244, NULL),
(5, 0, '2025-05-15 07:18:33', 7.5, 3, 244, NULL),
(6, 0, '2025-05-15 07:23:03', 4.9, 6.9, 244, NULL),
(7, 1, '2025-05-15 07:23:15', 0, 0, 244, '2nd Test de text '),
(8, 0, '2025-05-15 09:53:40', 2, 6, 244, NULL),
(9, 0, '2025-05-15 09:53:48', 5, 3, 244, NULL),
(10, 0, '2025-05-15 09:54:02', 3, 5.5, 244, NULL),
(11, 0, '2025-05-15 09:54:31', 3.5, 3, 244, NULL),
(12, 0, '2025-05-19 11:51:05', 3, 4, 244, NULL),
(13, 0, '2025-05-19 13:55:58', 0, 0, 244, NULL),
(14, 0, '2025-05-19 13:57:19', 3, 5, 244, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `idElement` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `categorieElement` int(11) NOT NULL,
  `numeroLot` text NOT NULL,
  `datePeremption` date NOT NULL,
  `nombrePortions` int(11) NOT NULL,
  `dateOuverture` date NOT NULL,
  `dateFermeture` date NOT NULL,
  `etat` int(11) NOT NULL DEFAULT 0 COMMENT '0 : Fermé\n1 : Ouvert\n2 : Périmé'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`idElement`, `nom`, `categorieElement`, `numeroLot`, `datePeremption`, `nombrePortions`, `dateOuverture`, `dateFermeture`, `etat`) VALUES
(1, 'Tomates', 0, 'A123', '2025-06-01', 20, '2025-05-01', '0000-00-00', 1),
(2, 'Mozzarella', 0, 'B456', '2025-07-15', 10, '0000-00-00', '0000-00-00', 0),
(3, 'Pâtes', 0, 'C789', '2026-01-01', 50, '2025-05-10', '0000-00-00', 1),
(4, 'Basilic', 0, 'D012', '2025-05-20', 5, '0000-00-00', '0000-00-00', 2),
(5, 'Poulet', 0, 'E345', '2025-05-25', 15, '2025-05-05', '2025-05-10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tresorerie`
--

CREATE TABLE `tresorerie` (
  `idElementTresorerie` int(11) NOT NULL,
  `date` date NOT NULL,
  `contenuCaisse` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `promo` int(11) NOT NULL DEFAULT 70,
  `solde` float NOT NULL DEFAULT 0,
  `acces` int(11) NOT NULL DEFAULT 0,
  `mdp` text NOT NULL,
  `numeroCompte` int(11) NOT NULL,
  `roue` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `nom`, `prenom`, `email`, `promo`, `solde`, `acces`, `mdp`, `numeroCompte`, `roue`) VALUES
(1, 'MARCHAND', 'Clément', 'clement.marchand@student.junia.com', 65, 0.2, 0, '', 1, 0),
(2, 'IERA', 'Tanguy', 'tanguy.iera@student.junia.com', 64, -3.3, 0, '$2y$10$QBy2Czb.5dvLh8CPtgAeG.gq5su8umVx3Spzl2/N3uMmrs1X3SyM6', 552, 0),
(3, 'DI LENARDA', 'Oscar', 'oscar.di lenarda@student.junia.com', 64, -3, 0, '', 306, 0),
(4, 'AMELINCK', 'Fabien', 'fabien.amelinck@student.junia.com', 64, 0, 0, '', 307, 0),
(5, 'MULLER', 'Axel', 'axel.muller@student.junia.com', 64, -1.6, 0, '', 308, 0),
(6, 'SOUDANT', 'Maxime', 'maxime.soudant@student.junia.com', 64, 0, 0, '', 328, 0),
(7, 'ODOKINE', 'Antoine', 'antoine.odokine@student.junia.com', 64, -3, 0, '', 329, 0),
(8, 'VERNEZ', 'Hugo', 'hugo.vernez@student.junia.com', 64, 11.1, 0, '', 331, 0),
(9, 'COULON', 'Célia', 'celia.coulon@student.junia.com', 64, -3, 0, '', 348, 0),
(10, 'DEKNUYT', 'Martin', 'martin.deknuyt@student.junia.com', 64, 0, 0, '', 349, 0),
(11, 'TINEL', 'Nicolas', 'nicolas.tinel@student.junia.com', 64, 0, 0, '', 350, 0),
(12, 'STOCK', 'Thibault', 'thibault.lallemant-stock@student.junia.com', 64, 0, 0, '$2y$10$8z5cVqr/tCTGX.DylenTlOwJkxMZBN9NGC4ICMVKBpZQFkdQRIVcC', 351, 0),
(13, 'THIBAUT', 'Elisée', 'elisee.thibaut@student.junia.com', 64, 0, 0, '', 363, 0),
(14, 'CURILLI', 'Yann', 'yann.curilli@student.junia.com', 64, -3.3, 0, '', 367, 0),
(15, 'DUMONT', 'Thomas', 'thomas.dumont@student.junia.com', 64, 3.3, 0, '', 371, 0),
(16, 'BOIZARD', 'Nicolas', 'nicolas.boizard@student.junia.com', 64, -1.6, 0, '', 372, 0),
(17, 'LUCAS', 'Valentin', 'valentin.lucas@student.junia.com', 64, 7.8, 0, '', 373, 0),
(18, 'WAULTRE', 'Paul', 'paul.waultre@student.junia.com', 64, 0, 0, '$2y$10$XyTHjLyIuKMQGKwC9/nq4OfEBBlDdkhHpPF9lUXriQBeiGkfWGhYm', 375, 0),
(19, 'LUCAS', 'Sasha', 'sasha.lucas@student.junia.com', 64, -0.1, 0, '', 379, 0),
(20, 'LERMYTTE', 'Clement', 'clement.lermytte@student.junia.com', 64, 1.9, 0, '', 381, 0),
(21, 'VANDEMOORTELE', 'Alexis', 'alexis.vandemoortele@student.junia.com', 64, -1.4, 0, '', 384, 0),
(22, 'MARLIOT', 'Paul', 'paul.marliot@student.junia.com', 65, -1.5, 0, '', 387, 0),
(23, 'DELOBELLE', 'Théo', 'theo.delobelle@student.junia.com', 64, -1.7, 0, '', 388, 0),
(24, 'SMOLAREK', 'Philipe', 'philipe.smolarek@student.junia.com', 64, 0, 0, '', 391, 0),
(25, 'MANOUVRIEZ', 'Louis', 'louis.manouvriez@student.junia.com', 65, 0, 0, '', 392, 0),
(26, 'THILLOU', 'Angele', 'angele.thillou@student.junia.com', 65, 0, 0, '$2y$10$Mcaf9yS5gBh1Y22P5XmlKulU5L59P/IpZ7wk0LJsegxRkUwwY5VpC', 394, 0),
(27, 'DESAVIS', 'Clément', 'clement.desavis@student.junia.com', 65, -2.4, 0, '', 427, 0),
(28, 'VANDERHAEGEN', 'Hugo', 'hugo.vanderhaegen@student.junia.com', 64, 0, 0, '', 428, 0),
(29, 'VERMERSCH', 'Louis', 'louis.vermersch@student.junia.com', 65, -4.6, 0, '', 431, 0),
(30, 'CANTAIS', 'Dolyan', 'dolyan.cantais@student.junia.com', 64, 0, 0, '', 434, 0),
(31, 'VIEILLARD', 'Louis', 'louis.vieillard@student.junia.com', 64, -0.3, 0, '', 439, 0),
(32, 'FOURNET', 'Antoine', 'antoine.fournet@student.junia.com', 65, 0.2, 0, '$2y$10$VQswX.yCUvSG7WR1ZZuYSupzm/nTPbDZ.EkpIjhDaWfDKy9hn1z.2', 441, 0),
(33, 'BEHAGUE', 'Antonin', 'antonin.behague@student.junia.com', 64, 0.2, 0, '', 444, 0),
(34, 'BLANCO', 'Anthony', 'anthony.blanco@student.junia.com', 64, 7.4, 0, '', 445, 0),
(35, 'SPINNEWYN', 'Florian', 'florian.spinnewyn@student.junia.com', 65, 0, 0, '$2y$10$nxca.mxLSljXXaR56vtAUeDd1BheA.4mHY5vbfwUTMpf8QVzpDJea', 446, 0),
(36, 'CHEVALIER', 'Marc', 'marc.chevalier@student.junia.com', 64, -0.8, 0, '', 447, 0),
(37, 'FAVREL', 'Tristan', 'tristan.favrel@student.junia.com', 64, 0, 0, '', 451, 0),
(38, 'MAREEL', 'Adrien', 'adrien.mareel@student.junia.com', 65, 0, 0, '$2y$10$VoGlmX3d.hqjy8FzmVG/Z.rU3B2i7Fewcwq/LqPLkBvbtAfMgHPni', 452, 0),
(39, 'BERNARD', 'Geoffrey', 'geoffrey.bernard@student.junia.com', 64, 2, 0, '', 454, 0),
(40, 'BOUSSEMART', 'Charles', 'charles.boussemart@student.junia.com', 64, 0, 0, '$2y$10$km1v3UgvFbkRCUYcI7U5su167dUDmBQvKEgwj8eqY7iBdN15RGBZW', 455, 0),
(41, 'TRASSAERT', 'Marion', 'marion.trassaert@student.junia.com', 64, 0.8, 0, '', 457, 0),
(42, 'ROUAIX', 'Julien', 'julien.rouaix@student.junia.com', 64, 1.1, 0, '$2y$10$Zj6ULEkMCS1mHWcxNubEr.mTkvA5F.04gmpFkS36CttjMTPZhySLm', 458, 0),
(43, 'DESMEDT', 'Lou', 'lou.desmedt@student.junia.com', 64, 0.1, 0, '$2y$10$2pu0mFSP3OW/JONLLjC3W.L9UD0z1kKdzsFHVy94xCZYdf89YPZFK', 460, 0),
(44, 'DUPUIS', 'Maxence', 'maxence.dupuis@student.junia.com', 64, -7.1, 0, '$2y$10$6mEotjaZnyu7qtcEXBb5gOQbdTdkO/DdYb4OWTwfEv34WgsTpCpOK', 461, 0),
(45, 'DESEURE', 'Louis', 'louis.deseure@student.junia.com', 64, -1.1, 0, '$2y$10$jNJIfzBYzrjmKm4teKUhTuEsFA7LVSiJhFZrEEZcAAMscuHmnq3O.', 462, 0),
(46, 'GUILLEMOT', 'Esther', 'esther.guillemot@student.junia.com', 64, 5.5, 0, '', 463, 0),
(47, 'BERRO', 'Wael', 'wael.berro@student.junia.com', 64, -0.8, 0, '', 464, 0),
(48, 'PONTOIS', 'Paul', 'paul.pontois@student.junia.com', 64, 3.3, 0, '', 465, 0),
(49, 'KALLEL', 'Cyrine', 'cyrine.kallel@student.junia.com', 64, 0, 0, '', 466, 0),
(50, 'SFILIGOÏ', 'Oscar', 'oscar.sfiligoï@student.junia.com', 64, 1.3, 0, '', 469, 0),
(51, 'BOULAY', 'Martin', 'martin.boulay@student.junia.com', 64, -2, 0, '', 473, 0),
(52, 'DEBUF', 'Garance', 'garance.debuf@student.junia.com', 64, 0, 0, '', 474, 0),
(53, 'FAGOT', 'Arthur', 'arthur.fagot@student.junia.com', 65, 0.02, 0, '$2y$10$JrYJdJGhHLasgMNvpmnzAuFRn8VD68cafLi5C6HTiADXO9UvJj3Ge', 475, 0),
(54, 'MULET', 'Victor', 'victor.mulet@student.junia.com', 64, 0, 0, '', 476, 0),
(55, 'FESARD', 'Thomas', 'thomas.fesard@student.junia.com', 65, 1.16, 0, '$2y$10$GvtwL.430nXN9PF9BbRDteEDai4TBIavMFWxKRAn0wlaRNwo9LCVy', 477, 0),
(56, 'BLONDEAU', 'Loïc', 'loic.blondeau@student.junia.com', 65, 6.4, 0, '$2y$10$2v9sdsZbsXah94gP2Z0QaeIjj0t0ZOroxLaCWe5PSzb27DBMKtXYC', 478, 0),
(57, 'NOIRON', 'Sebastien', 'sebastien.noiron@student.junia.com', 64, 0, 0, '$2y$10$p8XPZAmmFH.ITMQhkliY6e76r4D1gRAakdlvMn8i3pvp.jJOEELPy', 479, 0),
(58, 'BOCQUET', 'Corentin', 'corentin.bocquet@student.junia.com', 66, 1.8, 1, '$2y$10$PcB6MRjaqn3Rircsgto7pOptfeUYNo4Qt55w01Fh8cVqpiOJGCn6G', 480, 0),
(59, 'RONDOUX', 'Théo', 'theo.rondoux@student.junia.com', 65, 0.71, 0, '$2y$10$VBFtBOTjNstKGhKOtBWIJ.RERmAcxqpxR5GDJXmjUEu.33qU2Pdsu', 481, 0),
(60, 'DENOULET', 'Corentin', 'corentin.denoulet@student.junia.com', 65, 0, 0, '$2y$10$b6CEjdhGc9Juqx6NVgD3t.MUWV4qOFfgyuvOObGI8dJikURhBoEKC', 482, 0),
(61, 'VANDUYNSLAEGER', 'Victor', 'victor.vanduynslaeger@student.junia.com', 65, 13.31, 0, '$2y$10$DCvjIZKMj.hnYKstSIOuQelta19ZBtV6Nh5m3pT9MpKes/Gph3cSS', 483, 0),
(62, 'SERLOOTEN', 'Côme', 'come.serlooten@student.junia.com', 64, 0, 0, '', 485, 0),
(63, 'LACOMBLEZ', 'Léa', 'léa.lacomblez@student.junia.com', 64, -1.6, 0, '', 486, 0),
(64, 'HER', 'Bastien', 'bastien.her@student.junia.com', 65, -0.3, 0, '', 487, 0),
(65, 'BOCHU', 'Axel', 'axel.bochu@student.junia.com', 67, 3.2, 0, '$2y$10$V.NbZ8jAI2g8rF0jM3WnruNy8dYVImXNyUsF6nhZ/n7W8RBYBsaTq', 488, 0),
(66, 'BARGE', 'Paul', 'paul.barge@student.junia.com', 67, 0.3, 0, '$2y$10$9iJR6Vl2FKYA0aGUUM5Rc.m5mNy6aUzBqZmLVfh0/hx8Tyo0to8VC', 489, 0),
(67, 'SERRURE', 'Agnès', 'agnes.serrure@student.junia.com', 64, 7, 0, '$2y$10$KfbuOH/jrE8w.HIYeVYq2uqdXJYE6vEcq8J0dJAL1yjcRzmHpWP4S', 491, 0),
(68, 'MOHAMED', 'Tilal', 'tilal.mohamed@student.junia.com', 67, -3, 0, '', 492, 0),
(69, 'SAID ALI', 'Mourwa', 'mourwa.said ali@student.junia.com', 67, 0, 0, '', 493, 0),
(70, 'DEBEVE', 'Axel', 'axel.debeve@student.junia.com', 64, -3.8, 0, '', 494, 0),
(71, 'HOULLEGATTE', 'Edouard', 'edouard.houllegatte@student.junia.com', 64, -1.2, 0, '', 496, 0),
(72, 'EL OUARDIGHI', 'Walid', 'walid.el ouardighi@student.junia.com', 64, 0, 0, '', 497, 0),
(73, 'DUPARCQ', 'Hakim', 'hakim.duparcq@student.junia.com', 64, 5.7, 0, '', 498, 0),
(74, 'BLONDEL', 'Adeline', 'adeline.blondel@student.junia.com', 67, 0, 0, '', 499, 0),
(75, 'LAMOURET', 'Florine', 'florine.lamouret@student.junia.com', 64, 0.4, 0, '$2y$10$/H8fcTCsid2sXiTQSfzlm.ElPYtrM9cvqmUi9zZKHMN7tfoK2fB7O', 500, 0),
(76, 'BRELLE', 'Paul', 'paul.brelle@student.junia.com ', 65, -0.08, 0, '$2y$10$autzr6jnhcx78tpkIPMGo.2IE.zzPCubkS6ZCePYisi5dn3zt2gKi', 502, 0),
(77, 'FREVAL', 'Maxence', 'maxence.freval@student.junia.com', 65, 0, 0, '$2y$10$BTC0b8bhRjNypTPdpx1Ss.YSwKjfOIjRxCsXvxzFvBQw7ucuI8yh.', 503, 0),
(78, 'DUCROCQ', 'Louis', 'louis.ducrocq@student.junia.com', 65, 4.7, 0, '$2y$10$BOD8wfCFXO3TIbpdW9oNlOYnONSGskQ6Tl/cV.vQylS4Hh0GnQjQO', 504, 0),
(79, 'JASPART', 'Pauline', 'pauline.jaspart@student.junia.com', 65, 0, 0, '$2y$10$maeUrkjCidPuS9milUIY9e8BCe4Cg1AhhgyNiupaIqF.Nrr9yW17m', 506, 0),
(80, 'ALBERT', 'Line', 'line.albert@student.junia.com', 65, 0, 0, '$2y$10$tPRJvJ19l2pkCpancp4jK.WvLym6JAvQHu7VrNcJEAEP0rVdsWWUO', 507, 0),
(81, 'MICOTTIS', 'Tom', 'tom.micottis@student.junia.com', 65, 0, 0, '$2y$10$WAldlUo5ohPpSlO59ZH5..N3dBZnG/sBoU8FLmD3undAMMziyUD3u', 508, 0),
(82, 'POLVENT', 'Balthazar', 'balthazar.polvent@student.junia.com', 65, 5.4, 0, '$2y$10$xISKqvPGKFf0EqRGoJKkUec9xcxAp6FqYceO6DsFSseomviKCFFxK', 509, 0),
(83, 'BOULNOIS', 'Constant', 'constant.boulnois@student.junia.com', 65, -1.1, 0, '$2y$10$.Johv/1cbUWLQiiBbx9Hd.9nj98GYPtNwTUr03B8DaZZsqxYubHq2', 511, 0),
(84, 'DEMAY', 'Cléo', 'cleo.demay@student.junia.com', 65, 0, 0, '$2y$10$IQW3Szy2PA0igfVG75.2xuKJNo6NKEecTqVsIc6ufJQP.M11prTn.', 512, 0),
(85, 'GORGOL', 'Axandre', 'axandre.gorgol@student.junia.com', 64, 0, 0, '', 513, 0),
(86, 'ROELANDTS', 'Marie', 'marie.roelandts@student.junia.com', 64, 0.2, 0, '', 514, 0),
(87, 'POLEDRI', 'Axel', 'axel.poledri@student.junia.com', 65, 0.8, 0, '$2y$10$/sL8Rokr2AsXBYlBWG11HeghDVFy7an0ft9IuzhoqDsfcAmDXXDsu', 515, 0),
(88, 'DEMNATI', 'Lamia', 'lamia.demnati@student.junia.com', 65, -1.1, 0, '$2y$10$8IzXX6gV.ezvKY7enQ4ple/YQFWCxmGz8R0/FJ0nTB76wDRAwyCO6', 516, 0),
(89, 'CONRY', 'Mattéo', 'matteo.conry@student.junia.com', 65, 2.1, 0, '$2y$10$ZiHpUMLP0MPW2vqTmomC/OzrY6O5GrHEf/Yvof0nAv2fPkegebmd6', 517, 0),
(90, 'MULLIER', 'Tom', 'tom.mullier@student.junia.com', 66, 0, 0, '$2y$10$Xbf6xZZ0oemNPwQ7gk.5TefwMwK8kDXw80jqawMX5nxBzVt/yGBRi', 518, 0),
(91, 'BENSLAMA', 'Ilies', 'Ilies.benslama@student.junia.com', 65, -3, 1, '$2y$10$HyPdJbadFOaDZtNIy6ZGeuXlwUxeZ9fAbEqkuzJ/5iwRMm25uQEEO', 519, 0),
(92, 'KLEIN', 'Baptiste', 'baptiste.klein@student.junia.com', 65, -0.6, 0, '$2y$10$mMLLzgrclu4xThrxR1ezCePM35liDNWeGigGrKBDonoOwZmy7EF9O', 520, 0),
(93, 'MARCHAL', 'Clément', 'clement.marchal@student.junia.com', 64, -3.3, 0, '$2y$10$/clmxgjZLESnLHItDpi.0..UTuT7RJA4e/dvql/vS9ivl4ea0OUUm', 521, 0),
(94, 'POURRIER', 'Arthur', 'arthur.pourrier@student.junia.com', 64, -2.5, 0, '$2y$10$uuXF5pAQRwoQA7XNryMuuenp2XR.7INMKGcQKgQeDVyJR6JVkMGBe', 522, 0),
(95, 'D\'HARCOURT', 'François', 'francois.dharcourt@student.junia.com', 65, 4.2, 0, '$2y$10$XTkY2rqMKXZrKhwncQg85Opq3Tvl.WHWeWxju2UXhq7DHFJJraHj6', 523, 0),
(96, 'CORNU', 'Emile', 'emile.cornu@student.junia.com', 66, 0, 0, '$2y$10$pItCxKosORJdxBxG1vepnOaycEBmzuJ.3SlyrrSI6GYZZ9TEjTKzG', 524, 0),
(97, 'KADDOURI', 'Abberzak', 'abberzak.kaddouri@student.junia.com', 64, -1.6, 0, '', 525, 0),
(98, 'DERUY', 'Thomas', 'thomas.deruy@student.junia.com', 64, 0.3, 0, '', 526, 0),
(99, 'DUPAS', 'Noah', 'noah.dupas@student.junia.com', 64, 0.6, 0, '', 527, 0),
(100, 'MOUQUET', 'Quentin', 'quentin.mouquet@student.junia.com', 64, 0.2, 0, '', 528, 0),
(101, 'BOUBERT', 'Louis', 'louis.boubert@student.junia.com', 65, 3.7, 0, '$2y$10$cxkN.FpF8Fj9Fm7xTfg0IeL8DxTIj0cvGzu8l.JBZC3SckXU5eWAa', 530, 0),
(102, 'KENOUZ', 'Abdelghani', 'abdelghani.kenouz@student.junia.com', 65, -8.7, 0, '', 531, 0),
(103, 'DUBUS', 'Julien', 'julien.dubus@student.junia.com', 65, 5.7, 0, '$2y$10$pcfYp74dXQIzuIHOCLzlxOE0T1THkVlywZUc0qIKwS.zUIh9etldS', 532, 0),
(104, 'BELYAZID ', 'Samuel', 'samuel.belyazid@student.junia.com', 65, 3.1, 0, '$2y$10$x3/s5Xn1Mw9UwpqKX5mOkuneXHT/aIXAt3Gkhxy39oJDiP8i/Xbpy', 533, 0),
(105, 'PETIT', 'Sarah', 'sarah.petit@student.junia.com', 65, 0.1, 0, '$2y$10$P40pWhmPw6WqAWFbLeqpceZ/A6kxa5yFcFUiggX.XLa94CfW4lP3S', 534, 0),
(106, 'DELAPORTE', 'Théo', 'theo.delaporte@student.junia.com', 65, 0.22, 0, '$2y$10$lMFfRh5Dw/wymeqj9kHp5e3zyvhUVjxqM63iV2z7yIGL7ONrTBpdO', 536, 0),
(107, 'CAPELLE', 'Martin vip', 'martin.capelle@student.junia.com', 65, 7, 1, '$2y$10$l91ohts.hb1iL26mYXy5he5pet.QG2U9f14OsQ6qwKIKF88gBHfAW', 537, 0),
(108, 'VAN HONACKER', 'Lexi', 'lexi.van honacker@student.junia.com', 65, -3, 0, '', 538, 0),
(109, 'BAUM', 'Louise', 'louise.baum@student.junia.com', 64, 4.7, 0, '', 539, 0),
(110, 'MAZURE', 'Pierre', 'pierre.mazure@student.junia.com', 65, 5.7, 0, '$2y$10$srR6j1N5S62HrZB/Wc.FJO/nu33NAHTm4Vaxu1rCPiVp545W1hefq', 540, 0),
(111, 'DUHAMEL', 'Florian', 'florian.duhamel@student.junia.com', 65, 9, 0, '', 541, 0),
(112, 'DEFFRENNES', 'Armand', 'armand.deffrennes@student.junia.com', 65, 3.5, 0, '$2y$10$nMfmHvo2SSwjcm6bmEYhgeOarX5K2svB9.dA0Uc0dYOvdJ4zA59jm', 542, 0),
(113, 'LALLART', 'Anya', 'anya.lallart@student.junia.com', 67, -2.29, 2, '$2y$10$kBBoN2IX3xgrSIyalU2b1OkmXrvre82ttpcmQB/BVag0Oi5yG3IYS', 543, 0),
(114, 'PIETRI', 'Romain', 'romain.pietri@student.junia.com', 67, -0.6, 0, '$2y$10$NpjScs4Mhnx780uw9c3HPeIT9Au71.lejXKykGTUecRC8BxplPq/K', 544, 0),
(115, 'MAVET', 'Valentin', 'valentin.mavet@student.junia.com', 65, 0, 0, '$2y$10$xNrwuMGGUBx4.WZIm0dvt.VDCLOF0phKwkW2v2ra7nw09Oxym9h5u', 545, 0),
(116, 'DELERUE', 'Paul', 'paul.delerue@student.junia.com', 67, 0, 0, '', 546, 0),
(117, 'DEPREZ', 'Alexandre', 'alexandre.deprez@student.junia.com', 66, 0, 0, '$2y$10$bs8torq0ZaFbNxZ87BXvouiAzG7oYLBq5452c21k8VAYMukHlo2BK', 547, 0),
(118, 'HAEGMAN', 'Maxence', 'maxence.haegman@student.junia.com', 65, 2.5, 0, '$2y$10$MoUMxOmfegrvszFtGDIdb.Vs9k0vvAhrVppSWd7qi8nXPqllBZVFu', 549, 0),
(119, 'LEPERS', 'Alban', 'alban.lepers@student.junia.com', 65, -5.6, 0, '$2y$10$hSsm1ggg7i3ez9tOYxdj4.pqoAsRlF9IA0QgpwvcwnB072XSkttdi', 550, 0),
(120, 'DELRUE', 'Logan', 'logan.delrue@student.junia.com', 65, -0.1, 0, '$2y$10$J2ZLmOgj6155iHqFnk2rEOy6ajYokrYkEr5i3oO/raFN3dGAMMJre', 551, 0),
(121, 'DUFOUR HOOFD', 'Zelie', 'zelie.dufour-hoofd@student.junia.com', 65, 0, 0, '$2y$10$.r2k5jWgCAfX3ebnrJwEsO4ZRMT2r2rcw1E86NpDroOQxoePh9qW6', 553, 0),
(122, 'PARMENTIER', 'Perrine', 'perrine.parmentier@student.junia.com', 65, 1.6, 0, '$2y$10$aSVtGU2TF96m0XUEVgj0J.5wkjrfS/ldrnEzTAhpKbOZpOshWGF.i', 554, 0),
(123, 'GILLARD', 'Gabriel', 'gabriel.gillard@student.junia.com', 65, -0.8, 0, '', 555, 0),
(124, 'BUCHWALD', 'Albane', 'albane.buchwald@student.junia.com', 65, 1.4, 0, '$2y$10$0wykg18Zoa7DALxI75Fvcu8rZDaZeINO6zSxJ4FAe3ZaZSxvSUoJi', 556, 0),
(125, 'MACKOVIAK', 'Leo', 'leo.mackoviak@student.junia.com', 65, 3.9, 0, '', 557, 0),
(126, 'DELEHONTE', 'Aymeric', 'aymeric.delehonte@student.junia.com', 65, 0, 0, '', 558, 0),
(127, 'DEFOUG', 'Pierre-louis', 'pierre-louis.defoug@student.junia.com', 65, -1.8, 0, '', 559, 0),
(128, 'JEAN DE DIEU', 'Swan', 'swan.jean-de-dieu@student.junia.com', 65, 0.4, 0, '$2y$10$lpD.hKDHHeBi6KAoironKevjJj.9FaKbKtugemDGA1ax81mREskEu', 560, 0),
(129, 'ZHOU', 'Lucas', 'lucas.zhou@student.junia.com', 65, 1, 0, '$2y$10$VEQxY8I.zvEgvLgZKJHqPOu/8tyupc8XzY6rKynKHAt3jVDbZy2xm', 561, 0),
(130, 'PETIT', 'Clément', 'clément.petit@student.junia.com', 65, 4.1, 0, '', 562, 0),
(131, 'DELZENNE', 'Mattéo', 'matteo.delzenne@student.junia.com', 65, 11.2, 0, '$2y$10$xCjC5J2krco46FM/v.eLSOKnDjp4L7tyer5xzWczOtNNgBeJbwOQy', 563, 0),
(132, 'HENSGEN', 'Louis', 'louis.hensgen@student.junia.com', 65, 0.3, 0, '$2y$10$Z48uKcrpifDM/ya8YzSaE.KFY7d8AK7r/anbBUBsJ1qIba2KSCTMa', 564, 0),
(133, 'DESMYTTERE', 'Matthieu', 'matthieu.desmyttere@student.junia.com', 65, 0, 0, '$2y$10$kO8e8nNvsL9M2C0KqvkbsO./hZOq0TtG5.JHbRI0mjcBss6vBWyNm', 565, 0),
(134, 'BATTUT', 'Matteo', 'matteo.battut@student.junia.com', 65, -1.6, 0, '$2y$10$F3IrFGlrTN7KYHGziH/um.YokkunWWwxYE2bGh9WyyTqDte..nGfa', 566, 0),
(135, 'ESCAFFRE', 'Nathan', 'nathan.escaffre@student.junia.com', 65, 4.8, 0, '$2y$10$TewJhIZMA1DzX7.XgDY8cOMgnrD9H8VV/5vOLl1ci3DrvtBCE4Xhm', 567, 0),
(136, 'GONNET', 'Charles ', 'charles.gonnet@student.junia.com', 66, 0.5, 0, '', 570, 0),
(137, 'ADAM', 'Arthur', 'arthur.adam@student.junia.com', 65, -5, 0, '', 571, 0),
(138, 'MARQUANT', 'Enguerrand', 'enguerrand.marquant@student.junia.com', 65, 0, 2, '$2y$10$kMFCD4zqo7IBMPST7u5XWuaWcjPzkBIEUdQ0whPFJZgG4Nlv2HLuO', 606, 0),
(139, 'VILLAIN', 'Pierre', 'pierre.villain@student.junia.com', 65, 2.4, 0, '', 573, 0),
(140, 'HUL', 'Alexis', 'alexis.hul@student.junia.com', 65, 4.77, 0, '$2y$10$UhvPGsojw33CVp8bGaCW..IxWL4/JVpkIT34Q7ISn5MoNS.Oe80VW', 574, 0),
(141, 'LEDUC', 'Xavier', 'xavier.leduc@student.junia.com', 66, 1, 0, '$2y$10$petRR/12NiC8ppIIyZs3Q.jI9AygY9Cg0k4j5hxnl..900bpMibvS', 575, 0),
(142, 'DELCOURT', 'Arnaud', 'arnaud.delcourt@student.junia.com', 65, 0, 0, '$2y$10$6ETv3H/LlSkv6lXlDNijGOdygWV5X1PX4SbAfgc8ZhIQrU5Z0FX8q', 576, 0),
(143, 'DUMAS', 'Vincent', 'vincent.dumas@student.junia.com', 65, 0, 0, '$2y$10$a8pIY4HGMVHoH2Hga63b..RIWySwb.rLThDPdBq4Kg98xu.mBJw3W', 577, 0),
(144, 'JAMELOT', 'Maxime', 'maxime.jamelot@student.junia.com', 65, -0.1, 0, '$2y$10$BkBbKW0VI.FXfIaD9ahcUewPaFnsZcBn5BVMTOth0rWV.Gh0SRxxy', 578, 0),
(145, 'LORIDAN', 'Victor', 'victor.loridan@student.junia.com', 65, -2.9, 0, '$2y$10$VHvON69I/nd0bEFnYbUi8.I880cd58EnkBM6J9E/stklT6CWYeF2S', 579, 0),
(146, 'SAVRE', 'William', 'william.savre@student.junia.com', 66, 0.4, 0, '$2y$10$pV.c/zcy9ACKdyCsAiGNPehgf4KJBwTLkaGKjda.39mGmKZeR5POS', 580, 0),
(147, 'VILARINHO PARRAIN', 'Fabio', 'fabio.vilarinho@student.junia.com', 68, 0.7, 0, '$2y$10$VgSoKEVEm.GVcfolYm.kSOCkJ7EMf/Czs29mypQb7rFSJxXZXYKwO', 581, 0),
(148, 'DELOBEL', 'Aurélien', 'aurelien.delobel@student.junia.com', 65, 2.5, 0, '', 582, 0),
(149, 'MORCHAIN', 'Alexis', 'alexis.morchain@student.junia.com', 68, 0, 2, '$2y$10$pklopZs9N9E/v1r4DWhYy.anVi2bMhLTBJK/wBJ6bGKYEWjsMW9xm', 583, 0),
(150, 'VANDEVOIR', 'Victor', 'victor.vandevoir@student.junia.com', 68, 1.6, 2, '$2y$10$Sck9P8nngd12ZCkXdCDZ4Oz3PtwjV.E8B1k22xMaaV/4ojQOJg/li', 584, 0),
(151, 'POTEL', 'Cyriaque', 'cyriaque.potel@student.junia.com', 68, 0, 0, '$2y$10$bQUy/KIPBGakWyYLL/Dz2eJHkqXZkMOm4fRct0UxlSI7V6gsgXXjC', 585, 0),
(152, 'LE-ROUX ZIELENSKI', 'Sasha', 'sasha.le-roux-zielinski@student.junia.com', 68, 0, 3, '$2y$10$jDyZ.Mj1tF6Sty1MF/nGYupGcdH1oR2GtakENX.n5/8s7bMjorkxS', 586, 0),
(153, 'LAMBERT', 'Edouard', 'edouard.lambert@student.junia.com', 67, 19.16, 2, '$2y$10$O/EQ.7TFQRmdUO8S/wiiuO5noheB37j3RW3gmo5iKvf1scgXzysiu', 587, 0),
(154, 'COMPTE TEST', 'Lalala', 'fabio.leparrain@student.junia.com', 68, 0, 0, '', 588, 0),
(155, 'PHILLIPE', 'Lou', 'lou.phillipe@student.junia.com', 65, 0, 0, '', 589, 0),
(156, 'MAERTE', 'Alixe', 'alixe.maerte@student.junia.com', 67, 0, 1, '$2y$10$PvXekXpw0sGzvvV9svNEauRfYx6I0RR.2u.f8Soi1Pni/BYa5FsIa', 590, 0),
(157, 'TONNERRE', 'Cyriaque', 'cyriaque.tonnerre@student.junia.com', 67, 0, 2, '$2y$10$2iI2XFIrk6moL0DEvVwbuuH05oJdpYduPmtAEC6tVk/wW6v0hc3m6', 591, 0),
(158, 'LIBERT', 'Baptiste', 'baptiste.libert@student.junia.com', 67, -1.2, 2, '$2y$10$D2BjsStA.Tg3g24mCzhR8eyofjCHF/qI4WT4RV1zHOxmPrPv9c5um', 600, 0),
(159, 'OUCHENE', 'Yanis', 'yanis.ouchene@student.junia.com', 68, -4.2, 2, '$2y$10$BfSyiWbFOdg.xHm4/SUxqeFRfxvnfZebCY4trUBljL2fWDeEXzk9S', 623, 0),
(160, 'BOSSUT', 'Siméon', 'simeon.bossut@student.junia.com', 68, 3.2, 2, '$2y$10$1MMqgOo39W7zUhYZV6GpZuFCelbiKAqQpBrR1B76AUBa4sEFLTJOS', 625, 0),
(161, 'GUERARD', 'Mathis', 'mathis.guerard@student.junia.com', 64, -9.8, 0, '', 666, 0),
(162, 'TASSIN', 'Clément', 'clement.tassin@student.junia.com', 68, -1.44, 2, '$2y$10$/uak8DXpIDwetDI7O0ed2umJb7hlbq0UQbndbAFSSasbhZo3JJ45e', 667, 0),
(163, 'LONGATTE', 'Marc-Antoine', 'marc-antoine.longatte@student.junia.com', 67, 0, 2, '$2y$10$YkoBIMRHzClxWAHwaQCNSuq4zNzDHHT.bTlbDP2sCUKsLWucyV/jO', 669, 0),
(164, 'DROULERS', 'Aymeric', 'aymeric.droulers@student.junia.com', 68, 8.4, 0, '$2y$10$XWjBZp5lyGJiXJwz6hIeP.xmcBxtypGdKagMQzomskxJVezMFr9r6', 670, 0),
(165, 'SAUNIER', 'Hugo', 'hugo.saunier@student.junia.com', 67, 9.6, 0, '$2y$10$B6SjBHzEm0PQjo6ObU7zLO8VVRaJZ92DD7QojL8newl2ZW1wX7tLW', 671, 0),
(166, 'FERJAULT', 'Arthur', 'arthur.ferjault@student.junia.com', 65, 8.2, 0, '$2y$10$U/bAKfBYDtAb2aZwIi6WyOY7xnH/Kg/S1grMwR7qspyXBlX/qQ5te', 680, 0),
(167, 'BAILLIEU', 'Arthur', 'arthur.baillieu@student.junia.com', 65, -1.3, 0, '$2y$10$KRp.hTgoHV.81ZAh.v.cW.G7MY6hGNqrISqe7JEYL6yrXe8dNfUGm', 696, 0),
(168, 'MATHON', 'Mathys', 'mathys.mathon@student.junia.com', 67, 5.45, 2, '$2y$10$EiCQKStr6umTNQ1CvmG2JOlEvrNf9YHLBDFUNyfnNPdc8k1ei6orG', 712, 0),
(169, 'DUPIRE-MARCANT', 'Mathis', 'mathis.dupire-marcant@student.junia.com', 68, 11.95, 2, '$2y$10$hbMKsTK0.LdXNEiGNur1kOR6VLuUinToy8JPsEy7OzcErMbmojdke', 777, 0),
(170, 'BONDON', 'Théodore', 'theodore.bondon@student.junia.com', 66, 0.1, 0, '', 840, 0),
(171, 'DOUCHET', 'Antoine', 'antoine.douchet@student.junia.com', 65, -0.8, 0, '$2y$10$iZ34LhtOjmYYNMxPTUW0gu31UDm5YV7YBOK3VWfxg1yzw6YSvitty', 888, 0),
(172, 'SOCCIO', 'Roméo', 'romeo.soccio@student.junia.com', 68, 0.3, 2, '$2y$10$7O0uOp.iK2b.i/dptjH.xeqgm2A0Flo6AspXFh4RKJ7I0F7M/bnJ6', 909, 0),
(173, 'ESPRIET', 'Charles', 'charles.espriet@student.junia.com', 67, -3.3, 1, '$2y$10$sD7o1q5utGsVx1IzzFkD/uh80n6p/spzFABu5UURSrER5ixOelglK', 911, 0),
(174, 'KESTELOOT', 'Elen', 'elen.kesteloot@student.junia.com', 68, 5.5, 1, '$2y$10$CZjU.fo0MBmIRYykuq/73.8KL.wCmg2.pyZNrSKRFRolNd2bl5wtu', 969, 0),
(175, 'PORET', 'Lucas', 'lucas.poret@student.junia.com', 67, 5.64, 2, '$2y$10$ct5ijPKKs08I5Wey39nblOaywJuTtoDQZB./YEMoNZToMX1Tanuhy', 992, 0),
(176, 'DOCEUL', 'Logan', 'logan.doceul@student.junia.com', 67, -2.81, 2, '$2y$10$enFWQxFwHvLlUppHYp5w0O98/woM2pyPWfz1LJOL3qyobecFfZQnm', 996, 0),
(177, 'LOISEAU', 'Clément', 'clément.loiseau@student.junia.com', 64, 1.86, 0, '', 999, 0),
(178, 'SALAH', 'Matys', 'matys.salah@student.junia.com', 68, 0, 2, '$2y$10$0Z7kqe1YadK/0KV1kQUEfejOIck6PkFJwciPxyE9XFV6zoZhJm2MW', 1000, 0),
(179, 'BURIEZ', 'Auguste', 'auguste.buriez@student.junia.com', 67, 0, 0, '$2y$10$4RKPPpaQDMTxZxkSEzHFk.ihxGxIL7ASJ.BSCz9x4mxDZ.sWPcY3O', 5467, 0),
(180, 'DESITTER', 'Mathéo', 'matheo.desitter@student.junia.com', 68, 3, 2, '$2y$10$OOEYIOSfkqvpWIkiQ6hzFeHvzV4DImeLTG18gKmYTorvYD4hNuvUG', 967, 0),
(181, 'FELIX-FAURE', 'Henry', 'henry.felix-faure@student.junia.com', 68, -0.6, 0, '$2y$10$f5j4jZGqqb7NHyxnXp0jq.rnWv5epnzf.QRQtDOD6hsZ82S1WxIre', 69420, 0),
(182, 'ROY', 'Jules', 'jules.roy@student.junia.com', 68, 6.7, 3, '$2y$10$pdg2QLODdzwOhDLjZN14x.dT2cfqPwFh10SRRj8XfcXI09pr24BYq', 14, 0),
(183, 'CYRIAQUE', 'Tonnerre', 'test.test@student.junia.com', 67, 0, 1, '$2y$10$HmaBlIicystor4ViWORx7ulQRYs2eSVScT5.pyuaSzM5lXOqssU7C', 998, 0),
(184, 'TEST', 'Test', 'maison.ducul@student.junia.com', 65, 0, 0, '$2y$10$AkFc7NecowxyzCSusuhJoOR5bXTKKYrw7.GdTWPVTTcHOY.DF9iqW', 44, 0),
(185, 'BASSET', 'Maxime', 'maxime.basset@student.junia.com', 68, 7.1, 2, '$2y$10$XCF/fFyNjJvWGlHxKuIeU.LsqVuScVYf.5JSyJJwSwwKPZbB27P9m', 869, 0),
(186, 'MAITRE', 'Jean-baptiste', 'jean-baptiste.maitre@student.junia.com', 67, 0, 0, '$2y$10$yPJYsc8WWYYYFjp6Yxv.U.xRiq5X403yB.XlcIQKXwbBs.OYdhhNe', 268, 0),
(187, 'LOCAL', 'Mi', 'local@student.junia.com', 65, 0, 1, '$2y$10$.76HZhdtV7xhGMi0Nm4oeOIdD1MzA3ZlG91.yDV7xkNT151i1upra', 2, 0),
(188, 'DUMAS', 'Antonin', 'antonin.dumas@student.junia.com', 68, 1.83, 2, '$2y$10$RBo2gj/Jrj1TVN7hzPDeBewd3rOS/EEGVYaOv2tHfFxab/AJtjZJS', 10, 0),
(189, 'AGEZ', 'Rémy', 'remy.agez@student.junia.com', 65, -0.05, 0, '$2y$10$vBvm/azWXton6/7rUTGUruZ/jjruAFfYAvEtNHKFtBs1H4mjEqFp6', 699, 0),
(190, 'PAOLO', 'Alexandre', 'alexandre.paolo@student.junia.com', 65, 0, 1, '$2y$10$3zbhGPeSUbeXfG/d5dMYTebNOGx0rp/v5v7mgGVIqnyWnx6i6HtXq', 808, 0),
(192, 'LEFEBVRE', 'Calliste', 'calliste.lefebvre@student.junia.com', 69, 0, 0, '$2y$10$hza0UT5YdxeqWjGGszb0buMPXoS.jJIpYFUSTwMBsTKAexrRurJvK', 369, 0),
(193, 'BOULINGUIEZ', 'Aymerick', 'aymerick.boulinguiez@student.junia.com', 65, 0.1, 0, '$2y$10$laSwDUNMtZvBfER5mOfPNOqkRAASnoyj8FnAiDM0kApLmG87MxB/y', 855, 0),
(194, 'COMBLE', 'Logan', 'logan.comble@student.junia.com', 69, -4.4, 0, '$2y$10$DZJE65OSp.GfxQq3shDdVudqbhF7r.dDExG/nTNES2Deb7KNuMT4u', 18, 0),
(195, 'RYCKEBUSCH', 'Romain', 'romain.ryckebusch@student.junia.com', 65, 0, 0, '$2y$10$5QFwaAedkGWfvBM4sHF3/uDz01SoOhtWTC2gzOc/.Clgp.VnjKU4a', 974, 0),
(196, 'ZIELINSKI', 'Alekseï', 'aleksei.mollet-zielinski@student.junia.com', 69, 0.2, 0, '$2y$10$17c46Bnm7pcObFz9NtdCMOjTl9qMy3Urf6yFwjMYnen2b0OuDaeWS', 284, 0),
(197, 'BROUCQSAULT', 'Simon', 'simon.broucqsault@student.junia.com', 68, 6.7, 2, '$2y$10$yqPstYPXDyVDVwkJUpqWrOCoXg/sDUM.tJoC4MHJBGrDvbjma6sMi', 22, 0),
(198, 'DEMEULEMEESTER', 'Maxime', 'maxime.demeulemeester@student.junia.com', 68, 1, 0, '$2y$10$hYptCBs0cYN7B0woK4LNpeWmm8jxI8m7fIoLJtrGXrHf/Gog/V2qC', 245, 0),
(199, 'TOUNSI', 'Aymane-adam', 'aymane-adam.tounsi@student.junia.com', 65, 0.1, 0, '$2y$10$MBcHLcsxJvpPKgc9Gih18e3TKGsthrfVq4znMVYD7/Hvd1dnQbzeq', 123, 0),
(200, 'NEVEU', 'Theo', 'theo.neveu@student.junia.com', 69, 2.5, 0, '$2y$10$kugjRm2/OiVHk6yP0rsMou2KvSmzPPPwYczRZX4WzYD2BadUjvwxa', 757, 0),
(201, 'OLOT', 'Bryan', 'bryan.olot@student.junia.com', 69, 0, 0, '$2y$10$WEJJdtcZznZQO8I7OXP5H.y/1Ud4sHY0kSQ5vkgTl5O2pXnp5QDrW', 345, 0),
(202, 'RUBIN', 'Clement', 'clement.rubin@student.junia.com', 69, 0, 0, '$2y$10$vSgtOepRvd1oAV7khzRPIeSTpB1oXY5NfqPOpnGcgc9b2Zrzf0KZu', 346, 0),
(203, 'ROY', 'Thomas', 'thomas.roy@student.junia.com', 68, 0, 0, '$2y$10$LEoyPG4SK0fRBcGCo5qaceUgG4J3Vdq.09U6.YDfGt/NdSBL4lT/2', 347, 0),
(204, 'FACON-BOCQUET', 'Alexandre', 'alexandre.facon-bocquet@student.junia.com', 67, 0.1, 0, '$2y$10$SCh94itst2K1NY07rnche.h8.6IRQI2urhRsjsMDDeNGCc6GqlzJi', 7, 0),
(205, 'WILLEMART', 'William', 'william.willemart@student.junia.com', 69, 0, 0, '$2y$10$WgtZqJgdy6XfY5sEPI7uTOrWCGk3ASvrf8HfXfkNsede6XYI11KpW', 56, 0),
(206, 'SOULAS', 'Benjamin', 'benjamin.soulas@student.junia.com', 67, -0.52, 0, '$2y$10$pa2zGjQzdRPiGhq07v4qQuom9o8.8yZ7uItLDElm5sthVE.m0dvcS', 420, 0),
(207, 'LEGRAND', 'Julien', 'julien.legrand@student.junia.com', 68, 0, 0, '$2y$10$BzdnriYIa0.L9up4vg6g0OPByThqWKiYNO.LVohIDMKeKvwT8NNIO', 66, 0),
(208, 'PAVY', 'Adam', 'adam.pavy@student.junia.com', 69, 0, 0, '$2y$10$uQSZ27gyNBY5azx6XUudS.R5hRPqp2Eo7GyiciEqScKxjtaSyn7Fu', 236, 0),
(209, 'LAFONT', 'Arthur', 'arthur.lafont@student.junia.com', 66, 0, 0, '$2y$10$/9JTKlRBzTzihGNWg6dBeueOoeKCFuKGQjkzZ98kazjUk5TYtMcx.', 314, 0),
(210, 'EVIN', 'Alexis', 'alexis.evin@student.junia.com', 69, -1, 1, '$2y$10$ki7txOduWe0MGrvHHGqZ5uwthg.2.rczlj2.B2FW34VQDEz.KZWsq', 626, 0),
(211, 'JEREMIE', 'Marcant', 'jeremie.marcant@student.junia.com', 69, 0, 0, '$2y$10$Yw4.69fSLTCAifeD/6wpV.UV5ET1mPAJkbSUpZMrWG2.pPW2ajGem', 759, 0),
(212, 'CARRE', 'Lucas', 'lucas.carre@student.junia.com', 69, 0, 0, '$2y$10$n8JO89YWzGaEDO3d24d9IO/tEvpUAr6yQWBW9x2r/bZAOh9PjbEuG', 809, 0),
(213, 'FOURNET', 'Paul', 'paul.fournet@student.junia.com', 69, -3.8, 0, '$2y$10$3B0QSXHuj4jEo0u9FcpIcOSlMIhiXm6dXPHgaZtPEPiygUh1R2hKy', 190, 0),
(214, 'LOUF', 'Arthur', 'arthur.louf@student.junia.com', 65, 0, 0, '$2y$10$4iEcQn8kUK7T5LUlG4WSJ.Q.986SiGJtD4cZdLk.jqAhTS0zq74Zu', 264, 0),
(215, 'LANGER', 'Camille', 'camille.langer@student.junia.com', 65, 0, 2, '$2y$10$MM52TXn7H69i1hfyXB/leuruYI/dlWy1ox5TVB4rS2BoPJ7k/j.4i', 3, 0),
(216, 'MANY', 'Hugo', 'hugo.many@student.junia.com', 67, -0.8, 0, '$2y$10$djlvSNJHcssBD6RKWATCHOhV/VrNo/3wHJZ6BmuzgF3V6MURNVhu6', 323, 0),
(217, 'MIRAMOND', 'Louis', 'louis.miramond@student.junia.com', 69, 0, 0, '$2y$10$EH4yNGKTDOcCh167kmgxNehPB1www76wdeAvIr01wUTdlgf0AjRZm', 203, 0),
(218, 'MARTEL', 'Flavien', 'flavien.martel@student.junia.com', 69, 3.3, 0, '$2y$10$sarcI.moHiXQnbUbDZNBp.5tViFF.3uTnhyenRb0B/ZDMLh3dU9.O', 773, 0),
(219, 'PAINPARAY', 'Esteban', 'esteban.painparay@student.junia.com', 69, 0, 0, '$2y$10$7gBEZTFzR8o31ZGzPofN3eKRv82O4yB4GzU/Tw3GiYoEtely.D9.e', 240, 0),
(220, 'LEVECQ', 'Jules', 'jules.levecq@student.junia.com', 69, 0, 0, '$2y$10$2RsaGrnRQ5Lp1dYCOm0xsOHl.zA2r2vwFiCR7gOizLnQBAn0D/Qxa', 751, 0),
(221, 'MOUMIN', 'Nour', 'nour.moumin@student.junia.com', 65, 0, 0, '$2y$10$FZKaU12V0PqUgGCAj1K0BuunwrasKYypi8k7RJCZA9PXFKH4iWq2G', 291, 0),
(222, 'HUBERT', 'Matthieu', 'matthieu.hubert@student.junia.com', 68, 3.7, 2, '$2y$10$o/v6ObCV7QSsLZkv21HmvuYwJYjZJqmHRg5Z/KLv535z3108q2mXu', 4, 0),
(223, 'LESAGE-GANTE', 'Mathéo', 'matheo.lesage-gante@student.junia.com', 69, -3.4, 0, '$2y$10$HB/Gj.z.4RcZlCRGBUovEOaf5FuFXr8W52gTDQq5CV0Qv3noeDiKS', 274, 0),
(224, 'CADET', 'Hugo', 'hugo.cadet@student.junia.com', 69, 0, 0, '$2y$10$F3EgPTKc40R077mQVEZCQuTqQacL2YpGkIVTwkwlJZSOdxpzswS/2', 186, 0),
(225, 'BERGHE', 'Nathan', 'nathan.berghe@student.junia.com', 68, 0, 0, '$2y$10$nTy0Bz8FXBrQ/wp3omrNQu0wPTeVE69AOomBCcR7l3D/eSbkDuEoO', 970, 0),
(226, 'BRUNELLE', 'Antoine', 'antoine.brunelle@student.junia.com', 65, 9.2, 0, '$2y$10$ORqDfTfu2E7zUWSIdahsoOi97uAlPfZ6xqOOEfMiJtyPz5TqvS.66', 246, 0),
(227, 'GIBARU', 'Maxence', 'maxence.gibaru@student.junia.com', 68, 0, 0, '$2y$10$mXVA.cu90GIx62aVmPxFg.qu/I.WXEdOvN5lQb5DOw0PZGPga6Wvu', 978, 0),
(228, 'LEMPEREUR', 'Théo', 'theo.lempereur@student.junia.com', 69, -0.1, 1, '$2y$10$D5p5QJ4GavvbsoSFqHYWFeuiq0xDRRfta2w8mzGPtfY5rMqe5iiqu', 95, 0),
(229, 'DUVERGER', 'Maxime', 'maxime.duverger@student.junia.com', 65, 0, 0, '$2y$10$E4uHik6TJ8pi8awMtExhR.JwNSOaN7IBerJoJuWZDfuLmq7B2bPCe', 727, 0),
(230, 'LESAGE', 'Théo', 'theo.lesage@student.junia.com', 69, 6.6, 3, '$2y$10$wo6s.yxi7xsOmXrk0Y2q7uQgjyoerxOdv4j4D2bf7aeUDozs2tjkq', 569, 0),
(231, 'CHIREZ', 'Benoît', 'benoit.chirez@student.junia.com', 69, 0, 0, '$2y$10$FzMCIR0mlkeqkM3OXXQMVOHA/nD/56kl6jxP..TOv1mTz0hms6hOy', 169, 0),
(232, 'MONTEGNIES', 'Mathis', 'mathis.montegnies@student.junia.com', 65, 0, 0, '$2y$10$EPCLKWekRM.OmJKI6HfQnOb7YrJfd2HHaD5FcRi3aGqadI9Qy6d9C', 309, 0),
(233, 'DA SILVA', 'Esteban', 'esteban.da-silva@student.junia.com', 69, 0, 0, '$2y$10$MhrAC18gQ8o.amnfktGMj.s26Nw.7/hx.nRnlROst4hZUxTaH8Hxq', 222, 0),
(234, 'DUCOULOMBIER', 'Maxence', 'maxence.ducoulombier@student.junia.com', 65, 0, 0, '$2y$10$RvVDXyFLoOANnGi97L3vGOG7h1kDPwdmnc98I7BbunKGennZwEVdq', 865, 0),
(235, 'DEBERDT', 'Alexandre', 'alexandre.deberdt@student.junia.com', 67, 0, 0, '$2y$10$SssiJGQGrWTZPYJ45Zx8wu3gtUtYSwTm50TR//uAeEqLNXIP763Py', 642, 0),
(236, 'CHAFAI', 'Mehdi', 'djallal.chafai@student.junia.com', 67, 0.9, 0, '$2y$10$uIi3qLjSmuL9PbaFZjNz/OS4sknd.uZVtKt2JC5qqmFw4PbtV64gy', 5, 0),
(237, 'CLAUS', 'Damia', 'damia.claus@student.junia.com', 68, 0, 0, '$2y$10$2ZHIJhKLIdkbhGH6ArXL3..eHnfNoqGzwEOaXobatJCru8YHcB3pm', 125, 0),
(238, 'LEANG', 'Narthanël', 'nathanael.leang@student.junia.com', 69, 0, 0, '$2y$10$DTblo/nN27anVaN7WitdgemA9dunNOHKxDEyVf5uDVyCfUjMzkUa.', 300, 0),
(239, 'BARLET', 'Noé', 'noe.barlet@student.junia.com', 67, 1.1, 0, '$2y$10$G/qBp3SO3PKU6GJLb1JGJuRVV4UsTrUqfcIayt0uHPDL3mhWQ6we.', 238, 0),
(240, 'MEGARD', 'Thibault', 'thibault.megard@student.junia.com', 67, -5, 2, '$2y$10$8zfPDpzj2sfPJUjwBHwvXO9dTWFR1TXCByhEMFeV3tUALywMRKsK6', 708, 0),
(241, 'DUMAS', 'Philippe', 'philippe.dumas@student.junia.com', 65, 0, 0, '$2y$10$/sH3guZXpVSHyA7kHv9xFeLrNjORMQBtMgDrcXNPzsrYFbaK4HGuG', 459, 0),
(242, 'DEVAUX', 'Fabien le vip', 'fabien.devaux@student.junia.com', 68, 53.4, 0, '$2y$10$rzOT6Q2tTd5U5nUw8I0y6eLP/Acu8BpXUnBmDefDBLhUS1VxA4KDO', 6, 0),
(243, 'FOULON', 'Arthur', 'arthur.foulon@student.junia.com', 67, 0, 0, '$2y$10$DvX27L5audcyxl9iFmKXPerIZORtsIvzGPqT9f2cQyFTEStBtFq.e', 932, 0),
(244, 'LEROY', 'Simon', 'simon.leroy@student.junia.com', 69, 0, 3, '$2y$10$ag.dKL.dXOloaL.qvDy9UejLynppcXbdwxeMaQes/d3V17mpTTvWO', 997, 0),
(245, 'DEFRETIN', 'Stéphane', 'stephane.defretin@student.junia.com', 66, 0, 0, '$2y$10$n9qgfPU/XN3qZdji9g1uLO6ahyo1G3knGhfqZuiY5w77NEQ4.02Zi', 180, 0),
(246, 'DEMEILLIERS', 'Simon', 'simon.demeilliers@student.junia.com', 65, 0, 0, '$2y$10$IQRiIhlLbuwzgmhnR2uHSuwyZa16fh6VLADL/LwvV36I8tNmUHxaG', 164, 0),
(247, 'LOUCHET', 'Maxence', 'maxence.louchet@student.junia.com', 66, 0, 0, '$2y$10$6xd2jsDaItwPXQkVhlHqbuLbBFSi3pmZ6J7TMCijPzr/Ias7kSGoS', 761, 0),
(248, 'BAREA FERNANDEZ', 'Enzo', 'enzo.barea-fernandez@student.junia.com', 65, 0, 0, '$2y$10$Mp3TCv4k9fUAwwkrDM6.Qevt1RsGr.xw9j3/SXBjrDagfIHEAAiA6', 789, 0),
(250, 'HU', 'Lucas', 'lucas.hu@student.junia.com', 68, 0, 0, '$2y$10$bkHNjpoB2LOh0VW04iMi1upTUHIZ8ddrz2kuULHsQvLpKnTCBwn.q', 68, 0),
(251, 'ROY', 'Jules', 'jules.royy@student.junia.com', 68, 0, 1, '$2y$10$r7zNqhONsYNosyh2T5kR1OxPo2HpR/gBASx5qrbW3WXE28o8cBMxy', 81, 0),
(252, 'TEST', 'Test', 'test@student.junia.com', 0, 0, 0, '$2y$10$w6zC8TkRe43Tc8pJE8OTPOAJyrocylA4Qu1fOdAHRq3431icfqlQi', 8, 0),
(254, 'HADADI', 'Ilyes', 'ilyes.hadadi@student.junia.com', 65, 0, 0, '$2y$10$oKWNXT8169EfvQzB5GnZy.uwJIG8yhRmbQys14/xq/945hHzqng92', 279, 0),
(255, 'JEANNIN', 'Paul', 'paul.jeannin@student.junia.com', 68, 0, 0, '$2y$10$JxdCLPQ1xfjplg3Pd1aElukM6MFKASEmZ.ppCg0mCUQ36WUjW22oW', 501, 0),
(256, 'GRAIRE', 'Erwan', 'erwan.graire@student.junia.com', 69, 0, 0, '$2y$10$rxip479nDo4xa7zxYzR.T.gdTqJprtNrPtqnjxNf4KgBcnWhac7Ru', 255, 0),
(257, 'ABEME MEYE', 'Byllie', 'byllie.abeme-meye@student.junia.com', 69, 0, 0, '$2y$10$.fSKv5mNzk4ui1ZZiXuOaeM0a0AlLiRn.97WByGXpBRU6qR1hmqXy', 681, 0),
(258, 'TOCQUEVILLE', 'Hector', 'hector.grouard-de-tocqueville@student.junia.com', 65, 0, 0, '$2y$10$ytJlBRlDpyvvRlKmIipfl.HvIGyYZTKUURN6RJnSXdli54fj54Ib2', 397, 0),
(259, 'THUILLIER', 'Maxime', 'maxime.thuillier@student.junia.com', 65, 0, 0, '$2y$10$YI.QDP2ZtPII11m50LyIqebY7VDiBBObOyl1pe/3BR4yS5jjBUs3q', 740, 0),
(260, 'ROSSEEL', 'Maxence', 'maxence.rosseel@student.junia.com', 69, 14.4, 2, '$2y$10$0VDSh8i3rDPXfDO1EU3RJeaseE9TxVYpjL7Y3g77f84hUE76dHzoK', 834, 0),
(261, 'DELEVOYE', 'Samuel', 'samuel.delevoye@student.junia.com', 69, 0, 0, '$2y$10$IpetUKbPyjB0e9m9heEiAOarvnFfdmI0S.3651Gaysuw2JyKSaXKa', 792, 0),
(262, 'GENRE', 'Elodie', 'elodie.genre@student.junia.com', 65, -1.6, 0, '$2y$10$ornSPcV1Tz0lbViyy4X0H.eHQkHWqQjWYtwtRXl3pFJpx1PTB41ua', 76, 0),
(263, 'DAMAY', 'Louis', 'louis.damay@student.junia.com', 68, 0, 0, '$2y$10$NxlKQPSr8lKE7U8s7RJvLuHEl6lZQODIR16pfFuzuGtmZ54O2NsJu', 595, 0),
(264, 'HALILA', 'Nada', 'nada.halila@student.junia.com', 68, 0, 1, '$2y$10$esoCDZ8VfS0uyW/L7eiSReraux3/BVRD8LApa9jOW07p4x9vtI/M2', 672, 0),
(265, 'LAMMAR', 'Léo', 'leo.lammar@student.junia.com', 68, -0.5, 2, '$2y$10$5CfkUFkWMPY9O9v.MsjBvOZFGp7eA7EEa/FHnkNBeTQX9VePbh3DK', 848, 0),
(266, 'LAVALLéE', 'Hugo', 'hugo.lavallee@student.junia.com', 66, 0.2, 0, '$2y$10$gnnBcKQtAfyuw9x.jiAQlemjkZYrB108bVaAdlkH0UNioPx3/VUXy', 968, 0),
(267, 'BECART', 'Simon', 'Simon.becart@student.junia.com', 66, 0, 0, '$2y$10$l91PM7cQz4Laif0ZPC8a4uwk1QSZZEKFdy5/h0U/HNhkOjIjnSKq2', 821, 0),
(268, 'DEVULDER', 'Marie', 'marie.devulder@student.junia.com', 66, 0, 0, '$2y$10$r5gRwIq3QCqBQpOssAS73ex1p.k/lEnJx84tYZGwdVb33GABKO6qW', 174, 0),
(269, 'GARCIA', 'Lilou', 'lilou.garcia@student.junia.com', 65, 0, 0, '$2y$10$yO7yIGRYUgQNXjel6D2l0OU/cfMscooZmRRSLrp830n63JP3jNdlO', 275, 0),
(270, 'ALI', 'Meeke', 'meeke.ali-abayazid@student.junia.com', 69, 0, 0, '$2y$10$COy4VFaN8P5qAIAaLKbVn.G1X7RS8wW7ADC8KuCgS3G4yVkT5Dxx.', 819, 0),
(271, 'VéNIER', 'Bastien', 'bastien.venier@student.junia.com', 68, 0, 0, '$2y$10$7sQZ3.iKaG6V5u/STpvZEeng3gte9NdGqK0cxdkGgzRrGT0aXRRKC', 947, 0),
(272, 'BRASSART', 'Valentin', 'valentin.brassart@student.junia.com', 68, 2.6, 0, '$2y$10$IO2cjVUe7NTvKthu5/UvfO0lQoEiA33tTGNEKHpjyjX.62apQR912', 218, 0),
(273, 'DELPORT', 'Hana', 'hana.delport@student.junia.com', 66, 0, 0, '$2y$10$DReSROeUYv58cbMYCH5d3.lqefzvVxg9RypMY/HNtqaZYKnNN.2PG', 248, 0),
(274, 'DURAND', 'Cem', 'cem.durand@student.junia.com', 65, 0.55, 3, '$2y$10$kWUjPlN4KdPt2ZMexPbOXuXcvzzoPzftrvQXhJo4ELFDttOlhzigS', 225, 0),
(275, 'PIAT', 'Romain', 'romain.piat@student.junia.com', 69, 0, 0, '$2y$10$D5SW3J.4Wp.8f1UAWQNMI.EWhwaLEKf8c57AjiT9LxOn.C4gq4kIS', 122, 0),
(276, 'MASQUELIER', 'Clément', 'clement.masquelier@student.junia.com', 69, 0, 0, '$2y$10$BOqp6nOYL9/MxbOaGZ9sjuz..0Q8srQYPD02PR1tg4HXMmmkbYIHm', 892, 0),
(277, 'CLABECQ', 'Lilian', 'lilian.clabecq@student.junia.com', 69, 0, 0, '$2y$10$H75UQBsyNW11NtKfh3p/JOsBpwTmm46WkGDUej/N4/5AtQ3scExRe', 966, 0),
(278, 'VERHAEGHE', 'Adrien', 'adrien.verhaeghe@student.junia.com', 65, 0, 0, '$2y$10$SZJxKScHl9KzFUwlKC7.VuQH4cqiwtqf89gsL1RP.Yb1QLG00QVdW', 409, 0),
(279, 'SEMENS', 'Evann', 'evann.semens@student.junia.com', 68, 0, 0, '$2y$10$p2yjqrHBHuMYfEqMDwo81eM6Bhe6S4dnNGeEBAqrb9YSGXNRqo4Oi', 718, 0),
(280, 'AMBROZIEWICZ', 'Quentin', 'quentin.ambroziewicz@student.junia.com', 66, 0, 0, '$2y$10$zoqIPzBB5K5VcZJuJZgaMuJhZQ944zKhhg.nqBIWfKwczRPFwq3mO', 676, 0),
(281, 'ALLIENNE', 'Adrien', 'adrien.allienne@student.junia.com', 69, 0, 0, '$2y$10$0NLYffvI2fqrdEdlYiVGNuAFqVzpFHQ.aTY35d9WmksFTSo0Mdzf2', 161, 0),
(282, 'MOUSSARD', 'Saona', 'saona.moussard@student.junia.com', 66, 0, 0, '$2y$10$skSfUBFFcjq4HmFTJJ4Jy.nRAU2bY2IYWe3C7Sjj2lz30c70ORsVq', 318, 0),
(283, 'REYNAL DE SAINT MICHEL', 'Noémie', 'noemie.reynal-de-saint-michel@student.junia.com', 65, 0, 0, '$2y$10$OF3BzpIJppOJhkumgsp57.fjXJ0VfPLXsh4FPEGu6MV7oFO6fNjFK', 961, 0),
(284, 'MARQUILLY', 'Perrine', 'perrine.marquilly@student.junia.com', 68, 0, 0, '$2y$10$dAGQ.fKfJsO7cZldaIp/U.TXmpJc7ejEM9Vj/C5wOFibgge1DOEHu', 942, 0),
(285, 'CHARPENTIER', 'Louis', 'louis.charpentier@student.junia.com', 67, 1.7, 0, '$2y$10$9btXHVIrJLBWQxtAIjnTJ.EVxhQ0Fs6NSPrx1RtlEco1JFB2APd.S', 701, 0),
(286, 'MATARESE', 'Robin', 'robin.matarese@student.junia.com', 68, 0, 0, '$2y$10$YChnq0jFiRd7O2Bo.CKbaeD4MyA4GMRBSfriXbxRYfK11wOuQgzZq', 282, 0),
(287, 'BOUDRY', 'Benjamin', 'benjamin.boudry@student.junia.com', 67, 0, 0, '$2y$10$k4p33vlvyPXhGaQRuFOLNuoNh8FN9ndhCa2Cluraxm8cjPq/WQPH2', 938, 0),
(288, 'LECOUTURIER', 'Louis', 'louis.lecouturier@student.junia.com', 66, 0, 0, '$2y$10$EaDBQBG06pLO4.T4xajsmuIAM1Nk2BVuhnzLifwyTgdb/u/GLiwua', 107, 0),
(289, 'MAES', 'Antoine', 'antoine.maes@student.junia.com', 66, 0, 0, '$2y$10$KK/LYsQmyzhuBliCn1mQSuR7biY9Wf9RpvI1sDCWAqka1dUQ.CXw.', 505, 0),
(290, 'RIGAUD', 'Mathilde', 'mathilde.rigaud@student.junia.com', 66, 0, 0, '$2y$10$le/MFfK2pWWaBNOCdwvoQOtVwtUMygchiH.r9slVEFuyXUtjdDRzG', 472, 0),
(291, 'DUSAUSOY', 'Léonce', 'leonce.dusausoy@student.junia.com', 69, 0, 0, '$2y$10$jSFVv0S/KrI65rwF8AVdreMnUO2ZPxruG5J4qH8RScTNw47GvIDiK', 720, 0),
(292, 'VASSEUR-PLADYS', 'Gabriel', 'gabriel.vasseur-pladys@student.junia.com', 65, 0, 0, '$2y$10$8xPbfDdcg.bTmhKIXBI5OOyKEmW9ifv0Zs3i7iwJQAAwXejDHuIM6', 293, 0),
(293, 'LUPINE', 'Alexandre', 'alexandre.lupine@student.junia.com', 66, 0, 0, '$2y$10$koI47mvEqK7Tx.5wD06gJ.3tBvOwoBSymtK094ooMHUv6vR59kevG', 286, 0),
(294, 'URQUIJO', 'Nicolas', 'nicolas.urquijo@student.junia.com', 65, 0, 0, '$2y$10$kU.8HZftCUMR7G1mEy7LNeMyIojCZMhm23.eKgtZyxjBI.4FnHD7i', 651, 0),
(295, 'LONGATTTE', 'Marc-antoine', 'antoine.longatte@student.junia.com', 65, 0, 0, '$2y$10$XL6BbtSwzGhsHCnMPwk2se9.jZmftkOsZjNzNnqXjEYWl/lLKW4oW', 339, 0),
(296, 'TSERSTEVENS', 'Eva', 'eva.tserstevens@student.junia.com', 65, 0, 0, '$2y$10$C8ieVcWaALKskbcU.AmOFu56NKLVl6OZEfhbh0SMtonp1QJi1/wxu', 828, 0),
(297, 'MORCEL', 'Paul', 'paul.morcel@student.junia.com', 68, 0, 0, '$2y$10$ylYsWvPxMOqj7hzPhLgsW.Jlgpr8Ima0WqJGVtjPqKC.cja5Nuodu', 760, 0),
(298, 'SéREUSE', 'Alexis', 'alexis.sereuse@student.junia.com', 65, 0, 0, '$2y$10$WMCyRnREXMLMZaTKSuk0neLfIg1vZlWX/1Xv5Ey2JfckDIpQnwdmW', 706, 0),
(299, 'EVAIN', 'Sacha', 'sacha.evain@student.junia.com', 65, 0, 0, '$2y$10$ymvm6biUfrDdG5lLvzTwUee6.GreGc7qoX0cOkXtyzGRodQEZPigm', 596, 0),
(300, 'HOARAU', 'Gautier', 'gautier.hoarau@student.junia.com', 67, 0.4, 2, '$2y$10$VlX.DlVw/Y3O7QIKTaE8zumKiuJbA3Yw9coXDaXl3tA1onxYd1VDC', 690, 0),
(301, 'SéNéCHAL', 'Pierre', 'pierre.senechal@student.junia.com', 65, 0, 0, '$2y$10$laf511VQ23Nv2amoa9eQI.dQ7FpAbVKFXb2f8aWVHihXz60xD/Wfa', 689, 0),
(302, 'DEMEULIER', 'Théophile', 'theophile.demeulier@student.junia.com', 66, 0, 0, '$2y$10$SYUJ/Uuz.k4TXRleLLFLLOOwhKLjK5UZr3OUq7l5OWZu2qlmvELiq', 266, 0),
(303, 'DEGAIN', 'Aurélien', 'aurelien.degain@student.junia.com', 66, 0, 0, '$2y$10$rtYRUlDQ.XoeHwl/SppbbenMWle/KwWEIISRWiWioVSIT0LXDNCFa', 440, 0),
(304, 'HADDADI', 'Lokman', 'lokman.haddadi@student.junia.com', 65, 0, 0, '$2y$10$tIVQhEToFDyQXfgwlrr27.9WwhIdw5uqzA7qkKJpNbL8lRgRDtgEy', 989, 0),
(305, 'BRISSON', 'Clément', 'clement.brisson@student.junia.com', 68, 1, 0, '$2y$10$hSe7oIdReIEULp0ZlVLuAeasadSJP0d8c5PKbMw3IDxuA0j1TG9PC', 407, 0),
(306, 'MAZEAU', 'Clément', 'clement.mazeau@student.junia.com', 65, 0, 0, '$2y$10$W25OA8uC4FlqKnXyraILje/pHx4iK1jhkbK/hTtvhj8z5dQGxhUTe', 812, 0),
(307, 'LORIDANT', 'Tom', 'tom.loridant@student.junia.com', 68, 0, 0, '$2y$10$eJ5a2pV.Vq/wVU/xX6rn9uCdFv21KG7cnqWU6GtHbuE3SXkXKdYo.', 592, 0),
(308, 'ETTAHRI', 'Othmane', 'othmane.ettahri-el-joti@student.junia.com', 67, 0, 0, '$2y$10$aHC3uRMo09Q7y4wBzvIOV.oLtMsOp/GiGlbgYndvivVjSfLOvJMCq', 891, 0),
(309, 'ROUILLER', 'Théo', 'theo.rouiller@student.junia.com', 67, -0.8, 0, '$2y$10$Guqnkppal9zLtR6JhX9g8Om/lR8smbTtFZpM3hralWvsq8lY3Z95S', 177, 0),
(310, 'DUQUESNE', 'Eugénie', 'eugenie.duquesne@student.junia.com', 69, 0, 1, '$2y$10$6KlPVHWnghcoMqxduPJ7I.1HRv4Y1gim4ZZqtx9S1KmSXaNM2Lg9S', 410, 0),
(311, 'WARTEL', 'Antoine', 'antoine.wartel@student.junia.com', 68, 1.5, 0, '$2y$10$8atHmFhQfFi15RwSVFIOTONfszrb/Auv7m4oTTur4vp5rQFY69lT6', 198, 0),
(312, 'BONDEAU', 'Corentin', 'corentin.bondeau@student.junia.com', 65, 3.3, 0, '$2y$10$cslCJaeuNuvZi7neLt9/N.w/FLdKvrP42qWKAEwNhjq3P7HTRdAFK', 319, 0),
(313, 'MONTUORI', 'Milo', 'milo.montuori@student.junia.com', 65, 3.5, 2, '$2y$10$5lU7SUr9GKb2fJU27MxmSuJZn/ZGzxpcBPCcVkte2dXTVSQmb31we', 69, 0),
(314, 'CHEMERY', 'Basrien', 'bastien.chemery@student.junia.com', 67, 0, 0, '$2y$10$bp.Nz7i6rebbbXDHob94wO6QJComnN0Awr7a6eTZqAYvtSKOGnMva', 377, 0),
(316, 'BUTEZ', 'Pierre', 'pierre.butez@student.junia.com', 69, 0, 0, '$2y$10$V3XXUfByzsqdeChCb1yM7./U1OH79SurDzMWDM9AXWvvhAQLpBvWy', 118, 0),
(317, 'LEWANDOWSKI', 'Léo', 'leo.lewandowski@student.junia.com', 69, 1.1, 3, '$2y$10$bvqtFsZOzgnhBvCxMVtSTufiuucuWgGBICkUtkaynrPTciWl9jRie', 220, 0),
(318, 'BAYARD', 'Nathan', 'nathan.bayard@student.junia.com', 68, 0, 0, '$2y$10$cbqk../8pqbY71r5eWJTiebUusff2Nai/CYNY4XV8LAFFtQ6vFx4q', 918, 0),
(319, 'MAES', 'Victor', 'victor.maes@student.junia.com', 66, 0, 0, '$2y$10$xo20Rjv0ywnVZb2qMvnVSeSNvZ84eVzpZsR80iW7LrQzmsyomXbSa', 207, 0),
(320, 'SKRZYPCZAK', 'Louis', 'louis.skrzypczak@student.junia.com', 65, 0, 0, '$2y$10$tGLPnBMDdU.UQFDNOMprduLu.oXHBbu3KeRkI9DCTvPYLbm7BWOoK', 990, 0),
(321, 'ROMAIN', 'Pecriaux', 'romain.pecriaux-swynghedauw@student.junia.com', 67, 0, 0, '$2y$10$54fm42fvBcDWOI1.AOhIvOcI70Ep82j46uvXmvw1SPAGTgf/VRw6u', 993, 0),
(322, 'ROBILLART', 'Flavie', 'flavie.robillart@student.junia.com', 67, 3.6, 0, '$2y$10$GmchQ.r0qq1T3EKcA/VBrudWQciT7/NDEMo5dsfETU4ApZ15S.zw6', 830, 0),
(323, 'PONCHON', 'Antonin', 'antonin.ponchon@student.junia.com', 65, -2.2, 0, '$2y$10$9Yh9AI/37mBRqC/y5jmW3eVSJ4sE2afaCImg2FmEgk9qMA9WPPBv.', 221, 0),
(324, 'LARDEUR', 'Mathis', 'mathis.lardeur@student.junia.com', 68, 9.8, 0, '$2y$10$j7STono7lC2hW..dPHGYpuaAWvAJdKlqrmGJSDoxmxUbhTSDRqgtC', 120, 0),
(325, 'HALLIEZ', 'Axel', 'axel.halliez@student.junia.com', 68, 0, 0, '$2y$10$Uq0CftGJlMF.CAh/3s8R8ORzG6oNJ4UcvM1T00infLl9zjW2jjQMO', 288, 0),
(326, 'NOWOCZYN', 'Anatole', 'anatole.nowoczyn@student.junia.com', 68, 0, 0, '$2y$10$Lce1eT1nNM8diBFQRRybxO2gjfcwVQoyim32bNyi5fgWG1oH5frZ.', 907, 0),
(327, 'MOLCRETTE', 'Alan', 'alan.molcrette@student.junia.com', 66, 0, 0, '$2y$10$1jMUlaDXkIbw3YyM5hQxy.Q5mxf3E2rZ/u9HwJG8gsZZlFGTk75HG', 945, 0),
(328, 'HAGE', 'Rémi', 'remi.hage@student.junia.com', 67, 0, 0, '$2y$10$j95SA417147/nVwvggaRqOKEQsbAmW64HaDWl6b8YiwHJye/sT42e', 734, 0),
(329, 'HOSTE', 'Matthieu', 'matthieu.hoste@student.junia.com', 67, 0.3, 0, '$2y$10$m6DKxlSvJSwnESxCS5qufemixeAB.jR4PGcRofwDOV09SBrmMhBMu', 717, 0),
(330, 'DEPARIS', 'Hippoylte', 'hippolyte.deparis@student.junia.com', 69, 0, 0, '$2y$10$K8KZqb4xMa6j.BejbUfF0OHrJ1FTP9vczl0BI.bGiD.KHoWrhbh4O', 748, 0),
(331, 'GOUBERT', 'Natacha', 'natacha.goubert@student.junia.com', 65, 0, 0, '$2y$10$m4mD.HzcL4EibhOJHTDl2OBlp4qhZA4jYb1pi2lPwKQMXS7lH9x2W', 841, 0),
(337, 'BRESTENBACH', 'Joris', 'joris.brestenbach@student.junia.com', 70, 0, 0, '$2b$10$NUo7me.IE4Nb2y.3TIu5bO0JvQ7l7.1kBI4y07WWIkGiznnSf6vjq', 735, 0),
(338, 'LECOMPTE', 'Hugo', 'hugo.lecompte@student.junia.com', 70, 14.6, 0, '$2y$10$fJxDw6ThCs7/ZKf1I8bB1u5waYbMdNWgTKEdppoMCq9s3fFMWs0UO', 280, 0),
(339, 'BONAMI', 'Antonin', 'antonin.bonami@student.junia.com', 70, 0, 0, '$2b$10$0v79jrpGe.x/RtdLXyPwfeCMqHPpOxV8Q/tt6cJD./XBtHoxrUb0i', 370, 0),
(340, 'COCATRIX', 'Maxime', 'maxime.cocatrix@student.junia.com', 70, 8.3, 0, '$2y$10$9l5uDbrTT/ZPEe.WaLMLzORicQJ9dWHbrURLT2qKEr1F7VjTjLy/i', 332, 0),
(341, 'LASQUELLEC PEUTIN', 'Paul', 'paul.lasquellec--peutin@student.junia.com', 70, 0, 0, '$2b$10$FVPeFT808pRNBMq/JFkUQuH/Bgmu4gwz8FcNPHMZyAfl23lU4zgxu', 247, 0),
(342, 'DUMAS', 'Simon', 'simon.dumas@student.junia.com', 70, 0.1, 0, '$2b$10$TIeVHrwhes.mx/nDyvVh9esdBzwo8GwbCw50va7MR3k7mYLnihWgK', 419, 0),
(343, 'GOUëLLO', 'Titouan', 'titouan.gouello@student.junia.com', 66, 1.2, 1, '$2y$10$Gj.hkoEYbljpgZAAqTSEcOsK6AO1Z49oYh9uAjFtkZlDORa5Uu93m', 114, 0),
(344, 'MACAJONE', 'Enzo', 'enzo.macajone@student.junia.com', 66, 8.7, 0, '$2y$10$Zlv98BX9.HXriDUBKNXjBeVGmDCEW5UoC/D5ndyDfM86lCPlRttQG', 981, 0),
(345, 'FACON', 'Adrien', 'adrien.facon1@student.junia.com', 66, 0, 1, '$2y$10$xavz1xnbpggNAt4Idz0LXuz2QFCJ8SOf/2/ePFsWvDvBjllnpNMX2', 934, 0),
(346, 'MARECHAUX', 'Gaspard', 'gaspard.marechaux@student.junia.com', 70, 0, 0, '$2y$10$qwmEbfRWkgi6pjJKMX36GOKpAUpaitT6orw5KgDzn2JjchO8SPIBK', 426, 0),
(347, 'CHANTERELLE', 'Léonard', 'leonard.chanterelle@student.junia.com', 70, 0, 1, '$2y$10$lkpU5N9t1NClA3qEVzOBluSwykioIqMt3JA6405Vqiu7uNgVzAMQi', 851, 0),
(348, 'BRASSART', 'Edouard', 'edouard.brassart@student.junia.com', 70, -0.3, 0, '$2y$10$rF3Z3AHolPsEIdLh5BP3yOe3xSunqL.7bF6rEV7/IAGfnyk9KdAly', 301, 0),
(349, 'RENARD', 'Dorian', 'dorian.renard@student.junia.com', 70, 14.8, 0, '$2y$10$BngFf8JJutZaMSyt1EcJWe2bDfhUEAjpv9aNHeVjfhIpe6z2GEXN2', 353, 0),
(350, 'SCOHY', 'Pierre', 'pierre.scohy@student.junia.com', 70, 0, 0, '$2y$10$ikXWmaXeNwPJkSzbP0dPu.O0oXA6UBPYhkQjIYGmnDol9xiWyQKgS', 436, 0),
(351, 'VANIEMBOURG', 'Ianis', 'ianis.vaniembourg@student.junia.com', 66, 0, 1, '$2y$10$YJa4UlVksUe5xCHx5/f5meamQBA63J/aIUsUOg7F6O5.EIgHpnvQO', 210, 0),
(352, 'PRIEM', 'Charles', 'charles.priem@student.junia.com', 70, 0, 0, '$2y$10$ux0Xxgb9ySIkV1zkNnLG/uEiPRLh73D3sKHHHvCgZAwKLgDX9S3HG', 843, 0),
(353, 'PIQUEREAU', 'Lucas', 'lucas.piquereau@student.junia.com', 70, 0, 0, '$2y$10$CgbVHwvQ8AnYf5pH5yYtdOyvGQQ6yFYXmE9ySnzawp2wBvrhPdyhK', 747, 0),
(354, 'DE ALMEIDA', 'Julien', 'julien.de-almeida@student.junia.com', 67, -5.3, 0, '$2y$10$UbOqtGrvErQF1uXp.Tg5Iel7uRnAJZeN5Yh4nM5ShO/cxMRwLOtL.', 208, 0),
(355, 'PRZYSZCZYPKOWSKI', 'Esteban', 'esteban.przyszczypkowski@student.junia.com', 68, 0, 0, '$2y$10$hPbz9bq1iBK2Ih4FwuAXLuXCABsus7VncgI8RLB/6tHe8guICVB22', 607, 0),
(356, 'FARTHOUAT', 'Titoine', 'titoine.farthouat@student.junia.com', 66, 0, 0, '$2y$10$pt9YwdbPNuhcl6NZaGg/QuRpgn3fcOkFBqIOpLPU1LLKVaGR8JGqy', 116, 0),
(357, 'ARGAUD', 'Vincent', 'vincent.argaud@student.junia.com', 70, 0, 0, '$2y$10$KLCu2440wuhT5/kvhJCjIun67hf3gqzXE7hDhKLOdebKbn3U/7166', 321, 0),
(358, 'SELLIER', 'Mathieu', 'mathieu.sellier@student.junia.com', 68, 0, 0, '$2y$10$VJ0UjGHU5ZaxaCRztWiaxujaBwMyQs3EgPRySmlBfQvqFNzUqAxIi', 664, 0),
(359, 'BONIFACE', 'Rimbaud', 'rimbaud.boniface@student.junia.com', 70, 0, 0, '$2y$10$MgtMg/Ydjx6CiBZzplNb5.de53DRuT.LSIdl0OWSlU8wzkma64b.G', 495, 0),
(360, 'CARDINEAUD', 'Gaston', 'gaston.cardineaud@student.junia.com', 70, 0, 0, '$2y$10$zr.A7RUOwH4Ck6i0QhpH6uvE.xXpyBZm9y6N36rYkTnfdF2xjXwy.', 442, 0),
(361, 'MARQUES', 'Mathis', 'mathis.marques@student.junia.com', 70, 0, 0, '$2y$10$A5lrMqsAnBapEVYYNzi/AOGOsg0k3CIDW/Uxnnvoq3YmSRi4PxpUW', 774, 0),
(362, 'FLOQUET', 'Louis', 'louis.floquet@student.junia.com', 68, 0, 0, '$2y$10$hcNgYE6oImfmPD.gEG3fTuud8to8soLwcpCIvi5eWuqJv.IfxQqBK', 702, 0),
(363, 'MORNEAU', 'Théo', 'the.morneau@student.junia.com', 68, 0, 0, '$2y$10$TBvJbRezd9Q6BXVuyMVYA.s1L5SliQiWBY5nsJ4s9cYBecPNZKrlK', 889, 0),
(364, 'ENGELS', 'Tom', 'tom.engels@student.junia.com', 66, 0, 0, '$2y$10$csC/zQskoTduR4ResFRNgeSAuVHOAwcofWOcJWyRzwd5lsUK8RK.q', 753, 0),
(365, 'HUOT', 'Brieuc', 'brieuc.huot@student.junia.com', 68, 0, 0, '$2y$10$FEuYnIbmNfxQ2YGt3ppROu4feafuF.d0K2.VlfiWKSd8NtcXM1KdG', 783, 0),
(366, 'RAKOTOMAVO', 'Louis-mathis', 'louis-mathis.rakotomavo@student.junia.com', 70, 0, 0, '$2y$10$rDb9muB061utYISnAlSd/OfMvgkN2km9stxkzfyqL4Qpf9vJN8fC2', 257, 0),
(367, 'DELECOUR', 'Alix', 'alix.delecour@student.junia.com', 70, 0, 0, '$2y$10$/H/0..HlxVjuf8NwKAfgTur5nw2xGGwRCtkCIcHGWQ/PLHeRWFMu6', 611, 0),
(368, 'GAWLAS', 'Robin', 'robin.gawlas@student.junia.com', 70, 0, 0, '$2y$10$CVqoKR5H73A7Su0/vvLeeOz8k8Zsq1vSsQ10Hgq73K8x07tF4Tn2O', 656, 0),
(369, 'LELEU', 'Eliot', 'eliot.leleu@student.junia.com', 66, 0, 0, '$2y$10$iMhuWEaKTCF0ANQ1IS3MsOU7PhvCYH/lGk8ZEFVOgBQ7qqrA158UO', 204, 0),
(370, 'DAVID', 'Thomas', 'thomas.david@student.junia.com', 68, 7.2, 0, '$2y$10$zjLJtHrFi.xfSloD4.PiZ.UjgNfLuy4wBtjAlQIm19pd3mPeKUSwO', 143, 0),
(371, 'FOURMAUX', 'Charles', 'charles.fourmaux@student.junia.com', 68, 0, 0, '$2y$10$J54ChQmYOUCAKeSI6UVQjuHZeLYGR4u./SKZR9wL23YcNBYGiRncC', 613, 0),
(372, 'OLIVIER', 'Ethan', 'ethan.olivier@student.junia.com', 70, 0, 0, '$2y$10$zSvAnRHy3X4PsLcIqahUf.5rGiw7EGYefgrbEumCFKfEmXEMC6ERa', 287, 0),
(373, 'OSCAR', 'Nicolas', 'oscar.nicolas@student.junia.com', 69, 0, 0, '$2y$10$aw/kC9DOmnvumbPZUSaCd.bLVZmI4CmM/GuT0WYwFennmLeNSaAna', 619, 0),
(374, 'DENOYELLE', 'Christophe', 'christophe.denoyelle@junia.com', 66, 10.7, 0, '$2y$10$ZQGBXTLmWVr2W9L29TFAcO4eC6hFrLG7G6yKS6MZ8ozv6zZgN1AsG', 199, 0),
(375, 'MECHOUMA', 'Nassim', 'nassim.mechouma@student.junia.com', 66, 0, 0, '$2y$10$8oNNRJbLq0w3dl6z5VeMAOGsGZGXX9KWvOHb.1wsrmduiH1eL0Ky6', 325, 0),
(376, 'ZHU', 'Clément', 'clement.zhu@student.junia.com', 66, 0, 0, '$2y$10$LZ..AjWYOUjV9mXpEtYqJub4uON792MD7wUPhVymNeUq5m3GyLdHO', 366, 0),
(377, 'CARION', 'Jeanne', 'jeanne.carion@student.junia.com', 66, 0, 1, '$2y$10$VhI7qGEmPMTDFfw41PIy0u3.VYhwKSC1YstI4JGkSG67n/Ep135su', 832, 0),
(378, 'LEBRUN', 'Adèle', 'adele.lebrun@student.junia.com', 69, 0, 3, '$2y$10$YSfkeOaJ6tvh0jhXEBgVg.XpqxSg9yXr9Aox9XxaUHwi60EDpi5Y2', 276, 0),
(379, 'PHILIPPE', 'Lou', 'lou.philippe@student.junia.com', 68, 0, 0, '$2y$10$cSHxXfNeMxBOy4dv/J9qSO9mcu/6OqOdjaaPPfNp0aR58LX9at6Be', 979, 0),
(380, 'LALIN', 'Louise', 'louise.lalin@student.junia.com', 67, 0, 0, '$2y$10$j7.KWW8tQ8UJCaAgPRn9J.3AN.AlilaJi93KYGVZEEJrMOu5A9lz2', 954, 0),
(381, 'COTDELOUP', 'Thomas', 'thomas.cotdeloup@student.junia.com', 66, 0, 0, '$2y$10$O8ytckmX0EUwbyMMwfALXuHUTKY737zForxR/ZXenRPecksNVZs7e', 897, 0),
(382, 'MORY', 'Alexis', 'alexis.mory@student.junia.com', 68, 0, 0, '$2y$10$O66.h3xfZNP8jz7KBrjlke8lEGqkWMCoEy1/VPhV4eaQwmpfzd312', 678, 0),
(383, 'OBERT', 'Quentin', 'quentin.obert@student.junia.com', 66, 14.2, 0, '$2y$10$K/hJ0W92lUr.Fuz457JMPuzcMy1pZz3V9R15PYeqje7gocKBd4vCe', 297, 0);
INSERT INTO `utilisateurs` (`idUtilisateur`, `nom`, `prenom`, `email`, `promo`, `solde`, `acces`, `mdp`, `numeroCompte`, `roue`) VALUES
(384, 'GOSSE', 'Raphael', 'raphael.gosse@student.junia.com', 70, 0, 2, '$2y$10$Va0I7gKWxpYOQlkPKgKYveKMyUt0qI9KIvGp6hSrMbNUf9hdB5vaO', 128, 0),
(385, 'RABE', 'Béa', 'bea.rabe@student.junia.com', 69, -8, 1, '$2y$10$pdg2QLODdzwOhDLjZN14x.dT2cfqPwFh10SRRj8XfcXI09pr24BYq', 868, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actus`
--
ALTER TABLE `actus`
  ADD PRIMARY KEY (`idActu`),
  ADD UNIQUE KEY `idActu` (`idActu`);

--
-- Indexes for table `carteElements`
--
ALTER TABLE `carteElements`
  ADD PRIMARY KEY (`idElement`),
  ADD UNIQUE KEY `idElement` (`idElement`);

--
-- Indexes for table `carteMenus`
--
ALTER TABLE `carteMenus`
  ADD PRIMARY KEY (`idMenu`);

--
-- Indexes for table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`idCommande`),
  ADD UNIQUE KEY `idCommande` (`idCommande`),
  ADD KEY `FK_Commande_Utilisateur` (`idUtilisateur`),
  ADD KEY `FK_Commande_Paiement` (`idPaiement`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`idEvent`);

--
-- Indexes for table `inventaire`
--
ALTER TABLE `inventaire`
  ADD PRIMARY KEY (`idIngredient`),
  ADD UNIQUE KEY `idIngredient` (`idIngredient`);

--
-- Indexes for table `mdpReset`
--
ALTER TABLE `mdpReset`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`idPaiement`),
  ADD UNIQUE KEY `idPaiement` (`idPaiement`),
  ADD KEY `idUtilisateur` (`idUtilisateur`);

--
-- Indexes for table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`idParametre`),
  ADD UNIQUE KEY `idParametre` (`idParametre`);

--
-- Indexes for table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`idInscription`),
  ADD UNIQUE KEY `idInscription` (`idInscription`),
  ADD KEY `FK_Planning_Utilisateur` (`idUtilisateur`);

--
-- Indexes for table `salleEtSecurite`
--
ALTER TABLE `salleEtSecurite`
  ADD PRIMARY KEY (`idReleve`),
  ADD UNIQUE KEY `idReleve` (`idReleve`),
  ADD KEY `FK_SalleEtSecu_Utilisateur` (`idUtilisateur`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`idElement`),
  ADD UNIQUE KEY `idElement` (`idElement`);

--
-- Indexes for table `tresorerie`
--
ALTER TABLE `tresorerie`
  ADD PRIMARY KEY (`idElementTresorerie`),
  ADD UNIQUE KEY `idElementTresorerie` (`idElementTresorerie`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idUtilisateur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actus`
--
ALTER TABLE `actus`
  MODIFY `idActu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `carteElements`
--
ALTER TABLE `carteElements`
  MODIFY `idElement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;

--
-- AUTO_INCREMENT for table `carteMenus`
--
ALTER TABLE `carteMenus`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `idCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2114;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `idEvent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventaire`
--
ALTER TABLE `inventaire`
  MODIFY `idIngredient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `idPaiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1015;

--
-- AUTO_INCREMENT for table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `idParametre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `planning`
--
ALTER TABLE `planning`
  MODIFY `idInscription` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `salleEtSecurite`
--
ALTER TABLE `salleEtSecurite`
  MODIFY `idReleve` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `idElement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tresorerie`
--
ALTER TABLE `tresorerie`
  MODIFY `idElementTresorerie` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `FK_Commande_Paiement` FOREIGN KEY (`idPaiement`) REFERENCES `paiements` (`idPaiement`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Commande_Utilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON UPDATE CASCADE;

--
-- Constraints for table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `FK_Paiement_Utilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `FK_Planning_Utilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `salleEtSecurite`
--
ALTER TABLE `salleEtSecurite`
  ADD CONSTRAINT `FK_SalleEtSecu_Utilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

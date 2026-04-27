-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 27, 2026 alle 10:21
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scoremaps`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `risultato`
--

CREATE TABLE `risultato` (
  `id` int(11) NOT NULL,
  `id_squadra1` int(11) NOT NULL,
  `id_squadra2` int(11) NOT NULL,
  `punteggio_sq1` int(11) NOT NULL,
  `punteggio_sq2` int(11) NOT NULL,
  `vincitore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `risultato`
--

INSERT INTO `risultato` (`id`, `id_squadra1`, `id_squadra2`, `punteggio_sq1`, `punteggio_sq2`, `vincitore`) VALUES
(1, 2, 5, 71, 74, 5),
(2, 7, 20, 76, 71, 7),
(3, 13, 3, 100, 102, 3),
(4, 8, 21, 109, 69, 8),
(5, 4, 16, 82, 75, 4),
(6, 6, 9, 102, 105, 9),
(7, 1, 11, 105, 88, 1),
(8, 9, 2, 61, 94, 2),
(9, 3, 8, 72, 63, 3),
(10, 20, 1, 80, 82, 1),
(11, 11, 14, 79, 84, 14),
(12, 21, 7, 83, 78, 21),
(13, 16, 6, 79, 75, 16),
(14, 5, 13, 107, 95, 5),
(15, 4, 14, 102, 66, 4),
(16, 6, 2, 72, 76, 2),
(17, 8, 5, 89, 75, 8),
(18, 7, 9, 103, 79, 7),
(19, 13, 11, 79, 86, 11),
(20, 20, 3, 72, 81, 3),
(21, 1, 16, 69, 86, 16),
(22, 9, 8, 74, 85, 8),
(23, 2, 4, 101, 88, 2),
(24, 3, 21, 104, 94, 3),
(25, 11, 7, 95, 87, 11),
(26, 14, 20, 92, 85, 14),
(27, 1, 6, 90, 71, 1),
(28, 16, 13, 96, 79, 16),
(29, 6, 20, 70, 88, 20),
(30, 8, 1, 83, 102, 1),
(31, 13, 14, 100, 107, 14),
(32, 21, 16, 91, 83, 21),
(33, 4, 9, 86, 75, 4),
(34, 7, 2, 61, 93, 2),
(35, 5, 11, 87, 76, 5),
(36, 9, 1, 77, 83, 1),
(37, 3, 2, 98, 92, 3),
(38, 6, 21, 100, 84, 6),
(39, 16, 8, 92, 83, 16),
(40, 20, 4, 87, 94, 4),
(41, 7, 13, 88, 89, 13),
(42, 14, 5, 91, 81, 14),
(43, 3, 14, 98, 75, 3),
(44, 2, 13, 87, 63, 2),
(45, 8, 11, 87, 93, 11),
(46, 5, 9, 90, 87, 5),
(47, 1, 7, 80, 78, 1),
(48, 4, 6, 89, 76, 4),
(49, 21, 20, 90, 85, 21),
(50, 20, 5, 90, 94, 5),
(51, 16, 14, 113, 94, 16),
(52, 6, 8, 89, 88, 6),
(53, 9, 21, 91, 82, 9),
(54, 7, 4, 79, 89, 4),
(55, 11, 3, 72, 85, 3),
(56, 13, 1, 79, 101, 1),
(57, 3, 16, 83, 72, 3),
(58, 8, 13, 81, 68, 8),
(59, 14, 2, 86, 82, 14),
(60, 9, 20, 59, 66, 20),
(61, 5, 4, 90, 98, 4),
(62, 21, 1, 77, 89, 1),
(63, 11, 6, 86, 75, 11),
(64, 6, 14, 85, 80, 6),
(65, 7, 3, 87, 93, 3),
(66, 20, 11, 78, 71, 20),
(67, 4, 21, 101, 95, 4),
(68, 2, 8, 94, 90, 2),
(69, 16, 9, 79, 87, 9),
(70, 1, 5, 92, 77, 1),
(71, 14, 7, 92, 82, 14),
(72, 8, 4, 96, 90, 8),
(73, 5, 6, 118, 113, 5),
(74, 3, 9, 102, 94, 3),
(75, 11, 16, 102, 76, 11),
(76, 13, 21, 86, 81, 13),
(77, 2, 1, 74, 63, 2),
(78, 21, 2, 89, 94, 2),
(79, 4, 11, 106, 96, 4),
(80, 20, 13, 86, 79, 20),
(81, 16, 5, 71, 76, 5),
(82, 7, 8, 77, 68, 7),
(83, 9, 14, 84, 69, 9),
(84, 1, 3, 86, 76, 1),
(85, 8, 20, 75, 82, 20),
(86, 3, 4, 104, 93, 3),
(87, 13, 6, 89, 92, 6),
(88, 5, 7, 81, 67, 5),
(89, 11, 21, 98, 86, 11),
(90, 2, 16, 91, 74, 2),
(91, 14, 1, 66, 74, 1),
(92, 9, 11, 84, 80, 9),
(93, 6, 3, 93, 86, 6),
(94, 8, 14, 89, 87, 8),
(95, 16, 7, 71, 67, 16),
(96, 2, 20, 85, 84, 2),
(97, 21, 5, 79, 85, 5),
(98, 4, 13, 87, 66, 4),
(99, 20, 7, 85, 80, 20),
(100, 3, 13, 108, 83, 3),
(101, 21, 8, 84, 100, 8),
(102, 16, 4, 84, 93, 4),
(103, 9, 6, 88, 84, 9),
(104, 11, 1, 73, 95, 1),
(105, 5, 2, 75, 87, 2),
(106, 2, 9, 96, 85, 2),
(107, 8, 3, 95, 103, 3),
(108, 1, 20, 83, 77, 1),
(109, 14, 11, 93, 86, 14),
(110, 7, 21, 96, 80, 7),
(111, 6, 16, 92, 91, 6),
(112, 13, 5, 74, 106, 5),
(113, 14, 4, 85, 78, 14),
(114, 2, 6, 94, 81, 2),
(115, 5, 8, 93, 87, 5),
(116, 9, 7, 84, 82, 9),
(117, 11, 13, 95, 101, 13),
(118, 3, 20, 94, 84, 3),
(119, 16, 1, 74, 90, 1),
(120, 5, 20, 79, 80, 20),
(121, 21, 4, 81, 86, 4),
(122, 2, 3, 81, 90, 3),
(123, 6, 16, 104, 86, 6),
(124, 14, 13, 84, 76, 14),
(125, 9, 7, 61, 76, 7),
(126, 1, 8, 85, 87, 8),
(127, 16, 21, 89, 87, 16),
(128, 11, 4, 64, 79, 4),
(129, 8, 9, 84, 78, 8),
(130, 5, 14, 104, 99, 5),
(131, 20, 6, 92, 79, 20),
(132, 3, 1, 79, 87, 1),
(133, 13, 2, 71, 76, 2),
(134, 9, 3, 98, 96, 9),
(135, 14, 11, 110, 84, 14),
(136, 6, 5, 82, 89, 5),
(137, 4, 7, 79, 81, 7),
(138, 21, 8, 108, 91, 21),
(139, 1, 20, 90, 86, 1),
(140, 16, 2, 67, 86, 2),
(141, 8, 6, 96, 99, 6),
(142, 7, 14, 97, 61, 7),
(143, 11, 1, 71, 90, 1),
(144, 13, 4, 90, 91, 4),
(145, 20, 9, 81, 92, 9),
(146, 5, 16, 85, 78, 5),
(147, 2, 21, 88, 86, 2),
(148, 4, 20, 101, 94, 4),
(149, 14, 8, 84, 78, 14),
(150, 6, 7, 99, 102, 7),
(151, 9, 13, 91, 86, 9),
(152, 21, 11, 94, 77, 21),
(153, 16, 3, 78, 79, 3),
(154, 1, 2, 104, 94, 1),
(155, 2, 6, 99, 87, 2),
(156, 14, 4, 78, 84, 4),
(157, 5, 21, 100, 73, 5),
(158, 8, 3, 77, 85, 3),
(159, 11, 9, 104, 75, 11),
(160, 13, 16, 97, 94, 13),
(161, 7, 1, 84, 70, 7),
(162, 9, 5, 97, 87, 9),
(163, 4, 8, 87, 106, 8),
(164, 16, 11, 88, 81, 16),
(165, 6, 13, 103, 108, 13),
(166, 20, 2, 86, 83, 20),
(167, 21, 14, 97, 76, 21),
(168, 3, 7, 92, 101, 7),
(169, 3, 11, 100, 85, 3),
(170, 14, 9, 90, 89, 14),
(171, 13, 5, 91, 86, 13),
(172, 16, 20, 82, 73, 16),
(173, 21, 6, 80, 78, 21),
(174, 2, 7, 80, 76, 2),
(175, 1, 4, 82, 86, 4),
(176, 7, 16, 96, 78, 7),
(177, 4, 3, 74, 89, 3),
(178, 20, 14, 70, 89, 14),
(179, 9, 6, 91, 90, 9),
(180, 5, 8, 103, 84, 5),
(181, 11, 13, 88, 71, 11),
(182, 1, 21, 89, 79, 1),
(183, 8, 7, 82, 90, 7),
(184, 13, 20, 92, 82, 13),
(185, 5, 1, 69, 74, 1),
(186, 2, 11, 125, 97, 2),
(187, 6, 4, 79, 98, 4),
(188, 14, 3, 82, 86, 3),
(189, 21, 9, 100, 96, 21);

-- --------------------------------------------------------

--
-- Struttura della tabella `squadra`
--

CREATE TABLE `squadra` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `logo` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `squadra`
--

INSERT INTO `squadra` (`id`, `nome`, `logo`) VALUES
(1, 'Virtus Bologna', 'img/bologna.png'),
(2, 'Olimpia Milano', 'img/milano.png'),
(3, 'Pallacanestro Brescia', 'img/brescia.png'),
(4, 'Reyer Venezia', 'img/venezia.png'),
(5, 'Derthona Basket', 'img/tortona.png'),
(6, 'Dinamo Sassari', 'img/sassari.png'),
(7, 'Pallacanestro Reggiana', 'img/reggioemilia.png'),
(8, 'Aquila Basket Trento', 'img/trento.png'),
(9, 'Pallacanestro Varese', 'img/varese.png'),
(10, 'Victoria Libertas Pesaro', 'img/pesaro.png'),
(11, 'Napoli Basket', 'img/napoli.png'),
(12, 'New Basket Brindisi', 'img/brindisi.png'),
(13, 'Universo Treviso Basket', 'img/treviso.png'),
(14, 'Pallacanestro Trieste', 'img/trieste.png'),
(15, 'Scafati Basket', 'img/scafati.png'),
(16, 'Vanoli Cremona', 'img/cremona.png'),
(17, 'Pistoia Basket 2000', 'img/pistoia.png'),
(18, 'Scaligera Basket Verona', 'img/verona.png'),
(19, 'Fortitudo Bologna 103', 'img/fortitudo.png'),
(20, 'APU Udine', 'img/udine.png'),
(21, 'Pallacanestro Cantù', 'img/cantu.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL,
  `admin` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `risultato`
--
ALTER TABLE `risultato`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_squadra1` (`id_squadra1`),
  ADD KEY `id_squadra2` (`id_squadra2`),
  ADD KEY `vincitore` (`vincitore`);

--
-- Indici per le tabelle `squadra`
--
ALTER TABLE `squadra`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `risultato`
--
ALTER TABLE `risultato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `risultato`
--
ALTER TABLE `risultato`
  ADD CONSTRAINT `risultato_ibfk_1` FOREIGN KEY (`id_squadra1`) REFERENCES `squadra` (`id`),
  ADD CONSTRAINT `risultato_ibfk_2` FOREIGN KEY (`id_squadra2`) REFERENCES `squadra` (`id`),
  ADD CONSTRAINT `risultato_ibfk_3` FOREIGN KEY (`vincitore`) REFERENCES `squadra` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

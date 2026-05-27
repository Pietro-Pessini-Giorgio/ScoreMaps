-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 27, 2026 alle 09:31
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
-- Struttura della tabella `squadra`
--

CREATE TABLE `squadra` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `logo` tinytext NOT NULL,
  `id_sport` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `squadra`
--

INSERT INTO `squadra` (`id`, `nome`, `logo`, `id_sport`) VALUES
(1, 'Virtus Bologna', 'img/bologna.png', 1),
(2, 'Olimpia Milano', 'img/milano.png', 1),
(3, 'Pallacanestro Brescia', 'img/brescia.png', 1),
(4, 'Reyer Venezia', 'img/venezia.png', 1),
(5, 'Derthona Basket', 'img/tortona.png', 1),
(6, 'Dinamo Sassari', 'img/sassari.png', 1),
(7, 'Pallacanestro Reggiana', 'img/reggioemilia.png', 1),
(8, 'Aquila Basket Trento', 'img/trento.png', 1),
(9, 'Pallacanestro Varese', 'img/varese.png', 1),
(11, 'Napoli Basket', 'img/napoli.png', 1),
(13, 'Universo Treviso Basket', 'img/treviso.png', 1),
(14, 'Pallacanestro Trieste', 'img/trieste.png', 1),
(16, 'Vanoli Cremona', 'img/cremona.png', 1),
(20, 'APU Udine', 'img/udine.png', 1),
(21, 'Pallacanestro Cantù', 'img/cantu.png', 1),
(22, 'Bartoccini-Mc Restauri Perugia', 'img/perugia.png', 2),
(23, 'Bergamo', 'img/bergamo.png', 2),
(24, 'Cbf Balducci Hr Macerata', 'img/macerata.png', 2),
(25, 'Eurotek Laica Uyba', 'img/uyba.png', 2),
(26, 'Honda Cuneo Granda Volley', 'img/cuneo.png', 2),
(27, 'Igor Gorgonzola Novara', 'img/novara.png', 2),
(28, 'Il Bisonte Firenze', 'img/firenze.png', 2),
(29, 'Megabox Ond. Savio Vallefoglia', 'img/vallefoglia.png', 2),
(30, 'Numia Vero Volley Milano', 'img/veromilano.png', 2),
(31, 'Omag-Mt San Giovanni In M.No', 'img/sangiovanni.png', 2),
(32, 'Prosecco Doc A.Carraro Imoco Conegliano', 'img/conegliano.png', 2),
(33, 'Reale Mutua Fenera Chieri \'76', 'img/chieri.png', 2),
(34, 'Savino Del Bene Scandicci', 'img/scandicci.png', 2),
(35, 'Wash4green Monviso Volley', 'img/monviso.png', 2),
(36, 'Famila Wuber Schio', 'img/schio.png', 3),
(37, 'Umana Reyer Venezia', 'img/venezia.png', 3),
(38, 'La Molisana Magnolia Campobasso', 'img/campobasso.png', 3),
(39, 'Autosped G Bcc Derthona', 'img/tortona.png', 3),
(40, 'Geas Sesto San Giovanni', 'img/geas.png', 3),
(41, 'People Strategy Panthers Roseto', 'img/roseto.png', 3),
(42, 'Alama San Martino Di Lupari', 'img/lupari.png', 3),
(43, 'Logiman Broni', 'img/broni.png', 3),
(44, 'Dinamo Banco Di Sardegna Women', 'img/sassari.png', 3),
(45, 'RMB Brixia Basket', 'img/brixia.png', 3),
(46, 'O.Me.P.S. Battipaglia', 'img/battipaglia.png', 3),
(47, 'Allianz Milano', 'img/allianz_milano.png', 4),
(48, 'Cisterna Volley', 'img/cisterna.png', 4),
(49, 'Cucine Lube Civitanova', 'img/civitanova.png', 4),
(50, 'Gas Sales Bluenergy Piacenza', 'img/piacenza.png', 4),
(51, 'Itas Trentino', 'img/itas_trentino.png', 4),
(52, 'MA Acqua S.Bernardo Cuneo', 'img/cuneo_m.png', 4),
(53, 'Rana Verona', 'img/verona.png', 4),
(54, 'Sir Susa Scai Perugia', 'img/perugia_m.png', 4),
(55, 'Sonepar Padova', 'img/padova.png', 4),
(56, 'Valsa Group Modena', 'img/modena.png', 4),
(57, 'Vero Volley Monza', 'img/monza.png', 4),
(58, 'Yuasa Battery Grottazzolina', 'img/grottazzolina.png', 4),
(59, 'C.u.s. Genova Asd', 'img/cus_genova.png', 5),
(60, 'Asd Unione Monferrato Rugby', 'img/monferrato.png', 5),
(61, 'Asd Amatori Rugby Capoterra', 'img/capoterra.png', 5),
(62, 'Rugby Sondrio Soc.coop.dil. Arl', 'img/sondrio.png', 5),
(63, 'Asd Rugby Cernusco', 'img/cernusco.png', 5),
(64, 'Cus Milano Rugby Asd', 'img/cus_milano.png', 5),
(65, 'Asd Rugby San Mauro', 'img/san_mauro.png', 5),
(66, 'Ivrea Rugby Club Asd', 'img/ivrea.png', 5),
(67, 'Rugby Rho Asd', 'img/rho.png', 5),
(68, 'Asd Rugby Varese', 'img/rugby_varese.png', 5);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `squadra`
--
ALTER TABLE `squadra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_sport` (`id_sport`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `squadra`
--
ALTER TABLE `squadra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `squadra`
--
ALTER TABLE `squadra`
  ADD CONSTRAINT `FK_squadra_sport` FOREIGN KEY (`id_sport`) REFERENCES `sport` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

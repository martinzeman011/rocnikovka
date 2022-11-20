-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 20. lis 2022, 11:52
-- Verze serveru: 10.4.25-MariaDB
-- Verze PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `bass_acad`
--

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `TestTroju` (IN `a` INT, IN `b` INT, IN `c` INT)   BEGIN
    DECLARE typ VARCHAR(55);

    IF(a = b AND a != c)THEN
        SET typ = "rovnoramenný";
    ELSEIF(b = c AND b != a)THEN
        SET typ = "rovnoramenný";
    ELSEIF(a = c AND a != b)THEN
        SET typ = "rovnoramenný";
    ELSEIF(POWER(b, 2) + POWER(c, 2) = POWER(a, 2))THEN
        SET typ = "pravoúhlý";
    ELSEIF(POWER(a, 2) + POWER(c, 2) = POWER(b, 2))THEN
        SET typ = "pravoúhlý";
    ELSEIF(POWER(a, 2) + POWER(b, 2) = POWER(c, 2))THEN
        SET typ = "pravoúhlý";
    ELSEIF(a = b AND a = c)THEN 
        SET typ = "rovnostranný";
    ELSEIF(a + b > c AND a + c > b AND b + c > a)THEN 
        SET typ = "obecný";
    ELSE 
        SET typ = "nelze sestrojit";
    END IF;

    SELECT a, b, c, typ AS "Typ Trojuhelniku";
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE `uzivatele` (
  `id_uziv` int(11) NOT NULL,
  `uziv_jmeno` varchar(45) NOT NULL,
  `heslo` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `over_kod` varchar(45) NOT NULL,
  `overeni` tinyint(1) NOT NULL DEFAULT 0,
  `datum` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id_uziv`, `uziv_jmeno`, `heslo`, `email`, `over_kod`, `overeni`, `datum`) VALUES
(16, 'martnzeman', 'f2b74407c920083a677af222e0f0304c8bcd80f7', 'martinzeman011@gmail.com', '39ffeb107a9a632b2fb7ddd8184513a0', 1, '2022-11-20 09:54:23.511494');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id_uziv`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `id_uziv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

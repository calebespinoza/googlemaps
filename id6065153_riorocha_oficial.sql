-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-06-2018 a las 04:14:02
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id6065153_riorocha`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `markers`
--

CREATE TABLE `markers` (
  `MarkerID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Latitude` varchar(255) NOT NULL,
  `Longitude` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `markers`
--

INSERT INTO `markers` (`MarkerID`, `Name`, `Latitude`, `Longitude`) VALUES
(1, 'Puente Siles', '-17.374979', '-66.131331'),
(2, 'Puente Cobija', '-17.387925', '-66.164950'),
(3, 'Colcapirhua', '-17.411623', '-66.231694');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `watersamples`
--

CREATE TABLE `watersamples` (
  `SampleID` int(11) NOT NULL,
  `PersonName` varchar(255) NOT NULL,
  `UpdatingDate` date NOT NULL,
  `TotalValue` int(11) NOT NULL,
  `Category` varchar(255) NOT NULL,
  `Quality` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Color` varchar(100) NOT NULL,
  `MarkerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `watersamples`
--

INSERT INTO `watersamples` (`SampleID`, `PersonName`, `UpdatingDate`, `TotalValue`, `Category`, `Quality`, `Description`, `Color`, `MarkerID`) VALUES
(2, 'Andrea Vargas', '2018-05-12', 6, 'V', 'Muy Crítica', 'Aguas fuertemente contaminadas', 'red', 1),
(3, 'Cintia Ojeda', '2018-05-19', 5, 'V', 'Muy Crítica', 'Aguas fuertemente contaminadas', 'red', 1),
(4, 'Rodrigo Meruvia', '2018-05-25', 16, 'IV', 'Crítica', 'Aguas muy contaminadas', 'orange', 2),
(5, 'Rodrigo Meruvia', '2018-06-02', 13, 'V', 'Muy Crítica', 'Aguas fuertemente contaminadas', 'red', 2),
(6, 'Cintia Ojeda', '2018-05-19', 2, 'V', 'Muy Crítica', 'Aguas fuertemente contaminadas', 'red', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `markers`
--
ALTER TABLE `markers`
  ADD PRIMARY KEY (`MarkerID`);

--
-- Indices de la tabla `watersamples`
--
ALTER TABLE `watersamples`
  ADD PRIMARY KEY (`SampleID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `markers`
--
ALTER TABLE `markers`
  MODIFY `MarkerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `watersamples`
--
ALTER TABLE `watersamples`
  MODIFY `SampleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

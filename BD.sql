-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_serv
-- Tempo de geração: 03/05/2024 às 09:50
-- Versão do servidor: 10.9.8-MariaDB-1:10.9.8+maria~ubu2204
-- Versão do PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `adbneto_05`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `Etudiant`
--

CREATE TABLE `Etudiant` (
  `idE` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `VilleDomicileP` int(11) NOT NULL,
  `VilleDomicileS` int(11) DEFAULT NULL,
  `groupe` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Etudiant`
--

INSERT INTO `Etudiant` (`idE`, `Nom`, `Prenom`, `VilleDomicileP`, `VilleDomicileS`, `groupe`) VALUES
(1, 'Neto', 'Anete', 1, NULL, 'GB2'),
(2, 'Barbault', 'Raphaël', 1, 9, 'LK1'),
(3, 'Wade', 'Diarra', 1, NULL, 'GB2'),
(4, 'EL AMRANI', 'Lina', 1, NULL, 'GB2'),
(5, 'Ozkan', 'Omer-Arif', 3, NULL, 'GB1'),
(6, 'CHAKIR', 'Adam', 1, NULL, 'GB2'),
(7, 'Alkhalaf', 'Farah', 1, 10, 'GB2'),
(8, 'MARC', 'Romain', 1, NULL, 'LK2'),
(9, 'Fadili Hach', 'Mohamed-Salem', 11, 1, 'LK1'),
(10, 'Otmar', 'Zakariya', 12, NULL, 'LK1'),
(11, 'MERIALDO--BÊCHE', 'Aixandre', 1, 13, 'LK1'),
(12, 'ANTONIO', 'Catarino', 1, NULL, 'LK1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Mesure`
--

CREATE TABLE `Mesure` (
  `IdM` int(11) NOT NULL,
  `IdR` int(11) NOT NULL,
  `Temperature` int(11) NOT NULL,
  `Description` text NOT NULL,
  `VentVitesse` float NOT NULL,
  `Date` datetime NOT NULL,
  `Icone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Mesure`
--

INSERT INTO `Mesure` (`IdM`, `IdR`, `Temperature`, `Description`, `VentVitesse`, `Date`, `Icone`) VALUES
(9, 1, 18, 'nuageux', 4.87, '2024-04-30 10:58:00', '04d'),
(10, 6, 18, 'ciel dégagé', 2.06, '2024-04-30 10:57:00', '01d'),
(11, 5, 18, 'ciel dégagé', 1.03, '2024-04-30 10:54:00', '01d'),
(12, 3, 16, 'nuageux', 3.88, '2024-04-30 10:23:00', '04d'),
(13, 7, 16, 'ciel dégagé', 0.7, '2024-04-30 10:10:00', '01d'),
(14, 2, 15, 'ciel dégagé', 1.34, '2024-04-30 10:13:00', '01d'),
(15, 8, 13, 'ciel dégagé', 3.09, '2024-04-30 10:26:00', '01d'),
(16, 4, 12, 'bruine légère', 4.12, '2024-04-30 10:10:00', '09d'),
(17, 2, 15, 'nuageux', 4.87, '2024-04-29 15:07:18', '04d'),
(18, 1, 12, 'légère pluie', 4.14, '2024-05-02 03:14:47', '10n'),
(19, 3, 13, 'couvert', 4.27, '2024-05-02 03:16:14', '04n'),
(20, 9, 11, 'couvert', 3.26, '2024-05-02 03:16:14', '04n'),
(21, 10, 11, 'couvert', 3.09, '2024-05-02 03:12:47', '04n'),
(22, 11, 9, 'couvert', 3.86, '2024-05-02 03:16:15', '04n'),
(23, 12, 15, 'couvert', 5.95, '2024-05-02 03:16:15', '04n'),
(24, 13, 12, 'légère pluie', 4.11, '2024-05-02 03:16:16', '10n'),
(25, 14, 15, 'nuageux', 4.92, '2024-05-02 03:11:53', '04n'),
(27, 1, 9, 'couvert', 4.09, '2024-05-03 07:03:34', '04d'),
(28, 2, 10, 'couvert', 1.34, '2024-05-03 06:59:59', '04d'),
(29, 3, 9, 'couvert', 4.04, '2024-05-03 07:00:03', '04d'),
(30, 4, 10, 'peu nuageux', 4.63, '2024-05-03 07:00:02', '02d'),
(31, 5, 11, 'ciel dégagé', 4.12, '2024-05-03 06:58:51', '01d'),
(32, 6, 12, 'couvert', 4.63, '2024-05-03 07:00:01', '04d'),
(33, 7, 12, 'couvert', 5.53, '2024-05-03 07:00:18', '04d'),
(34, 8, 9, 'nuageux', 2.06, '2024-05-03 07:00:01', '04d'),
(35, 9, 10, 'couvert', 1.89, '2024-05-03 07:03:36', '04d'),
(36, 10, 10, 'peu nuageux', 4.63, '2024-05-03 07:00:02', '02d'),
(37, 11, 13, 'couvert', 4.46, '2024-05-03 07:00:04', '04d'),
(38, 12, 11, 'couvert', 5.31, '2024-05-03 07:03:36', '04d'),
(39, 13, 9, 'couvert', 4.08, '2024-05-03 06:59:59', '04d'),
(40, 14, 10, 'couvert', 1.34, '2024-05-03 06:59:59', '04d');

-- --------------------------------------------------------

--
-- Estrutura para tabela `Residence`
--

CREATE TABLE `Residence` (
  `IdR` int(11) NOT NULL,
  `Ville` varchar(50) NOT NULL,
  `CodePostal` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `Residence`
--

INSERT INTO `Residence` (`IdR`, `Ville`, `CodePostal`) VALUES
(1, 'Montbéliard', '25200'),
(2, 'Mulhouse', '68200'),
(3, 'Belfort', '90000'),
(4, 'Paris', '75000'),
(5, 'Bordeaux', '33000'),
(6, 'Strasbourg', '67100'),
(7, 'Haguenau', '67500'),
(8, 'Nantes', '44000'),
(9, 'Bonnay', '25870'),
(10, 'Paris', '92410'),
(11, 'Libourne', '33500'),
(12, 'Kingersheim', '68260'),
(13, 'SELONCOURT', '25230'),
(14, 'Mulhouse', '68100');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `Etudiant`
--
ALTER TABLE `Etudiant`
  ADD PRIMARY KEY (`idE`),
  ADD KEY `VilleDomicileP` (`VilleDomicileP`),
  ADD KEY `VilleDomicileS` (`VilleDomicileS`);

--
-- Índices de tabela `Mesure`
--
ALTER TABLE `Mesure`
  ADD PRIMARY KEY (`IdM`),
  ADD KEY `Residence` (`IdR`);

--
-- Índices de tabela `Residence`
--
ALTER TABLE `Residence`
  ADD PRIMARY KEY (`IdR`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `Etudiant`
--
ALTER TABLE `Etudiant`
  MODIFY `idE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `Mesure`
--
ALTER TABLE `Mesure`
  MODIFY `IdM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `Residence`
--
ALTER TABLE `Residence`
  MODIFY `IdR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `Etudiant`
--
ALTER TABLE `Etudiant`
  ADD CONSTRAINT `Etudiant_ibfk_1` FOREIGN KEY (`VilleDomicileP`) REFERENCES `Residence` (`IdR`),
  ADD CONSTRAINT `Etudiant_ibfk_2` FOREIGN KEY (`VilleDomicileS`) REFERENCES `Residence` (`IdR`);

--
-- Restrições para tabelas `Mesure`
--
ALTER TABLE `Mesure`
  ADD CONSTRAINT `Mesure_ibfk_1` FOREIGN KEY (`IdR`) REFERENCES `Residence` (`IdR`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Mar-2026 às 15:37
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `localizacao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `caminhoes`
--

CREATE TABLE `caminhoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `placa` varchar(20) DEFAULT NULL,
  `motorista` varchar(100) DEFAULT NULL,
  `lat_base` decimal(10,8) DEFAULT NULL,
  `lng_base` decimal(11,8) DEFAULT NULL,
  `raio_atendimento` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `rota_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `caminhoes`
--

INSERT INTO `caminhoes` (`id`, `nome`, `placa`, `motorista`, `lat_base`, `lng_base`, `raio_atendimento`, `status`, `rota_id`) VALUES
(1, 'Caminhão 1', '123', 'Sarah', -23.89026191, -46.42581940, 5, 'Ativo', NULL),
(2, 'Santos', '321', 'Andelson', -23.95586548, -46.34664059, 3, 'Ativo', NULL),
(3, 'Gonzaga', '258', 'Zezim', -23.97058937, -46.31526947, 5, 'Ativo', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gps_caminhao`
--

CREATE TABLE `gps_caminhao` (
  `id` int(11) NOT NULL,
  `caminhao_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `data_hora` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `gps_caminhao`
--

INSERT INTO `gps_caminhao` (`id`, `caminhao_id`, `latitude`, `longitude`, `data_hora`) VALUES
(1, 2, -23.96150000, -46.33390000, '2026-03-12 20:40:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `moradores`
--

CREATE TABLE `moradores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `rua` varchar(150) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `rota_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `moradores`
--

INSERT INTO `moradores` (`id`, `nome`, `rua`, `latitude`, `longitude`, `rota_id`) VALUES
(1, 'João', 'Rua Azevedo Sodré', -23.96630000, -46.32980000, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rotas`
--

CREATE TABLE `rotas` (
  `id` int(11) NOT NULL,
  `nome_rota` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `rotas`
--

INSERT INTO `rotas` (`id`, `nome_rota`, `descricao`) VALUES
(1, 'Rota Centro', 'Coleta região central'),
(2, 'Cubatão', 'Vila dos pescadores');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rota_pontos`
--

CREATE TABLE `rota_pontos` (
  `id` int(11) NOT NULL,
  `rota_id` int(11) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `rota_pontos`
--

INSERT INTO `rota_pontos` (`id`, `rota_id`, `latitude`, `longitude`, `ordem`) VALUES
(10, 2, -23.92442430, -46.40646458, 1),
(11, 2, -23.89566690, -46.42566919, 2),
(12, 1, -23.95643047, -46.34451628, 1),
(13, 1, -23.95805802, -46.32752180, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rota_ruas`
--

CREATE TABLE `rota_ruas` (
  `id` int(11) NOT NULL,
  `rota_id` int(11) DEFAULT NULL,
  `rua_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ruas`
--

CREATE TABLE `ruas` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `ruas`
--

INSERT INTO `ruas` (`id`, `nome`, `latitude`, `longitude`) VALUES
(1, 'Rua das Flores', -23.96080000, -46.33360000),
(2, 'Rua da Praia', -23.95990000, -46.33510000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `nivel` enum('admin','motorista','usuario') DEFAULT NULL,
  `caminhao_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `caminhoes`
--
ALTER TABLE `caminhoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rota` (`rota_id`);

--
-- Índices para tabela `gps_caminhao`
--
ALTER TABLE `gps_caminhao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caminhao_id` (`caminhao_id`);

--
-- Índices para tabela `moradores`
--
ALTER TABLE `moradores`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `rotas`
--
ALTER TABLE `rotas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `rota_pontos`
--
ALTER TABLE `rota_pontos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `rota_ruas`
--
ALTER TABLE `rota_ruas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ruas`
--
ALTER TABLE `ruas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `caminhoes`
--
ALTER TABLE `caminhoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `gps_caminhao`
--
ALTER TABLE `gps_caminhao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `moradores`
--
ALTER TABLE `moradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `rotas`
--
ALTER TABLE `rotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `rota_pontos`
--
ALTER TABLE `rota_pontos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `rota_ruas`
--
ALTER TABLE `rota_ruas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ruas`
--
ALTER TABLE `ruas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `caminhoes`
--
ALTER TABLE `caminhoes`
  ADD CONSTRAINT `fk_rota` FOREIGN KEY (`rota_id`) REFERENCES `rotas` (`id`);

--
-- Limitadores para a tabela `gps_caminhao`
--
ALTER TABLE `gps_caminhao`
  ADD CONSTRAINT `fk_caminhao_gps` FOREIGN KEY (`caminhao_id`) REFERENCES `caminhoes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

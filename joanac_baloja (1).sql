-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 10.123.0.211:3307
-- Tempo de geração: 10/04/2025 às 19:07
-- Versão do servidor: 8.0.25
-- Versão do PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `joanac_baloja`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int NOT NULL,
  `login_clientes` int NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci TABLESPACE `joanac_baloja`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int NOT NULL,
  `pedidos_id` int NOT NULL,
  `produtos_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `login_cliente` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci TABLESPACE `joanac_baloja`;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `pedidos_id`, `produtos_id`, `quantidade`, `preco`, `login_cliente`) VALUES
(22, 22, 11, 1, 85.00, ''),
(23, 23, 21, 1, 85.00, ''),
(24, 24, 21, 1, 85.00, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login_clientes`
--

CREATE TABLE `login_clientes` (
  `ID` int NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `enderecos` int DEFAULT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `rg` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 TABLESPACE `joanac_baloja`;

--
-- Despejando dados para a tabela `login_clientes`
--

INSERT INTO `login_clientes` (`ID`, `nome`, `email`, `senha`, `is_admin`, `reset_token`, `token_expiration`, `verification_code`, `telefone`, `enderecos`, `cpf`, `rg`) VALUES
(4, NULL, 'admin@example.com', '$2y$10$cnKkzIo6qC5n3SFSXminZePAgLUS8k7sSpjDqgueb5r3IBEPk8vYa', 2, 'd544c7d0e3922337ba2005ebdbb243bb', '2024-09-13 07:45:00', '9c99a541d453', NULL, NULL, NULL, NULL),
(5, 'João Pedro Diniz Nacur', 'luisoujpof@gmail.com', '$2y$10$bGmcNOM3g69YEgohYoMpDOsKXskAFv77jYyUxDNHnX8ELLMQf0te6', 0, 'eeb9597849fd80c2350f47c92c0d9098', '2024-09-26 13:09:25', '883682', NULL, NULL, NULL, NULL),
(6, 'Gabriel ', '7stevensdiamante@gmail.com', '$2y$10$YOGlGSHrtO8zHgGMjhjFEu0qoqfWTBnTg.IZpGDahuclw9FN6Oi1S', 0, NULL, NULL, 'e7f00bf653ab', NULL, NULL, NULL, NULL),
(7, 'ribino', 'josefaustoduarte@gmail.com', '$2y$10$s7aqNo3W/GY.PSLBcg2dC.21DZCEREGstzyezA5K4ItQJSK292CXS', 0, '020b8cdab1869e7a7188286d0ec5af73', '2024-09-20 13:09:21', '938417', NULL, NULL, NULL, NULL),
(8, 'Gabriel', 'gabriellandgraf@gmail.com', '$2y$10$8GYcse6WlkVv8nVoRiV7WeiPAnGiRRinkvzhniJispug6M4v.f4sC', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'ribino-verdadeiro', 'mail@mail.com', '$2y$10$eD67dvDRavfyyxLnlqBgTOtuuv1gfh4fn1NsWQDZJwDJGgN8z3yna', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Isabelli', 'isa@hotmail.com', '$2y$10$wfdW7xKICgd.k7DhmdbPg.lcuGBgUlstAQYkjm.rUSciPPrzeSEPG', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'gabriel', 'landgraf@gmail.com', '$2y$10$NRrxQMTys6ljpHEUNjO7kOXieHNtncYGIv8iXty5B2e9cnUZ5G5aC', 0, '4535b70934d1edcb9156ee6358ee1437', '2024-09-20 18:53:53', '931837', NULL, NULL, NULL, NULL),
(13, 'ribino', 'teste@gmail.com', '$2y$10$oFkM4vxETNsluDPYlNTMl.4FXVkZbkGEkH8sskFVY6SH0T2muuNau', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'silviosantos', 'diego.souza.dias@escola.pr.gov.br', '$2y$10$pHXf0MKL4ki5aKz./5e/4.Bjcb/H28sEb3jLbfkWYYQaDapcCWVs.', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Isabelli', 'isabelli@gmail.com', '$2y$10$Ctc0vV5Ijr9HK3vPQgRtserq5PVD51BXZhk2ocnUZXJdW9JYFYZbG', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'ribino', 'joseribino@gmail.com', '$2y$10$kHsEL3FYQZHchv8x096OluLKGjgoGPTYHkrUzrpk2KCp0qaDKLBNu', 0, '115ff35a22158c062066135b4fcc4ecd', '2024-09-20 19:26:17', '634550', NULL, NULL, NULL, NULL),
(17, 'Kurt Cobain Sobe Capa', 'kurtcobainsobecapa@gmail.com', '$2y$10$3AWK0.ZGLEADbfecorlY.OP/67IowOdXuIGkeYOzAIk6BWJFHqbW2', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'ribino', 'jose@gmail.com', '$2y$10$6euHj6txdmf5JjhuK9QHCuS/5QWuoY7FI0CD1k4JyWiuKrC8FkCTa', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `login_clientes` int NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `endereco` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bairro` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cidade` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `estado` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `cep` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `data_pedido` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci TABLESPACE `joanac_baloja`;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `login_clientes`, `nome`, `email`, `telefone`, `endereco`, `numero`, `bairro`, `cidade`, `estado`, `cep`, `total`, `data_pedido`) VALUES
(22, 0, 'João Pedro Diniz Nacur', 'luisoujpof@gmail.com', '43999300814', 'Rua marechal Deodoro da Fonseca', '556', 'Centro', 'Cornélio Procópio', 'PR', '86300-000', 85.00, '2024-09-26 16:34:32'),
(23, 0, 'João Pedro Diniz Nacur', 'luisoujpof@gmail.com', '43999300814', 'Rua marechal Deodoro da Fonseca', '556', 'Centro', 'Cornélio Procópio', 'PR', '86300-000', 85.00, '2024-09-26 16:40:49'),
(24, 0, 'João Pedro Diniz Nacur', 'luisoujpof@gmail.com', '43999300814', 'Rua marechal Deodoro da Fonseca', '556', 'Centro', 'Cornélio Procópio', 'PR', '86300-000', 85.00, '2024-09-30 13:14:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `descricao` text COLLATE utf8mb4_general_ci,
  `preco` decimal(10,2) NOT NULL,
  `altura` decimal(10,2) DEFAULT NULL,
  `largura` decimal(10,2) DEFAULT NULL,
  `comprimento` decimal(10,2) DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto5` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `foto6` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pedidos` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `joanac_baloja`;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `altura`, `largura`, `comprimento`, `foto`, `foto2`, `foto3`, `foto4`, `foto5`, `foto6`, `categoria`, `pedidos`) VALUES
(11, 'Lancheira', 'Mantenha seus lanches frescos e organizados com nossa lancheira retangular personalizada. Feita com materiais de alta qualidade, ela possui um design compacto e espaçoso, ideal para o dia a dia. Com forro térmico, alça ajustável e opções de personalização com nome ou estampas, são perfeita para levar estilo e praticidade em qualquer lugar.', 85.00, 20.00, 15.00, 25.00, '0dab1a4e-c941-465c-bc5b-630a81507f8d.jpg', '3a98f714-edf1-4056-9517-e01ccbe5ad9c.jpg', '5f732748-289f-43d8-af55-be93345b9b65.jpg', '991f3884-295b-49ea-9c07-43ee451bf0d4.jpg', NULL, NULL, 'Lancheira', 0),
(19, 'Bolsa Professora', 'bolsa', 75.00, 35.00, 45.00, 45.00, 'ecc8ea84-a4c2-4759-8aa9-1387f69d1ea9.jpg', '43788aa7-4b79-44d1-aca8-8a3bb2745eb4.jpg', 'ecc8ea84-a4c2-4759-8aa9-1387f69d1ea9.jpg', '43788aa7-4b79-44d1-aca8-8a3bb2745eb4.jpg', NULL, NULL, 'Mochilas', 0),
(21, 'Lancheira', 'Mantenha seus lanches frescos e organizados com nossa lancheira retangular personalizada. Feita com materiais de alta qualidade, ela possui um design compacto e espaçoso, ideal para o dia a dia. Com forro térmico, alça ajustável e opções de personalização com nome ou estampas, são perfeita para levar estilo e praticidade em qualquer lugar.', 85.00, 1.00, 1.00, 1.00, 'lancheirarosa1.jpg', 'lancheirarosa2.jpg', 'lancheirarosa3.jpg', 'lancheirarosa4.jpg', NULL, NULL, 'Lancheira', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `venda`
--

CREATE TABLE `venda` (
  `id` int NOT NULL,
  `produtos` int NOT NULL,
  `quantidade` int NOT NULL,
  `login_clientes` int NOT NULL,
  `data_venda` datetime DEFAULT CURRENT_TIMESTAMP,
  `valor_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `joanac_baloja`;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_clientes` (`login_clientes`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedidos_id` (`pedidos_id`);

--
-- Índices de tabela `login_clientes`
--
ALTER TABLE `login_clientes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `enderecos` (`enderecos`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produtos` (`produtos`),
  ADD KEY `login_clientes` (`login_clientes`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `login_clientes`
--
ALTER TABLE `login_clientes`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`login_clientes`) REFERENCES `login_clientes` (`ID`) ON DELETE CASCADE;

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `itens_pedido_ibfk_1` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `login_clientes`
--
ALTER TABLE `login_clientes`
  ADD CONSTRAINT `login_clientes_ibfk_1` FOREIGN KEY (`enderecos`) REFERENCES `enderecos` (`id`);

--
-- Restrições para tabelas `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `venda_ibfk_1` FOREIGN KEY (`produtos`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `venda_ibfk_2` FOREIGN KEY (`login_clientes`) REFERENCES `login_clientes` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

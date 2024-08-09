-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 09/08/2024 às 14:19
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fast_food`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comida`
--

DROP TABLE IF EXISTS `comida`;
CREATE TABLE IF NOT EXISTS `comida` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `categoria` varchar(200) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `img` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `comida`
--

INSERT INTO `comida` (`id`, `nome`, `categoria`, `descricao`, `preco`, `img`) VALUES
(1, 'Margherita', 'Pizza', 'Molho de tomate, mussarela de búfala, manjericão fresco e um fio de azeite de oliva.', 30.00, 'img\\pizza-margherita.jfif'),
(2, 'Calabresa', 'Pizza', 'Molho de tomate, mussarela, calabresa fatiada e cebola.', 35.00, 'img\\pizza-calabresa.jfif'),
(5, 'Quatro Queijos', 'Pizza', 'Molho de tomate, mussarela, gorgonzola, parmesão e catupiry.', 40.00, 'img\\pizza-quatroQueijos.jfif'),
(7, 'Portuguesa', 'Pizza', 'Molho de tomate, mussarela, presunto, ovos, cebola, azeitonas e orégano.', 38.00, 'img\\202407181611_gbGC_.avif'),
(8, 'Frango com Catupiry', 'Pizza', 'Molho de tomate, mussarela, frango desfiado, catupiry e milho.', 37.00, 'img\\pizza-FrangoCatupiry.jfif'),
(9, 'Pepperoni', 'Pizza', 'Molho de tomate, mussarela e pepperoni fatiado.', 36.00, 'img\\pizza-Pepperoni.jfif'),
(10, 'Vegetariana', 'Pizza', 'Molho de tomate, mussarela, pimentão, cebola, azeitonas, brócolis e cogumelos.', 34.00, 'img\\pizzaVegetariana.jfif'),
(11, 'Atum', 'Pizza', 'Molho de tomate, mussarela, atum, cebola e azeitonas.', 35.00, 'img\\pizza-atum.jfif'),
(12, 'Napolitana', 'Pizza', 'Molho de tomate, mussarela, tomate em rodelas, alho e manjericão.', 32.00, 'img\\pizza-napolitana.jfif'),
(13, 'Bacon', 'Pizza', 'Molho de tomate, mussarela, bacon fatiado e cebola roxa.', 38.00, 'img\\pizza-Bacon.jfif'),
(14, 'Cheeseburger Clássico', 'Hambúrguer', 'Pão, hambúrguer de carne bovina, queijo cheddar, alface, tomate e molho especial.', 25.00, 'img\\CheeseburgerClássico.jfif'),
(15, 'Bacon Burger', 'Hambúrguer', 'Pão, hambúrguer de carne bovina, queijo cheddar, bacon crocante, alface, tomate e maionese.', 28.00, 'img\\BaconBurger.jfif'),
(16, 'Chicken Burger', 'Hambúrguer', 'Pão, filé de frango grelhado, queijo suíço, alface, tomate e molho de mostarda e mel.', 27.00, 'img\\ChickenBurger.jfif'),
(17, 'Veggie Burger', 'Hambúrguer', 'Pão, hambúrguer de grão-de-bico, alface, tomate, cebola roxa e maionese de ervas.', 24.00, 'img\\VeggieBurger.jfif'),
(18, 'Double Cheeseburger', 'Hambúrguer', 'Pão, dois hambúrgueres de carne bovina, queijo cheddar duplo, cebola caramelizada e molho barbecue.', 32.00, 'img\\DoubleCheeseburger.jfif'),
(19, 'BBQ Burger', 'Hambúrguer', 'Pão, hambúrguer de carne bovina, queijo cheddar, bacon, cebola frita e molho barbecue.', 29.00, 'img\\BBQBurger.jfif'),
(20, 'Blue Cheese Burger', 'Hambúrguer', 'Pão, hambúrguer de carne bovina, queijo gorgonzola, rúcula e cebola roxa.', 30.00, 'img\\BlueCheeseBurger.jfif'),
(21, 'Avocado Burger', 'Hambúrguer', 'Pão, hambúrguer de carne bovina, queijo suíço, abacate fatiado, alface e tomate.', 31.00, 'img\\AvocadoBurger.jfif'),
(22, 'Spicy Burger', 'Hambúrguer', 'Pão, hambúrguer de carne bovina, queijo pepper jack, jalapeños, alface e molho picante.', 29.00, 'img\\SpicyBurger.jfif'),
(23, 'Egg Burger', 'Hambúrguer', 'Pão, hambúrguer de carne bovina, queijo cheddar, ovo frito, alface, tomate e maionese.', 28.00, 'img\\EggBurger.jfif');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

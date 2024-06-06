-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 03 juin 2024 à 19:46
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `checklist`
--

-- --------------------------------------------------------

--
-- Structure de la table `Categories`
--

CREATE TABLE `Categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Checklists`
--

CREATE TABLE `Checklists` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Checklists`
--

INSERT INTO `Checklists` (`id`, `titre`, `description`, `user_id`) VALUES
(2, 'az', 'az', 1),
(3, 'tkt chef ', 'finir mais projet', 1),
(4, 'tg', 'js pk \\r\\n', 1),
(5, 'futchapm', 'tkt', 1),
(7, 'TITRE', '\\r\\nKT', 4),
(10, 'anglais ', 'mardi ', 6);

-- --------------------------------------------------------

--
-- Structure de la table `Checklist_Categories`
--

CREATE TABLE `Checklist_Categories` (
  `checklist_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Items`
--

CREATE TABLE `Items` (
  `id` int(11) NOT NULL,
  `texte` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  `checklist_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Items`
--

INSERT INTO `Items` (`id`, `texte`, `etat`, `checklist_id`) VALUES
(3, 'ze', 0, 2),
(5, 'rezfdjgfrezy!fgezy!rugfz', 0, 3),
(6, 'azzazazaza', 0, 3),
(7, 'azaza', 0, 4),
(10, 'fut', 0, 2),
(13, 'antho', 0, 2),
(18, 'gergergre', 0, 2),
(19, 'fdgfdgfdg', 0, 4),
(20, 'azsa', 0, 2),
(21, 'rezfdjgfrezy!fgezy!rugfz', 0, 3),
(22, 'rezfdjgfrezy!fgezy!rugfz', 0, 2),
(23, 'azzzz', 0, 3),
(25, 'apprendre un ', 0, 10);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE `Utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Utilisateurs`
--

INSERT INTO `Utilisateurs` (`id`, `nom`, `email`, `mot_de_passe`) VALUES
(1, 'cantone', 'cantoneanthony5@gmail.com', '$2y$10$j4rDO1X37/jpBJ62Ls3qr.cPPiH1UC8/fc7UxcItQAexeXQjs2E6K'),
(3, 'cantone', 'cantoneanthony@gmail.com', '$2y$10$eI2IsQtyN1ruZSsIZcBG7Oz.AOx.mmxPb0z1wkJzLjw6.fyCuHoVG'),
(4, 'cantone', 'cantone@gmail.com', '$2y$10$xOPvoEGzv2fRrfDN6dHoOu3aBwwHe4mhje0fSFlSQLAGuLHqLeguW'),
(6, 'b&C Studio ', 'cantoneantho@gmail.com', '$2y$10$Q..0nb0V/Y5Q.o1u9/bieeWTR3mYKP1AzIDFfIVbe6f1EZns0Oipq');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Checklists`
--
ALTER TABLE `Checklists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `Checklist_Categories`
--
ALTER TABLE `Checklist_Categories`
  ADD PRIMARY KEY (`checklist_id`,`categorie_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `checklist_id` (`checklist_id`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Checklists`
--
ALTER TABLE `Checklists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Items`
--
ALTER TABLE `Items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Checklists`
--
ALTER TABLE `Checklists`
  ADD CONSTRAINT `checklists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Utilisateurs` (`id`);

--
-- Contraintes pour la table `Checklist_Categories`
--
ALTER TABLE `Checklist_Categories`
  ADD CONSTRAINT `checklist_categories_ibfk_1` FOREIGN KEY (`checklist_id`) REFERENCES `Checklists` (`id`),
  ADD CONSTRAINT `checklist_categories_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `Categories` (`id`);

--
-- Contraintes pour la table `Items`
--
ALTER TABLE `Items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`checklist_id`) REFERENCES `Checklists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

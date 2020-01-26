-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  Dim 26 jan. 2020 à 23:02
-- Version du serveur :  5.7.24
-- Version de PHP :  7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mi18`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `id_categorie_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visuel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `id_categorie_id`, `libelle`, `texte`, `visuel`, `prix`) VALUES
(1, 2, 'Pommes', 'Elle est bonne pour la tienne', 'produit-pommes.jpg', 3.42),
(2, 2, 'Fraises', 'Ici tu n\'en es pas une', 'produit-fraises.jpg', 2.11),
(3, 1, 'Carottes', 'Elle va te la donner', 'produit-carottes.jpg', 2.84),
(4, 1, 'Choux-fleurs', 'C\'est bon pour ta vue', 'produit-choux-fleurs.jpg', 2.9),
(5, 1, 'Choux violets', 'Fruit ou Légume ? Légume', 'produit-choux-violets.jpg', 1.7),
(6, 1, 'Echalottes', 'Mange des fractales', 'produit-echalottes.jpg', 1.81),
(7, 1, 'Haricots verts', 'C\'est bon, sauf pour ta santé', 'produit-haricots-verts.jpg', 4.5),
(8, 1, 'Oignons', 'Y\'a pas pire que za', 'produit-oignons.jpg', 2.25),
(9, 1, 'Piments', 'Seulement si tu es un pertubateur', 'produit-piments.jpg', 3.75),
(10, 1, 'Poivrons', 'Si tu aimes les couleurs', 'produit-poivrons.jpg', 2.16),
(11, 1, 'Tomates', 'Rondes et fraiches', 'produit-tomates.jpg', 1.8),
(12, 3, 'Jus multi-fruits', 'Toutes les saveurs en un seul jus', 'produit-jus-de-fruits.jpg', 4.5);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visuel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`, `texte`, `visuel`) VALUES
(1, 'Légumes', 'Plus tu en manges, moins tu en es un', 'category-1.jpg'),
(2, 'Fruits', 'De la passion ou de ton imagination', 'category-2.jpg'),
(3, 'Boissons', 'Des mixtures aux saveurs extraordinaires', 'category-3.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_utilisateur_id` int(11) NOT NULL,
  `date_commande` date NOT NULL,
  `statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_utilisateur_id`, `date_commande`, `statut`) VALUES
(1, 2, '2020-01-26', 1),
(2, 2, '2020-01-26', 1),
(3, 2, '2020-01-26', 1),
(4, 2, '2020-01-26', 1),
(5, 2, '2020-01-26', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_commande`
--

CREATE TABLE `ligne_commande` (
  `id` int(11) NOT NULL,
  `id_article_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` double NOT NULL,
  `id_commande_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `ligne_commande`
--

INSERT INTO `ligne_commande` (`id`, `id_article_id`, `quantite`, `prix`, `id_commande_id`) VALUES
(1, 3, 2, 2.84, 1),
(2, 1, 1, 3.42, 2),
(3, 2, 2, 2.11, 2),
(4, 3, 1, 2.84, 2),
(5, 12, 5, 4.5, 4),
(6, 3, 1, 2.84, 5);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20191220125218', '2019-12-20 14:13:45'),
('20191220140434', '2019-12-20 14:13:45'),
('20191220140944', '2019-12-20 14:13:46'),
('20191220141338', '2019-12-20 14:13:46'),
('20191220142922', '2019-12-20 14:29:31'),
('20200113092817', '2020-01-13 09:28:31'),
('20200115122929', '2020-01-15 12:30:23'),
('20200126103743', '2020-01-26 10:38:15'),
('20200126104028', '2020-01-26 10:40:43');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `roles`, `password`, `nom`, `prenom`) VALUES
(1, 'florent84@live.fr', '[\"ROLE_ADMIN\"]', '$2y$12$vKoaOY.I8roCwuz5yKl9NeB2bzYADBcCvakWYgp2POdVz0itob0IW', 'Pow', 'Florent'),
(2, 'test@test.com', '[\"ROLE_ADMIN\"]', '$2y$12$7AVtW8HnjfKedm9FbogFUOIoArZlVWGGmSPBruPIbwsbTS4aTO5aS', 'Testeur', 'Henry');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E669F34925F` (`id_categorie_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67DC6EE5C49` (`id_utilisateur_id`);

--
-- Index pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3170B74BD71E064B` (`id_article_id`),
  ADD KEY `IDX_3170B74B9AF8E3A3` (`id_commande_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1D1C63B3E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E669F34925F` FOREIGN KEY (`id_categorie_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DC6EE5C49` FOREIGN KEY (`id_utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `ligne_commande`
--
ALTER TABLE `ligne_commande`
  ADD CONSTRAINT `FK_3170B74B9AF8E3A3` FOREIGN KEY (`id_commande_id`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `FK_3170B74BD71E064B` FOREIGN KEY (`id_article_id`) REFERENCES `article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

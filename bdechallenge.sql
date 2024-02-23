-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 23 fév. 2024 à 10:55
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bdechallenge`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userNumber` int NOT NULL AUTO_INCREMENT,
  `role` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `validated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`userNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`userNumber`, `role`, `lastName`, `firstName`, `email`, `password`, `validated`) VALUES
(4, 'Etudiant', 'Dorange', 'Yoann', 'yoann.dorange@neuf.fr', '$2y$10$Eenu5ioLuNZgJc7VP3Vk/OW8KiclKWuJmZIXonzpIRIXT5k.s2p9a', 1),
(6, 'Etudiant', 'Sano', 'Manjiro', 'manjiro243@gmail.com', '$2y$10$lO5CT51SQgYws64jLdmoxOIy/24lHRaRzasLAchmfKJq2p0WBrDNK', 1),
(7, 'Etudiant', 'KPASSI', 'Morgan', 'morgan.kpassi@gmail.com', '$2y$10$mVdFGO/.FZ/.Mu5.JqiTw.t3CqZfYhZnwvMCC1chXA3rDd7veMs9O', 1),
(10, 'BDE', 'Enrico', 'Mat', 'mat@gmail.com', '$2y$10$ib9GUllY.3xLgfJCXFCh9uY7CNF2Y8vPxq3GWSDymUZPusB2o1KUy', 1);
-- (10, 'BDE', 'Enrico', 'Mat', 'matmusic23@gmail.com', '$2y$10$ib9GUllY.3xLgfJCXFCh9uY7CNF2Y8vPxq3GWSDymUZPusB2o1KUy', 1),
-- (12, 'Admin', 'Enrici', 'Mathis', 'mathis.enrici@gmail.com', '$2y$10$1rCAnvOQAojcjCWiTirK3O.iCrU5RkxKAzNPe7VbWgzwzm.JEKG4W', 1);

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `eventNumber` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `eventDate` date DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `userNumber` int NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`eventNumber`),
  KEY `userNumber` (`userNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`eventNumber`, `name`, `category`, `eventDate`, `location`, `userNumber`, `description`) VALUES
(2, 'Cinéma sous les Étoiles', 'Cinema', '2024-02-24', ' Lyon 1 - Auditorium Acoustique', 10, 'Un concert intime avec des performances acoustiques exceptionnelles. Laissez-vous emporter par la magie de la musique live dans une ambiance chaleureuse.'),
(11, 'Gabriel Davenport', 'Concert', '2025-02-24', 'Eveniet quis dignis', 10, 'Ut id sint nulla et '),
(12, 'Brock Walter', 'Soiree', '2025-03-02', 'Asperiores autem eaq', 10, 'Excepteur consectetu'),
(16, 'Nuit des Oscars', 'Cinema', '2024-02-28', 'Lyon 2 - Cinéma Prestige', 10, 'Une soirée de glamour et de cinéma pour célébrer les meilleurs films de l\'année. Tapis rouge, projections spéciales et surprises cinéphiles.'),
(17, 'Festival du Film Noir', 'Cinema', '2024-03-02', 'Lyon 1 - Ciné-Noir Hall', 10, 'Plongez dans l\'univers mystérieux du film noir avec une sélection de classiques sombres et captivants. Une nuit cinéphile inoubliable.'),
(18, 'Animation Extravaganza', 'Cinema', '2024-03-05', 'Lyon 5 - Cinéma AnimationX', 10, 'Une soirée dédiée à l\'animation avec une sélection de films d\'animation primés et des surprises visuelles. Parfait pour les amateurs de dessins animés de tous âges.'),
(19, 'Ciné-Club Indie', 'Soiree', '2024-03-09', 'Lyon 6 - Ciné-Club Indie', 10, 'Découvrez des films indépendants et alternatifs qui repoussent les limites du cinéma conventionnel. Des discussions animées et des projections stimulantes vous attendent.'),
(20, 'Rétro Cinéphile', 'Cinema', '2024-03-14', 'Lyon 3 - Ciné-Rétro Palace', 10, 'Voyagez dans le temps avec une soirée de films classiques des décennies passées. Une expérience cinématographique nostalgique pour les amoureux du cinéma vintage.'),
(21, 'Thriller Night', 'Cinema', '2024-03-17', 'Lyon 7 - Ciné-Thrill Arena', 10, 'Une sélection de thrillers captivants pour une nuit remplie de suspense et d\'intrigues. Attendez-vous à des retournements de situation inattendus.'),
(22, 'Cinéma Culinaire', 'Cinema', '2024-04-03', 'Lyon 8 - Ciné Gourmet Lounge', 10, 'Explorez le monde de la gastronomie à travers le cinéma avec des films qui mettent en avant la cuisine et les délices culinaires. Une expérience pour les sens.'),
(23, 'Nuit Enchantée', 'Soiree', '2024-02-24', 'Lyon 2 - Salle des étoiles', 10, ' Une soirée magique avec des lumières scintillantes, de la musique entraînante et une atmosphère féérique. Rejoignez-nous pour une nuit inoubliable sous les étoiles.'),
(24, 'Soirée Cosmique', 'Soiree', '2024-02-28', 'Lyon 4 - Galaxie Lounge', 10, 'Plongez dans l\'univers avec une soirée cosmique pleine de mystère et d\'aventure. Des cocktails interstellaires, une piste de danse galactique et des surprises interplanétaires vous attendent.'),
(25, 'Night Fever', 'Soiree', '2024-03-02', 'Lyon 1 - Club ÉlectroVibe', 10, 'Une soirée endiablée avec des rythmes frénétiques, des jeux de lumière époustouflants et une ambiance électrique. Préparez-vous à danser jusqu\'au bout de la nuit.'),
(26, 'Retro Vibes', 'Soiree', '2024-03-12', 'Lyon 5 - Studio 80\'s', 10, 'Remontez le temps avec une soirée rétro pleine de nostalgie. Musique vintage, costumes rétro et une ambiance réminiscente des décennies passées.'),
(27, 'Party Paradise', 'Soiree', '2024-03-22', 'Lyon 3 - Manoir Masqué', 10, 'Une soirée tropicale avec des cocktails exotiques, des décors de plage et des beats ensoleillés. Plongez dans l\'atmosphère d\'une fête paradisiaque.'),
(28, 'Glow Party', 'Soiree', '2024-03-27', 'Lyon 7 - Club Néon', 10, 'Une soirée fluo où la piste de danse s\'illumine avec des couleurs vibrantes. Habillez-vous de vos tenues les plus lumineuses et préparez-vous à briller.'),
(29, 'Extravagance', 'Soiree', '2024-03-29', 'Lyon 8 - Palais Élégance', 10, 'Une soirée grandiose avec un mélange de luxe, de glamour et d\'élégance. C\'est l\'occasion de vous mettre sur votre 31 et de vivre une soirée exceptionnelle.'),
(30, 'Harmonie Acoustique', 'Concert', '2024-03-01', 'Lyon 2 - Auditorium Acoustique', 10, 'Un concert intime avec des performances acoustiques exceptionnelles. Laissez-vous emporter par la magie de la musique live dans une ambiance chaleureuse.'),
(31, 'Rock Revolution', 'Concert', '2024-03-02', 'Lyon 4 - Salle du Rock', 10, 'Une nuit de pur rock\'n\'roll avec des groupes dynamiques et des solos de guitare endiablés. Les amateurs de musique alternative vont adorer cette expérience sonore.'),
(32, 'Symphonie Électrique', 'Concert', '2024-03-07', 'Lyon 1 - Salle ÉlectroSympho', 10, 'Un concert électro-symphonique où l\'orchestre rencontre la musique électronique. Une fusion unique de genres pour une expérience musicale inédite.'),
(33, 'Soulful Serenade', 'Concert', '2024-03-25', 'Lyon 5 - Théâtre de l\'Âme', 10, 'Plongez dans l\'âme de la musique avec des performances soul captivantes. Des voix puissantes et des mélodies émotionnelles vous transporteront.'),
(34, 'Pop Fusio', 'Concert', '2024-03-30', 'Lyon 6 - Scène PopFusion', 10, 'Un concert pop éclectique avec des artistes aux styles variés. Des mélanges de genres pour une soirée pleine de surprises musicales.'),
(35, 'Jazz Journey', 'Soiree', '2024-03-14', 'Lyon 3 - Jazz Lounge', 10, 'Voyagez à travers les époques avec un concert de jazz éclectique. Des improvisations brillantes et des rythmes envoûtants vous attendent.'),
(36, 'Rap Rendezvous', 'Concert', '2024-03-08', 'Lyon 7 - Salle HipHop', 10, 'Une nuit dédiée au hip-hop et au rap avec des artistes émergents et des stars confirmées. Des paroles percutantes et des rythmes entraînants seront au rendez-vous.'),
(37, 'Festival Indie', 'Concert', '2024-03-29', 'Lyon 8 - Indie Arena', 10, 'Découvrez la scène indie avec un concert mettant en vedette des groupes indépendants prometteurs. Une immersion dans le monde alternatif de la musique.'),
(38, 'Safari Night', 'Soiree', '2024-03-10', 'Lyon 6 - Safari Lounge', 10, 'Une soirée sauvage avec une ambiance jungle, des cocktails exotiques et des rythmes tribaux. Plongez dans l\'aventure au cœur de Lyon.'),
(39, 'Disco Diva', 'Soiree', '2024-03-11', 'Lyon 3 - Disco Galaxy', 10, 'Revivez l\'ère disco avec des boules à facettes, des costumes pailletés et des tubes rétro. Une nuit de danse et de grooves entraînants.'),
(40, 'Casino Royale', 'Soiree', '2024-04-05', 'Lyon 1 - Casino Élégance', 10, 'Entrez dans l\'univers glamour du casino avec des jeux de table, des cocktails sophistiqués et une ambiance digne de James Bond.'),
(41, 'Soirée Art Fusion', 'Soiree', '2024-04-14', 'Lyon 4 - Galerie Fusion', 10, 'Une soirée qui marie l\'art visuel et la musique, avec des performances live, des expositions et une atmosphère créative.');

-- --------------------------------------------------------

--
-- Structure de la table `event_participants`
--

DROP TABLE IF EXISTS `event_participants`;
CREATE TABLE IF NOT EXISTS `event_participants` (
  `eventNumber` int NOT NULL,
  `userNumber` int NOT NULL,
  PRIMARY KEY (`eventNumber`,`userNumber`),
  KEY `userNumber` (`userNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `event_participants`
--

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `userNumber` int NOT NULL,
  `eventNumber` int NOT NULL,
  PRIMARY KEY (`userNumber`,`eventNumber`),
  KEY `fk_wishlist_user` (`userNumber`),
  KEY `fk_wishlist_event` (`eventNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`userNumber`) REFERENCES `user` (`userNumber`);

--
-- Contraintes pour la table `event_participants`
--
ALTER TABLE `event_participants`
  ADD CONSTRAINT `event_participants_ibfk_1` FOREIGN KEY (`eventNumber`) REFERENCES `event` (`eventNumber`),
  ADD CONSTRAINT `event_participants_ibfk_2` FOREIGN KEY (`userNumber`) REFERENCES `user` (`userNumber`);

--
-- Contraintes pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_event` FOREIGN KEY (`eventNumber`) REFERENCES `event` (`eventNumber`),
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`userNumber`) REFERENCES `user` (`userNumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

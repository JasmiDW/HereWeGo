-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 20 mars 2023 à 07:56
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `hwg`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `libelle_categorie` varchar(50) NOT NULL,
  `icone_fontawesome` varchar(70) DEFAULT NULL,
  `id_couleur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `libelle_categorie`, `icone_fontawesome`, `id_couleur`) VALUES
(1, 'concert', 'fa-solid fa-music fa-lg', 1),
(2, 'sportif', 'fa-solid fa-car-burst', 1),
(3, 'Spectacle', 'fa-solid fa-glasses', 2),
(4, 'Humour', 'fa-solid fa-glasses', 2),
(5, 'Magie', 'fa-solid fa-glasses', 2);

-- --------------------------------------------------------

--
-- Structure de la table `couleurs`
--

CREATE TABLE `couleurs` (
  `id_couleur` int(11) NOT NULL,
  `libelle_couleur` varchar(50) DEFAULT NULL,
  `code_hexadecimal` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `couleurs`
--

INSERT INTO `couleurs` (`id_couleur`, `libelle_couleur`, `code_hexadecimal`) VALUES
(1, 'orange', '#E76F51'),
(2, 'bleu', '#264653');

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `titre_event` varchar(50) NOT NULL,
  `date_debut_event` date DEFAULT NULL,
  `date_fin_event` date DEFAULT NULL,
  `resume_event` varchar(130) DEFAULT NULL,
  `description_event` text DEFAULT NULL,
  `code_unique` varchar(15) NOT NULL,
  `statut_coupcoeur` tinyint(1) DEFAULT NULL,
  `nb_places` int(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_lieu` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `event`
--

INSERT INTO `event` (`id_event`, `titre_event`, `date_debut_event`, `date_fin_event`, `resume_event`, `description_event`, `code_unique`, `statut_coupcoeur`, `nb_places`, `id_user`, `id_lieu`, `id_categorie`) VALUES
(1, 'One Touch', '2023-06-15', '2023-06-19', ' One Touch propose aux amateurs de musique une expérience immersive et personnelle à travers des concerts silencieux.', 'One Touch est un événement musical innovant qui se tiendra du 15 au 19 juin 2023. Il propose aux amateurs de musique une expérience immersive et personnelle à travers des concerts silencieux. Les participants auront l\'occasion de vivre une performance musicale sans distractions extérieures, en utilisant des casques pour écouter la musique.\nL\'objectif de One Touch est de créer un environnement musical intime et privé pour les participants, où ils peuvent se concentrer uniquement sur la musique et les sensations qu\'elle suscite en eux. Les concerts silencieux permettent également aux artistes de se concentrer sur leur performance et d\'interagir avec le public d\'une manière unique.\nOne Touch promet d\'être un événement musical inoubliable pour les amateurs de musique, qui pourront découvrir de nouveaux talents et vivre des expériences musicales uniques. La combinaison de la technologie de pointe et de la musique de qualité garantit un événement musical qui sort de l\'ordinaire. Les participants auront l\'occasion de se connecter avec la musique et avec les autres fans dans un environnement privé et confortable.\nNantes est une ville vibrante et dynamique située dans l\'ouest de la France, qui est connue pour sa culture, son architecture et sa scène musicale florissante. Elle offre un cadre idéal pour l\'événement One Touch, avec une large gamme de salles de concert, de bars et de restaurants pour les participants.\n', 'A23F4-2375', 1, 500, 1, 2, 1),
(3, 'Je sais pas', '2023-03-28', '2023-03-30', 'Je sais pas bis ', '', 'ZE438-2375', 0, 120, 1, 4, 2),
(5, 'Two Touch', '2023-06-23', '2023-06-27', ' One Touch propose aux amateurs de musique une expérience immersive et personnelle à travers des concerts silencieux.', 'One Touch est un événement musical innovant qui se tiendra du 15 au 19 juin 2023. Il propose aux amateurs de musique une expérience immersive et personnelle à travers des concerts silencieux. Les participants auront l\'occasion de vivre une performance musicale sans distractions extérieures, en utilisant des casques pour écouter la musique.\r\nL\'objectif de One Touch est de créer un environnement musical intime et privé pour les participants, où ils peuvent se concentrer uniquement sur la musique et les sensations qu\'elle suscite en eux. Les concerts silencieux permettent également aux artistes de se concentrer sur leur performance et d\'interagir avec le public d\'une manière unique.\r\nOne Touch promet d\'être un événement musical inoubliable pour les amateurs de musique, qui pourront découvrir de nouveaux talents et vivre des expériences musicales uniques. La combinaison de la technologie de pointe et de la musique de qualité garantit un événement musical qui sort de l\'ordinaire. Les participants auront l\'occasion de se connecter avec la musique et avec les autres fans dans un environnement privé et confortable.\r\nNantes est une ville vibrante et dynamique située dans l\'ouest de la France, qui est connue pour sa culture, son architecture et sa scène musicale florissante. Elle offre un cadre idéal pour l\'événement One Touch, avec une large gamme de salles de concert, de bars et de restaurants pour les participants.\r\n', 'HAIAK-2375', 0, 120, 1, 3, 1),
(6, 'Merguez Tuning Show', '2023-06-04', '2023-06-04', 'Un événement avec des voitures. ', 'Le Saint Jour est arrivé. \r\n\r\nLe Dimanche 4 Juin 2023 se tiendra la 1ère édition de notre événement dédié à la merguez, au SP98 et aux V8 hurlants : Le MERGUEZ TUNING SHOW.\r\n\r\nSur le circuit de Nevers Magny-Cours F1, vous pourrez voir de vos propres yeux le flamboyant 1000tipla (ou 1294tipla pour les puristes), cracher ses flammes dans un vacarme digne des pets du Père Chabrimerde.\r\n\r\nPour ce jour de fête de mères les traces de pneus seront nombreuses, avec en point d’orgue l’ultime loterie : chaque participant aura une chance de pouvoir monter dans le 1000tipla gratuitement, afin d’être sattelisé et d’atteindre une autre galaxie (bouchons d’oreilles et sac à vomi inclus)\r\n\r\nMais cet événement est également une grande messe autour de la chaîne Vilebrequin, et vous proposera donc un grand nombre d’activités : Baptêmes en voiture de sport, concert, tours de bus, survol du circuit en hélicoptère, karting, pêche aux canards, activités Off-Road, Fury-Car, simulateur de F4… et bien sûr le gros machin rouge et bruyant qui fait peur aux enfants. \r\n\r\nFais tes prières et prend ta place dans l’onglet billetterie juste au-dessus.', '', NULL, 50000, 1, 6, 2),
(9, 'HELLO', '2023-06-15', '2023-06-19', ' One Touch propose aux amateurs de musique une expérience immersive et personnelle à travers des concerts silencieux.', '', '2', 1, 12, 3, 1, 3),
(56, 'JE SAIS PAS ', '2023-03-28', '2023-03-30', 'Je sais pas bis ', '', 'E6C13-2369', 0, 600, 3, 4, 4);

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `id_favoris` int(11) NOT NULL,
  `libelle_favoris` varchar(50) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lieux`
--

CREATE TABLE `lieux` (
  `id_lieu` int(11) NOT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `adresse` varchar(200) DEFAULT NULL,
  `longitude` decimal(8,6) DEFAULT NULL,
  `lattitude` decimal(8,6) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lieux`
--

INSERT INTO `lieux` (`id_lieu`, `ville`, `adresse`, `longitude`, `lattitude`, `code_postal`) VALUES
(1, 'Nantes', '', '-1.553621', '47.218371', '44000'),
(2, 'Paris', '', '2.361500', '48.863700', '75000'),
(3, 'Marseille', NULL, '5.400000', '43.300000', '13000'),
(4, 'Lyon', NULL, '4.835000', '45.764000', '69000'),
(5, 'Toulouse', NULL, '1.433300', '43.600000', '31000'),
(6, 'Rennes', NULL, '-1.677000', '48.117000', '35000');

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `id_photos` int(11) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `id_event` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`id_photos`, `url`, `id_event`) VALUES
(1, '1190298.jpg', 1),
(2, '187210.jpg', 6);

-- --------------------------------------------------------

--
-- Structure de la table `moyen_de_transport`
--

CREATE TABLE `moyen_de_transport` (
  `id_mdt` int(11) NOT NULL,
  `libelle_mdt` varchar(50) NOT NULL,
  `tarif` decimal(6,2) DEFAULT NULL,
  `info_contact` varchar(200) DEFAULT NULL,
  `descriptif` varchar(400) DEFAULT NULL,
  `date_depart_transport` date DEFAULT NULL,
  `nb_place` int(11) DEFAULT NULL,
  `nb_dispo` int(11) DEFAULT NULL,
  `heure_depart` time DEFAULT NULL,
  `heure_arrivee` time DEFAULT NULL,
  `id_lieu` int(11) NOT NULL,
  `id_participant` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `id_type_transport` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `moyen_de_transport`
--

INSERT INTO `moyen_de_transport` (`id_mdt`, `libelle_mdt`, `tarif`, `info_contact`, `descriptif`, `date_depart_transport`, `nb_place`, `nb_dispo`, `heure_depart`, `heure_arrivee`, `id_lieu`, `id_participant`, `id_event`, `id_type_transport`) VALUES
(2, '', '15.00', 'na.86@hotmail.fr', 'La voiture disponible pour l\'événement musical est une Peugeot 308 de couleur bleu foncé. Cette voiture dispose de cinq places, dont le conducteur. Elle est spacieuse et confortable, avec des sièges en tissu noir, une climatisation et un système audio de qualité. La couleur bleu foncé de la voiture donne un look élégant et sophistiqué, et elle est en excellent état. Si vous souhaitez voyager avec ', '2023-06-05', 3, 3, '10:00:00', '10:30:00', 1, 1, 1, 1),
(4, '[value-2]', '10.00', '0664348271', 'Moto noire', '2023-07-05', 1, 1, '08:00:00', '09:00:00', 2, 1, 3, 2),
(5, '', '15.00', 'na.86@hotmail.fr', 'La voiture disponible pour l\'événement musical est une Peugeot 308 de couleur bleu foncé. Cette voiture dispose de cinq places, dont le conducteur. Elle est spacieuse et confortable, avec des sièges en tissu noir, une climatisation et un système audio de qualité. La couleur bleu foncé de la voiture donne un look élégant et sophistiqué, et elle est en excellent état. Si vous souhaitez voyager avec ', '2023-06-06', 3, 3, '10:00:00', '10:30:00', 5, 1, 5, 1),
(6, '', '1.00', 'na.86@hotmail.fr', 'La voiture disponible pour l\'événement musical est une Peugeot 308 de couleur bleu foncé. Cette voiture dispose de cinq places, dont le conducteur. Elle est spacieuse et confortable, avec des sièges en tissu noir, une climatisation et un système audio de qualité. La couleur bleu foncé de la voiture donne un look élégant et sophistiqué, et elle est en excellent état. Si vous souhaitez voyager avec ', '2023-06-07', 2, 1, '18:00:00', '10:30:00', 3, 1, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE `participant` (
  `id_participant` int(11) NOT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `participant`
--

INSERT INTO `participant` (`id_participant`, `statut`, `id_event`, `id_user`) VALUES
(1, 'oui', 1, 2),
(2, 'oui', 6, 2);

-- --------------------------------------------------------

--
-- Structure de la table `reserver`
--

CREATE TABLE `reserver` (
  `id_mdt` int(11) NOT NULL,
  `id_participant` int(11) NOT NULL,
  `nb_place` int(11) DEFAULT NULL,
  `date_resa` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `id_statut` int(11) NOT NULL,
  `libelle_statut` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id_statut`, `libelle_statut`) VALUES
(1, 'organisateur'),
(2, 'visiteur'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `type_transport`
--

CREATE TABLE `type_transport` (
  `id_type_transport` int(11) NOT NULL,
  `libelle_type_transport` varchar(50) NOT NULL,
  `icone_fontawesome` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_transport`
--

INSERT INTO `type_transport` (`id_type_transport`, `libelle_type_transport`, `icone_fontawesome`) VALUES
(1, 'voiture', 'fa-solid fa-car fa-xl'),
(2, 'moto', 'fa-solid fa-motorcycle fa-xl'),
(3, 'minibus', 'fa-solid fa-bus-simple');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_user` int(11) NOT NULL,
  `raison_sociale` varchar(50) DEFAULT NULL,
  `nom_user` varchar(50) DEFAULT NULL,
  `prenom_user` varchar(50) DEFAULT NULL,
  `genre` tinyint(1) NOT NULL COMMENT '0 = femme 1 = homme',
  `password` varchar(250) DEFAULT NULL,
  `tel_user` varchar(20) DEFAULT NULL,
  `mail_user` varchar(50) DEFAULT NULL,
  `url_photo` varchar(100) DEFAULT NULL,
  `badge_acquis` tinyint(1) DEFAULT 0,
  `date_inscription` date DEFAULT NULL,
  `id_lieu` int(11) NOT NULL,
  `id_statut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_user`, `raison_sociale`, `nom_user`, `prenom_user`, `genre`, `password`, `tel_user`, `mail_user`, `url_photo`, `badge_acquis`, `date_inscription`, `id_lieu`, `id_statut`) VALUES
(1, 'Association Music Ly', 'Casgrain', 'Océane', 0, 'ieSh3thai', '05.68.49.73.35', 'OceaneCasgrain@teleworm.us', '', 0, '2023-02-26', 1, 1),
(2, '', 'Rousseau', 'Nadia', 0, 'herewego', '0664348271', 'na.86@hotmail.fr', '', 0, '0000-00-00', 1, 2),
(3, 'Vilbrequin', 'Levy', 'Sylvain', 1, 'merguez', '0434512711', 'contact@vilbrequin.fr', '202308071223.svg', 0, '2023-03-08', 1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`),
  ADD KEY `id_couleur` (`id_couleur`);

--
-- Index pour la table `couleurs`
--
ALTER TABLE `couleurs`
  ADD PRIMARY KEY (`id_couleur`);

--
-- Index pour la table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`),
  ADD UNIQUE KEY `code_unique` (`code_unique`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`id_favoris`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_event` (`id_event`);

--
-- Index pour la table `lieux`
--
ALTER TABLE `lieux`
  ADD PRIMARY KEY (`id_lieu`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_photos`),
  ADD KEY `id_event` (`id_event`);

--
-- Index pour la table `moyen_de_transport`
--
ALTER TABLE `moyen_de_transport`
  ADD PRIMARY KEY (`id_mdt`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_participant` (`id_participant`),
  ADD KEY `id_event` (`id_event`),
  ADD KEY `id_type_transport` (`id_type_transport`);

--
-- Index pour la table `participant`
--
ALTER TABLE `participant`
  ADD PRIMARY KEY (`id_participant`),
  ADD KEY `id_event` (`id_event`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD PRIMARY KEY (`id_mdt`,`id_participant`),
  ADD KEY `id_participant` (`id_participant`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `type_transport`
--
ALTER TABLE `type_transport`
  ADD PRIMARY KEY (`id_type_transport`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_statut` (`id_statut`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `couleurs`
--
ALTER TABLE `couleurs`
  MODIFY `id_couleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `id_favoris` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lieux`
--
ALTER TABLE `lieux`
  MODIFY `id_lieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id_photos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `moyen_de_transport`
--
ALTER TABLE `moyen_de_transport`
  MODIFY `id_mdt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `participant`
--
ALTER TABLE `participant`
  MODIFY `id_participant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `id_statut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type_transport`
--
ALTER TABLE `type_transport`
  MODIFY `id_type_transport` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `categorie_ibfk_1` FOREIGN KEY (`id_couleur`) REFERENCES `couleurs` (`id_couleur`);

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`),
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`id_lieu`) REFERENCES `lieux` (`id_lieu`),
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`),
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`);

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`);

--
-- Contraintes pour la table `moyen_de_transport`
--
ALTER TABLE `moyen_de_transport`
  ADD CONSTRAINT `moyen_de_transport_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `lieux` (`id_lieu`),
  ADD CONSTRAINT `moyen_de_transport_ibfk_2` FOREIGN KEY (`id_participant`) REFERENCES `participant` (`id_participant`),
  ADD CONSTRAINT `moyen_de_transport_ibfk_3` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`),
  ADD CONSTRAINT `moyen_de_transport_ibfk_4` FOREIGN KEY (`id_type_transport`) REFERENCES `type_transport` (`id_type_transport`);

--
-- Contraintes pour la table `participant`
--
ALTER TABLE `participant`
  ADD CONSTRAINT `participant_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`),
  ADD CONSTRAINT `participant_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `utilisateur` (`id_user`);

--
-- Contraintes pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD CONSTRAINT `reserver_ibfk_1` FOREIGN KEY (`id_mdt`) REFERENCES `moyen_de_transport` (`id_mdt`),
  ADD CONSTRAINT `reserver_ibfk_2` FOREIGN KEY (`id_participant`) REFERENCES `participant` (`id_participant`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `lieux` (`id_lieu`),
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`id_statut`) REFERENCES `statut` (`id_statut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 28 mars 2023 à 23:59
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
(1, 'Musical', 'fa-solid fa-music fa-lg', 1),
(2, 'Sportif', 'fa-solid fa-car-burst', 4),
(3, 'Spectacle', 'fa-solid fa-glasses', 3),
(4, 'Humour', 'fa-solid fa-face-laugh-beam', 5),
(5, 'Magie', 'fa-solid fa-wand-magic', 6),
(6, 'Culturel', 'fa-solid fa-icons fa-lg', 7),
(7, 'Esport', 'fa-solid fa-gamepad fa-lg', 2);

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
(2, 'bleu', '#264653'),
(3, 'jaune', '#E9C46A'),
(4, 'orange-clair', '#F4A261'),
(5, 'rose', '#DDCECD'),
(6, 'marron', '#382633'),
(7, 'vert', '#92BDA3');

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
(1, 'One Touch', '2023-06-15', '2023-06-19', ' One Touch propose aux amateurs de musique une expérience immersive et personnelle à travers des concerts silencieux.', 'One Touch est un événement musical innovant qui se tiendra du 15 au 19 juin 2023. Il propose aux amateurs de musique une expérience immersive et personnelle à travers des concerts silencieux. Les participants auront l\'occasion de vivre une performance musicale sans distractions extérieures, en utilisant des casques pour écouter la musique.\nL\'objectif de One Touch est de créer un environnement musical intime et privé pour les participants, où ils peuvent se concentrer uniquement sur la musique et les sensations qu\'elle suscite en eux. Les concerts silencieux permettent également aux artistes de se concentrer sur leur performance et d\'interagir avec le public d\'une manière unique.\nOne Touch promet d\'être un événement musical inoubliable pour les amateurs de musique, qui pourront découvrir de nouveaux talents et vivre des expériences musicales uniques. La combinaison de la technologie de pointe et de la musique de qualité garantit un événement musical qui sort de l\'ordinaire. Les participants auront l\'occasion de se connecter avec la musique et avec les autres fans dans un environnement privé et confortable.\nNantes est une ville vibrante et dynamique située dans l\'ouest de la France, qui est connue pour sa culture, son architecture et sa scène musicale florissante. Elle offre un cadre idéal pour l\'événement One Touch, avec une large gamme de salles de concert, de bars et de restaurants pour les participants.\n', 'A23F4-2375', 1, 500, 12, 2, 1),
(2, 'Festival de l\'Art Contemporain', '2023-04-12', '2023-04-14', 'Le \"Festival de l\'Art Contemporain\" rassemblera des artistes locaux et internationaux de renom, venus de tous les horizons.', 'L\'organisme \"Événements Créatifs\" est fier de vous présenter son tout nouvel événement, le \"Festival de l\'Art Contemporain\". Ce festival se tiendra du 12 au 14 Avril 2023 au Centre des Arts de la Ville de Paris, un lieu emblématique pour les amateurs d\'art et les passionnés de culture.\r\n\r\nLe \"Festival de l\'Art Contemporain\" rassemblera des artistes locaux et internationaux de renom, venus de tous les horizons pour célébrer l\'art contemporain sous toutes ses formes. Du street art aux installations, en passant par la peinture et la sculpture, il y en a pour tous les goûts. Les visiteurs auront l\'occasion de découvrir les œuvres des artistes les plus innovants et les plus talentueux de notre époque, ainsi que des artistes émergents qui viennent de faire leur entrée sur la scène artistique.\r\n\r\nEn plus de découvrir les dernières tendances en matière d\'art contemporain, les visiteurs pourront également participer à des ateliers et des activités interactives conçues pour les faire s\'engager dans le monde de l\'art. Ils pourront également rencontrer les artistes en personne et discuter avec eux de leur processus créatif et de leur inspiration.\r\n\r\nLe \"Festival de l\'Art Contemporain\" se situe dans la catégorie de \"Festival d\'Art\" et se veut être un événement annuel incontournable pour les amateurs d\'art et les passionnés de culture. Il est ouvert à tous les âges et à tous les niveaux d\'intérêt pour l\'art, du simple amateur à l\'expert. Le nombre de places disponibles est limité à 1000 pour garantir une expérience personnelle et immersive pour chaque visiteur.\r\n\r\nNe manquez pas cette occasion unique de découvrir l\'art contemporain de première main et de vous immerger dans un monde de créativité et d\'innovation ! Inscrivez-vous dès maintenant pour vous assurer de votre place au \"Festival de l\'Art Contemporain\".\r\n', 'XF414-2375', NULL, 1000, 16, 2, 6),
(3, 'Festival de Jazz de Paris', '2023-07-05', '2023-07-07', 'Un festival de Jazz comme vous les aimez. ', 'Le Festival de Jazz de Paris est un événement musical incontournable pour les amateurs de jazz. Avec des performances en direct de certains des meilleurs musiciens de jazz du monde entier, ce festival offre une expérience musicale inoubliable. Les visiteurs peuvent écouter du jazz classique, du jazz moderne, du swing, du bebop et plus encore, tout en profitant de la nourriture, des boissons et de l\'ambiance festive. Ce festival se situe dans la catégorie \"Festival de Musique\".', 'ZE438-2375', 0, 3000, 12, 2, 1),
(4, 'Biennale d\'Art Contemporain de Venise', '2023-09-15', '2023-11-15', NULL, 'La Biennale d\'Art Contemporain de Venise est l\'un des plus grands événements d\'art contemporain au monde, présentant les dernières tendances et les plus grandes réalisations de l\'art contemporain. Les visiteurs peuvent explorer les expositions de plusieurs pays, rencontrer des artistes et des commissaires d\'exposition, et découvrir les tendances actuelles en matière d\'art contemporain. Ce festival se situe dans la catégorie \"Biennale d\'Art\".', 'DF414-2375', 0, 10000, 16, 2, 6),
(5, 'Champions League des Jeux Vidéo', '2023-08-20', '2023-08-22', 'Grand tournoi d\'esport à Toulouse. Venez nombreux !', 'La Champions League des Jeux Vidéo est le plus grand tournoi de sports électroniques de l\'année, mettant en vedette les meilleurs joueurs du monde entier dans un affrontement épique pour le titre de champion. Les visiteurs pourront assister à des matchs en direct, rencontrer des célébrités du monde des esports, participer à des activités interactives et découvrir les derniers produits et technologies liés aux esports.\r\n', '12F56-2531', 0, 5000, 17, 5, 7),
(6, 'Merguez Tuning Show', '2023-06-04', '2023-06-04', 'Un événement avec des voitures. ', 'Le Saint Jour est arrivé. \r\n\r\nLe Dimanche 4 Juin 2023 se tiendra la 1ère édition de notre événement dédié à la merguez, au SP98 et aux V8 hurlants : Le MERGUEZ TUNING SHOW.\r\n\r\nSur le circuit de Nevers Magny-Cours F1, vous pourrez voir de vos propres yeux le flamboyant 1000tipla (ou 1294tipla pour les puristes), cracher ses flammes dans un vacarme digne des pets du Père Chabrimerde.\r\n\r\nPour ce jour de fête de mères les traces de pneus seront nombreuses, avec en point d’orgue l’ultime loterie : chaque participant aura une chance de pouvoir monter dans le 1000tipla gratuitement, afin d’être sattelisé et d’atteindre une autre galaxie (bouchons d’oreilles et sac à vomi inclus)\r\n\r\nMais cet événement est également une grande messe autour de la chaîne Vilebrequin, et vous proposera donc un grand nombre d’activités : Baptêmes en voiture de sport, concert, tours de bus, survol du circuit en hélicoptère, karting, pêche aux canards, activités Off-Road, Fury-Car, simulateur de F4… et bien sûr le gros machin rouge et bruyant qui fait peur aux enfants. \r\n\r\nFais tes prières et prend ta place dans l’onglet billetterie juste au-dessus.', '', NULL, 50000, 14, 6, 2),
(7, 'Esport Arena', '2024-09-01', '2024-09-03', 'Assistez à l\'action palpitante de l\'Esport Arena à Paris, où les meilleurs joueurs du monde rivalisent dans des tournois de jeux.', 'Esport Arena est un événement esport de niveau mondial qui rassemble les joueurs professionnels les plus talentueux pour des tournois de jeux vidéo compétitifs. Les tournois se déroulent sur plusieurs jours, avec des matchs passionnants qui se déroulent sur scène devant un public enthousiaste. Les jeux joués incluent certains des titres les plus populaires et les plus compétitifs du monde esport, tels que League of Legends, Dota 2 et Overwatch.\r\nLes tournois sont diffusés en direct en ligne pour les fans du monde entier qui ne peuvent pas assister en personne, mais les chanceux qui peuvent se rendre à Paris auront la chance de vivre l\'action en direct. Les joueurs s\'affrontent pour des prix en argent énormes, ainsi que pour le titre de champion du tournoi. Des commentateurs professionnels et des analystes de jeux vidéo sont présents pour donner aux spectateurs une meilleure compréhension de ce qui se passe sur l\'écran.\r\nEsport Arena est un événement intérieur, avec une grande arène spécialement conçue pour l\'événement. Les spectateurs peuvent s\'attendre à une expérience immersive et captivante, avec des animations sur scène, des expositions de jeux vidéo et des zones de jeux pour les visiteurs. La capacité d\'accueil de l\'événement est de 5 000 places, avec des billets disponibles pour les spectateurs individuels ainsi que pour les groupes.\r\n', 'AZ123-2575', 0, 5000, 17, 2, 7),
(8, 'Coupe mondiale de parkour', '2024-06-01', '2024-06-10', 'La Coupe mondiale de parkour est un événement sportif international qui rassemble les meilleurs athlètes de parkour.', 'La Coupe mondiale de parkour est un événement sportif spectaculaire qui réunit les meilleurs athlètes de parkour du monde entier pour une compétition intense de 10 jours. Les athlètes seront testés sur leur agilité, leur force et leur vitesse alors qu\'ils s\'affronteront sur un parcours d\'obstacles de classe mondiale, conçu spécialement pour cette compétition.\r\n\r\nLa Coupe mondiale de parkour mettra en vedette des compétitions individuelles et par équipes, où les athlètes devront effectuer des mouvements acrobatiques à couper le souffle tels que des sauts de précision, des sauts en longueur, des salto avant et arrière, et des franchissements de murs. Les juges noteront chaque athlète sur leur exécution technique, leur créativité et leur fluidité dans la progression du parcours.\r\n\r\nLes spectateurs auront la chance de voir les athlètes les plus talentueux du monde rivaliser pour remporter la prestigieuse Coupe mondiale de parkour, ainsi que d\'assister à des démonstrations de parkour de classe mondiale par des professionnels. Cet événement sera une expérience inoubliable pour tous les amateurs de sports d\'adrénaline et de performances spectaculaires.\r\n', 'DP3L4-2633', 0, 30000, 18, 7, 2),
(9, 'La course des glaces', '2024-01-01', '2024-01-07', 'Découvrez une compétition unique en son genre avec La course des glaces, une course de ski, patinage et snowmobile.', 'La course des glaces est une compétition de course sur glace à travers les magnifiques paysages hivernaux. Les athlètes concourent en ski, en patin à glace et en snowmobile pour une expérience sportive unique.', 'XP2L4-2633', 1, 5000, 18, 8, 2),
(10, 'Le Grand Défi', '2024-07-15', '2024-07-22', 'Relevez Le Grand Défi, une compétition sportive intense sur le Mont Blanc en France. Escalade, randonnée, VTT, parapente, course..', 'Le Grand Défi est un événement sportif de sept jours qui met les compétences physiques et mentales des athlètes à l\'épreuve dans un cadre spectaculaire sur le Mont Blanc. Les compétitions incluent l\'escalade, la randonnée, le VTT, le parapente et la course en montagne.', '1PC81-2674', 0, 2000, 18, 8, 2),
(11, 'Lumières de France', '2024-10-01', '2024-11-15', 'Plongez dans la magie de Lumières de France à Versailles, un événement culturel éblouissant avec des installations lumineuses.', 'Lumières de France est un événement culturel unique en son genre qui célèbre l\'histoire et la culture française. Les jardins de Versailles, un site du patrimoine mondial de l\'UNESCO, seront transformés en un parcours de lumières étincelantes, avec des installations artistiques conçues pour mettre en valeur l\'architecture et les éléments naturels du parc.\r\nLes visiteurs pourront explorer les jardins illuminés de manière spectaculaire, avec des effets de lumière éblouissants qui mettent en valeur la beauté des arbres, des fontaines et des statues. Les installations seront accompagnées de musique, de projections vidéo et d\'expositions artistiques pour offrir une expérience immersive et captivante.\r\nL\'événement est ouvert au public, avec des billets disponibles pour les individus ainsi que pour les groupes. La capacité de l\'événement est de 10 000 places, ce qui permet aux visiteurs de profiter de l\'expérience sans se sentir trop bondés.\r\nEn plus de l\'expérience visuelle et artistique de Lumières de France, les visiteurs pourront profiter de concerts en plein air avec des artistes locaux et internationaux de renom. Il y aura également des expositions d\'art contemporain et des installations interactives pour que les visiteurs puissent s\'immerger dans la culture française.\r\nLumières de France est un événement inoubliable qui offre aux visiteurs une occasion unique de découvrir la beauté et la richesse de la culture française d\'une manière nouvelle et passionnante.\r\n', '3CAER-2678', 0, 10000, 15, 10, 6);

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
(6, 'Rennes', NULL, '-1.677000', '48.117000', '35000'),
(7, 'Bordeaux', NULL, '-0.594000', '44.837800', '33000'),
(8, 'Chamonix', NULL, '6.869433', '45.923697', '74400'),
(9, 'Torcy', NULL, '2.654472', '48.850572', '77200'),
(10, 'Versailles', NULL, '2.130122', '48.801408', '78000');

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
(1, 'public/media/events/1190298.jpg', 1),
(2, 'public/media/events/6202303262237.jpg', 6),
(3, 'public/media/events/20230324.jpg', 1),
(7, 'public/media/events/202303261136.jpg', 2),
(8, 'public/media/events/202303261137.jpg', 2),
(9, 'public/media/events/202303261138.jpg', 2),
(10, 'public/media/events/202303261140.jpg', 3),
(11, 'public/media/events/202303261141.jpg', 3),
(12, 'public/media/events/202303261142.jpg', 3),
(13, 'public/media/events/202303261144.jpg', 4),
(14, 'public/media/events/202303261145.jpg', 4),
(15, 'public/media/events/202303261146.jpg', 4),
(16, 'public/media/events/202303261934.jpg', 5),
(17, 'public/media/events/202303261935.jpg', 5),
(18, 'public/media/events/202303261936.jpg', 5),
(19, 'public/media/events/202303261939.jpg', 9),
(20, 'public/media/events/202303261940.jpg', 9),
(21, 'public/media/events/202303261941.jpg', 9),
(22, 'public/media/events/202303261944.jpg', 8),
(23, 'public/media/events/202303261943.jpg', 8),
(24, 'public/media/events/202303261942.jpg', 8);

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
(4, '[value-2]', '10.00', '0664348271', 'UBZHUEVFBIZHVDLZHDV LZJHDLZJ D', '2023-07-05', 1, 1, '08:00:00', '09:00:00', 2, 1, 3, 2),
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
(1, 'oui', 1, 13),
(2, 'oui', 6, 13),
(4, NULL, 2, 20),
(5, NULL, 6, 20),
(6, NULL, 3, 20);

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
(12, 'Association Music Ly', 'Casgrain', 'Océane', 0, '$2y$10$3o5F2vnsJrCc3KhfN8Umi.gIsWMgUXHrowlLwG1NmYa5WsFMUAgfG', '05.68.49.73.35', 'OceaneCasgrain@teleworm.us', 'public/media/users/20230325.jpg', 0, '2023-03-28', 1, 1),
(13, '', 'Rousseau', 'Nadia', 0, '$2y$10$WjSjCu11fDsellxQwq8RBeXCBvTc2ilxMopeO/PywhgnVbGiy4kJi', '0664348271', 'na.86@hotmail.fr', 'public/media/users/20230325.jpg', 0, '2023-03-28', 1, 2),
(14, 'Vilbrequin', 'Levy', 'Sylvain', 1, '$2y$10$mBOTyVjTS2n/A/yhiAHacOMe/oYoDlfhldb8kFeG71356TGjviGEm', '0435173810', 'contact@vilbrequin.fr', 'public/media/users/20230326.jpg', 0, '2023-03-28', 10, 1),
(15, 'Artéclair', 'Riquier', 'Théodore', 1, '$2y$10$ZXeRptQi54yKcyiR755VFOR5578X60KegvHt3w.sHg/CdscgPgW7G', '01.41.34.39.57', 'TheodoreRiquier@rhyta.com', NULL, 0, '2023-03-28', 9, 1),
(16, 'Evénements Créatifs', 'Arcouet', 'Alphonse', 1, '$2y$10$3oihgXOom9YF12HwlWbDGOn5QPEnAUYJdKgT1Yy.bdQgkISv69AMa', '02.12.17.89.35 ', 'AlphonseArcouet@armyspy.com', NULL, 0, '2023-03-28', 2, 1),
(17, 'Esports en Action', 'Bertrand', 'Pascaline', 0, '$2y$10$8CC87q1yTS/tf46x//uOiOHk6UYg0zue1fZK86g4Lwpckzrynug5W', '04.02.81.66.71 ', 'PascalineBertrand@teleworm.us', NULL, 0, '2023-03-28', 5, 1),
(18, 'Arctic Sports Entertainment (ASE)', 'Givry', 'Gabrielle', 0, '$2y$10$2m4uTKgFBvwN0zwd6iovB.S3QQnYbCG3epcAXdv7Po4MhY.1SGZKi', '05.72.81.26.82', 'GabrielleGivry@armyspy.com', NULL, 0, '2023-03-28', 7, 1),
(20, NULL, 'TOi', 'LABAS', 0, '$2y$10$.xvVUMFCeZq9UxVapaYSYelvoT/v1lw/lglJEf1Gf.BT0oDgZBsqq', '', 'del.lavaud@gmail.com', NULL, 0, '2023-03-28', 1, 2);

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
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `couleurs`
--
ALTER TABLE `couleurs`
  MODIFY `id_couleur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT pour la table `favoris`
--
ALTER TABLE `favoris`
  MODIFY `id_favoris` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lieux`
--
ALTER TABLE `lieux`
  MODIFY `id_lieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `id_photos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `moyen_de_transport`
--
ALTER TABLE `moyen_de_transport`
  MODIFY `id_mdt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `participant`
--
ALTER TABLE `participant`
  MODIFY `id_participant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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

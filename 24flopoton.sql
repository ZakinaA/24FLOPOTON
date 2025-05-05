-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 28 avr. 2025 à 11:31
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `24flopoton`
--

-- --------------------------------------------------------

--
-- Structure de la table `accessoire`
--

DROP TABLE IF EXISTS `accessoire`;
CREATE TABLE IF NOT EXISTS `accessoire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `instrument_id` int DEFAULT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8FD026ACF11D9C` (`instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `accessoire`
--

INSERT INTO `accessoire` (`id`, `instrument_id`, `libelle`) VALUES
(1, 1, 'médiator'),
(2, 1, 'Mé­tro­nomes'),
(3, 2, 'Casques Audio');

-- --------------------------------------------------------

--
-- Structure de la table `classe_instrument`
--

DROP TABLE IF EXISTS `classe_instrument`;
CREATE TABLE IF NOT EXISTS `classe_instrument` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classe_instrument`
--

INSERT INTO `classe_instrument` (`id`, `libelle`) VALUES
(1, 'Claviers'),
(2, 'Instruments amplifiés'),
(3, 'Bois'),
(4, 'Cuivres'),
(5, 'Cordes'),
(6, 'Percussions'),
(7, 'Vent');

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

DROP TABLE IF EXISTS `contrat`;
CREATE TABLE IF NOT EXISTS `contrat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `eleve_id` int DEFAULT NULL,
  `instrument_id` int DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `etat_detaille_debut` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_detaille_fin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_60349993A6CC7B2` (`eleve_id`),
  KEY `IDX_60349993CF11D9C` (`instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contrat`
--

INSERT INTO `contrat` (`id`, `eleve_id`, `instrument_id`, `date_debut`, `date_fin`, `etat_detaille_debut`, `etat_detaille_fin`) VALUES
(1, 1, 3, '2024-11-01', '2024-11-08', 'Neuf', 'Traces d\'utilisations normales'),
(2, 2, 3, '2024-10-14', '2024-10-21', 'Neuf', 'Neuf'),
(3, 3, 2, '2024-09-09', '2024-09-16', 'rayures au dos, très bon état général', 'légère rayure à l\'avant, très bon état général'),
(4, 2, 1, '2024-12-02', '2024-12-03', 'très bien', 'bien');

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `professeur_id` int DEFAULT NULL,
  `type_instrument_id` int DEFAULT NULL,
  `jour_id` int DEFAULT NULL,
  `typecours_id` int DEFAULT NULL,
  `libelle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `age_mini` int NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FDCA8C9CBAB22EE9` (`professeur_id`),
  KEY `IDX_FDCA8C9C7C1CAAA9` (`type_instrument_id`),
  KEY `IDX_FDCA8C9C220C6AD0` (`jour_id`),
  KEY `IDX_FDCA8C9C22A6F638` (`typecours_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `professeur_id`, `type_instrument_id`, `jour_id`, `typecours_id`, `libelle`, `age_mini`, `heure_debut`, `heure_fin`) VALUES
(1, 1, 1, 7, 2, 'Guitare Débutant', 12, '10:00:00', '12:00:00'),
(2, 2, 4, 1, 1, 'Piano Avancé', 15, '14:00:00', '16:00:00'),
(3, 3, 5, 3, 2, 'Batterie Intermédiaire', 12, '09:00:00', '11:00:00'),
(4, 3, 6, 4, 2, 'Violoncelle Débutant', 8, '16:00:00', '18:00:00'),
(5, 1, 4, 3, 1, 'Solfège pour débutants', 6, '17:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20241125121329', '2024-11-25 13:13:38', 14827),
('DoctrineMigrations\\Version20241209105821', '2024-12-09 10:58:42', 15007),
('DoctrineMigrations\\Version20241217220754', '2024-12-17 22:08:07', 3813),
('DoctrineMigrations\\Version20250402091654', '2025-04-02 09:17:15', 2518);

-- --------------------------------------------------------

--
-- Structure de la table `eleve`
--

DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `id` int NOT NULL AUTO_INCREMENT,
  `responsable_id` int DEFAULT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_rue` int NOT NULL,
  `rue` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `copos` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ECA105F753C59D72` (`responsable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `eleve`
--

INSERT INTO `eleve` (`id`, `responsable_id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 1, 'Leblanc', 'Tony', 5, 'Rue Ecuyère', '14000', 'Caen', '0606060606', 'TonyLebalnc@gmail.com'),
(2, 2, 'Deschamps', 'Benjamin', 9, 'Rue des Carmes', '14000', 'Caen', '0404040404', 'BenjaminDeschamps@gmail.com'),
(3, 3, 'Garnier', 'Rayan', 4, 'Rue basse', '14000', 'Caen', '0505050505', 'RayanGarnier@gmail.com'),
(4, 6, 'test', 'test', 1, 'test', '14000', 'test', '0101010101', 'test@test.com'),
(5, NULL, 'vc', 'cv cv', 3, 'cvfdsbvdsfg', 'c vcf', 'vcvqergqergergr', 'vcgqergqergq', 'vcergeqrgeqgrr');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cours_id` int NOT NULL,
  `eleve_id` int DEFAULT NULL,
  `date_inscription` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5E90F6D67ECF78B0` (`cours_id`),
  KEY `IDX_5E90F6D6A6CC7B2` (`eleve_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`id`, `cours_id`, `eleve_id`, `date_inscription`) VALUES
(1, 2, 3, '2024-12-21'),
(2, 3, 2, '2024-12-08'),
(3, 1, 2, '2024-12-28'),
(4, 3, 1, '2024-12-28'),
(5, 3, 3, '2024-12-18'),
(6, 3, 1, '2024-12-14'),
(7, 4, 2, '2024-12-28'),
(8, 3, 1, '2024-09-11'),
(9, 5, 1, '2024-12-17'),
(13, 3, 3, '2024-12-26');

-- --------------------------------------------------------

--
-- Structure de la table `instrument`
--

DROP TABLE IF EXISTS `instrument`;
CREATE TABLE IF NOT EXISTS `instrument` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_instrument_id` int DEFAULT NULL,
  `marque_id` int DEFAULT NULL,
  `modele_id` int DEFAULT NULL,
  `num_serie` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_achat` date NOT NULL,
  `prix_achat` double NOT NULL,
  `utilisation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `couleur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3CBF69DD7C1CAAA9` (`type_instrument_id`),
  KEY `IDX_3CBF69DD4827B9B2` (`marque_id`),
  KEY `IDX_3CBF69DDAC14B70A` (`modele_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `instrument`
--

INSERT INTO `instrument` (`id`, `type_instrument_id`, `marque_id`, `modele_id`, `num_serie`, `date_achat`, `prix_achat`, `utilisation`, `couleur`) VALUES
(1, 1, 1, 3, 'A153S', '2024-11-01', 199.98, 'prêt', 'rouge et noir'),
(2, 1, 2, 2, 'P512SZ', '2024-11-15', 349.99, 'prêt', 'Jaune'),
(3, 5, 2, 2, 'E2452SP', '2024-11-13', 100, 'prêt', 'Rose'),
(4, 2, 2, 2, 'PO152SZ', '2024-12-24', 300, 'En classe', 'Noir');

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `id` int NOT NULL AUTO_INCREMENT,
  `professionnel_id` int DEFAULT NULL,
  `instrument_id` int DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `descriptif` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quotite` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D11814AB8A49CC82` (`professionnel_id`),
  KEY `IDX_D11814ABCF11D9C` (`instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`id`, `professionnel_id`, `instrument_id`, `date_debut`, `date_fin`, `descriptif`, `prix`, `quotite`) VALUES
(1, 1, 1, '2024-12-02', '2024-12-04', 'Accordage d\'une guitare', '30', 3),
(2, 2, 1, '2024-12-19', '2024-12-20', 'réparation guitare', '160', 2),
(4, 3, 4, '2025-03-26', '2025-03-27', 'réparation de la flûte', '110', 2);

-- --------------------------------------------------------

--
-- Structure de la table `jour`
--

DROP TABLE IF EXISTS `jour`;
CREATE TABLE IF NOT EXISTS `jour` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `jour`
--

INSERT INTO `jour` (`id`, `libelle`) VALUES
(1, 'lundi'),
(2, 'mardi'),
(3, 'mercredi'),
(4, 'jeudi'),
(5, 'vendredi'),
(6, 'samedi'),
(7, 'dimanche');

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id`, `libelle`) VALUES
(1, 'Shiver'),
(2, 'Yamaha'),
(3, 'Gibson');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `metier`
--

DROP TABLE IF EXISTS `metier`;
CREATE TABLE IF NOT EXISTS `metier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `metier`
--

INSERT INTO `metier` (`id`, `libelle`) VALUES
(1, 'Accordeur'),
(2, 'Luthier'),
(3, 'Réparateur');

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

DROP TABLE IF EXISTS `modele`;
CREATE TABLE IF NOT EXISTS `modele` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `modele`
--

INSERT INTO `modele` (`id`, `nom`) VALUES
(1, 'Electrique'),
(2, 'Acoustique '),
(3, 'électro-acoustique');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

DROP TABLE IF EXISTS `paiement`;
CREATE TABLE IF NOT EXISTS `paiement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inscription_id` int DEFAULT NULL,
  `montant` int NOT NULL,
  `date_paiement` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B1DC7A1E5DAC5993` (`inscription_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `inscription_id`, `montant`, `date_paiement`) VALUES
(1, 4, 80, '2024-12-02'),
(2, 2, 110, '2024-11-04');

-- --------------------------------------------------------

--
-- Structure de la table `professeur`
--

DROP TABLE IF EXISTS `professeur`;
CREATE TABLE IF NOT EXISTS `professeur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_rue` int DEFAULT NULL,
  `rue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `copos` int DEFAULT NULL,
  `ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professeur`
--

INSERT INTO `professeur` (`id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 'Martinez', 'Lucas', 5, 'Rue Gabriel Dupont', 14000, 'Cean', '0784653218', 'MartinezLucas@gmail.com'),
(2, 'Moreno', 'Olivier', 6, 'Chemin des Pépinières', 14000, 'Caen', '0631323536', 'MorenoOlivier@gmail.com'),
(3, 'Léger', 'Mila', 12, 'La Folie', 14000, 'Caen', '0645494847', 'LegerMila@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `professionnel`
--

DROP TABLE IF EXISTS `professionnel`;
CREATE TABLE IF NOT EXISTS `professionnel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_rue` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rue` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `copos` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `professionnel`
--

INSERT INTO `professionnel` (`id`, `nom`, `nom_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 'Bob', 'Rue de Falaise', '1', '14118', 'Caen', '0123456789', 'pro1@gmail.com'),
(2, 'Tom', 'Route de Louvigny', '4', '14118', 'Caen', '0123456789', 'pro2@gmail.com'),
(3, 'Monde', 'Rue Froide', '6', '14000', 'Caen', '0715067120', 'Monde@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `professionnel_metier`
--

DROP TABLE IF EXISTS `professionnel_metier`;
CREATE TABLE IF NOT EXISTS `professionnel_metier` (
  `professionnel_id` int NOT NULL,
  `metier_id` int NOT NULL,
  PRIMARY KEY (`professionnel_id`,`metier_id`),
  KEY `IDX_715C73CA8A49CC82` (`professionnel_id`),
  KEY `IDX_715C73CAED16FA20` (`metier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quotient_familial`
--

DROP TABLE IF EXISTS `quotient_familial`;
CREATE TABLE IF NOT EXISTS `quotient_familial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `quotient_mini` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `quotient_familial`
--

INSERT INTO `quotient_familial` (`id`, `libelle`, `quotient_mini`) VALUES
(1, '-9999 à -1', -9999),
(2, '0 à 250', 0),
(3, '251 à 425', 251),
(4, '426 à 680', 426),
(5, '681 à 935', 681),
(6, '936 à 1800', 936),
(7, '1801 et plus', 1801);

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quotient_familial_id` int DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_rue` smallint DEFAULT NULL,
  `rue` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copos` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_52520D07C8D8BF3D` (`quotient_familial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `responsable`
--

INSERT INTO `responsable` (`id`, `quotient_familial_id`, `nom`, `prenom`, `num_rue`, `rue`, `copos`, `ville`, `tel`, `mail`) VALUES
(1, 2, 'Blondin', 'Lola', 16, 'Rue de la Monnaie', '14025', 'Caen', '0702030604', 'BlondinLola@gmail.com'),
(2, 6, 'Marie', 'Richard', 9, 'Allée de l\'Acacia', '14000', 'Caen', '0732658471', 'MarieRichard@gmail.com'),
(3, 4, 'Moreau', 'Cantin', 21, 'Rue Ernest Manchon', '14000', 'Caen', '0655554444', 'MoreauCantin@gmail.com'),
(4, 2, 'Mari', 'Richard', 1, 'Allée de l\'Acacia', '14000', 'Caen', '0625317345', 'richard.mari@gmail.com'),
(5, 3, 'Mari', 'Richard', 1, 'Allée de l\'Acacia', '14000', 'Caen', '0625317345', 'richard.mari@gmail.com'),
(6, 1, 'BAPTISTE', 'LE ROSSIF', 9, NULL, NULL, NULL, NULL, NULL),
(7, 4, 'BRISSONEAU', 'Pierre', 9, 'Truc', '14000', 'Caen', '0123456789', 'LOOSER@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `tarif`
--

DROP TABLE IF EXISTS `tarif`;
CREATE TABLE IF NOT EXISTS `tarif` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_cours_id` int DEFAULT NULL,
  `quotient_familial_id` int DEFAULT NULL,
  `montant` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E7189C9B3305F4C` (`type_cours_id`),
  KEY `IDX_E7189C9C8D8BF3D` (`quotient_familial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tarif`
--

INSERT INTO `tarif` (`id`, `type_cours_id`, `quotient_familial_id`, `montant`) VALUES
(1, 1, 1, 150),
(2, 2, 2, 120);

-- --------------------------------------------------------

--
-- Structure de la table `type_cours`
--

DROP TABLE IF EXISTS `type_cours`;
CREATE TABLE IF NOT EXISTS `type_cours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_cours`
--

INSERT INTO `type_cours` (`id`, `libelle`) VALUES
(1, 'Collectif'),
(2, 'Individuel');

-- --------------------------------------------------------

--
-- Structure de la table `type_instrument`
--

DROP TABLE IF EXISTS `type_instrument`;
CREATE TABLE IF NOT EXISTS `type_instrument` (
  `id` int NOT NULL AUTO_INCREMENT,
  `classe_instrument_id` int DEFAULT NULL,
  `libelle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_21BCBFF8CE879FB1` (`classe_instrument_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_instrument`
--

INSERT INTO `type_instrument` (`id`, `classe_instrument_id`, `libelle`) VALUES
(1, 5, 'Guitare'),
(2, 7, 'Flûte'),
(3, 5, 'Violon'),
(4, 6, 'Piano'),
(5, 6, 'Batterie'),
(6, 5, 'Violoncelle');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `responsable_id` int DEFAULT NULL,
  `username` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_USERNAME` (`username`),
  UNIQUE KEY `UNIQ_8D93D64953C59D72` (`responsable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `responsable_id`, `username`, `roles`, `password`) VALUES
(7, NULL, 'gestadmin', '[\"ROLE_USER\", \"ROLE_GESTIONNAIRE\", \"ROLE_ADMIN\"]', '$2y$13$MvUJ./dcdVtwehJgEPYQMOMhI2/AJ/EevUYITDW3F34h11/lpOQJe'),
(8, NULL, 'admin', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$djpDp2Ar8JwNnylpCpkoj.bgX0UB5e.p3Bf8uo0f7kOk6X2obgXBC'),
(9, NULL, 'gestio', '[\"ROLE_USER\", \"ROLE_GESTIONNAIRE\"]', '$2y$13$yOnLDo88awWTppPRqfZ6cuUpaZePA9dqxKI7NqYePzXRMG71948kO'),
(10, 1, 'resp', '{\"1\": \"ROLE_RESPELEVE\"}', '$2y$13$KdW08lHVLOAwyHwDuJxAGO/CMyc28TxkGgmBJ566jqLvhKIa4pc..'),
(11, 6, 'bapt', '[]', '$2y$13$L.R6snk/FqMs9K3MnRVrwOCn3d.cbSVOmm/QqW8UoRAB4Wuh5PvBy'),
(12, 7, 'bonjour les sio', '[]', '$2y$13$7C26MbOyNNZRtHbABKpu6eFDnv/tgEQGsRsQJMzYc4eXmFoGklbya');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `accessoire`
--
ALTER TABLE `accessoire`
  ADD CONSTRAINT `FK_8FD026ACF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD CONSTRAINT `FK_60349993A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`),
  ADD CONSTRAINT `FK_60349993CF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `FK_FDCA8C9C220C6AD0` FOREIGN KEY (`jour_id`) REFERENCES `jour` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9C22A6F638` FOREIGN KEY (`typecours_id`) REFERENCES `type_cours` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9C7C1CAAA9` FOREIGN KEY (`type_instrument_id`) REFERENCES `type_instrument` (`id`),
  ADD CONSTRAINT `FK_FDCA8C9CBAB22EE9` FOREIGN KEY (`professeur_id`) REFERENCES `professeur` (`id`);

--
-- Contraintes pour la table `eleve`
--
ALTER TABLE `eleve`
  ADD CONSTRAINT `FK_ECA105F753C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `responsable` (`id`);

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `FK_5E90F6D67ECF78B0` FOREIGN KEY (`cours_id`) REFERENCES `cours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_5E90F6D6A6CC7B2` FOREIGN KEY (`eleve_id`) REFERENCES `eleve` (`id`);

--
-- Contraintes pour la table `instrument`
--
ALTER TABLE `instrument`
  ADD CONSTRAINT `FK_3CBF69DD4827B9B2` FOREIGN KEY (`marque_id`) REFERENCES `marque` (`id`),
  ADD CONSTRAINT `FK_3CBF69DD7C1CAAA9` FOREIGN KEY (`type_instrument_id`) REFERENCES `type_instrument` (`id`),
  ADD CONSTRAINT `FK_3CBF69DDAC14B70A` FOREIGN KEY (`modele_id`) REFERENCES `modele` (`id`);

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `FK_D11814AB8A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`),
  ADD CONSTRAINT `FK_D11814ABCF11D9C` FOREIGN KEY (`instrument_id`) REFERENCES `instrument` (`id`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `FK_B1DC7A1E5DAC5993` FOREIGN KEY (`inscription_id`) REFERENCES `inscription` (`id`);

--
-- Contraintes pour la table `professionnel_metier`
--
ALTER TABLE `professionnel_metier`
  ADD CONSTRAINT `FK_715C73CA8A49CC82` FOREIGN KEY (`professionnel_id`) REFERENCES `professionnel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_715C73CAED16FA20` FOREIGN KEY (`metier_id`) REFERENCES `metier` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `responsable`
--
ALTER TABLE `responsable`
  ADD CONSTRAINT `FK_52520D07C8D8BF3D` FOREIGN KEY (`quotient_familial_id`) REFERENCES `quotient_familial` (`id`);

--
-- Contraintes pour la table `tarif`
--
ALTER TABLE `tarif`
  ADD CONSTRAINT `FK_E7189C9B3305F4C` FOREIGN KEY (`type_cours_id`) REFERENCES `type_cours` (`id`),
  ADD CONSTRAINT `FK_E7189C9C8D8BF3D` FOREIGN KEY (`quotient_familial_id`) REFERENCES `quotient_familial` (`id`);

--
-- Contraintes pour la table `type_instrument`
--
ALTER TABLE `type_instrument`
  ADD CONSTRAINT `FK_21BCBFF8CE879FB1` FOREIGN KEY (`classe_instrument_id`) REFERENCES `classe_instrument` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D64953C59D72` FOREIGN KEY (`responsable_id`) REFERENCES `responsable` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

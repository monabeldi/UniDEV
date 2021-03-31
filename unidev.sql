-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 02 mars 2021 à 08:43
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `unidev`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `id_act` int(11) NOT NULL,
  `id_organis` int(11) NOT NULL,
  `lieu_eve` varchar(50) NOT NULL,
  `prix_parti` float NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `heure_eve` time NOT NULL,
  `heure_fin` time NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id_act`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL,
  `username_ad` varchar(30) NOT NULL,
  `password_ad` varchar(30) NOT NULL,
  `role` varchar(30) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

DROP TABLE IF EXISTS `boutique`;
CREATE TABLE IF NOT EXISTS `boutique` (
  `id_boutique` int(11) NOT NULL,
  `nom_boutique` varchar(30) NOT NULL,
  `addr_boutique` varchar(30) NOT NULL,
  `num_tel_boutique` int(11) NOT NULL,
  `email_boutique` varchar(50) NOT NULL,
  `photo_boutique` varchar(30) NOT NULL,
  PRIMARY KEY (`id_boutique`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `catalogue`
--

DROP TABLE IF EXISTS `catalogue`;
CREATE TABLE IF NOT EXISTS `catalogue` (
  `id_cata` int(11) NOT NULL,
  `photo_cata` int(30) NOT NULL,
  `nom_plat` varchar(30) NOT NULL,
  `desc_plat` varchar(30) NOT NULL,
  PRIMARY KEY (`id_cata`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
CREATE TABLE IF NOT EXISTS `chambre` (
  `id_chambre` int(11) NOT NULL,
  `num_chambre` int(11) NOT NULL,
  `type_chambre` varchar(30) NOT NULL,
  `etat_chambre` varchar(30) NOT NULL,
  `prix_chambre` float NOT NULL,
  `id_hotel` int(11) NOT NULL,
  PRIMARY KEY (`id_chambre`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int(11) NOT NULL,
  `nom_client` varchar(30) NOT NULL,
  `prenom_client` varchar(30) NOT NULL,
  `nationalite` varchar(30) NOT NULL,
  `email_client` varchar(30) NOT NULL,
  `password_client` varchar(30) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id_fac` int(11) NOT NULL,
  `img_fac` varchar(30) NOT NULL,
  PRIMARY KEY (`id_fac`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `guide`
--

DROP TABLE IF EXISTS `guide`;
CREATE TABLE IF NOT EXISTS `guide` (
  `id_gui` int(11) NOT NULL,
  `nom_gui` varchar(30) NOT NULL,
  `prenom_gui` varchar(30) NOT NULL,
  `langues_gui` varchar(30) NOT NULL,
  `etat_gui` varchar(30) NOT NULL,
  `secteur_gui` varchar(30) NOT NULL,
  `avis_gui` varchar(30) NOT NULL,
  `desc_gui` varchar(30) NOT NULL,
  `num_tel_gui` int(11) NOT NULL,
  `photo_gui` varchar(30) NOT NULL,
  PRIMARY KEY (`id_gui`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
CREATE TABLE IF NOT EXISTS `hotel` (
  `id_hotel` int(11) NOT NULL,
  `nom_hotel` varchar(30) NOT NULL,
  `adrr_hotel` varchar(30) NOT NULL,
  `photo_hotel` varchar(30) NOT NULL,
  `rate_hotel` varchar(30) NOT NULL,
  `desc_hotel` int(30) NOT NULL,
  `prix_nuit` float NOT NULL,
  `num_tel_hotel` int(11) NOT NULL,
  `id_chambre` int(11) NOT NULL,
  PRIMARY KEY (`id_hotel`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ogranisateur`
--

DROP TABLE IF EXISTS `ogranisateur`;
CREATE TABLE IF NOT EXISTS `ogranisateur` (
  `id_organis` int(11) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `num_tel_org` int(11) NOT NULL,
  `desc_org` varchar(50) NOT NULL,
  PRIMARY KEY (`id_organis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_pan` int(11) NOT NULL,
  `total` float NOT NULL,
  `id_resv` int(11) NOT NULL,
  `id_prod` int(11) NOT NULL,
  PRIMARY KEY (`id_pan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id-prod` int(11) NOT NULL,
  `nom_prod` varchar(30) NOT NULL,
  `marque_prod` varchar(30) NOT NULL,
  `prix_prod` int(11) NOT NULL,
  `poids_prod` int(11) NOT NULL,
  `id_boutique` int(11) NOT NULL,
  PRIMARY KEY (`id-prod`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id_resv` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `id_hotel` int(11) NOT NULL,
  `id_rest` int(11) NOT NULL,
  `id_gui` int(11) NOT NULL,
  `id_trans` int(11) NOT NULL,
  `id_act` int(11) NOT NULL,
  PRIMARY KEY (`id_resv`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `restaurant`
--

DROP TABLE IF EXISTS `restaurant`;
CREATE TABLE IF NOT EXISTS `restaurant` (
  `id_res` int(11) NOT NULL,
  `nom_res` varchar(30) NOT NULL,
  `addr_res` varchar(30) NOT NULL,
  `photo_res` varchar(30) NOT NULL,
  `id-cat` int(11) NOT NULL,
  `num_tel_res` int(11) NOT NULL,
  PRIMARY KEY (`id_res`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

DROP TABLE IF EXISTS `transport`;
CREATE TABLE IF NOT EXISTS `transport` (
  `id_trans` int(11) NOT NULL,
  `type_trans` varchar(30) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `matr_trans` varchar(30) NOT NULL,
  PRIMARY KEY (`id_trans`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `uber`
--

DROP TABLE IF EXISTS `uber`;
CREATE TABLE IF NOT EXISTS `uber` (
  `id_uber` int(11) NOT NULL,
  `nom_uber` varchar(20) NOT NULL,
  `prenom_uber` varchar(20) NOT NULL,
  `id_trans` int(11) NOT NULL,
  `desc_uber` varchar(30) NOT NULL,
  PRIMARY KEY (`id_uber`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

DROP TABLE IF EXISTS `voiture`;
CREATE TABLE IF NOT EXISTS `voiture` (
  `id-voiture` int(11) NOT NULL,
  `marque_voiture` varchar(30) NOT NULL,
  `desc_voiture` varchar(30) NOT NULL,
  PRIMARY KEY (`id-voiture`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

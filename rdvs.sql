-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 05 Mai 2014 à 09:48
-- Version du serveur: 5.5.29
-- Version de PHP: 5.4.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `rdvs`
--

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `action_id` int(11) NOT NULL AUTO_INCREMENT,
  `action_label` varchar(100) DEFAULT NULL,
  `actions_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`action_id`),
  KEY `FK_actions_actions_type_id` (`actions_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `actions`
--

INSERT INTO `actions` (`action_id`, `action_label`, `actions_type_id`) VALUES
(1, 'Afficher', 1),
(2, 'Imprimer', 1),
(3, 'Ajouter', 2),
(4, 'Modifier', 2),
(5, 'Supprimer', 2),
(6, 'Connexion', 3),
(7, 'Deconnexion', 3),
(8, 'fermer', 4);

-- --------------------------------------------------------

--
-- Structure de la table `actions_types`
--

CREATE TABLE IF NOT EXISTS `actions_types` (
  `actions_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `actions_type_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`actions_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `actions_types`
--

INSERT INTO `actions_types` (`actions_type_id`, `actions_type_label`) VALUES
(1, 'Consultation'),
(2, 'Modification'),
(3, 'Login'),
(4, 'fermer');

-- --------------------------------------------------------

--
-- Structure de la table `activities`
--

CREATE TABLE IF NOT EXISTS `activities` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `activities`
--

INSERT INTO `activities` (`activity_id`, `activity_label`) VALUES
(1, 'Etudiant'),
(2, 'Ingénieur');

-- --------------------------------------------------------

--
-- Structure de la table `calviews`
--

CREATE TABLE IF NOT EXISTS `calviews` (
  `calview_id` int(11) NOT NULL AUTO_INCREMENT,
  `calview_code` varchar(100) DEFAULT NULL,
  `calview_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`calview_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `calviews`
--

INSERT INTO `calviews` (`calview_id`, `calview_code`, `calview_label`) VALUES
(1, 'month', 'Mois'),
(2, 'agendaWeek', 'Semaine'),
(3, 'agendaDay', 'Jour');

-- --------------------------------------------------------

--
-- Structure de la table `hierarchy`
--

CREATE TABLE IF NOT EXISTS `hierarchy` (
  `hierarchy_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id_supervisor` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  PRIMARY KEY (`hierarchy_id`),
  KEY `FK_hierarchy_role_id` (`role_id`),
  KEY `FK_hierarchy_person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `hierarchy`
--

INSERT INTO `hierarchy` (`hierarchy_id`, `person_id_supervisor`, `role_id`, `person_id`) VALUES
(1, 1, 2, 2),
(2, 2, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_datetime` int(11) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `actions_type_id` int(11) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `FK_logs_action_id` (`action_id`),
  KEY `FK_logs_username` (`username`),
  KEY `FK_logs_actions_type_id` (`actions_type_id`),
  KEY `FK_logs_object_id` (`object_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `logs`
--

INSERT INTO `logs` (`log_id`, `log_datetime`, `action_id`, `username`, `actions_type_id`, `object_id`) VALUES
(1, 1393178724, 1, 'tarik', 1, 2),
(2, 1393178738, 3, 'tarik', 2, 5),
(3, 1393179089, 6, 'khalil', 3, 1),
(4, 1393179512, 3, 'khalil', 2, 14),
(5, 1393179523, 1, 'khalil', 1, 13),
(6, 1393179542, 1, 'khalil', 1, 12),
(7, 1393179644, 1, 'khalil', 1, 13),
(8, 1393198286, 6, 'khalil', 3, 1),
(9, 1394028485, 6, 'khalil', 3, 1),
(10, 1394028497, 1, 'khalil', 1, 2),
(11, 1394028519, 3, 'khalil', 2, 5);

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `compte_public` int(11) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `calview_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`username`),
  KEY `FK_members_person_id` (`person_id`),
  KEY `FK_members_calview_id` (`calview_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `members`
--

INSERT INTO `members` (`username`, `password`, `compte_public`, `person_id`, `calview_id`) VALUES
('khalil', '8c6617dbddaf5ee6d4dd0a91108429ecf6018408', 0, 1, 1),
('tarik', '243fad2125b703b6e06c163de9bc1f108deb8225', 0, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `object_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_label` varchar(100) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`object_id`),
  KEY `FK_objects_action_id` (`action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `objects`
--

INSERT INTO `objects` (`object_id`, `object_label`, `action_id`) VALUES
(1, 'Login', 6),
(2, 'select', 1),
(3, 'event_drop', 4),
(4, 'eventResize', 4),
(5, 'create_save', 3),
(6, 'create_close', 8),
(7, 'select_click_event', 1),
(8, 'save_click_event', 3),
(9, 'delete_click_event', 5),
(10, 'close_click_event', 8),
(11, 'logout', 7),
(12, 'parametres', 1),
(13, 'profil', 1),
(14, 'add_contact', 3),
(15, 'add_adress', 3);

-- --------------------------------------------------------

--
-- Structure de la table `organisation`
--

CREATE TABLE IF NOT EXISTS `organisation` (
  `organisation_id` int(11) NOT NULL AUTO_INCREMENT,
  `organisation_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`organisation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `organisation`
--

INSERT INTO `organisation` (`organisation_id`, `organisation_name`) VALUES
(1, 'ENSIM'),
(2, 'Entreprise1');

-- --------------------------------------------------------

--
-- Structure de la table `organisation_activities`
--

CREATE TABLE IF NOT EXISTS `organisation_activities` (
  `organisation_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL,
  PRIMARY KEY (`organisation_id`,`activity_id`),
  KEY `FK_organisation_activities_activity_id` (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `organisation_activities`
--

INSERT INTO `organisation_activities` (`organisation_id`, `activity_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `permission_types`
--

CREATE TABLE IF NOT EXISTS `permission_types` (
  `permission_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_type_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`permission_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `permission_types`
--

INSERT INTO `permission_types` (`permission_type_id`, `permission_type_label`) VALUES
(1, 'Consultation'),
(2, 'Modification');

-- --------------------------------------------------------

--
-- Structure de la table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_firstname` varchar(100) DEFAULT NULL,
  `person_lastname` varchar(100) DEFAULT NULL,
  `person_birthday` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  KEY `FK_persons_activity_id` (`activity_id`),
  KEY `FK_persons_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `persons`
--

INSERT INTO `persons` (`person_id`, `person_firstname`, `person_lastname`, `person_birthday`, `email`, `activity_id`, `username`) VALUES
(1, 'Khalil', 'EL ISMAILI', '1986-09-18', NULL, 1, 'khalil'),
(2, 'tarik', 'FERDAOUSSI', '2014-02-10', NULL, 2, 'tarik'),
(3, 'Contact 1', 'CONTACT', '2014-02-02', NULL, 1, NULL),
(4, 'Contact1', 'CONTACT', '2014-02-03', NULL, 1, NULL),
(5, 'Contact1', 'CONTACT', '2014-02-03', NULL, 1, NULL),
(6, 'khalil', 'el ismaili', '2014-02-14', NULL, 2, NULL),
(7, 'madeth', 'May', '2014-02-05', NULL, 2, NULL),
(8, 'silniki', 'Gaeton', '2014-02-05', NULL, 1, NULL),
(9, 'blabla', 'blabla', '2014-02-03', NULL, 1, 'khalil'),
(10, 'hfjdsk', 'bmla', '2014-02-23', NULL, 1, 'khalil');

-- --------------------------------------------------------

--
-- Structure de la table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `place_id` int(11) NOT NULL AUTO_INCREMENT,
  `place_name` varchar(100) DEFAULT NULL,
  `place_addr` varchar(255) DEFAULT NULL,
  `place_public` int(11) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`place_id`),
  KEY `FK_places_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `places`
--

INSERT INTO `places` (`place_id`, `place_name`, `place_addr`, `place_public`, `username`) VALUES
(1, 'ENSIM', 'rue Aristote - 72000 - Le Mans', NULL, 'khalil'),
(2, 'Chez moi', '16 bd suchet', NULL, 'tarik'),
(3, 'Chez moi', '16 bd suchet', NULL, 'tarik'),
(4, 'zez', '14 sd', NULL, 'tarik'),
(5, 'machin', 'bidule', NULL, 'tarik');

-- --------------------------------------------------------

--
-- Structure de la table `rdvs`
--

CREATE TABLE IF NOT EXISTS `rdvs` (
  `rdv_id` int(11) NOT NULL AUTO_INCREMENT,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `allDay` varchar(50) DEFAULT NULL,
  `className` varchar(100) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `place_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`rdv_id`),
  KEY `FK_rdvs_person_id` (`person_id`),
  KEY `FK_rdvs_place_id` (`place_id`),
  KEY `FK_rdvs_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `rdvs`
--

INSERT INTO `rdvs` (`rdv_id`, `start`, `end`, `title`, `allDay`, `className`, `person_id`, `place_id`, `username`) VALUES
(1, '2014-01-30 00:00:00', '2014-01-30 00:00:00', 'rdv1', 'true', '', 2, 2, 'tarik'),
(2, '2014-01-28 00:00:00', '2014-01-28 00:00:00', 'rdv2', 'true', '', 2, 2, 'tarik'),
(3, '2014-02-27 00:00:00', '2014-02-27 00:00:00', 'rdv téléphonique', 'true', '', 10, 2, 'khalil');

-- --------------------------------------------------------

--
-- Structure de la table `right_to`
--

CREATE TABLE IF NOT EXISTS `right_to` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `organisation_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`,`organisation_id`,`username`),
  KEY `FK_right_to_organisation_id` (`organisation_id`),
  KEY `FK_right_to_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `right_to`
--

INSERT INTO `right_to` (`role_id`, `organisation_id`, `username`) VALUES
(1, 1, 'khalil'),
(2, 1, 'tarik');

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_label` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`role_id`, `role_label`) VALUES
(1, 'Administrateur'),
(2, 'Assistant');

-- --------------------------------------------------------

--
-- Structure de la table `roles_permissions`
--

CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_type_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_type_id`),
  KEY `FK_roles_permissions_permission_type_id` (`permission_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `permission_type_id`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `unit_permissions`
--

CREATE TABLE IF NOT EXISTS `unit_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_label` varchar(100) DEFAULT NULL,
  `permission_type_id` int(11) NOT NULL,
  PRIMARY KEY (`permission_id`),
  KEY `FK_unit_permissions_permission_type_id` (`permission_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `unit_permissions`
--

INSERT INTO `unit_permissions` (`permission_id`, `permission_label`, `permission_type_id`) VALUES
(1, 'Afficher', 1),
(2, 'Imprimer', 1),
(3, 'Ajouter', 2),
(4, 'Modifier', 2),
(5, 'Supprimer', 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `FK_actions_actions_type_id` FOREIGN KEY (`actions_type_id`) REFERENCES `actions_types` (`actions_type_id`);

--
-- Contraintes pour la table `hierarchy`
--
ALTER TABLE `hierarchy`
  ADD CONSTRAINT `FK_hierarchy_person_id` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`),
  ADD CONSTRAINT `FK_hierarchy_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Contraintes pour la table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FK_logs_actions_type_id` FOREIGN KEY (`actions_type_id`) REFERENCES `actions_types` (`actions_type_id`),
  ADD CONSTRAINT `FK_logs_action_id` FOREIGN KEY (`action_id`) REFERENCES `actions` (`action_id`),
  ADD CONSTRAINT `FK_logs_object_id` FOREIGN KEY (`object_id`) REFERENCES `objects` (`object_id`),
  ADD CONSTRAINT `FK_logs_username` FOREIGN KEY (`username`) REFERENCES `members` (`username`);

--
-- Contraintes pour la table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `FK_members_calview_id` FOREIGN KEY (`calview_id`) REFERENCES `calviews` (`calview_id`),
  ADD CONSTRAINT `FK_members_person_id` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`);

--
-- Contraintes pour la table `objects`
--
ALTER TABLE `objects`
  ADD CONSTRAINT `FK_objects_action_id` FOREIGN KEY (`action_id`) REFERENCES `actions` (`action_id`);

--
-- Contraintes pour la table `organisation_activities`
--
ALTER TABLE `organisation_activities`
  ADD CONSTRAINT `FK_organisation_activities_activity_id` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`activity_id`),
  ADD CONSTRAINT `FK_organisation_activities_organisation_id` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`organisation_id`);

--
-- Contraintes pour la table `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `FK_persons_activity_id` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`activity_id`),
  ADD CONSTRAINT `FK_persons_username` FOREIGN KEY (`username`) REFERENCES `members` (`username`);

--
-- Contraintes pour la table `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `FK_places_username` FOREIGN KEY (`username`) REFERENCES `members` (`username`);

--
-- Contraintes pour la table `rdvs`
--
ALTER TABLE `rdvs`
  ADD CONSTRAINT `FK_rdvs_person_id` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`),
  ADD CONSTRAINT `FK_rdvs_place_id` FOREIGN KEY (`place_id`) REFERENCES `places` (`place_id`),
  ADD CONSTRAINT `FK_rdvs_username` FOREIGN KEY (`username`) REFERENCES `members` (`username`);

--
-- Contraintes pour la table `right_to`
--
ALTER TABLE `right_to`
  ADD CONSTRAINT `FK_right_to_organisation_id` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`organisation_id`),
  ADD CONSTRAINT `FK_right_to_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `FK_right_to_username` FOREIGN KEY (`username`) REFERENCES `members` (`username`);

--
-- Contraintes pour la table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD CONSTRAINT `FK_roles_permissions_permission_type_id` FOREIGN KEY (`permission_type_id`) REFERENCES `permission_types` (`permission_type_id`),
  ADD CONSTRAINT `FK_roles_permissions_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Contraintes pour la table `unit_permissions`
--
ALTER TABLE `unit_permissions`
  ADD CONSTRAINT `FK_unit_permissions_permission_type_id` FOREIGN KEY (`permission_type_id`) REFERENCES `permission_types` (`permission_type_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

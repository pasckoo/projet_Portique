-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Ven 08 Juillet 2022 à 08:36
-- Version du serveur :  5.7.11
-- Version de PHP :  7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gdcr`
--

-- --------------------------------------------------------

--
-- Structure de la table `atelier`
--

CREATE TABLE `atelier` (
  `id_atelier` int(11) NOT NULL,
  `designation_atelier` varchar(50) DEFAULT NULL,
  `commentaire_atelier` varchar(255) DEFAULT NULL,
  `id_secteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `controle`
--

CREATE TABLE `controle` (
  `id_controle` int(11) NOT NULL,
  `date_controle` date DEFAULT NULL,
  `id_materiel` int(11) NOT NULL,
  `id_perio` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment_controle` varchar(255) DEFAULT NULL,
  `date_suiv_controle` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `controle`
--

INSERT INTO `controle` (`id_controle`, `date_controle`, `id_materiel`, `id_perio`, `id_user`, `comment_controle`, `date_suiv_controle`) VALUES
(9, '2022-06-23', 9, 16, 2, 'RAS', '0000-00-00'),
(21, '2022-06-23', 1, 16, 3, 'RAS', '0000-00-00'),
(22, '2022-06-23', 1, 20, 3, 'RAS', '0000-00-00'),
(26, '2022-06-26', 11, 20, 2, 'RAS', '0000-00-00'),
(27, '2022-06-29', 18, 20, 2, 'RAS', '0000-00-00'),
(29, '2022-05-02', 19, 16, 2, '', '2022-05-02'),
(30, '2022-06-01', 1, 20, 2, '', '2022-06-01'),
(31, '2022-07-07', 20, 16, 2, 'RAS', '2022-07-07');

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE `famille` (
  `id_famille` int(11) NOT NULL,
  `categorie_famille` varchar(50) NOT NULL,
  `designation_famille` varchar(255) DEFAULT NULL,
  `periodicite1_famille` varchar(50) DEFAULT NULL,
  `periodicite2_famille` varchar(50) DEFAULT NULL,
  `periodicite3_famille` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `famille`
--

INSERT INTO `famille` (`id_famille`, `categorie_famille`, `designation_famille`, `periodicite1_famille`, `periodicite2_famille`, `periodicite3_famille`) VALUES
(4, 'Extincteur', 'Famille des extincteurs', '1 an', '', ''),
(5, 'Eclairage de secours', 'Eclairages de secours', '1 an', '', ''),
(6, 'Manutention', 'Famille des éléments de manutention', '1 an', '', ''),
(7, 'Borne incendie', 'Famille des bornes incendie', '1 an', '', ''),
(8, 'Portes coupe-feu', 'Famille des portes coupe-feu', '6 mois', '', ''),
(9, 'reservoir', 'Famille des cuves sous pression', '40 mois', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `loginusers`
--

CREATE TABLE `loginusers` (
  `id_login` int(11) NOT NULL,
  `login_login` varchar(100) NOT NULL,
  `heure_login` varchar(50) DEFAULT NULL,
  `type_login` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE `materiel` (
  `id_materiel` int(11) NOT NULL,
  `rep_materiel` varchar(50) DEFAULT NULL,
  `designation_materiel` varchar(100) DEFAULT NULL,
  `reference_materiel` varchar(50) DEFAULT NULL,
  `date_mes_materiel` date DEFAULT NULL,
  `commentaire_materiel` varchar(512) DEFAULT NULL,
  `photo_materiel` varchar(100) DEFAULT NULL,
  `id_secteur` int(11) DEFAULT NULL,
  `id_famille` int(11) DEFAULT NULL,
  `id_modele` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `rep_materiel`, `designation_materiel`, `reference_materiel`, `date_mes_materiel`, `commentaire_materiel`, `photo_materiel`, `id_secteur`, `id_famille`, `id_modele`) VALUES
(1, 'H1EXE1', 'Hall 1 extincteur à eau N° 1', 'SICLI', '2022-06-15', 'aucun', 'eau.jpg', 6, 4, 2),
(3, 'H1E2', 'Extincteur à eau N°2 du hall 1', 'SICLI', '2022-06-15', '', 'eau.jpg', 6, 4, 2),
(9, 'HBI01', 'borne incendie 1 du hall 1', 'bA123', '2022-06-17', 'aucun', '', 3, 7, 10),
(10, 'HCC1', 'chaine 4 brins N°1 du hall 1', '1tonne à 45°, 2 mètres', '2022-06-17', 'Nouveau matériel', '', 4, 6, 9),
(11, 'HCE2', 'elingue 2 du hall C', '2 tonnes, 4 mètres', '2022-06-17', 'aucun', '', 4, 6, 8),
(17, 'HCE4', 'Elingue 4 du hall C', '2 tonnes, 2 mètres', '2022-06-01', 'Nouvelle élingue pour le hall C', '', 4, 4, 2),
(18, 'H1EX2', 'Hall 1 Extincteur à eau N° 2', 'SICLI', '2022-06-01', '', '', 6, 4, 2),
(19, 'H1BA1', '', '', '2022-06-02', '', '', 6, 5, 7),
(20, 'HBBA2', 'Hall B éclairage secours BAES N°2', 'LEGRAND', '2022-05-20', '', '', 3, 5, 7),
(21, 'HCBOP1', 'Hall C borne incendie poteau N°1', '', '2022-07-04', '', '', 4, 7, 10),
(22, 'BU0ME12', 'Bureau rez de chaussée elingue N°12', '', '2022-05-06', '', '', 7, 6, 9);

-- --------------------------------------------------------

--
-- Structure de la table `modele`
--

CREATE TABLE `modele` (
  `id_modele` int(11) NOT NULL,
  `type_modele` varchar(50) DEFAULT NULL,
  `designation_modele` varchar(255) DEFAULT NULL,
  `id_famille` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `modele`
--

INSERT INTO `modele` (`id_modele`, `type_modele`, `designation_modele`, `id_famille`) VALUES
(2, 'Eau', 'Extincteur à eau', 4),
(3, 'Poudre', 'Exincteur à poudre', 4),
(4, 'CO2', 'Extincteur à CO2', 4),
(7, 'BAES', 'Eclairage de secours', 5),
(8, 'Chaîne', 'Chaîne de levage', 6),
(9, 'Elingue', 'Elingue souple', 6),
(10, 'Poteau', 'Borne type poteau', 7),
(13, 'Pince', 'Pince de levage', 6);

-- --------------------------------------------------------

--
-- Structure de la table `perio`
--

CREATE TABLE `perio` (
  `id_perio` int(11) NOT NULL,
  `intitule_perio` varchar(50) NOT NULL,
  `type_perio` varchar(50) NOT NULL,
  `nb_perio` int(10) NOT NULL,
  `commentaire_perio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `perio`
--

INSERT INTO `perio` (`id_perio`, `intitule_perio`, `type_perio`, `nb_perio`, `commentaire_perio`) VALUES
(13, 'Quotidien', 'jour', 1, 'Tous les jours'),
(14, 'Hebdomadaire', 'semaine', 1, 'Toutes les semaines'),
(15, 'Bimensuelle', 'semaine', 2, 'Toutes les 2 semaines'),
(16, 'Mensuelle', 'mois', 1, 'Tous les mois'),
(17, 'Bimestrielle', 'mois', 2, 'Tous les 2 mois'),
(18, 'Trimestrielle', 'mois', 3, 'Tous les 3 mois'),
(19, 'Semestrielle', 'mois', 6, 'Tous les 6 mois'),
(20, 'Annuelle', 'année', 1, 'Tous les ans');

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

CREATE TABLE `planning` (
  `id_modele` int(11) NOT NULL,
  `id_perio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `planning`
--

INSERT INTO `planning` (`id_modele`, `id_perio`) VALUES
(7, 16),
(2, 20),
(4, 20),
(7, 20),
(8, 20),
(9, 20),
(10, 20);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `prochain_controle`
--
CREATE TABLE `prochain_controle` (
`prochain_controle` date
,`rep_materiel` varchar(50)
,`categorie_famille` varchar(50)
,`type_modele` varchar(50)
,`intitule_perio` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure de la table `secteur`
--

CREATE TABLE `secteur` (
  `id_secteur` int(11) NOT NULL,
  `designation_secteur` varchar(50) NOT NULL,
  `commentaire_secteur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `secteur`
--

INSERT INTO `secteur` (`id_secteur`, `designation_secteur`, `commentaire_secteur`) VALUES
(3, 'HB', 'Hall B (Usinage)'),
(4, 'HC', 'Secteur Hall C (mécano-soudure)'),
(6, 'H1', 'Secteur hall 1 (réception, magasin)'),
(7, 'BU0', 'Bureaux RDC'),
(8, 'BU1', 'Bureaux 1er étage');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nom_user` varchar(50) DEFAULT NULL,
  `prenom_user` varchar(50) DEFAULT NULL,
  `login_user` varchar(50) NOT NULL,
  `mdp_user` varchar(255) DEFAULT NULL,
  `fonction_user` varchar(50) DEFAULT NULL,
  `date_crea_user` date DEFAULT NULL,
  `type_user` varchar(50) DEFAULT NULL,
  `image_user` varchar(255) DEFAULT '..\\IMG\\photos\\6.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id_user`, `nom_user`, `prenom_user`, `login_user`, `mdp_user`, `fonction_user`, `date_crea_user`, `type_user`, `image_user`) VALUES
(2, 'Gillotin', 'Pascal', 'pascal@gillotin', '081013837e084b6914fa666600b38fc071212b997004b4c8ff8e722c34ca0043b1c7f4a2182d917bd3c67c4205e19813a2b22186324086f1f74c271d2084bd4b', 'controleur', '2022-06-23', '1', '8'),
(3, 'Gillotin', 'Sabine', 'sabine@gillotin', 'c9a9663d3c8b77726118cf4d8b7f94bff9f211b2bb36f64ced05551acb6b5cba83db21d803c916017f7affc5662fee9803175cac2194a0ebcb7ed511c1e86307', 'controleur', '2022-06-23', '0', '6'),
(9, 'Gillotin', 'Nicolas', 'nicolas@gillotin', '081013837e084b6914fa666600b38fc071212b997004b4c8ff8e722c34ca0043b1c7f4a2182d917bd3c67c4205e19813a2b22186324086f1f74c271d2084bd4b', 'controleur', '2022-07-05', '0', '1'),
(23, 'Gabin', 'Jean', 'jean@gabin', '081013837e084b6914fa666600b38fc071212b997004b4c8ff8e722c34ca0043b1c7f4a2182d917bd3c67c4205e19813a2b22186324086f1f74c271d2084bd4b', 'utilisateur', '2022-07-06', '0', '6'),
(27, 'admin', 'admin', 'admin@admin', 'cc2c68b6e4c7d25c1066e33d7e0ea1861fd1d7083a7e26912f09170e84904f84508cd6eb9e4e2cae20e5e454c273bf4947cfe56e1398a9269105580c3ee78313', 'controleur', '2022-07-06', '1', '3'),
(29, 'Dion', 'C&eacute;line', 'celine@dion', '081013837e084b6914fa666600b38fc071212b997004b4c8ff8e722c34ca0043b1c7f4a2182d917bd3c67c4205e19813a2b22186324086f1f74c271d2084bd4b', 'utilisateur', '2022-07-06', '0', '6');

-- --------------------------------------------------------

--
-- Structure de la vue `prochain_controle`
--
DROP TABLE IF EXISTS `prochain_controle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prochain_controle`  AS  select (case when (`perio`.`type_perio` = 'jour') then (`controle`.`date_controle` + interval `perio`.`nb_perio` day) when (`perio`.`type_perio` = 'semaine') then (`controle`.`date_controle` + interval `perio`.`nb_perio` week) when (`perio`.`type_perio` = 'mois') then (`controle`.`date_controle` + interval `perio`.`nb_perio` month) when (`perio`.`type_perio` = 'annee') then (`controle`.`date_controle` + interval `perio`.`nb_perio` year) end) AS `prochain_controle`,`materiel`.`rep_materiel` AS `rep_materiel`,`famille`.`categorie_famille` AS `categorie_famille`,`modele`.`type_modele` AS `type_modele`,`perio`.`intitule_perio` AS `intitule_perio` from (((((`controle` join `materiel`) join `user`) join `perio`) join `famille`) join `modele`) where ((`controle`.`id_materiel` = `materiel`.`id_materiel`) and (`controle`.`id_user` = `user`.`id_user`) and (`controle`.`id_perio` = `perio`.`id_perio`) and (`famille`.`id_famille` = `materiel`.`id_famille`) and (`modele`.`id_modele` = `materiel`.`id_modele`)) union select distinct (case when (`perio`.`type_perio` = 'jour') then (`materiel`.`date_mes_materiel` + interval `perio`.`nb_perio` day) when (`perio`.`type_perio` = 'semaine') then (`materiel`.`date_mes_materiel` + interval `perio`.`nb_perio` week) when (`perio`.`type_perio` = 'mois') then (`materiel`.`date_mes_materiel` + interval `perio`.`nb_perio` month) when (`perio`.`type_perio` = 'annee') then (`materiel`.`date_mes_materiel` + interval `perio`.`nb_perio` year) end) AS `prochain_controle`,`materiel`.`rep_materiel` AS `rep_materiel`,`famille`.`categorie_famille` AS `categorie_famille`,`modele`.`type_modele` AS `type_modele`,`perio`.`intitule_perio` AS `intitule_perio` from ((((`materiel` join `planning`) join `modele`) join `perio`) join `famille`) where ((not(`materiel`.`id_materiel` in (select `controle`.`id_materiel` from `controle`))) and (`planning`.`id_perio` = `perio`.`id_perio`) and `planning`.`id_modele` in (select `modele`.`id_modele` from `modele` where (`modele`.`id_modele` = `materiel`.`id_modele`)) and (`modele`.`id_modele` = `materiel`.`id_modele`) and (`famille`.`id_famille` = `materiel`.`id_famille`)) ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `atelier`
--
ALTER TABLE `atelier`
  ADD PRIMARY KEY (`id_atelier`),
  ADD UNIQUE KEY `designation_atelier` (`designation_atelier`),
  ADD KEY `id_secteur` (`id_secteur`);

--
-- Index pour la table `controle`
--
ALTER TABLE `controle`
  ADD PRIMARY KEY (`id_controle`),
  ADD KEY `id_perio` (`id_perio`),
  ADD KEY `Id_materiel` (`id_materiel`),
  ADD KEY `controle_ibfk_2` (`id_user`);

--
-- Index pour la table `famille`
--
ALTER TABLE `famille`
  ADD PRIMARY KEY (`id_famille`),
  ADD UNIQUE KEY `categorie_famille` (`categorie_famille`);

--
-- Index pour la table `loginusers`
--
ALTER TABLE `loginusers`
  ADD PRIMARY KEY (`id_login`);

--
-- Index pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD PRIMARY KEY (`id_materiel`),
  ADD UNIQUE KEY `rep_materiel` (`rep_materiel`),
  ADD KEY `id_secteur` (`id_secteur`),
  ADD KEY `id_modele` (`id_modele`),
  ADD KEY `id_famille` (`id_famille`);

--
-- Index pour la table `modele`
--
ALTER TABLE `modele`
  ADD PRIMARY KEY (`id_modele`),
  ADD UNIQUE KEY `type_modele` (`type_modele`),
  ADD KEY `id_famille` (`id_famille`);

--
-- Index pour la table `perio`
--
ALTER TABLE `perio`
  ADD PRIMARY KEY (`id_perio`),
  ADD UNIQUE KEY `intitule_perio` (`intitule_perio`);

--
-- Index pour la table `planning`
--
ALTER TABLE `planning`
  ADD PRIMARY KEY (`id_modele`,`id_perio`),
  ADD KEY `id_perio` (`id_perio`);

--
-- Index pour la table `secteur`
--
ALTER TABLE `secteur`
  ADD PRIMARY KEY (`id_secteur`),
  ADD UNIQUE KEY `designation_secteur` (`designation_secteur`),
  ADD UNIQUE KEY `designation_secteur_2` (`designation_secteur`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `login_user` (`login_user`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `atelier`
--
ALTER TABLE `atelier`
  MODIFY `id_atelier` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `controle`
--
ALTER TABLE `controle`
  MODIFY `id_controle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `famille`
--
ALTER TABLE `famille`
  MODIFY `id_famille` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `loginusers`
--
ALTER TABLE `loginusers`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `materiel`
--
ALTER TABLE `materiel`
  MODIFY `id_materiel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `modele`
--
ALTER TABLE `modele`
  MODIFY `id_modele` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `perio`
--
ALTER TABLE `perio`
  MODIFY `id_perio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `secteur`
--
ALTER TABLE `secteur`
  MODIFY `id_secteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `atelier`
--
ALTER TABLE `atelier`
  ADD CONSTRAINT `atelier_ibfk_1` FOREIGN KEY (`id_secteur`) REFERENCES `secteur` (`id_secteur`);

--
-- Contraintes pour la table `controle`
--
ALTER TABLE `controle`
  ADD CONSTRAINT `controle_ibfk_1` FOREIGN KEY (`id_perio`) REFERENCES `perio` (`id_perio`),
  ADD CONSTRAINT `controle_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `controle_ibfk_3` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`);

--
-- Contraintes pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD CONSTRAINT `materiel_ibfk_1` FOREIGN KEY (`id_secteur`) REFERENCES `secteur` (`id_secteur`),
  ADD CONSTRAINT `materiel_ibfk_2` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`),
  ADD CONSTRAINT `materiel_ibfk_3` FOREIGN KEY (`id_famille`) REFERENCES `famille` (`id_famille`);

--
-- Contraintes pour la table `modele`
--
ALTER TABLE `modele`
  ADD CONSTRAINT `modele_ibfk_1` FOREIGN KEY (`id_famille`) REFERENCES `famille` (`id_famille`);

--
-- Contraintes pour la table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`id_modele`) REFERENCES `modele` (`id_modele`),
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`id_perio`) REFERENCES `perio` (`id_perio`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

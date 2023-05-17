-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 16 mai 2023 à 17:39
-- Version du serveur : 5.7.24
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `omnes_my_skills`
--

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `ID_Classe` int(11) NOT NULL,
  `Num_groupe` int(3) DEFAULT NULL,
  `Nombre_etudiant` int(5) DEFAULT NULL,
  `ID_Promotion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

CREATE TABLE `competence` (
  `ID_Competence` int(11) NOT NULL,
  `Nom_competence` varchar(30) NOT NULL,
  `Date_Creation` int(4) NOT NULL,
  `Theme` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `competence`
--

INSERT INTO `competence` (`ID_Competence`, `Nom_competence`, `Date_Creation`, `Theme`) VALUES
(1, 'Maitrise_C++', 2020, 'Programmation'),
(2, 'Maitrise_C', 2019, 'Programmation'),
(3, 'Maitrise_Python', 2018, 'Programmation');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `ID_Compte` int(11) NOT NULL,
  `Nom_Compte` varchar(50) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `E_mail` varchar(50) NOT NULL,
  `MDP` varchar(30) NOT NULL,
  `Type_compte` varchar(30) NOT NULL,
  `Deja_connecte` tinyint(1) NOT NULL,
  `ID_Ecole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`ID_Compte`, `Nom_Compte`, `Prenom`, `E_mail`, `MDP`, `Type_compte`, `Deja_connecte`, `ID_Ecole`) VALUES
(1, 'ZIZOU', 'Bastien', 'ilrevient@gmail.com', 'n2ggsz245', 'Etudiant', 1, 3),
(2, 'MASSON', 'Charles', 'charles17@gmail.com', 'n2515', 'Etudiant', 1, 1),
(3, 'BAUDOUIN', 'ARTHUR', 'arthur17@gmail.com', 'n224245', 'Etudiant', 1, 2),
(5, 'ARRIETA', 'Lukeh', 'iso@gmail.com', 'aetsxeb45', 'Professeur', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `compte_competence`
--

CREATE TABLE `compte_competence` (
  `ID_compte_competence` int(11) NOT NULL,
  `ID_Compte` int(11) NOT NULL,
  `ID_Competence` int(11) NOT NULL,
  `Moyenne_professeur` int(2) DEFAULT NULL,
  `Etat_competence` varchar(30) NOT NULL,
  `Competence_valide_etudiant` varchar(30) DEFAULT NULL,
  `Competence_valide_professeur` varchar(30) DEFAULT NULL,
  `Appreciation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte_competence`
--

INSERT INTO `compte_competence` (`ID_compte_competence`, `ID_Compte`, `ID_Competence`, `Moyenne_professeur`, `Etat_competence`, `Competence_valide_etudiant`, `Competence_valide_professeur`, `Appreciation`) VALUES
(1, 1, 1, 14, 'noneva', 'noneva', 'noneva', 'tresgrosnul'),
(2, 1, 2, 15, 'noneva', 'noneva', 'noneva', 'tresgrosnul'),
(3, 1, 3, 18, 'noneva', 'noneva', 'noneva', 'tresgrosnul'),
(7, 2, 2, 14, 'noneva', 'noneva', 'noneva', 'grosnul');

-- --------------------------------------------------------

--
-- Structure de la table `compte_matiere`
--

CREATE TABLE `compte_matiere` (
  `ID_compte_matiere` int(11) NOT NULL,
  `ID_Compte` int(11) NOT NULL,
  `ID_Matiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte_matiere`
--

INSERT INTO `compte_matiere` (`ID_compte_matiere`, `ID_Compte`, `ID_Matiere`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 1),
(4, 1, 2),
(5, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `ecole`
--

CREATE TABLE `ecole` (
  `ID_Ecole` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ecole`
--

INSERT INTO `ecole` (`ID_Ecole`, `Nom`) VALUES
(1, 'ECE'),
(2, 'ESCE'),
(3, 'ECAM');

-- --------------------------------------------------------

--
-- Structure de la table `ecole_filiere`
--

CREATE TABLE `ecole_filiere` (
  `ID_ecole_filiere` int(11) NOT NULL,
  `ID_Ecole` int(11) NOT NULL,
  `ID_Filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `ID_Filiere` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `matiere`
--

CREATE TABLE `matiere` (
  `ID_Matiere` int(11) NOT NULL,
  `Nom_matiere` varchar(50) NOT NULL,
  `Volume_horaire` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `matiere`
--

INSERT INTO `matiere` (`ID_Matiere`, `Nom_matiere`, `Volume_horaire`) VALUES
(1, 'Informatique', 600),
(2, 'Physique', 300),
(3, 'Mathematiques', 500);

-- --------------------------------------------------------

--
-- Structure de la table `matiere_competence`
--

CREATE TABLE `matiere_competence` (
  `ID_matiere_competence` int(11) NOT NULL,
  `ID_Matiere` int(11) NOT NULL,
  `ID_Competence` int(11) NOT NULL,
  `Professeur` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `matiere_competence`
--

INSERT INTO `matiere_competence` (`ID_matiere_competence`, `ID_Matiere`, `ID_Competence`, `Professeur`) VALUES
(1, 1, 1, 'MAmirouche'),
(2, 2, 3, 'AFEF'),
(3, 3, 2, 'HINTZY'),
(4, 2, 3, 'BONFILS');

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `ID_Promotion` int(11) NOT NULL,
  `Annee_debut` int(4) DEFAULT NULL,
  `Anne_fin` int(4) DEFAULT NULL,
  `ID_Ecole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`ID_Classe`),
  ADD KEY `ID_Promotion` (`ID_Promotion`);

--
-- Index pour la table `competence`
--
ALTER TABLE `competence`
  ADD PRIMARY KEY (`ID_Competence`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`ID_Compte`),
  ADD KEY `ID_Ecole` (`ID_Ecole`);

--
-- Index pour la table `compte_competence`
--
ALTER TABLE `compte_competence`
  ADD PRIMARY KEY (`ID_compte_competence`),
  ADD KEY `ID_Compte` (`ID_Compte`),
  ADD KEY `ID_Competence` (`ID_Competence`);

--
-- Index pour la table `compte_matiere`
--
ALTER TABLE `compte_matiere`
  ADD PRIMARY KEY (`ID_compte_matiere`),
  ADD KEY `ID_Compte` (`ID_Compte`),
  ADD KEY `ID_Matiere` (`ID_Matiere`);

--
-- Index pour la table `ecole`
--
ALTER TABLE `ecole`
  ADD PRIMARY KEY (`ID_Ecole`);

--
-- Index pour la table `ecole_filiere`
--
ALTER TABLE `ecole_filiere`
  ADD PRIMARY KEY (`ID_ecole_filiere`),
  ADD KEY `ID_Ecole` (`ID_Ecole`),
  ADD KEY `ID_Filiere` (`ID_Filiere`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`ID_Filiere`);

--
-- Index pour la table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`ID_Matiere`);

--
-- Index pour la table `matiere_competence`
--
ALTER TABLE `matiere_competence`
  ADD PRIMARY KEY (`ID_matiere_competence`),
  ADD KEY `ID_Matiere` (`ID_Matiere`),
  ADD KEY `ID_Competence` (`ID_Competence`);

--
-- Index pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`ID_Promotion`),
  ADD KEY `ID_Ecole` (`ID_Ecole`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `ID_Classe` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `competence`
--
ALTER TABLE `competence`
  MODIFY `ID_Competence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `ID_Compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `compte_competence`
--
ALTER TABLE `compte_competence`
  MODIFY `ID_compte_competence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `compte_matiere`
--
ALTER TABLE `compte_matiere`
  MODIFY `ID_compte_matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `ecole`
--
ALTER TABLE `ecole`
  MODIFY `ID_Ecole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `ecole_filiere`
--
ALTER TABLE `ecole_filiere`
  MODIFY `ID_ecole_filiere` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `ID_Filiere` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `ID_Matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `matiere_competence`
--
ALTER TABLE `matiere_competence`
  MODIFY `ID_matiere_competence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `ID_Promotion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `classe`
--
ALTER TABLE `classe`
  ADD CONSTRAINT `classe_ibfk_1` FOREIGN KEY (`ID_Promotion`) REFERENCES `promotion` (`ID_Promotion`);

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `compte_ibfk_1` FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole` (`ID_Ecole`);

--
-- Contraintes pour la table `compte_competence`
--
ALTER TABLE `compte_competence`
  ADD CONSTRAINT `compte_competence_ibfk_1` FOREIGN KEY (`ID_Compte`) REFERENCES `compte` (`ID_Compte`),
  ADD CONSTRAINT `compte_competence_ibfk_2` FOREIGN KEY (`ID_Competence`) REFERENCES `competence` (`ID_Competence`);

--
-- Contraintes pour la table `compte_matiere`
--
ALTER TABLE `compte_matiere`
  ADD CONSTRAINT `compte_matiere_ibfk_1` FOREIGN KEY (`ID_Compte`) REFERENCES `compte` (`ID_Compte`),
  ADD CONSTRAINT `compte_matiere_ibfk_2` FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere` (`ID_Matiere`);

--
-- Contraintes pour la table `ecole_filiere`
--
ALTER TABLE `ecole_filiere`
  ADD CONSTRAINT `ecole_filiere_ibfk_1` FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole` (`ID_Ecole`),
  ADD CONSTRAINT `ecole_filiere_ibfk_2` FOREIGN KEY (`ID_Filiere`) REFERENCES `filiere` (`ID_Filiere`);

--
-- Contraintes pour la table `matiere_competence`
--
ALTER TABLE `matiere_competence`
  ADD CONSTRAINT `matiere_competence_ibfk_1` FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere` (`ID_Matiere`),
  ADD CONSTRAINT `matiere_competence_ibfk_2` FOREIGN KEY (`ID_Competence`) REFERENCES `competence` (`ID_Competence`);

--
-- Contraintes pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD CONSTRAINT `promotion_ibfk_1` FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole` (`ID_Ecole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

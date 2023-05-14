CREATE Database  IF NOT EXISTS Omnes_my_skills;

USE Omnes_my_skills;


CREATE TABLE  `ecole` (
    `ID_Ecole` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_Ecole` varchar(50) NOT NULL
);


CREATE TABLE  `promotion` (
    `ID_Promotion` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Annee_debut` int(4),
    `Anne_fin` int(4),
    `ID_Ecole` int(11) NOT NULL,
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`)
);


CREATE TABLE  `classe` (
  `ID_Classe` int(11) PRIMARY KEY AUTO_INCREMENT,
  `Num_groupe` int(3),
  `Nombre_etudiant` int(5),
  `ID_Promotion` int(11) NOT NULL,
  FOREIGN KEY (`ID_Promotion`) REFERENCES `promotion`(`ID_Promotion`)
);


CREATE TABLE  `compte` (
    `ID_Compte` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_Compte` varchar(50) NOT NULL,
    `Prenom` varchar(30) NOT NULL,
    `E_mail` varchar(50) NOT NULL,
    `MDP` varchar(30) NOT NULL,
    `Type_compte` varchar(30) NOT NULL,
    `Deja_connecte` boolean NOT NULL,
    `ID_Ecole` int(11) NOT NULL,
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`)
);


CREATE TABLE  `filiere` (
    `ID_Filiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_filiere` varchar(50) NOT NULL
);


CREATE TABLE  `matiere` (
    `ID_Matiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_Matiere` varchar(50) NOT NULL,
    `Volume_horaire` int(3)
);


CREATE TABLE  `competence` (
    `ID_Competence` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_Competence` varchar(30) NOT NULL,
    `Date_Creation` int(4) NOT NULL,
    `Theme` varchar(30)
);


CREATE TABLE  `ecole_filiere` (
    `ID_ecole_filiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Ecole` int(11) NOT NULL,
    `ID_Filiere` int(11) NOT NULL,
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`),
    FOREIGN KEY (`ID_Filiere`) REFERENCES `filiere`(`ID_Filiere`)
);


CREATE TABLE  `compte_matiere` (
    `ID_compte_matiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Compte` int(11) NOT NULL,
    `ID_Matiere` int(11) NOT NULL,
    FOREIGN KEY (`ID_Compte`) REFERENCES `compte`(`ID_Compte`),
    FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere`(`ID_Matiere`) 
);


CREATE TABLE  `matiere_competence` (
    `ID_matiere_competence` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Matiere` int(11) NOT NULL,
    `ID_Competence` int(11) NOT NULL,
    `Professeur` varchar(50) NOT NULL,
    FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere`(`ID_Matiere`),
    FOREIGN KEY (`ID_Competence`) REFERENCES `competence`(`ID_Competence`) 
);


CREATE TABLE  `compte_competence` (
    `ID_compte_competence` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Compte` int(11) NOT NULL,
    `ID_Competence` int(11) NOT NULL,
    FOREIGN KEY (`ID_Compte`) REFERENCES `compte`(`ID_Compte`),
    FOREIGN KEY (`ID_Competence`) REFERENCES `competence`(`ID_Competence`),
    `Moyenne_professeur` int(2),
    `Etat_competence`  varchar(30) NOT NULL,	
    `Competence_valide_etudiant`varchar(30),
    `Competence_valide_professeur`varchar(30),
    `Appreciation` varchar(100)
);



CREATE Database  IF NOT EXISTS Omnes_my_skills;

USE Omnes_my_skills;


CREATE TABLE  `ecole` (
    `ID_Ecole` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom` varchar(50) NOT NULL
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
    `Nom` varchar(50) NOT NULL,
    `Prenom` varchar(30) NOT NULL,
    `E_mail` varchar(50) NOT NULL,
    `MDP` varchar(30) NOT NULL,
    `Type_compte` varchar(30) NOT NULL,
    `Déjà_connecté` boolean NOT NULL,
    `ID_Ecole` int(11) NOT NULL,
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`)
);


CREATE TABLE  `filiere` (
    `ID_Filiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom` varchar(50) NOT NULL
);


CREATE TABLE  `matiere` (
    `ID_Matiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom` varchar(50) NOT NULL,
    `Volume_horaire` int(3) 
);


CREATE TABLE  `competence` (
    `ID_Competence` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom` varchar(30) NOT NULL,
    `Theme` varchar(30),
);


CREATE TABLE  `ecole/filiere` (
    `ID_ecole/filiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Ecole` int(11) NOT NULL,
    `ID_Filiere` int(11) NOT NULL,
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`),
    FOREIGN KEY (`ID_Filiere`) REFERENCES `filiere`(`ID_Filiere`)
);


CREATE TABLE  `compte/matiere` (
    `ID_compte/matiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Compte` int(11) NOT NULL,
    `ID_Matiere` int(11) NOT NULL,
    FOREIGN KEY (`ID_Compte`) REFERENCES `compte`(`ID_Compte`),
    FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere`(`ID_Matiere`) 
);


CREATE TABLE  `matiere/competence` (
    `ID_matiere/competence` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Matiere` int(11) NOT NULL,
    `ID_Competence` int(11) NOT NULL,
    FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere`(`ID_Matiere`),
    FOREIGN KEY (`ID_Competence`) REFERENCES `competence`(`ID_Competence`) 
);


CREATE TABLE  `compte/competence` (
    `ID_compte/competence` int(11) PRIMARY KEY AUTO_INCREMENT,
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



INSERT INTO `ecole` (`Nom`) VALUES ('Ecole 42');
/*INSERT INTO (`ecole`) VALUES ('GUGUGAGASCHOOL');*/

INSERT INTO `compte` (`ID_Compte`,`Nom`, `Prenom`, `E_mail`, `MDP`, `Type_compte`,`Déjà_connecté`, `ID_Ecole`) VALUES 
(1, 'Gogo', 'Gadget', 'gg@gmail.com', 'gg', 'etudiant', 1, 1),
(2, 'aa', 'aa', 'aa@gmail.com', 'aa', 'etudiant', 0, 1),
(3, 'bb', 'bb', 'bb@gmail.com', 'bb', 'admin', 1, 1),
(4, 'cc', 'cc', 'cc@gmail.com', 'gg', 'admin', 0, 1);

/*INSERT INTO `compte/competence` (`ID_compte/competence`, `ID_Compte`, `ID_Competence`, `Moyenne_professeur`, `Etat_competence`, `Competence_valide_etudiant`, `Competence_valide_professeur`, `Appreciation`) VALUES
(1, 1, 1,'', '', '', '', '', ''),
(2, 2, 2,'', '', '', '', '', ''),
(3, 3, 3,'', '', '', '', '', ''),
(4, 4, 4,'', '', '', '', '', ''),
(5, 5, 5,'', '', '', '', '', '');*/

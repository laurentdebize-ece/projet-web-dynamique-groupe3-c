CREATE Database  IF NOT EXISTS omnesmyskills;

USE omnesmyskills;


CREATE TABLE  `ecole` (
    `ID_Ecole` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_Ecole` varchar(50) NOT NULL
);

INSERT INTO `ecole` (`ID_Ecole`, `Nom_Ecole`) VALUES
(1, 'ECE'),
(2, 'ESCE'),
(3, 'ECAM'),
(4, 'INSA'),
(5, 'FAC'),
(6, 'ESME'),
(7, 'SUPAHERO'),
(8, 'NORMALSUP'),
(9, 'POLYTECH'),
(10, 'EPITA');



CREATE TABLE  `promotion` (
    `ID_Promotion` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Annee_debut` int(4),
    `Annee_fin` int(4),
    `ID_Ecole` int(11) NOT NULL,
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`)
);

INSERT INTO `promotion` (`ID_Promotion`, `Annee_debut`, `Annee_fin`,`ID_Ecole`) VALUES
(1, '2000','2005',1),
(2, '2001','2006',1),
(3, '2010','2015',2),
(4, '2000','2005',2),
(5, '2002','2007',3),
(6, '2003','2008',6),
(7, '2006','2009',5),
(8, '2020','2025',7),
(9, '2021','2026',8),
(10, '2050','2055',9),
(11, '2048','2053',4),
(12, '2017','2022',3),
(13, '2023','2028',10),

/*Promo des profs et des admins*/
(0,'1950','2050',1);





CREATE TABLE  `classe` (
  `ID_Classe` int(11) PRIMARY KEY AUTO_INCREMENT,
  `Num_groupe` int(3),
  `ID_Promotion` int(11) NOT NULL,
  FOREIGN KEY (`ID_Promotion`) REFERENCES `promotion`(`ID_Promotion`)
);

INSERT INTO `classe` (`ID_Classe`, `Num_groupe`, `ID_Promotion`) VALUES
(1, 1,  1),
(2, 2,  1),
(3, 3,  1),
(4, 1,  2),
(5, 2,  2),
(6, 3,  2),
(7, 1,  3),
(8, 2,  3),
(9, 1,  4),
(10, 1,  5),
(11, 1,  6),
(12, 1,  7),
(13, 1,  8),
(14, 1,  9),
(15, 1,  10),
(16, 1,  11),
(17, 1,  12),
(18, 1,  13),

(0,1,0);


CREATE TABLE  `compte` (
    `ID_Compte` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_Compte` varchar(50) NOT NULL,
    `Prenom` varchar(30) NOT NULL,
    `E_mail` varchar(50) NOT NULL,
    `MDP` varchar(30) NOT NULL,
    `Type_compte` varchar(30) NOT NULL,
    `Deja_connecte` boolean NOT NULL,
    `ID_Ecole` int(11) NOT NULL,
    `ID_Promotion` int(11) NOT NULL,	
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`),
    FOREIGN KEY (`ID_Promotion`) REFERENCES `promotion`(`ID_Promotion`),
    FOREIGN KEY (`ID_Classe`) REFERENCES `classe`(`ID_Classe`)
);

INSERT INTO `compte` (`ID_Compte`, `Nom_Compte`, `Prenom`, `E_mail`, `MDP`, `Type_compte`, `Deja_connecte`, `ID_Ecole`, `ID_Promotion`) VALUES
(1, 'VIRET', 'Pierre', 'pierreviret@gmail.com', '1111','Etudiant',1,1,1),
(2, 'MASSON', 'Charles', 'Charlesmasson@gmail.com', 'xpzcl421','Etudiant',1,1,1),
(3, 'BOJ', 'Lucas', 'Lucasboj@gmail.com', 'cpcnifz361q','Etudiant',1,1,2),
(4, 'RUAT', 'Noemie', 'NoemieRuat@gmail.com', '2882ssscsww','Etudiant',1,2,3),
(5, 'BATHEROSSE', 'Emma', 'EmmaBatherosse@gmail.com', '852wcdhus','Etudiant',1,2,3),
(6, 'CHAPERON', 'Axel', 'AxelChap@gmail.com', '72ccdid28z8','Etudiant',1,2,1),
(7, 'DEBIZE', 'Laurent', 'LaurentDebize@gmail.com', '1234','Professeur',1,1,0),
(8, 'BONFILS', 'Anne', 'AnneBonfils@gmail.com', 'daeb2252c','Professeur',1,1,0),
(9, 'DEDECKER', 'Samira', 'SamiraDedecker@gmail.com', 'zfqju451','Professeur',1,1,0),
(10, 'HINTZY', 'Antoine', 'AntoineLEHintzy@gmail.com', 'zkeenxsi581','Professeur',1,1,0),
(11, 'DIEU', 'LUKEH', 'ALED@gmail.com', '0000','Administrateur',1,1,0,0);



CREATE TABLE  `filiere` (
    `ID_Filiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_filiere` varchar(50) NOT NULL
);

INSERT INTO `filiere` (`ID_Filiere`, `Nom_filiere`) VALUES
(1, 'Economique'),
(2, 'Electronique'),
(3, 'Mecanique'),
(4, 'Biologique'),
(5, 'Chimique'),
(6, 'Physique'),
(7, 'Scientifique'),
(8, 'Geologique'),
(9, 'Geographique'),
(10, 'Historique'),
(11, 'Linguistique');




CREATE TABLE  `matiere` (
    `ID_Matiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_matiere` varchar(50) NOT NULL,
    `Volume_horaire` int(3)
);

INSERT INTO `matiere` (`ID_Matiere`, `Nom_matiere`, `Volume_horaire`) VALUES
(1, 'Mathematiques', 300),
(2, 'Physique', 250),
(3, 'Electronique', 300),
(4, 'Informatique', 500),
(5, 'Geographie', 2),
(6, 'Anglais', 30),
(7, 'Français', 30),
(8, 'Chimie', 2),
(9, 'Histoire', 10),
(10, 'Gestion', 50),
(11, 'Humanite', 5),
(12, 'SI', 30),
(13, 'Sport', 10);

CREATE TABLE  `competence` (
    `ID_Competence` int(11) PRIMARY KEY AUTO_INCREMENT,
    `Nom_competence` varchar(30) NOT NULL,
    `Date_Creation` date NOT NULL,
    `Theme` varchar(30)
);

INSERT INTO `competence` (`ID_Competence`, `Nom_competence`, `Date_Creation`, `Theme`) VALUES
(1, 'Matrices', '2018-01-01', 'Mathematiques'),
(2, 'Vecteurs', '2018-02-01', 'Physique'),
(3, 'PCB', '2018-03-01', 'Electronique'),
(4, 'Maitrise_C', '2019-07-01', 'Informatique'),
(5, 'Maitrise_C++', '2018-08-01', 'Informatique'),
(6, 'Key_Words', '2021-11-01', 'Anglais'),
(7, 'Compter', '2020-09-01', 'Gestion'),
(8, 'Diluer', '2017-05-01', 'Chimie'),
(9, 'Multiplier', '2018-04-01', 'Mathematiques'),
(10, 'Maxwell', '2018-12-01', 'Physique'),
(11, 'Alcolemie', '2003-10-17', 'BDE'),
(12, 'Dessins', '2018-11-01', 'SI'),
(13, 'Courrir', '2018-02-01', 'Sport');


CREATE TABLE  `ecole_filiere` (
    `ID_ecole_filiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Ecole` int(11) NOT NULL,
    `ID_Filiere` int(11) NOT NULL,
    FOREIGN KEY (`ID_Ecole`) REFERENCES `ecole`(`ID_Ecole`),
    FOREIGN KEY (`ID_Filiere`) REFERENCES `filiere`(`ID_Filiere`)
);

INSERT INTO `ecole_filiere` (`ID_ecole_filiere`,`ID_Ecole`,`ID_Filiere`) VALUES 
(1, 1,1),
(2, 1,2),
(3, 2,3),
(4, 2,4),
(5, 3,5);



CREATE TABLE  `compte_matiere` (
    `ID_compte_matiere` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Compte` int(11) NOT NULL,
    `ID_Matiere` int(11) NOT NULL,
    FOREIGN KEY (`ID_Compte`) REFERENCES `compte`(`ID_Compte`),
    FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere`(`ID_Matiere`) 
);

INSERT INTO `compte_matiere` (`ID_compte_matiere`, `ID_Compte`, `ID_Matiere`) VALUES
(1,1,1),
(2,1,2),
(3,1,3),
(4,1,4),
(5,2,4),
(6,2,5),
(7,2,6),
(8,3,1),
(9,3,13),
(10,5,9),
(11,6,11),
(12,6,12),
(13,6,3),

(14,7,4),
(15,8,1),
(16,9,2),
(17,10,4);


CREATE TABLE `compte_classe` (
    `ID_compte_classe` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Compte` int(11) NOT NULL,
    `ID_Classe` int(11) NOT NULL,
    FOREIGN KEY (`ID_Compte`) REFERENCES `compte`(`ID_Compte`),
    FOREIGN KEY (`ID_Classe`) REFERENCES `classe`(`ID_Classe`) 
);	


INSERT INTO `compte_classe` (`ID_compte_classe`, `ID_Compte`, `ID_Classe`) VALUES 
(1,1,3),
(2,2,3),
(3,3,5),
(4,4,8),
(5,5,7),
(6,6,1),
(7,7,3),
(8,8,3),
(9,9,2),
(10,10,3),
(11,11,0);


CREATE TABLE  `matiere_competence` (
    `ID_matiere_competence` int(11) PRIMARY KEY AUTO_INCREMENT,
    `ID_Matiere` int(11) NOT NULL,
    `ID_Competence` int(11) NOT NULL,
    `Professeur` varchar(50) NOT NULL,
    FOREIGN KEY (`ID_Matiere`) REFERENCES `matiere`(`ID_Matiere`),
    FOREIGN KEY (`ID_Competence`) REFERENCES `competence`(`ID_Competence`) 
);


INSERT INTO `matiere_competence` (`ID_matiere_competence`, `ID_Matiere`, `ID_Competence`, `Professeur`) VALUES
(1, 4, 4, 'HINTZY'),
(2, 4, 5, 'DEBIZE'),
(3, 1, 3, 'BONFILS'),
(4, 2, 2, 'DEDECKER'),
(5, 1, 1, 'BONFILS'),
(6, 1, 9, 'BONFILS');



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

INSERT INTO `compte_competence` (`ID_compte_competence`, `ID_Compte`, `ID_Competence`, `Moyenne_professeur`, `Etat_competence`, `Competence_valide_etudiant`, 
`Competence_valide_professeur`, `Appreciation`) VALUES

(1, 1, 1, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(2, 1, 2, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(3, 1, 3, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(4, 2, 4, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(5, 2, 5, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(6, 2, 6, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(7, 3, 7, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(8, 3, 1, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(9, 3, 13, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(10, 4, 1, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(11, 4, 2, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(12, 4, 12, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(13, 5, 3, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(14, 5, 4, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(15, 6, 1, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(16, 6, 2, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune'),
(17, 6, 4, null, 'NonEva', 'NonEva', 'NonEva', 'Aucune');
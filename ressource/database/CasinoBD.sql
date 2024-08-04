DROP TABLE IF EXISTS Jouer;
DROP TABLE IF EXISTS Jeux;
DROP TABLE IF EXISTS DatesHoraires;
/*DROP TABLE IF EXISTS AdministrateursCasino;*/
/*DROP TABLE IF EXISTS UtilisateursCasino;*/

-- Table UtilisateursCasino
CREATE TABLE UtilisateursCasino (
pseudoUtilisateurCasino varchar(255),
nomUtilisateurCasino varchar(255),
prenomUtilisateurCasino varchar(255),
email varchar(255),
motDePasse varchar(255),
credit float,
age int,
nomRole varchar(255),
PRIMARY KEY(pseudoUtilisateurCasino)
);

-- Table Roles
CREATE TABLE Roles (
nomRole varchar(255),
descriptionRole text,
PRIMARY KEY (nomRole)
);

-- Table DatesHoraires
CREATE TABLE DatesHoraires (
idDate datetime,
PRIMARY KEY (idDate)
);

-- Table Jeux
CREATE TABLE Jeux (
idJeu int PRIMARY KEY AUTO_INCREMENT,
nomJeu varchar(255)
);

-- Table Jouer
CREATE TABLE Jouer (
pseudoUtilisateurCasino varchar(255),
idJeu int,
idDate datetime,
miseEffectuer float,
gainObtenu float,
PRIMARY KEY(pseudoUtilisateurCasino,idJeu, idDate),
FOREIGN KEY(pseudoUtilisateurCasino) REFERENCES UtilisateursCasino(pseudoUtilisateurCasino) on delete cascade,
FOREIGN KEY(idJeu) REFERENCES Jeux(idJeu) on delete cascade,
FOREIGN KEY(idDate) REFERENCES DatesHoraires(idDate) on delete cascade
);

INSERT INTO Roles (nomRole, descriptionRole)
VALUES ('Admin', 'Administrateur avec tous les droits sur le site'),
       ('Membre', 'Utilisateur standard avec des droits limités'),
       ('Modérateur', 'Utilisateur avec des droits d édition et de modération');

CREATE OR REPLACE VIEW VueJouerAvecCredit AS
SELECT
    j.pseudoUtilisateurCasino,
    j.idJeu,
    j.idDate,
    j.miseEffectuer,
    j.gainObtenu,
    jo.credit
From Jouer j
         JOIN UtilisateursCasino jo on jo.pseudoUtilisateurCasino = j.pseudoUtilisateurCasino;

DELIMITER //
-- '2023-01-01 12:00:00' pour la date
-- Pour l'instant l'utilisateur et
CREATE PROCEDURE InsererPartie(
    p_pseudoUtilisateurCasino VARCHAR(255),
    p_idJeu INT,
    p_idDate DATETIME,
    p_miseEffectuer FLOAT,
    p_gainObtenu FLOAT,
    p_credit FLOAT
)
BEGIN
IF NOT EXISTS (SELECT * FROM DatesHoraires WHERE idDate = p_idDate) THEN
    INSERT INTO DatesHoraires (idDate)
    VALUES (p_idDate);
END IF;

INSERT INTO Jouer (pseudoUtilisateurCasino, idJeu, idDate, miseEffectuer, gainObtenu)
VALUES (p_pseudoUtilisateurCasino, p_idJeu, p_idDate, p_miseEffectuer, p_gainObtenu);

UPDATE UtilisateursCasino
SET credit = p_credit + p_gainObtenu - p_miseEffectuer
WHERE pseudoUtilisateurCasino = p_pseudoUtilisateurCasino;
END //

DELIMITER ;



/*
Create or replace Trigger tr_br_ins_Joueur_Casino
Before Insert on UtilisateursCasino
For each row
Declare

nb_Administrateur number;

Begin

Select count(*) into nb_Administrateur
From AdministrateursCasino
where idAdministrateurCasino = :New.idUtilisateurCasino;

if nb_Administrateur != 0 then
    RAISE_APPLICATION_ERROR(-20001, 'Il existe déjà un administrateur ' || :New.idUtilisateurCasino);
End if;

END;
*/

/*
Create or replace Trigger tr_br_ins_Administrateur_Casino
Before Insert on AdministrateursCasino
For each row
Declare

nb_Joueur number;

Begin

Select count(*) into nb_Joueur
From UtilisateursCasino
where idUtilisateurCasino = :New.idUtilisateurCasino;

if nb_Joueur != 0 then
    RAISE_APPLICATION_ERROR(-20001, 'Il existe déjà un joueur ' || :New.idUtilisateurCasino);
End if;

END;
*/
CREATE TABLE Utilisateur(
   id_utilisateur INT AUTO_INCREMENT,
   email VARCHAR(50)  NOT NULL,
   mot_de_passe VARCHAR(50)  NOT NULL,
   nom VARCHAR(50)  NOT NULL,
   prenom VARCHAR(50)  NOT NULL,
   type_profil VARCHAR(50)  NOT NULL,
   vitesse_marche DECIMAL(15,2)   NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE Lieu(
   id_lieu INT AUTO_INCREMENT,
   coordonnees_gps VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id_lieu)
);

CREATE TABLE Jours(
   id_jours VARCHAR(50) ,
   heure_ouverture TIME,
   heure_fermeture TIME,
   PRIMARY KEY(id_jours)
);

CREATE TABLE Visite(
   id_visite INT AUTO_INCREMENT,
   date_ DATE,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_visite),
   FOREIGN KEY(id_utilisateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE Spectacle(
   id_spectacle INT AUTO_INCREMENT,
   libelle VARCHAR(50)  NOT NULL,
   duree_spectacle TIME NOT NULL,
   duree_attente TIME NOT NULL,
   id_lieu INT NOT NULL,
   PRIMARY KEY(id_spectacle),
   FOREIGN KEY(id_lieu) REFERENCES Lieu(id_lieu)
);

CREATE TABLE Seance(
   id_seance INT AUTO_INCREMENT,
   heure_debut TIME,
   heure_fin TIME,
   id_spectacle INT NOT NULL,
   PRIMARY KEY(id_seance),
   FOREIGN KEY(id_spectacle) REFERENCES Spectacle(id_spectacle)
);

CREATE TABLE Parcours(
   id_visite INT,
   id_parcours INT AUTO_INCREMENT,
   duree TIME,
   PRIMARY KEY(id_visite, id_parcours),
   FOREIGN KEY(id_visite) REFERENCES Visite(id_visite)
);

CREATE TABLE Etape(
   id_etape INT AUTO_INCREMENT,
   id_visite INT NOT NULL,
   id_parcours INT NOT NULL,
   id_seance INT NOT NULL,
   PRIMARY KEY(id_etape),
   FOREIGN KEY(id_visite, id_parcours) REFERENCES Parcours(id_visite, id_parcours),
   FOREIGN KEY(id_seance) REFERENCES Seance(id_seance)
);

CREATE TABLE choisir(
   id_spectacle INT,
   id_visite INT,
   PRIMARY KEY(id_spectacle, id_visite),
   FOREIGN KEY(id_spectacle) REFERENCES Spectacle(id_spectacle),
   FOREIGN KEY(id_visite) REFERENCES Visite(id_visite)
);

CREATE TABLE distance(
   id_lieu INT,
   id_lieu_1 INT,
   PRIMARY KEY(id_lieu, id_lieu_1),
   FOREIGN KEY(id_lieu) REFERENCES Lieu(id_lieu),
   FOREIGN KEY(id_lieu_1) REFERENCES Lieu(id_lieu)
);

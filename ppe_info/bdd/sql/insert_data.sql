INSERT INTO Utilisateur (email, mot_de_passe, nom, prenom, type_profil, vitesse_marche) VALUES
('admin@puydufou.com', 'admin123', 'Dupont', 'Pierre', 'admin', 4.5),
('user1@gmail.com', 'user123', 'Martin', 'Sophie', 'user', 3.8),
('user2@hotmail.com', 'user456', 'Bernard', 'Luc', 'user', 4.2);

INSERT INTO Lieu (coordonnees_gps) VALUES
('46.4563, -0.4567'),
('46.4578, -0.4552'),
('46.4589, -0.4531'),
('46.4595, -0.4518'),
('46.4602, -0.4497');

INSERT INTO Jours (id_jours, heure_ouverture, heure_fermeture) VALUES
('Lundi', '09:00:00', '18:00:00'),
('Mardi', '09:00:00', '18:00:00'),
('Mercredi', '09:00:00', '18:00:00'),
('Jeudi', '09:00:00', '18:00:00'),
('Vendredi', '09:00:00', '18:00:00'),
('Samedi', '09:00:00', '19:00:00'),
('Dimanche', '09:00:00', '19:00:00');

INSERT INTO Spectacle (libelle, duree_spectacle, duree_attente, id_lieu) VALUES
('Le Signe du Triomphe', '00:45:00', '00:30:00', 1),
('Les Vikings', '00:35:00', '00:25:00', 2),
('Le Secret de la Lance', '00:40:00', '00:20:00', 3),
('Mousquetaire de Richelieu', '00:50:00', '00:35:00', 4),
('Les Noces de Feu', '00:25:00', '00:15:00', 5);

INSERT INTO Visite (date_, id_utilisateur) VALUES
('2024-06-15', 2),
('2024-06-16', 3);

INSERT INTO Seance (heure_debut, heure_fin, id_spectacle) VALUES
('10:30:00', '11:15:00', 1),
('11:45:00', '12:20:00', 2),
('13:00:00', '13:40:00', 3),
('14:30:00', '15:20:00', 4),
('16:00:00', '16:25:00', 5),
('15:00:00', '15:45:00', 1),
('16:30:00', '17:05:00', 2);

INSERT INTO Parcours (duree, id_visite) VALUES
('04:30:00', 1),
('05:15:00', 2);

INSERT INTO Etape (id_parcours, id_seance) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(2, 6);

INSERT INTO choisir (id_spectacle, id_visite) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 2),
(5, 2),
(1, 2);

INSERT INTO distance (id_lieu, id_lieu_1) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 3),
(2, 4),
(2, 5),
(3, 4),
(3, 5),
(4, 5);
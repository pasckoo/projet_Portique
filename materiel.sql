
CREATE TABLE materiel(
   Id_materiel INT AUTO_INCREMENT,
   rep_materiel VARCHAR(50) NOT NULL,
   designation_materiel VARCHAR(100),
   reference_materiel VARCHAR(50),
   Date_mes_materiel DATE,
   commentaire_materiel VARCHAR(255),
   photo_materiel VARCHAR(100),
   id_secteur INT NOT NULL,
   id_modele INT NOT NULL,
   id_famille INT NOT NULL,
   PRIMARY KEY(Id_materiel),
   UNIQUE(rep_materiel),
   FOREIGN KEY(id_secteur) REFERENCES secteur(id_secteur),
   FOREIGN KEY(id_modele) REFERENCES modele(id_modele),
   FOREIGN KEY(id_famille) REFERENCES famille(id_famille)
);

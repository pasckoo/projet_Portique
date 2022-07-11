CREATE TABLE modele(
   id_modele INT AUTO_INCREMENT,
   type_modele VARCHAR(50),
   designation_modele VARCHAR(255),
   id_famille INT NOT NULL,
   PRIMARY KEY(id_modele),
   UNIQUE(type_modele),
   FOREIGN KEY(id_famille) REFERENCES famille(id_famille)
);

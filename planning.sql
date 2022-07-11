CREATE TABLE planning(
   id_modele INT,
   id_perio INT,
   PRIMARY KEY(id_modele, id_perio),
   FOREIGN KEY(id_modele) REFERENCES modele(id_modele),
   FOREIGN KEY(id_perio) REFERENCES perio(id_perio)
);


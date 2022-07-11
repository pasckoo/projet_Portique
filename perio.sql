CREATE TABLE perio(
   id_perio INT AUTO_INCREMENT,
   intitule_perio VARCHAR(50) NOT NULL,
   type_perio VARCHAR(50) NOT NULL,
   nb_perio INT NOT NULL,
   commentaire_perio VARCHAR(255),
   PRIMARY KEY(id_perio),
   UNIQUE(intitule_perio)
);

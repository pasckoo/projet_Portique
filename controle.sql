CREATE TABLE controle(
   id_controle INT AUTO_INCREMENT,
   date_controle DATETIME,
   comment_controle VARCHAR(255),
   id_perio INT NOT NULL,
   id_user INT NOT NULL,
   Id_materiel INT NOT NULL,
   PRIMARY KEY(id_controle),
   FOREIGN KEY(id_perio) REFERENCES perio(id_perio),
   FOREIGN KEY(id_user) REFERENCES utilisateur(id_user),
   FOREIGN KEY(Id_materiel) REFERENCES materiel(Id_materiel)
);


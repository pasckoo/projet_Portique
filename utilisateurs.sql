CREATE TABLE user(
   id_user INT AUTO_INCREMENT,
   nom_user VARCHAR(50),
   prenom_user VARCHAR(50),
   login_user VARCHAR(50) NOT NULL,
   mdp_user VARCHAR(255),
   fonction_user VARCHAR(50),
   date_crea_user DATE,
   type_user VARCHAR(50),
   PRIMARY KEY(id_user),
   UNIQUE(login_user)
);

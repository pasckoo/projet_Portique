SELECT
        CASE
            WHEN perio.type_perio="jour" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  DAY ) 
            WHEN perio.type_perio="semaine" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  WEEK ) 
            WHEN perio.type_perio="mois" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  MONTH )       
            WHEN perio.type_perio="annee" THEN ADDDATE(controle.date_controle, INTERVAL perio.nb_perio  YEAR ) 
            END AS prochain_controle,
        materiel.rep_materiel,
        famille.categorie_famille,
        modele.type_modele,
        perio.intitule_perio
        
    FROM controle, materiel, user, perio, famille, modele
    WHERE
        controle.id_materiel = materiel.id_materiel
    AND  controle.id_user = user.id_user
    AND  controle.id_perio = perio.id_perio
    AND famille.id_famille = materiel.id_famille
    AND modele.id_modele = materiel.id_modele

UNION    

SELECT DISTINCT 
    CASE
            WHEN perio.type_perio="jour" THEN ADDDATE(materiel.date_mes_materiel, INTERVAL perio.nb_perio  DAY ) 
            WHEN perio.type_perio="semaine" THEN ADDDATE(materiel.date_mes_materiel, INTERVAL perio.nb_perio  WEEK ) 
            WHEN perio.type_perio="mois" THEN ADDDATE(materiel.date_mes_materiel, INTERVAL perio.nb_perio  MONTH )       
            WHEN perio.type_perio="annee" THEN ADDDATE(materiel.date_mes_materiel, INTERVAL perio.nb_perio  YEAR ) 
            END AS prochaine_controle,
 rep_materiel,
 categorie_famille,
 modele.type_modele,
 perio.intitule_perio
FROM materiel, planning, modele, perio, famille
WHERE id_materiel NOT  IN(
    SELECT id_materiel
    FROM controle
)
AND planning.id_perio = perio.id_perio
AND planning.id_modele IN(
    SELECT id_modele
    FROM modele
    WHERE id_modele = materiel.id_modele
)
AND modele.id_modele = materiel.id_modele
AND famille.id_famille = materiel.id_famille

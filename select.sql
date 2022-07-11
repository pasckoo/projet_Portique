SELECT
    famille.categorie_famille,
    materiel.rep_materiel
FROM materiel, famille
WHERE famille.id_famille = materiel.id_famille
ORDER BY materiel.id_famille ASC, materiel.rep_materiel ASC

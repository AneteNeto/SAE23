
/*QUERY HISTORIQUE*/
SELECT E.Nom,E.Prenom,R.Ville,M.Description,M.Temperature,
M.VentVitesse,M.Icone,M.Date 
FROM Mesure AS M 
JOIN Residence AS R 
ON M.IdR=R.IdR 
JOIN Etudiant AS E 
ON R.IdR IN(E.VilleDomicileP,E.VilleDomicileS)
WHERE (E.Nom="IDIRI" OR E.Prenom="Anas");

/*QUERY INFORMATION JOUR*/
SELECT E.Nom,E.Prenom,R.Ville,M.Description,M.Temperature,
M.VentVitesse,M.Icone,M.Date 
FROM Mesure AS M 
JOIN Residence AS R 
ON M.IdR=R.IdR 
JOIN Etudiant AS E 
ON R.IdR IN(E.VilleDomicileP,E.VilleDomicileS)
WHERE (E.Nom="IDIRI" OR E.Prenom="Anas")
AND DATE(M.Date)=CURRENT_DATE;

/*QUERY AVERAGE GROUPE*/

SELECT AVG(M.Temperature) AS M_Temp, AVG(M.VentVitesse) AS M_Vent
FROM Mesure AS M 
JOIN Residence AS R 
ON M.IdR=R.IdR 
JOIN Etudiant AS E 
ON R.IdR IN(E.VilleDomicileP,E.VilleDomicileS)
WHERE E.groupe="LK1"

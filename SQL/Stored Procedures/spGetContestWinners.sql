DELIMITER // 

CREATE PROCEDURE spGetContestWinners()

BEGIN
create TEMPORARY table tblwinners(nKey int,szImagePath varchar(50),szAccountName varchar(50), dtCreated datetime, FinalRating int );

insert into tblwinners SELECT 
    	r.nKey,              
    	r.szImagePath,
    	l.szAccountName,
        r.dtCreated,
    	SUM(c.nRating) AS FinalRating
	FROM tblcontestratings c
	JOIN tblcontestimage r ON r.nKey = c.nContestImageKey
	JOIN tbllogin l ON l.nKey = r.nLoginKey
    group by r.nKey, YEAR(r.dtCreated), MONTH(r.dtCreated);
    
select nKey,
    szImagePath,
    szAccountName,
    dtCreated,
    YEAR(dtCreated) as year,
    MONTH(dtCreated) as month,
    FinalRating
FROM 
    tblwinners w
WHERE 
    FinalRating = (
        SELECT MAX(FinalRating)
        FROM tblwinners w2
        WHERE YEAR(w2.dtCreated) = year(w.dtCreated)
          AND MONTH(w2.dtCreated) = month(w.dtCreated)
    )
ORDER BY 
    dtCreated;
END //

DELIMITER ;

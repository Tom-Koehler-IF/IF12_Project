DELIMITER //

create PROCEDURE spGetContestImagesToRate(IN UserKey int)
BEGIN 

select c.nKey,
       c.szImagePath,
       l.szAccountName,
       c.dtCreated,
       r.nRating
from tblcontestimage c 
join tbllogin l on l.nKey=c.nLoginKey
left join tblcontestratings r on r.nContestImageKey = c.nKey and r.nLoginKey = UserKey
where c.bCanBeRated <> 0;

END //

DELIMITER ;

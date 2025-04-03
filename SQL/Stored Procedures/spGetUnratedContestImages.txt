DELIMITER //

create PROCEDURE spGetUnratedContestImages(IN UserKey int)
BEGIN 

select c.nKey as nKey,
	   c.szImagePath,
       l.szAccountName,
       c.dtCreated
from tblcontestimage c 
join tbllogin l on l.nKey=c.nLoginKey
where l.nKey = UserKey and c.bCanBeRated <> 0 ;

END //

DELIMITER ;
DELIMITER //

CREATE PROCEDURE spGetUnconfirmedContestImages()
BEGIN
  SELECT i.nKey,
         i.szImagePath,
         l.szAccountName,
         i.dtCreated
  FROM tbllogin l 
  JOIN tblcontestimage i 
  ON i.nLoginKey = l.nKey 
  WHERE i.bCanBeRated IS NULL;
END //

DELIMITER ;
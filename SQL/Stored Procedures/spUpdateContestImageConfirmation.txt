DELIMITER //

CREATE PROCEDURE spUpdateContestImageConfirmation(IN nKey INT, IN Value INT)
BEGIN
  UPDATE tblcontestimage
  SET bCanBeRated = Value
  WHERE nKey = nKey;
END //

DELIMITER ;
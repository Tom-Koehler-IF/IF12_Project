DELIMITER //

-- spCreateNewContestImage

CREATE PROCEDURE spCreateNewContestImage(IN nLoginKey INT, IN szPfad CHAR(100))
BEGIN
  INSERT INTO tblcontestimage (nLoginKey, szImagePath, dtCreated) 
  VALUES (nLoginKey, szPfad, NOW());
END //

DELIMITER ;
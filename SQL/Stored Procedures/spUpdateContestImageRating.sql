DELIMITER //

CREATE PROCEDURE spUpdateContestImageRating(IN nUserKey INT, IN nImageKey INT, IN nMyRating INT)
BEGIN
  IF EXISTS (SELECT 1 FROM tblcontestratings c WHERE c.nLoginKey = nUserKey AND c.nContestImageKey = nImageKey) THEN
    UPDATE tblcontestratings
    SET nRating = nMyRating
    WHERE nLoginKey = nUserKey AND nContestImageKey = nImageKey;
  ELSE
    INSERT INTO tblcontestratings (nContestImageKey, nLoginKey, nRating)
    VALUES (nImageKey, nUserKey, nMyRating);
  END IF;
END //

DELIMITER ;
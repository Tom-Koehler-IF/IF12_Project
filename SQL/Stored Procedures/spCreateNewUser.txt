DELIMITER //

CREATE PROCEDURE spCreateNewUser(
    IN szAccountName CHAR(20),
    IN szAccountPassword CHAR(64),
    IN bIsAdmin tinyint (1)
)
BEGIN
       
    INSERT INTO tbllogin (szAccountName, szLoginPassword, bIsAdmin)
    VALUES (szAccountName, szAccountPassword, bIsAdmin); 
END //

DELIMITER ;

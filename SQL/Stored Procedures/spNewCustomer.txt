DELIMITER //

CREATE PROCEDURE spNewCustomer(
   IN FirstName CHAR(50),
   IN LastName CHAR(50),
   IN Street CHAR(50),
   IN StreetNumber CHAR(10),
   IN PostalCode CHAR(5),
   IN szCity CHAR(50),
   IN AccountName CHAR(50),
   IN LoginPassword CHAR(64),
   OUT Error TINYINT(1),
   OUT Customer INT
)
BEGIN 
    DECLARE LoginKey INT;

    if AccountName is not null
    then
        -- new user as not Admin
        CALL spCreateNewUser(AccountName, LoginPassword, 0);    

        SET LoginKey = (SELECT l.nKey FROM tbllogin l WHERE l.szAccountName = AccountName);
    end if;

    INSERT INTO tblcustomer (szFirstName, szLastName, szStreet, szStreetNumber, szPostalCode, szCity, nLoginKey) 
    VALUES (FirstName, LastName, Street, StreetNumber, PostalCode, szCity, LoginKey);

    SET Error = 0; -- Set Error to 0 to indicate success
    SET Customer = LAST_INSERT_ID();
END //

DELIMITER ;
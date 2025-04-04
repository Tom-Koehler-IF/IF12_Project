DELIMITER //

CREATE PROCEDURE spLoginUser(
    IN AccountName CHAR(20),
    IN AccountPassword CHAR(64)
)
BEGIN
    SELECT l.nKey as nUserKey,
           c.nKey as nCustomerKey,
           c.szFirstName,
           c.szLastName,
           c.szStreet,
           c.szStreetNumber,
           c.szCity,
           c.szPostalCode,
           l.szAccountName,
           l.bIsAdmin
    FROM tbllogin l
    JOIN tblcustomer c ON c.nLoginKey = l.nKey
    WHERE l.szAccountName = AccountName AND l.szLoginPassword = AccountPassword;
END //

DELIMITER ;
DELIMITER //

drop procedure spLoginUser//

CREATE PROCEDURE spLoginUser(
    IN AccountName CHAR(20),
    IN AccountPassword CHAR(64)
)
BEGIN
select l.nKey as nUserKey, l.szAccountName, l.bIsAdmin, c.szFirstName, c.szLastName, c.szStreet, c.szStreetNumber, c.szPostalCode, c.szCity
from tblLogin l
join tblCustomer c on c.nLoginKey = l.nKey
where l.szAccountName = AccountName
and l.szLoginPassword = AccountPassword;
END//
DELIMITER ;
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
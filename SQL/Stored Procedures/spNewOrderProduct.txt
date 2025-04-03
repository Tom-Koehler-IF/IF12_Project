DELIMITER ;

DELIMITER $$
CREATE  PROCEDURE spNewOrderProduct(IN nOrderID INT, IN nProductID INT, IN nQuantity INT)
BEGIN 

insert into tblorder_product(nOrderKey, nProductKey, nQuantity) VALUES (nOrderID, nProductID,nQuantity );

END$$
DELIMITER ;
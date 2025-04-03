DELIMITER //

-- spNewOrder

CREATE PROCEDURE spNewOrder (IN nCustomerID INT, OUT nOrderID INT)
BEGIN
    INSERT INTO tblOrder (nCustomerID, dtTime) VALUES (nCustomerID, NOW());   
    SET nOrderID = LAST_INSERT_ID();
END //

DELIMITER ;
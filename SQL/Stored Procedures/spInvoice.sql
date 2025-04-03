DELIMITER // 

CREATE PROCEDURE spInvoice(IN nOrderKey int)

BEGIN 

-- Datetime

select o.dtTime 
from tblorder o 
where o.nKey = nOrderKey; 

-- Customer 

SELECT c.* from tblorder o 
join tblcustomer c on c.nKey=o.nCustomerKey
where o.nKey=nOrderKey;

-- Order
SELECT p.szName as Name,
	   op.nQuantity as Quantity,
       op.dOldPrice as Price,
       op.nQuantity*op.dOldPrice as Gesamt   
       from tblorder o 
join tblorder_product op on o.nKey=op.nOrderKey
join tblproduct p on p.nKey=op.nProductKey
where o.nKey=nOrderKey;

-- Total price
SELECT 
       sum(op.dOldPrice* op.nQuantity) * 0.93 as Netto,
       sum(op.dOldPrice* op.nQuantity) * 0.07 as MwS,
       sum(op.dOldPrice* op.nQuantity) as Brutto
       from tblorder o 
join tblorder_product op on o.nKey=op.nOrderKey
join tblproduct p on p.nKey=op.nProductKey
where o.nKey=nOrderKey;

END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE spGetAllProducts(IN nCustomerKey int)
BEGIN
select * from tblproduct_category;
select * from tblproduct;
SELECT * from tblingredient;
select * from tblproduct_ingredient;
select * from tblmenu_product;

select 
	p.nKey,
	p.szName,
	SUM(op.nQuantity) as nQuantity
    from tblcustomer c
    join tblorder o on c.nKey=o.nCustomerKey
    join tblorder_product op on op.nOrderKey=o.nKey
    join tblproduct p on p.nKey = op.nProductKey
    where c.nKey = nCustomerKey
    GROUP BY p.nKey, p.szName, op.nProductKey 
    order by nQuantity desc
    ;


  END//

DELIMITER ;

ELIMITER //

drop procedure spGetAdminReport//

create procedure spGetAdminReport(
    IN dtFrom DATE,
    IN dtTill DATE
)
begin
set dtTill = DATE_ADD(dtTill, INTERVAL 1 DAY);

-- Erstes resultset für generelle informationen
select
        COUNT(distinct O.nKey) as nOrderCount
    ,   SUM(OP.dOldPrice * OP.nQuantity) as dTotalRevenue
    ,   SUM(OP.dOldPrice * OP.nQuantity) / NULLIF(COUNT(distinct O.nKey), 0) as dAvgOrderPrice
    ,   SUM(OP.nQuantity) as nItemsSold
from tblorder O
join tblorder_product OP on OP.nOrderKey = O.nKey
where O.dtTime between dtFrom and dtTill;

-- Zweites resultset für tägliche informationen
select
        DATE(O.dtTime) as dtDay
    ,   COUNT(distinct O.nKey) as nOrderCount
    ,   SUM(OP.dOldPrice * OP.nQuantity) as dTotalRevenue
    ,   SUM(OP.dOldPrice * OP.nQuantity) / NULLIF(COUNT(distinct O.nKey), 0) as dAvgOrderPrice
    ,   SUM(OP.nQuantity) as nItemsSold
from tblorder O
join tblorder_product OP on OP.nOrderKey = O.nKey
where O.dtTime between dtFrom and dtTill
group by DATE(O.dtTime);

-- Drittes resultset für top 5 produkte
select
        P.szName as szName
    ,   SUM(OP.nQuantity) as nTotalQuantity
    ,   SUM(OP.nQuantity * OP.dOldPrice) as dTotalRevenue
    ,   (SUM(OP.nQuantity * OP.dOldPrice) / SUM(SUM(OP.nQuantity * OP.dOldPrice)) OVER ()) * 100 as dTotalPercentage
from tblorder O
join tblorder_product OP on OP.nOrderKey = O.nKey
join tblproduct P on P.nKey = OP.nProductKey
where O.dtTime between dtFrom and dtTill
group by P.nKey, P.szName
order by dTotalRevenue desc
limit 5;

-- Viertes resultset für top 5 kategorien
select
        P.szName as szName
    ,   SUM(OP.nQuantity) as nTotalQuantity
    ,   SUM(OP.nQuantity * OP.dOldPrice) as dTotalRevenue
    ,   (SUM(OP.nQuantity * OP.dOldPrice) / SUM(SUM(OP.nQuantity * OP.dOldPrice)) OVER ()) * 100 as dTotalPercentage
from tblorder O
join tblorder_product OP on OP.nOrderKey = O.nKey
join tblproduct P on P.nKey = OP.nProductKey
join tblproduct_category C on C.nKey = P.nProduct_CategoryKey
where O.dtTime between dtFrom and dtTill
group by C.nKey, C.szName
order by dTotalRevenue desc
limit 5;

end
//

DELIMITER ;

DROP DATABASE IF EXISTS project;

create DATABASE project;

use project;

CREATE TABLE tblLogin (
    nKey INT AUTO_INCREMENT PRIMARY KEY,
    szAccountName CHAR(50) UNIQUE,
    szLoginPassword CHAR(64),
    bIsAdmin TINYINT(1)
);

CREATE TABLE tblContestImage (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    nLoginKey int NOT NULL,
    szImagePath CHAR(200),
    bCanBeRated tinyint(1),
    dtCreated DATETIME,
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey)
    );
    
CREATE TABLE tblContestRatings (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    nLoginKey int NOT NULL,
    nContestImageKey int NOT NULL,
    nRating int check(nRating between 1 and 5),
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey),
    FOREIGN KEY (nContestImageKey) REFERENCES tblContestImage(nKey),
    UNIQUE (nLoginKey, nContestImageKey)
);

CREATE TABLE tblCustomer (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nLoginKey int NOT NULL,
   szFirstName CHAR (50),
   szLastName CHAR (50),
   szStreet CHAR (50), 
   szStreetNumber CHAR(10),
   szPostalCode CHAR(5),
   szCity CHAR(50),
   FOREIGN Key (nLoginKey) REFERENCES tblLogin(nKey) 
);

CREATE TABLE tblOrder (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nCustomerKey int NOT NULL, 
   dtTime datetime,
   FOREIGN Key (nCustomerKey) REFERENCES tblCustomer(nKey) 
);


CREATE TABLE tblProduct_Category (
   nKey int PRIMARY KEY,
   szName CHAR(50),
   szImage CHAR(200)
);

CREATE TABLE tblProduct (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nProduct_CategoryKey int NOT NULL,
   szName CHAR(50),
   nCalories int,
   dPrice decimal (5,2),
   bIsMenu tinyint(1),
   szDescription CHAR(200),
   szImagePfad CHAR(200),
   FOREIGN KEY (nProduct_CategoryKey) REFERENCES tblProduct_Category(nKey)    
);

CREATE TABLE tblOrder_Product (
    nOrderKey int NOT NULL,
    nProductKey int NOT NULL,
    nQuantity int,
    dOldPrice decimal (5,2),
    FOREIGN KEY (nOrderKey) REFERENCES tblOrder(nKey),
    FOREIGN KEY (nProductKey) REFERENCES tblProduct(nKey)
);

CREATE TABLE tblIngredient (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    szName CHAR(50)
);


CREATE TABLE tblProduct_Ingredient (
    nProductKey int NOT NULL,
    nIngredientKey int NOT NULL,
    FOREIGN KEY (nProductKey) REFERENCES tblProduct(nKey),
    FOREIGN KEY (nIngredientKey) REFERENCES tblIngredient(nKey)
);

CREATE TABLE tblMenu_Product (
    nMenuKey int NOT NULL,
    nProductKey int NOT NULL,
    FOREIGN KEY (nMenuKey) REFERENCES tblProduct(nKey),
    FOREIGN KEY (nProductKey) REFERENCES tblProduct(nKey)
);

-- Procedures 

-- spUpdateContestImageRating

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

-- spGetUnratedContestImages

DELIMITER //

create PROCEDURE spGetUnratedContestImages(IN UserKey int)
BEGIN 

select c.nKey as nKey,
	   c.szImagePath,
       l.szAccountName,
       c.dtCreated
from tblcontestimage c 
join tbllogin l on l.nKey=c.nLoginKey
where l.nKey = UserKey and c.bCanBeRated <> 0 ;

END //

DELIMITER ;

-- spUpdateContestImageConfirmation

DELIMITER //

create procedure spUpdateContestImageConfirmation(IN nKeyContestImage int, IN nConfirmed int)
BEGIN

  UPDATE tblcontestimage
  SET bCanBeRated = nConfirmed
  WHERE nKey = nKeyContestImage;

END //

DELIMITER ;

DELIMITER //

-- spCreateNewContestImage

CREATE PROCEDURE spCreateNewContestImage(IN nLoginKey INT, IN szPfad CHAR(100))
BEGIN
  INSERT INTO tblcontestimage (nLoginKey, szImagePath, dtCreated) 
  VALUES (nLoginKey, szPfad, NOW());
END //

DELIMITER ;

-- spGetUnconfirmedContestImages

DELIMITER //

CREATE PROCEDURE spGetUnconfirmedContestImages()
BEGIN
  SELECT i.nKey,
         i.szImagePath,
         l.szAccountName,
         i.dtCreated
  FROM tbllogin l 
  JOIN tblcontestimage i 
  ON i.nLoginKey = l.nKey 
  WHERE i.bCanBeRated IS NULL;
END //

DELIMITER ;

DELIMITER //

-- spNewOrder

CREATE PROCEDURE spNewOrder (IN nCustomerKey INT, OUT nOrderKey INT)
BEGIN
    INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (nCustomerKey, NOW());
    SET nOrderKey = LAST_INSERT_ID();
END //

DELIMITER ;

-- spCreateNewUser

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


DELIMITER //

CREATE PROCEDURE spLoginUser(
    IN AccountName CHAR(20),
    IN AccountPassword CHAR(64)
)
BEGIN
    SELECT l.nKey as nUserKey,
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

DELIMITER //

CREATE PROCEDURE spGetAllProducts()
BEGIN
select * from tblproduct_category;
select * from tblproduct;
SELECT * from tblingredient;
select * from tblproduct_ingredient;
select * from tblmenu_product;
  END//
DELIMITER ;


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
   OUT Error TINYINT(1)
)
BEGIN 
    DECLARE LoginKey INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN 
        SET Error = 1;
        ROLLBACK;
      
    END;

    START TRANSACTION;


    CALL spCreateNewUser(AccountName, LoginPassword, 0);

    SET LoginKey = (SELECT l.nKey FROM tbllogin l WHERE l.szAccountName = AccountName);

    INSERT INTO tblcustomer (szFirstName, szLastName, szStreet, szStreetNumber, szPostalCode, szCity, nLoginKey) 
    VALUES (FirstName, LastName, Street, StreetNumber, PostalCode, szCity, LoginKey);

    COMMIT;
    SET Error = 0; 
END //

DELIMITER ;

DELIMITER $$
CREATE  PROCEDURE spNewOrderProduct(IN nOrderID INT, IN nProductID INT, IN nQuantity INT)
BEGIN 

insert into tblorder_product(nOrderKey, nProductKey, nQuantity) VALUES (nOrderID, nProductID,nQuantity );

END$$
DELIMITER ;

-- Functions

DELIMITER //

CREATE FUNCTION fkInvoice(orderKey INT) RETURNS TEXT
BEGIN
    DECLARE resultSet TEXT;

    SELECT GROUP_CONCAT(
               CONCAT(
                   l.szAccountName, '#', 
                   c.szFirstName, '#', 
                   c.szLastName, '#', 
                   o.dtTime, '#', 
                   p.szName, '#Price:', 
                   p.dPrice, '  #Quantity:', 
                   op.nQuantity,'#Total Price:', 
                   op.nQuantity * p.dPrice
               ) SEPARATOR '; ') INTO resultSet
    FROM tblorder_product op 
    JOIN tblorder o ON op.nOrderKey = o.nKey
    JOIN tblproduct p ON op.nProductKey = p.nKey
    JOIN tblcustomer c ON o.nCustomerKey = c.nKey
    JOIN tbllogin l ON c.nLoginKey = l.nKey
    WHERE o.nKey = orderKey;

    RETURN resultSet;
END //

DELIMITER ;


-- Triggers

DELIMITER //

CREATE TRIGGER before_insert_tblorder_product
BEFORE INSERT ON tblorder_product
FOR EACH ROW
BEGIN
    DECLARE productPrice DECIMAL(5,2);

    SELECT dPrice INTO productPrice FROM tblproduct WHERE nKey = NEW.nProductKey;

    SET NEW.dOldPrice = productPrice;
END //

DELIMITER ;


-- Product Categories

INSERT INTO tblProduct_Category (nKey, szName, szImage) VALUES
(1, 'Burgers and Sandwiches', 'Path'),
(2, 'Sides and Snacks', 'Path'),
(3, 'Wraps', 'Path'),
(4, 'Beverages', 'Path'),
(5, 'Desserts', 'Path');

-- Menu Category nKey 6 is resserved for Menues
INSERT INTO tblProduct_Category (nKey, szName, szImage) VALUES
(6, 'Menu', 'Path');


-- Products
INSERT INTO tblProduct (szName, nCalories, dPrice, bIsMenu, szDescription, szImagePfad, nProduct_CategoryKey) VALUES
('Classic Hamburger', 250, 5.00, 0, 'A juicy, grilled beef patty topped with fresh lettuce, tomato, and our signature sauce.', 'images/Products/Classic Hamburger.jpg', 1),
('Chicken Sandwich', 300, 6.50, 0, 'Crispy fried chicken breast with a tangy mayo sauce on a toasted bun.', 'images/Products/Chicken Sandwich.jpg', 1),
('Veggie Burger', 220, 5.50, 0, 'A delicious blend of veggies and grains, topped with crisp lettuce and tomato.', 'images/Products/Veggie Burger.jpg', 1),
 
('French Fries', 350, 2.50, 0, 'Golden and crispy fries seasoned to perfection.', 'images/Products/French Fries.jpg', 2),
('Onion Rings', 400, 3.00, 0, 'Crispy battered onion rings served hot.', 'images/Products/Onion Rings.jpg', 2),
('Mozzarella Sticks', 450, 3.50, 0, 'Breaded mozzarella sticks with a side of marinara sauce.', 'images/Products/Mozzarella Sticks.jpg', 2),
 
('Grilled Chicken Wrap', 320, 4.50, 0, 'Tender grilled chicken, fresh veggies, and a tangy sauce all wrapped up.', 'images/Products/Grilled Chicken Wrap.jpg', 3),
('Beef & Cheese Wrap', 350, 5.00, 0, 'Seasoned beef and melted cheese wrapped up in a warm tortilla.', 'images/Products/Beef & Cheese Wrap.jpg', 3),
('Veggie Wrap', 280, 4.00, 0, 'A healthy mix of fresh veggies and hummus in a soft wrap.', 'images/Products/Veggie Wrap.jpg', 3),
 
('Soft Drink', 150, 1.50, 0, 'Refreshing soft drink to quench your thirst.', 'images/Products/Soft Drinks.jpg', 4),
('Milkshake', 500, 3.50, 0, 'Creamy milkshake in your choice of flavors.', 'images/Products/Milkshake.jpg', 4),
('Fresh Juice', 120, 2.50, 0, 'Freshly squeezed juice packed with vitamins.', 'images/Products/Fresh Juice.jpg', 4),
 
('Ice Cream Sundae', 350, 4.00, 0, 'A delightful sundae with your choice of toppings.', 'images/Products/Ice Cream Sundae.jpg', 5),
('Brownie', 400, 2.00, 0, 'Rich, chocolatey brownie with a chewy center.', 'images/Products/Brownie.jpg', 5),
('Apple Pie', 300, 3.00, 0, 'Classic apple pie with a flaky crust and sweet filling.', 'images/Products/Apple Pies.jpg', 5);
 
-- Menus
INSERT INTO tblProduct (szName, nCalories, dPrice, bIsMenu, szDescription, szImagePfad, nProduct_CategoryKey) VALUES
('Classic Burger Combo', 950, 10.00, 1, 'Cheeseburger with French fries, a soft drink, and a brownie.', 'images/Menu/Classic Burger Combo.jpg', 6),
('Chicken Delight', 1200, 12.00, 1, 'Chicken Sandwich with onion rings, a milkshake, and an ice cream sundae.', 'images/Menu/Chicken Delight.jpg', 6),
('Veggie Feast', 950, 11.00, 1, 'Veggie Burger with mozzarella sticks, fresh juice, and an apple pie.', 'images/Menu/Veggie Feast.jpg', 6),
('Grilled Chicken Wrap Combo', 870, 9.00, 1, 'Grilled Chicken Wrap with French fries, a soft drink, and a brownie.', 'images/Menu/Grilled Chicken Wrap.jpg', 6),
('Beef & Cheese Wrap Combo', 920, 10.50, 1, 'Beef & Cheese Wrap with onion rings, a milkshake, and an ice cream sundae.', 'images/Menu/Beef & Cheese Wrap.jpg', 6),
('Veggie Wrap Combo', 800, 9.50, 1, 'Veggie Wrap with mozzarella sticks, fresh juice, and an apple pie.', 'images/Menu/Veggie Wrap Combo.jpg', 6),
('Double Trouble', 1200, 11.00, 1, 'Double Cheeseburger with French fries, a soft drink, and a brownie.', 'images/Menu/Double Trouble.jpg', 6),
('Crispy Chicken Sandwich Combo', 1250, 12.50, 1, 'Crispy Chicken Sandwich with onion rings, a milkshake, and an ice cream sundae.', 'images/Menu/Crispy Chicken Sandwich.jpg', 6),
('BBQ Bacon Burger Combo', 1000, 11.50, 1, 'BBQ Bacon Burger with mozzarella sticks, fresh juice, and an apple pie.', 'images/Menu/BBQ Bacon Burger.jpg', 6),
('Ultimate Wrap Combo', 1200, 13.00, 1, 'Grilled Chicken Wrap and Beef & Cheese Wrap with French fries, a soft drink, and an ice cream sundae.', 'images/Menu/Ultimae Wrap Combo.jpg', 6);

update tblproduct set dPrice = IF(dPrice % 2 = 0, dPrice+0.49,dPrice+0.99);

-- Administrator
insert into tblLogin (szAccountName, szLoginPassword, bIsAdmin) Values ('Administrator','7b7bc2512ee1fedcd76bdc68926d4f7b',1);

-- New Customer
SET @Error = 0;
CALL spNewCustomer('John', 'Doe', 'Main Street', '123', '12345', 'CityName', 'john_doe', '5f4dcc3b5aa765d61d8327deb882cf99', @Error);

-- Ingredients
INSERT INTO tblIngredient (szName) VALUES ('Beef Patty'), ('Lettuce'), ('Tomato'), ('Onion'), ('Cheese');
INSERT INTO tblIngredient (szName) VALUES ('Chicken Breast'), ('Mayo'), ('Pickle'), ('BBQ Sauce'), ('Bun');
INSERT INTO tblIngredient (szName) VALUES ('Veggie Patty'), ('Avocado'), ('Hummus'), ('Sprouts'), ('Whole Grain Bun');
INSERT INTO tblIngredient (szName) VALUES ('Potato'), ('Salt'), ('Oil');
INSERT INTO tblIngredient (szName) VALUES ('Onion'), ('Bread Crumbs'), ('Frying Oil');
INSERT INTO tblIngredient (szName) VALUES ('Mozzarella'), ('Bread Crumbs'), ('Tomato Sauce');
INSERT INTO tblIngredient (szName) VALUES ('Grilled Chicken'), ('Lettuce'), ('Wrap'), ('Tomato'), ('Cucumber');
INSERT INTO tblIngredient (szName) VALUES ('Beef'), ('Cheddar Cheese'), ('Tortilla Wrap');
INSERT INTO tblIngredient (szName) VALUES ('Mixed Vegetables'), ('Whole Wheat Wrap'), ('Hummus');
INSERT INTO tblIngredient (szName) VALUES ('Coca-Cola'), ('Pepsi'), ('Sprite');
INSERT INTO tblIngredient (szName) VALUES ('Vanilla Ice Cream'), ('Milk'), ('Strawberry Flavor');
INSERT INTO tblIngredient (szName) VALUES ('Orange'), ('Apple'), ('Carrot');
INSERT INTO tblIngredient (szName) VALUES ('Ice Cream'), ('Chocolate Syrup'), ('Sprinkles');
INSERT INTO tblIngredient (szName) VALUES ('Cocoa'), ('Sugar'), ('Butter');
INSERT INTO tblIngredient (szName) VALUES ('Apple'), ('Cinnamon'), ('Pastry Dough');

-- tblProduct_Ingredient
-- Classic Hamburger Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (1, 1), (1, 2), (1, 3), (1, 4), (1, 5);

-- Chicken Sandwich Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (2, 6), (2, 7), (2, 8), (2, 9), (2, 10);

-- Veggie Burger Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (3, 11), (3, 12), (3, 13), (3, 14), (3, 15);

-- French Fries Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (4, 16), (4, 17), (4, 18);

-- Onion Rings Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (5, 19), (5, 20), (5, 21);

-- Mozzarella Sticks Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (6, 22), (6, 23), (6, 24);

-- Grilled Chicken Wrap Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (7, 25), (7, 2), (7, 26), (7, 3), (7, 27);

-- Beef & Cheese Wrap Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (8, 28), (8, 29), (8, 30);

-- Veggie Wrap Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (9, 31), (9, 32), (9, 13);

-- Soft Drink Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (10, 33), (10, 34), (10, 35);

-- Milkshake Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (11, 36), (11, 37), (11, 38);

-- Fresh Juice Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (12, 39), (12, 40), (12, 41);

-- Ice Cream Sundae Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (13, 42), (13, 43), (13, 44);

-- Brownie Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (14, 45), (14, 46), (14, 47);

-- Apple Pie Ingredients
INSERT INTO tblProduct_Ingredient (nProductKey, nIngredientKey) VALUES (15, 48), (15, 49), (15, 50);

-- tblMenu_Product
-- Classic Burger Combo (nMenuKey = 16)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (16, 1);  -- Cheeseburger
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (16, 4);  -- French Fries
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (16, 10); -- Soft Drink
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (16, 14); -- Brownie

-- Chicken Delight (nMenuKey = 17)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (17, 2);  -- Chicken Sandwich
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (17, 5);  -- Onion Rings
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (17, 11); -- Milkshake
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (17, 13); -- Ice Cream Sundae

-- Veggie Feast (nMenuKey = 18)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (18, 3);  -- Veggie Burger
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (18, 6);  -- Mozzarella Sticks
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (18, 12); -- Fresh Juice
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (18, 15); -- Apple Pie

-- Grilled Chicken Wrap Combo (nMenuKey = 19)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (19, 7);  -- Grilled Chicken Wrap
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (19, 4);  -- French Fries
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (19, 10); -- Soft Drink
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (19, 14); -- Brownie

-- Beef & Cheese Wrap Combo (nMenuKey = 20)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (20, 8);  -- Beef & Cheese Wrap
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (20, 5);  -- Onion Rings
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (20, 11); -- Milkshake
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (20, 13); -- Ice Cream Sundae

-- Veggie Wrap Combo (nMenuKey = 21)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (21, 9);  -- Veggie Wrap
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (21, 6);  -- Mozzarella Sticks
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (21, 12); -- Fresh Juice
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (21, 15); -- Apple Pie

-- Double Trouble (nMenuKey = 22)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (22, 1);  -- Double Cheeseburger
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (22, 4);  -- French Fries
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (22, 10); -- Soft Drink
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (22, 14); -- Brownie

-- Crispy Chicken Sandwich Combo (nMenuKey = 23)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (23, 2);  -- Crispy Chicken Sandwich
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (23, 5);  -- Onion Rings
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (23, 11); -- Milkshake
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (23, 13); -- Ice Cream Sundae

-- BBQ Bacon Burger Combo (nMenuKey = 24)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (24, 1);  -- BBQ Bacon Burger
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (24, 6);  -- Mozzarella Sticks
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (24, 12); -- Fresh Juice
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (24, 15); -- Apple Pie

-- Ultimate Wrap Combo (nMenuKey = 25)
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (25, 7); -- Grilled Chicken Wrap
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (25, 8); -- Beef & Cheese Wrap
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (25, 4); -- French Fries
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (25, 10);-- Soft Drink
INSERT INTO tblMenu_Product (nMenuKey, nProductKey) VALUES (25, 13);-- Ice Cream Sundae



-- Declare a variable to capture the error output
SET @Error = 0;

-- Call the procedure with the details for Alice Smith
CALL spNewCustomer('Alice', 'Smith', 'Elm Street', '101', '54321', 'Metropolis', 'alice_smith', 'alicepassword', @Error);
SELECT @Error;

-- Call the procedure with the details for Bob Johnson
CALL spNewCustomer('Bob', 'Johnson', 'Oak Avenue', '202', '67890', 'Springfield', 'bob_johnson', 'bobpassword', @Error);
SELECT @Error;

-- Call the procedure with the details for Charlie Brown
CALL spNewCustomer('Charlie', 'Brown', 'Maple Drive', '303', '98765', 'Riverdale', 'charlie_brown', 'charliepassword', @Error);
SELECT @Error;

-- Call the procedure with the details for Diana Ross
CALL spNewCustomer('Diana', 'Ross', 'Pine Lane', '404', '12345', 'Gotham', 'diana_ross', 'dianapassword', @Error);
SELECT @Error;

-- Orders for Customer 1
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (1, '2025-02-20 10:00:00');
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (1, '2025-02-20 14:00:00');

-- Orders for Customer 2
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (2, '2025-02-21 09:30:00');
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (2, '2025-02-21 12:45:00');

-- Orders for Customer 3
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (3, '2025-02-22 11:15:00');
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (3, '2025-02-22 15:20:00');

-- Orders for Customer 4
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (4, '2025-02-23 08:50:00');
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (4, '2025-02-23 13:35:00');

-- Orders for Customer 5
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (5, '2025-02-24 10:05:00');
INSERT INTO tblOrder (nCustomerKey, dtTime) VALUES (5, '2025-02-24 16:00:00');


-- tblorder_product
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (2, 8, 3);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (3, 15, 1);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (4, 10, 4);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (5, 20, 2);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (6, 7, 5);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (7, 12, 1);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (8, 25, 3);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (9, 19, 2);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (10, 4, 4);
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (1, 9, 3); 
INSERT INTO tblorder_product (nOrderKey, nProductKey, nQuantity) VALUES (1, 18, 4); 


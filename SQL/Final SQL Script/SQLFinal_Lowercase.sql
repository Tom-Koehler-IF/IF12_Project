DROP DATABASE IF EXISTS project;

create DATABASE project;

use project;

create table tbllogin (
nKey int AUTO_INCREMENT PRIMARY KEY,
szAccountName CHAR (50),
szLoginPassword CHAR (64),
bIsAdmin tinyint(1)    
);

alter table tbllogin
add CONSTRAINT unique_szAccountName UNIQUE (szAccountName);

CREATE TABLE tblcontestimage (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    nLoginKey int,
    szImagePath CHAR(200),
    bCanBeRated tinyint(1),
    bIsAdmin tinyint(1),
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey)
    );
    
CREATE TABLE tblcontestratings (
    nLoginKey int,
    nContestImageKey int,
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey),
    FOREIGN KEY (nContestImageKey) REFERENCES tblcontestimage(nKey)
);

CREATE TABLE tblcustomer (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nLoginKey int, 
   szFirstName CHAR (50),
   szLastName CHAR (50),
   szStreet CHAR (50), 
   szStreetNumber CHAR(10),
   szPostalCode CHAR(5),
   szCity CHAR(50),
   FOREIGN Key (nLoginKey) REFERENCES tbllogin(nKey) 
);

CREATE TABLE tblorder (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nCustomerKey int, 
   dtTime datetime,
   FOREIGN Key (nCustomerKey) REFERENCES tblcustomer(nKey) 
);


CREATE TABLE tblproduct_category (
   nKey int PRIMARY KEY,
   szName CHAR(50),
   szImage CHAR(200)
);

CREATE TABLE tblproduct (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nProduct_CategoryKey int, 
   szName CHAR(50),
   nCalories int,
   dPrice decimal (5,2),
   bIsMenu tinyint(1),
   szDescription CHAR(200),
   szImagePfad CHAR(200),
   FOREIGN KEY (nProduct_CategoryKey) REFERENCES tblproduct_category(nKey)    
);

CREATE TABLE tblorder_product (
    nOrderKey int,
    nProductKey int,
    nQuantity int,
    dOldPrice decimal (5,2),
    FOREIGN KEY (nOrderKey) REFERENCES tblorder(nKey),
    FOREIGN KEY (nProductKey) REFERENCES tblproduct(nKey)
);

CREATE TABLE tblingredient (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    szName CHAR(50)
);


CREATE TABLE tblproduct_ingredient (
    nProductKey int,
    nIngredientKey int,
    FOREIGN KEY (nProductKey) REFERENCES tblproduct(nKey),
    FOREIGN KEY (nIngredientKey) REFERENCES tblingredient(nKey)
);

CREATE TABLE tblmenu_product (
    nMenuKey int,
    nProductKey int,
    FOREIGN KEY (nMenuKey) REFERENCES tblproduct(nKey),
    FOREIGN KEY (nProductKey) REFERENCES tblproduct(nKey)
);

-- Procedures 

DELIMITER //

-- spNewOrder

CREATE PROCEDURE spNewOrder (IN nCustomerKey INT, OUT nOrderKey INT)
BEGIN
    INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (nCustomerKey, NOW());
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
    IN AccountPassword CHAR(64),
    OUT loginResult TINYINT(1)
)
BEGIN
   IF EXISTS (
        SELECT 1
        FROM tbllogin
        WHERE szAccountName = AccountName AND szLoginPassword = AccountPassword
    ) THEN
        SET LoginResult = 1;
    ELSE
        SET LoginResult = 0;
    END IF;
END//
DELIMITER ;

DELIMITER //

CREATE PROCEDURE spGetAllProducts()
BEGIN
select * from tblproduct_category;
select * from tblproduct;
SELECT * from tblingredient;
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

INSERT INTO tblproduct_category (nKey, szName, szImage) VALUES
(1, 'Burgers and Sandwiches', 'Path'),
(2, 'Sides and Snacks', 'Path'),
(3, 'Wraps', 'Path'),
(4, 'Beverages', 'Path'),
(5, 'Desserts', 'Path');

-- Menu Category nKey 6 is resserved for Menues
INSERT INTO tblproduct_category (nKey, szName, szImage) VALUES
(6, 'Menu', 'Path');


-- Products
INSERT INTO tblproduct (szName, nCalories, dPrice, bIsMenu, szDescription, szImagePfad, nProduct_CategoryKey) VALUES
('Classic Hamburger', 250, 5.00, 0, 'A juicy, grilled beef patty topped with fresh lettuce, tomato, and our signature sauce.', '', 1),
('Chicken Sandwich', 300, 6.50, 0, 'Crispy fried chicken breast with a tangy mayo sauce on a toasted bun.', '', 1),
('Veggie Burger', 220, 5.50, 0, 'A delicious blend of veggies and grains, topped with crisp lettuce and tomato.', '', 1),

('French Fries', 350, 2.50, 0, 'Golden and crispy fries seasoned to perfection.', '', 2),
('Onion Rings', 400, 3.00, 0, 'Crispy battered onion rings served hot.', '', 2),
('Mozzarella Sticks', 450, 3.50, 0, 'Breaded mozzarella sticks with a side of marinara sauce.', '', 2),

('Grilled Chicken Wrap', 320, 4.50, 0, 'Tender grilled chicken, fresh veggies, and a tangy sauce all wrapped up.', '', 3),
('Beef & Cheese Wrap', 350, 5.00, 0, 'Seasoned beef and melted cheese wrapped up in a warm tortilla.', '', 3),
('Veggie Wrap', 280, 4.00, 0, 'A healthy mix of fresh veggies and hummus in a soft wrap.', '', 3),

('Soft Drink', 150, 1.50, 0, 'Refreshing soft drink to quench your thirst.', '', 4),
('Milkshake', 500, 3.50, 0, 'Creamy milkshake in your choice of flavors.', '', 4),
('Fresh Juice', 120, 2.50, 0, 'Freshly squeezed juice packed with vitamins.', '', 4),

('Ice Cream Sundae', 350, 4.00, 0, 'A delightful sundae with your choice of toppings.', '', 5),
('Brownie', 400, 2.00, 0, 'Rich, chocolatey brownie with a chewy center.', '', 5),
('Apple Pie', 300, 3.00, 0, 'Classic apple pie with a flaky crust and sweet filling.', '', 5);

-- Menus
INSERT INTO tblproduct (szName, nCalories, dPrice, bIsMenu, szDescription, szImagePfad, nProduct_CategoryKey) VALUES
('Classic Burger Combo', 950, 10.00, 1, 'Cheeseburger with French fries, a soft drink, and a brownie.', '', 6),
('Chicken Delight', 1200, 12.00, 1, 'Chicken Sandwich with onion rings, a milkshake, and an ice cream sundae.', '', 6),
('Veggie Feast', 950, 11.00, 1, 'Veggie Burger with mozzarella sticks, fresh juice, and an apple pie.', '', 6),
('Grilled Chicken Wrap Combo', 870, 9.00, 1, 'Grilled Chicken Wrap with French fries, a soft drink, and a brownie.', '', 6),
('Beef & Cheese Wrap Combo', 920, 10.50, 1, 'Beef & Cheese Wrap with onion rings, a milkshake, and an ice cream sundae.', '', 6),
('Veggie Wrap Combo', 800, 9.50, 1, 'Veggie Wrap with mozzarella sticks, fresh juice, and an apple pie.', '', 6),
('Double Trouble', 1200, 11.00, 1, 'Double Cheeseburger with French fries, a soft drink, and a brownie.', '', 6),
('Crispy Chicken Sandwich Combo', 1250, 12.50, 1, 'Crispy Chicken Sandwich with onion rings, a milkshake, and an ice cream sundae.', '', 6),
('BBQ Bacon Burger Combo', 1000, 11.50, 1, 'BBQ Bacon Burger with mozzarella sticks, fresh juice, and an apple pie.', '', 6),
('Ultimate Wrap Combo', 1200, 13.00, 1, 'Grilled Chicken Wrap and Beef & Cheese Wrap with French fries, a soft drink, and an ice cream sundae.', '', 6);

update tblproduct set dPrice = IF(dPrice % 2 = 0, dPrice+0.49,dPrice+0.99);

-- Administrator
insert into tbllogin (szAccountName, szLoginPassword, bIsAdmin) Values ('Administrator','Administrator',1);

-- New Customer
SET @Error = 0;
CALL spNewCustomer('John', 'Doe', 'Main Street', '123', '12345', 'CityName', 'john_doe', 'password', @Error);

-- Ingredients
INSERT INTO tblingredient (szName) VALUES ('Beef Patty'), ('Lettuce'), ('Tomato'), ('Onion'), ('Cheese');
INSERT INTO tblingredient (szName) VALUES ('Chicken Breast'), ('Mayo'), ('Pickle'), ('BBQ Sauce'), ('Bun');
INSERT INTO tblingredient (szName) VALUES ('Veggie Patty'), ('Avocado'), ('Hummus'), ('Sprouts'), ('Whole Grain Bun');
INSERT INTO tblingredient (szName) VALUES ('Potato'), ('Salt'), ('Oil');
INSERT INTO tblingredient (szName) VALUES ('Onion'), ('Bread Crumbs'), ('Frying Oil');
INSERT INTO tblingredient (szName) VALUES ('Mozzarella'), ('Bread Crumbs'), ('Tomato Sauce');
INSERT INTO tblingredient (szName) VALUES ('Grilled Chicken'), ('Lettuce'), ('Wrap'), ('Tomato'), ('Cucumber');
INSERT INTO tblingredient (szName) VALUES ('Beef'), ('Cheddar Cheese'), ('Tortilla Wrap');
INSERT INTO tblingredient (szName) VALUES ('Mixed Vegetables'), ('Whole Wheat Wrap'), ('Hummus');
INSERT INTO tblingredient (szName) VALUES ('Coca-Cola'), ('Pepsi'), ('Sprite');
INSERT INTO tblingredient (szName) VALUES ('Vanilla Ice Cream'), ('Milk'), ('Strawberry Flavor');
INSERT INTO tblingredient (szName) VALUES ('Orange'), ('Apple'), ('Carrot');
INSERT INTO tblingredient (szName) VALUES ('Ice Cream'), ('Chocolate Syrup'), ('Sprinkles');
INSERT INTO tblingredient (szName) VALUES ('Cocoa'), ('Sugar'), ('Butter');
INSERT INTO tblingredient (szName) VALUES ('Apple'), ('Cinnamon'), ('Pastry Dough');

-- tblproduct_ingredient
-- Classic Hamburger Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (1, 1), (1, 2), (1, 3), (1, 4), (1, 5);

-- Chicken Sandwich Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (2, 6), (2, 7), (2, 8), (2, 9), (2, 10);

-- Veggie Burger Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (3, 11), (3, 12), (3, 13), (3, 14), (3, 15);

-- French Fries Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (4, 16), (4, 17), (4, 18);

-- Onion Rings Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (5, 19), (5, 20), (5, 21);

-- Mozzarella Sticks Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (6, 22), (6, 23), (6, 24);

-- Grilled Chicken Wrap Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (7, 25), (7, 2), (7, 26), (7, 3), (7, 27);

-- Beef & Cheese Wrap Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (8, 28), (8, 29), (8, 30);

-- Veggie Wrap Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (9, 31), (9, 32), (9, 13);

-- Soft Drink Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (10, 33), (10, 34), (10, 35);

-- Milkshake Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (11, 36), (11, 37), (11, 38);

-- Fresh Juice Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (12, 39), (12, 40), (12, 41);

-- Ice Cream Sundae Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (13, 42), (13, 43), (13, 44);

-- Brownie Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (14, 45), (14, 46), (14, 47);

-- Apple Pie Ingredients
INSERT INTO tblproduct_ingredient (nProductKey, nIngredientKey) VALUES (15, 48), (15, 49), (15, 50);

-- tblmenu_product
-- Classic Burger Combo (nMenuKey = 16)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (16, 1);  -- Cheeseburger
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (16, 4);  -- French Fries
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (16, 10); -- Soft Drink
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (16, 14); -- Brownie

-- Chicken Delight (nMenuKey = 17)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (17, 2);  -- Chicken Sandwich
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (17, 5);  -- Onion Rings
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (17, 11); -- Milkshake
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (17, 13); -- Ice Cream Sundae

-- Veggie Feast (nMenuKey = 18)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (18, 3);  -- Veggie Burger
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (18, 6);  -- Mozzarella Sticks
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (18, 12); -- Fresh Juice
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (18, 15); -- Apple Pie

-- Grilled Chicken Wrap Combo (nMenuKey = 19)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (19, 7);  -- Grilled Chicken Wrap
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (19, 4);  -- French Fries
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (19, 10); -- Soft Drink
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (19, 14); -- Brownie

-- Beef & Cheese Wrap Combo (nMenuKey = 20)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (20, 8);  -- Beef & Cheese Wrap
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (20, 5);  -- Onion Rings
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (20, 11); -- Milkshake
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (20, 13); -- Ice Cream Sundae

-- Veggie Wrap Combo (nMenuKey = 21)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (21, 9);  -- Veggie Wrap
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (21, 6);  -- Mozzarella Sticks
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (21, 12); -- Fresh Juice
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (21, 15); -- Apple Pie

-- Double Trouble (nMenuKey = 22)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (22, 1);  -- Double Cheeseburger
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (22, 4);  -- French Fries
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (22, 10); -- Soft Drink
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (22, 14); -- Brownie

-- Crispy Chicken Sandwich Combo (nMenuKey = 23)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (23, 2);  -- Crispy Chicken Sandwich
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (23, 5);  -- Onion Rings
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (23, 11); -- Milkshake
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (23, 13); -- Ice Cream Sundae

-- BBQ Bacon Burger Combo (nMenuKey = 24)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (24, 1);  -- BBQ Bacon Burger
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (24, 6);  -- Mozzarella Sticks
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (24, 12); -- Fresh Juice
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (24, 15); -- Apple Pie

-- Ultimate Wrap Combo (nMenuKey = 25)
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (25, 7); -- Grilled Chicken Wrap
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (25, 8); -- Beef & Cheese Wrap
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (25, 4); -- French Fries
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (25, 10);-- Soft Drink
INSERT INTO tblmenu_product (nMenuKey, nProductKey) VALUES (25, 13);-- Ice Cream Sundae



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
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (1, '2025-02-20 10:00:00');
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (1, '2025-02-20 14:00:00');

-- Orders for Customer 2
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (2, '2025-02-21 09:30:00');
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (2, '2025-02-21 12:45:00');

-- Orders for Customer 3
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (3, '2025-02-22 11:15:00');
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (3, '2025-02-22 15:20:00');

-- Orders for Customer 4
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (4, '2025-02-23 08:50:00');
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (4, '2025-02-23 13:35:00');

-- Orders for Customer 5
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (5, '2025-02-24 10:05:00');
INSERT INTO tblorder (nCustomerKey, dtTime) VALUES (5, '2025-02-24 16:00:00');


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

-- tblContestImage

INSERT into tblcontestimage(nLoginKey, bCanBeRated,dtCreated, szImagePath) VALUES (2,1,NOW(),'images/Contest/Contest2');
INSERT into tblcontestimage(nLoginKey, bCanBeRated,dtCreated, szImagePath) VALUES (3,1,NOW(),'images/Contest/Contest3');
INSERT into tblcontestimage(nLoginKey, bCanBeRated,dtCreated, szImagePath) VALUES (4,1,date_sub(NOW(), INTERVAL 1 Month),'images/Contest/Contest1');
INSERT into tblcontestimage(nLoginKey, bCanBeRated,dtCreated, szImagePath) VALUES (2,1,date_sub(NOW(), INTERVAL 1 Month),'images/Contest/Contest2');

insert into tblcontestratings(nContestImageKey, nLoginKey, nRating) VALUES (1,1,1);
insert into tblcontestratings(nContestImageKey, nLoginKey, nRating) VALUES (1,2,2);

insert into tblcontestratings(nContestImageKey, nLoginKey, nRating) VALUES (2,3,4);
insert into tblcontestratings(nContestImageKey, nLoginKey, nRating) VALUES (2,2,3);

insert into tblcontestratings(nContestImageKey, nLoginKey, nRating) VALUES (3,3,5);
insert into tblcontestratings(nContestImageKey, nLoginKey, nRating) VALUES (3,1,1);

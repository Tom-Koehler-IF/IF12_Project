DROP DATABASE IF EXISTS project;

create DATABASE project;

use project;

create table tblLogin (
nID int AUTO_INCREMENT PRIMARY KEY,
szAccountName CHAR (50),
szLoginPassword CHAR (64),
bIsAdmin tinyint(1)    
);

alter table tbllogin
add CONSTRAINT unique_szAccountName UNIQUE (szAccountName);

CREATE TABLE tblContestImage (
    nID int AUTO_INCREMENT PRIMARY KEY,
    nLoginID int,
    szImagePath CHAR(200),
    bCanBeRated tinyint(1),
    bIsAdmin tinyint(1),
    FOREIGN KEY (nLoginID) REFERENCES tbllogin(nID)
    );
    
CREATE TABLE tblContestRatings (
    nLoginID int,
    nContestImageID int,
    FOREIGN KEY (nLoginID) REFERENCES tbllogin(nID),
    FOREIGN KEY (nContestImageID) REFERENCES tblContestImage(nID)
);

CREATE TABLE tblCustomer (
   nID int AUTO_INCREMENT PRIMARY KEY,
   nLoginID int, 
   szFirstName CHAR (50),
   szLastName CHAR (50),
   szStreet CHAR (50), 
   szStreetNumber CHAR(10),
   szPostalCode CHAR(5),
   szCity CHAR(50),
   FOREIGN Key (nLoginID) REFERENCES tblLogin(nID) 
);

CREATE TABLE tblOrder (
   nID int AUTO_INCREMENT PRIMARY KEY,
   nCustomerID int, 
   tTime datetime,
   FOREIGN Key (nCustomerID) REFERENCES tblCustomer(nID) 
);


CREATE TABLE tblProduct_Category (
   nID int PRIMARY KEY,
   szName CHAR(50),
   szImage CHAR(200)
);

CREATE TABLE tblProduct (
   nID int AUTO_INCREMENT PRIMARY KEY,
   nProduct_CategoryID int, 
   szName CHAR(50),
   nCalories int,
   dPrice decimal (5,2),
   bIsMenu tinyint(1),
   szDescription CHAR(200),
   szImagePfad CHAR(200),
   FOREIGN KEY (nProduct_CategoryID) REFERENCES tblProduct_Category(nID)    
);

CREATE TABLE tblOrder_Product (
    nOrderID int,
    nProductID int,
    nQuantity int,
    dOldPrice decimal (5,2),
    FOREIGN KEY (nOrderID) REFERENCES tblOrder(nID),
    FOREIGN KEY (nProductID) REFERENCES tblProduct(nID)
);

CREATE TABLE tblIngredient (
    nID int AUTO_INCREMENT PRIMARY KEY,
    szName CHAR(50)
);


CREATE TABLE tblProduct_Ingredient (
    nProductID int,
    nIngredientID int,
    FOREIGN KEY (nProductID) REFERENCES tblProduct(nID),
    FOREIGN KEY (nIngredientID) REFERENCES tblIngredient(nID)
);

CREATE TABLE tblMenu_Product (
    nMenuID int,
    nProductID int,
    nQuantity int,
    FOREIGN KEY (nMenuID) REFERENCES tblProduct(nID),
    FOREIGN KEY (nProductID) REFERENCES tblProduct(nID)
);











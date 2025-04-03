DROP DATABASE IF EXISTS project;

create DATABASE project;

use project;

create table tblLogin (
nKey int AUTO_INCREMENT PRIMARY KEY,
szAccountName CHAR (50),
szLoginPassword CHAR (64),
bIsAdmin tinyint(1)    
);

alter table tbllogin
add CONSTRAINT unique_szAccountName UNIQUE (szAccountName);

CREATE TABLE tblContestImage (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    nLoginKey int,
    szImagePath CHAR(200),
    bCanBeRated tinyint(1),
    bIsAdmin tinyint(1),
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey)
    );
    
CREATE TABLE tblContestRatings (
    nLoginKey int,
    nContestImageKey int,
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey),
    FOREIGN KEY (nContestImageKey) REFERENCES tblContestImage(nKey)
);

CREATE TABLE tblCustomer (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nLoginKey int, 
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
   nCustomerKey int, 
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
   nProduct_CategoryKey int, 
   szName CHAR(50),
   nCalories int,
   dPrice decimal (5,2),
   bIsMenu tinyint(1),
   szDescription CHAR(200),
   szImagePfad CHAR(200),
   FOREIGN KEY (nProduct_CategoryKey) REFERENCES tblProduct_Category(nKey)    
);

CREATE TABLE tblOrder_Product (
    nOrderKey int,
    nProductKey int,
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
    nProductKey int,
    nIngredientKey int,
    FOREIGN KEY (nProductKey) REFERENCES tblProduct(nKey),
    FOREIGN KEY (nIngredientKey) REFERENCES tblIngredient(nKey)
);

CREATE TABLE tblMenu_Product (
    nMenuKey int,
    nProductKey int,
    nQuantity int,
    FOREIGN KEY (nMenuKey) REFERENCES tblProduct(nKey),
    FOREIGN KEY (nProductKey) REFERENCES tblProduct(nKey)
);











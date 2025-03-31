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











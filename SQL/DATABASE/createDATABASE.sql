DROP DATABASE IF EXISTS project;

create DATABASE project;

use project;

CREATE TABLE tbllogin (
    nKey INT AUTO_INCREMENT PRIMARY KEY,
    szAccountName CHAR(50) UNIQUE,
    szLoginPassword CHAR(64),
    bIsAdmin TINYINT(1)
);

CREATE TABLE tblcontestimage (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    nLoginKey int NOT NULL,
    szImagePath CHAR(200),
    bCanBeRated tinyint(1),
    dtCreated DATETIME,
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey)
    );
    
CREATE TABLE tblcontestratings (
    nKey int AUTO_INCREMENT PRIMARY KEY,
    nLoginKey int NOT NULL,
    nContestImageKey int NOT NULL,
    nRating int check(nRating between 1 and 5),
    FOREIGN KEY (nLoginKey) REFERENCES tbllogin(nKey),
    FOREIGN KEY (nContestImageKey) REFERENCES tblcontestimage(nKey),
    UNIQUE (nLoginKey, nContestImageKey)
);

CREATE TABLE tblcustomer (
   nKey int AUTO_INCREMENT PRIMARY KEY,
   nLoginKey int NOT NULL,
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
   nCustomerKey int NOT NULL, 
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
   nProduct_CategoryKey int NOT NULL,
   szName CHAR(50),
   nCalories int,
   dPrice decimal (5,2),
   bIsMenu tinyint(1),
   szDescription CHAR(200),
   szImagePfad CHAR(200),
   FOREIGN KEY (nProduct_CategoryKey) REFERENCES tblproduct_category(nKey)    
);

CREATE TABLE tblorder_product (
    nOrderKey int NOT NULL,
    nProductKey int NOT NULL,
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
    nProductKey int NOT NULL,
    nIngredientKey int NOT NULL,
    FOREIGN KEY (nProductKey) REFERENCES tblproduct(nKey),
    FOREIGN KEY (nIngredientKey) REFERENCES tblingredient(nKey)
);

CREATE TABLE tblmenu_product (
    nMenuKey int NOT NULL,
    nProductKey int NOT NULL,
    FOREIGN KEY (nMenuKey) REFERENCES tblproduct(nKey),
    FOREIGN KEY (nProductKey) REFERENCES tblproduct(nKey)
);











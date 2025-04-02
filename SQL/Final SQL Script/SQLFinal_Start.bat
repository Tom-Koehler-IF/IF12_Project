@echo off
REM Navigate to the MySQL bin directory
cd /d C:\xampp\mysql\bin

REM Start MySQL and execute the SQL script
mysql -u root -p < "C:/IF12_Project/SQL/Final SQL Script/SQLFinal.sql"

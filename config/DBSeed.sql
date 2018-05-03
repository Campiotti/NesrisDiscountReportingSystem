DROP DATABASE IF EXISTS M153;
CREATE DATABASE M153;
USE M153;
CREATE TABLE Activity(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
name VARCHAR(32) NOT NULL,
hourlyPrice FLOAT NOT NULL
);
CREATE TABLE Employee(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
firstname VARCHAR(32) NOT NULL,
lastname VARCHAR(32) NOT NULL,
email VARCHAR(255) NOT NULL,
tel VARCHAR(20) NOT NULL,
username VARCHAR(32) NOT NULL,
password VARCHAR(420) NOT NULL
);
CREATE TABLE Customer(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
firstname VARCHAR(32) NOT NULL,
lastname VARCHAR(32) NOT NULL,
email VARCHAR(255) NOT NULL,
tel VARCHAR(20) NOT NULL
);
CREATE TABLE Expense(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
unitType VARCHAR(32) NOT NULL,
unit VARCHAR(16) NOT NULL,
unitPrice FLOAT NOT NULL
);
CREATE TABLE TextBlock(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
activityFk INT NOT NULL,
content TEXT NOT NULL,
FOREIGN KEY (activityFk) REFERENCES Activity(id) ON DELETE CASCADE
);
CREATE TABLE Report(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
customerFk INT NOT NULL,
employeeFk INT NOT NULL,
title VARCHAR(128) NOT NULL,
status ENUM('unverified','verified','denied') NOT NULL,
signature BLOB,
signatureDate date,
FOREIGN KEY (customerFk) REFERENCES Customer(id) ON DELETE RESTRICT,
FOREIGN KEY (employeeFk) REFERENCES Employee(id) ON DELETE RESTRICT
);
CREATE TABLE ReportExpense(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
expenseFk INT NOT NULL,
reportFk INT NOT NULL,
amount FLOAT NOT NULL,
FOREIGN KEY (expenseFk) REFERENCES Expense(id) ON DELETE RESTRICT,
FOREIGN KEY (reportFk) REFERENCES Report(id) ON DELETE CASCADE
);
CREATE TABLE ReportActivity(
id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
activityFk INT NOT NULL,
reportFk INT NOT NULL,
hours FLOAT NOT NULL,
description TEXT NOT NULL,
doneOn date NOT NULL,
FOREIGN KEY (activityFk) REFERENCES Activity(id) ON DELETE RESTRICT,
FOREIGN KEY (reportFk) REFERENCES Report(id) ON DELETE CASCADE
);
-- Test Data --
-- Activities --
insert into Activity(name,hourlyPrice) values ('Support',24.95);
insert into Activity(name,hourlyPrice) values ('Meeting',29.95);
insert into Activity(name,hourlyPrice) values ('Service',49.95);
insert into Activity(name,hourlyPrice) values ('Networking',34.95);
-- Expenses --
insert into Expense(unitType,unit,unitPrice) values ('Travel by train','hrs',49.50);
insert into Expense(unitType,unit,unitPrice) values ('Travel by car','km',3.95);
insert into Expense(unitType,unit,unitPrice) values ('Travel by boat','km',7.50);
insert into Expense(unitType,unit,unitPrice) values ('Travel by canoe','km',24.95);
insert into Expense(unitType,unit,unitPrice) values ('Travel by skateboard','km',24.95);
insert into Expense(unitType,unit,unitPrice) values ('Travel by helicopter','km',5.50);
insert into Expense(unitType,unit,unitPrice) values ('Travel by plane','km',1.50);

-- Customers --
insert into Customer (firstname, lastname, email, tel) values ('Madelina', 'Hedgeman', 'mhedgeman0@about.me', '3137040108');
insert into Customer (firstname, lastname, email, tel) values ('Lazar', 'Culleton', 'lculleton1@hexun.com', '6477264870');
insert into Customer (firstname, lastname, email, tel) values ('Clive', 'Osgordby', 'cosgordby2@vinaora.com', '7105315946');
insert into Customer (firstname, lastname, email, tel) values ('Berkley', 'Ettels', 'bettels3@lycos.com', '4134729653');
insert into Customer (firstname, lastname, email, tel) values ('Carly', 'Schindler', 'cschindlero@squidoo.com', '3113206464');
-- Employees --
insert into Employee (firstname, lastname, email, tel, username, password) values ('Dayle', 'Hugill', 'dhugill0@amazonaws.com', '3726956069', 'doug', '$5$rounds=5000$NesriniDMagician$Q2guGhlc5hmbf7q7soZNgnadWipw2KtLcOg6uyIeAT6');
insert into Employee (firstname, lastname, email, tel, username, password) values ('Ado', 'Olivey', 'aolivey1@privacy.gov.au', '2534449079', 'alivey1', '$5$rounds=5000$NesriniDMagician$Q2guGhlc5hmbf7q7soZNgnadWipw2KtLcOg6uyIeAT6');
insert into Employee (firstname, lastname, email, tel, username, password) values ('Laurena', 'Pounsett', 'lpounsett2@yolasite.com', '6081250253', 'Jeff', '$5$rounds=5000$NesriniDMagician$Q2guGhlc5hmbf7q7soZNgnadWipw2KtLcOg6uyIeAT6');
insert into Employee (firstname, lastname, email, tel, username, password) values ('Dolly', 'Bingell', 'dbingell3@indiatimes.com', '8259904853', 'Bell', '$5$rounds=5000$NesriniDMagician$Q2guGhlc5hmbf7q7soZNgnadWipw2KtLcOg6uyIeAT6');
insert into Employee (firstname, lastname, email, tel, username, password) values ('Chilton', 'Oxx', 'coxx4@columbia.edu', '3381945769', 'john', '$5$rounds=5000$NesriniDMagician$Q2guGhlc5hmbf7q7soZNgnadWipw2KtLcOg6uyIeAT6');
-- TextBlock --
insert into TextBlock(activityFk, content) values (1,'Fixed IP settings on Windows PC');
insert into TextBlock(activityFk, content) values (1,'Linux and Window compatibility fixed between folders');
insert into TextBlock(activityFk, content) values (2,'Held meeting with customer to figure out our current stance and what to do next, resulting in');
insert into TextBlock(activityFk, content) values (2,'Held meeting with customer - mentoring them towards the right direction.');
insert into TextBlock(activityFk, content) values (3,'Fixed a few failing connection between different computers that weren\'t functioning as they should.');
insert into TextBlock(activityFk, content) values (4,'Installed Windows Server and setup AD accordingly with the client\'s requirements');
-- Report --
insert into Report(customerFk, employeeFk, title, status) values (1,1,'Fixing up the Ms. Hedgeman\'s company structure.',1);
insert into Report(customerFk, employeeFk,title, status) values (1,2,'Follow up on the last project with Ms Hedgeman.',2);
insert into Report(customerFk, employeeFk,title, status) values (2,3,'Windows Linux compatibility at Mr. Culleton\'s company.',1);
insert into Report(customerFk, employeeFk,title, status) values (3,3,'Osgordby\'s emegency consultation regarding their company\'s recent failures.',3);
insert into Report(customerFk, employeeFk,title, status) values (5,4,'Setting up IT infrastructure for Ms. Schindler.',1);
insert into Report(customerFk, employeeFk,title, status) values (5,5,'Setting up IT infrastructure for Mr. Ettels.',1);

-- ReportExpense --
insert into ReportExpense(expenseFk ,reportFk ,amount) values (1,2,100);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (2,2,50);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (4,2,10);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (3,2,40);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (2,2,250);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (5,1,80);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (6,3,162);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (7,4,88);
insert into ReportExpense(expenseFk ,reportFk ,amount) values (7,5,120);
-- ReportActivity --
insert into ReportActivity(activityFk, reportFk, hours, description, doneOn) values (1,2,5,'Lorem Ipsum','2018-02-24');
insert into ReportActivity(activityFk, reportFk, hours, description, doneOn) values (3,1,2.5,'Lorem Ipsum','2018-04-20');
insert into ReportActivity(activityFk, reportFk, hours, description, doneOn) values (4,3,7,'Lorem Ipsum','2018-01-24');
insert into ReportActivity(activityFk, reportFk, hours, description, doneOn) values (3,4,9,'Lorem Ipsum','2018-02-28');
insert into ReportActivity(activityFk, reportFk, hours, description, doneOn) values (2,3,1,'Lorem Ipsum','2018-03-24');
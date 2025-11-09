CREATE DATABASE HospitalDB;
USE HospitalDB;
CREATE TABLE Patient (
    PiD INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50),
    Gender VARCHAR(10),
    Age INT,
    DOB DATE,
    MobNo VARCHAR(15)
);
INSERT INTO Patient (Name, Gender, Age, DOB, MobNo) VALUES
('Ravi Kumar', 'Male', 32, '1993-06-15', '9876543210'),
('Priya Sharma', 'Female', 27, '1998-03-22', '9876501234'),
('Karan Singh', 'Male', 45, '1980-10-05', '9988776655'),
('Neha Rao', 'Female', 29, '1996-07-18', '9765432109'),
('Amit Das', 'Male', 38, '1987-01-10', '9123456780');
CREATE TABLE Doctor (
    DiD INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50),
    Gender VARCHAR(10),
    Age INT,
    Department VARCHAR(50),
    Qualification VARCHAR(50),
    MobNo VARCHAR(15)
);

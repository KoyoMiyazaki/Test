CREATE DATABASE sample;
use sample;

CREATE TABLE data_table(
    id int AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    receipt_date DATE,
    class VARCHAR(255),
    ticket VARCHAR(255),
    remarks VARCHAR(255),
    page_no int
);

CREATE TABLE user(
    name VARCHAR(255) PRIMARY KEY,
    primary_order int unique
);

ALTER USER 'root' IDENTIFIED WITH mysql_native_password BY 'pass';
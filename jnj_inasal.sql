CREATE DATABASE jnj_inasal;
USE jnj_inasal;

CREATE TABLE Cashier ( 
    Cashier_id INT PRIMARY KEY,
    Cashier_name VARCHAR(45) NOT NULL, 
    Cashier_email VARCHAR(100) NOT NULL UNIQUE, 
    Cashier_contact_num VARCHAR(20) NOT NULL UNIQUE, 
    Cashier_shift VARCHAR(10) CHECK(Waiter_shift IN ('Morning', 'Afternoon', 'Full')),
    Date_hired DATE, 
    Total_transactions INT
); 

CREATE TABLE Waiter ( 
    Waiter_id INT PRIMARY KEY,
    Waiter_name VARCHAR(45) NOT NULL,
    Waiter_email VARCHAR(100) NOT NULL UNIQUE, 
    Waiter_contact_num VARCHAR(20) NOT NULL UNIQUE,
    Waiter_shift VARCHAR(10) CHECK(Waiter_shift IN ('Morning', 'Afternoon', 'Full')),
    Date_hired DATE NOT NULL
);

CREATE TABLE Manager (
    Manager_id INT PRIMARY KEY, 
    Manager_name VARCHAR(45) NOT NULL,
    Manager_email VARCHAR(45) NOT NULL UNIQUE,
    Manager_contact_num VARCHAR(20) NOT NULL UNIQUE, 
    Password VARCHAR(255) NOT NULL,
    Date_hired DATE NOT NULL
);

CREATE TABLE Dish ( 
    Dish_id INT PRIMARY KEY AUTO_INCREMENT,
    Dish_name VARCHAR(100) NOT NULL,
    Dish_category VARCHAR(45) NOT NULL CHECK(Dish_category IN ('Main', 'Soup', 'Sides', 'Appetizer')),
    Price DECIMAL(10,2) NOT NULL CHECK (Price >= 0),
    Preparation_timeMin INT,
    Availability_status VARCHAR(45) NOT NULL CHECK (Availability_status IN ('Available','Unavailable')),
    Ingredients VARCHAR(255)
); 

CREATE TABLE Cart (
    Cart_id INT PRIMARY KEY AUTO_INCREMENT, 
    Dish_id INT NOT NULL,
    Quantity INT NOT NULL CHECK (Quantity > 0), 
    CONSTRAINT fk_Dish FOREIGN KEY (Dish_id) REFERENCES Dish(Dish_id) 
); 

CREATE TABLE Tables ( 
    Table_id INT PRIMARY KEY,
    Table_capacity INT,
    Table_status VARCHAR(45) NOT NULL CHECK(Table_status IN ('Dirty', 'Available', 'Occupied')),
    Waiter_id INT,
    CONSTRAINT fk_table_waiter FOREIGN KEY (Waiter_id) REFERENCES Waiter(Waiter_id) 
); 

CREATE TABLE Orders ( 
    Order_id INT PRIMARY KEY AUTO_INCREMENT, 
    Order_items VARCHAR(200) NOT NULL, 
    Order_date DATETIME DEFAULT CURRENT_TIMESTAMP, 
    Total_amount DECIMAL(10,2) NOT NULL CHECK (Total_amount >= 0), 
    Order_status VARCHAR(50) NOT NULL DEFAULT 'Preparing' CHECK (Order_status IN ('Preparing','Prepared')),
    Table_id INT NOT NULL,
    Cashier_id INT NOT NULL, 
    CONSTRAINT fk_order_table
        FOREIGN KEY (Table_id) REFERENCES Tables(Table_id), 
    CONSTRAINT fk_order_cashier  
        FOREIGN KEY (Cashier_id) REFERENCES Cashier(Cashier_id), 
); 

CREATE TABLE Chef ( 
    Chef_id INT PRIMARY KEY, 
    Chef_name VARCHAR(45) NOT NULL, 
    Chef_email VARCHAR(45) NOT NULL UNIQUE, 
    Chef_contact_num VARCHAR(20) NOT NULL UNIQUE, 
    Speciality VARCHAR(100), 
    Chef_shift VARCHAR(10) CHECK(Chef_shift IN ('Morning', 'Afternoon', 'Full')),
    Years_of_experience INT CHECK (Years_of_experience >= 0), 
    Order_id INT, 
    CONSTRAINT fk_chef_order FOREIGN KEY (Order_id) REFERENCES Orders(Order_id) 
); 

CREATE TABLE Payment ( 
    Payment_id INT PRIMARY KEY AUTO_INCREMENT, 
    Payment_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    Amount_paid DECIMAL(10,2) NOT NULL CHECK (Amount_paid > 0), 
    Payment_method VARCHAR(50) NOT NULL CHECK (Payment_method IN ('Gcash','Paymaya','Cash')), 
    Payment_status VARCHAR(50) NOT NULL CHECK (Payment_status IN ('Paid','Not Paid')), 
    Transaction_Num VARCHAR(100),
    Cashier_id INT NOT NULL,
    Order_id INT NOT NULL,
    CONSTRAINT fk_payment_cashier  
        FOREIGN KEY (Cashier_id) REFERENCES Cashier(Cashier_id), 
    CONSTRAINT fk_payment_order 
        FOREIGN KEY (Order_id) REFERENCES Orders(Order_id)
); 

CREATE TABLE Ingredients ( 
    Ingredients_id INT PRIMARY KEY AUTO_INCREMENT, 
    Ingredients_name VARCHAR(45) NOT NULL, 
    Category VARCHAR(45) NOT NULL,
    Quantity_available INT CHECK (Quantity_available >= 0), 
    Unit_of_measure VARCHAR(45), 
    Date_received DATE,
    Expiry_date DATE NOT NULL, 
    Restock_status VARCHAR(45) CHECK (Restock_status IN ('Good','Need Restock')),
    Status_updated DATETIME DEFAULT CURRENT_TIMESTAMP, 
    Chef_id INT NOT NULL,
    CONSTRAINT fk_ingredients_chef FOREIGN KEY (Chef_id) REFERENCES Chef(Chef_id)
); 

CREATE TABLE Supply (
    Supply_id INT PRIMARY KEY AUTO_INCREMENT, 
    Supply_Name VARCHAR(45) NOT NULL, 
    Supply_Quantity INT NOT NULL, 
    Unit_of_measure VARCHAR(45) NOT NULL, 
    Price_per_unit DECIMAL(10,2) NOT NULL CHECK (Price_per_unit > 0), 
    Date_procured DATE NOT NULL,
    Expiry_date DATE NOT NULL,
    Supplier_name VARCHAR(45) NOT NULL,
    Manager_id INT NOT NULL,
    CONSTRAINT fk_supply_manager FOREIGN KEY (Manager_id) REFERENCES Manager(Manager_id) 
); 
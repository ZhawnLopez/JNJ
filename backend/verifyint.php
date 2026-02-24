<?php
require '../../frontend/header.php';
require 'db.php';
if(isset($_POST['Manager_name']) && isset($_POST['password']) && !isset($_POST['reset_dummy'])){
    $name = $_POST['Manager_name'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM Manager WHERE Manager_name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1){
        $manager = $result->fetch_assoc();
        if(password_verify($password, $manager['Password'])){
            // Create session
            $_SESSION['manager_id'] = $manager['Manager_id'];
            $_SESSION['manager_name'] = $manager['Manager_name'];
            $_SESSION['role'] = 'admin';
            // Redirect to employees page
            header("Location: employees.php");
            exit();
        } else {
            echo "<script>alert('Incorrect Password');</script>";
        }
    } else {
        echo "<script>alert('Manager Not Found');</script>";
    }
}
if(isset($_POST['reset_dummy'])){
    // Disable FK checks so we can truncate safely
    $conn->query("SET FOREIGN_KEY_CHECKS = 0");
    $tables = ["Payment","Ingredients","Supply","Chef","Orders","Tables","Cart","Dish","Cashier","Waiter","Manager"];
    foreach($tables as $table){
        $conn->query("TRUNCATE TABLE $table");
    }
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");
    //declare set ids again
    $conn->query("ALTER TABLE Cashier AUTO_INCREMENT = 2001");
    $conn->query("ALTER TABLE Waiter AUTO_INCREMENT = 3001");
    $conn->query("ALTER TABLE Manager AUTO_INCREMENT = 5201");
    $conn->query("ALTER TABLE Dish AUTO_INCREMENT = 301");
    $conn->query("ALTER TABLE Tables AUTO_INCREMENT = 201");
    $conn->query("ALTER TABLE Chef AUTO_INCREMENT = 4001");
    $conn->query("ALTER TABLE Payment AUTO_INCREMENT = 497201");
    $conn->query("ALTER TABLE Supply AUTO_INCREMENT = 8901");
    // INSERT MANAGER
    $password = password_hash("jnjinasal20", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO Manager (Manager_name, Manager_email, Manager_contact_num, Password, Date_hired) VALUES ('manager', 'manager@jnj.com', '09123456789', '$password', CURDATE())");
    $manager_id = $conn->insert_id;
    // INSERT CASHIER 
    $conn->query("INSERT INTO Cashier(Cashier_name, Cashier_email, Cashier_contact_num, Cashier_shift, Date_hired, Total_transactions)VALUES('Meigen Rei','meigen@sample.com','09111111111','Full',CURDATE(),0)");
    $cashier_id = $conn->insert_id;
    // INSERT WAITER
    $conn->query("INSERT INTO Waiter(Waiter_name, Waiter_email, Waiter_contact_num, Waiter_shift, Date_hired) VALUES ('Ronald Wilson','ronald@sample.com','09222222222','Afternoon',CURDATE())");
    $waiter_id = $conn->insert_id;
    // INSERT TABLE
    $conn->query("INSERT INTO Tables (Table_capacity, Table_status, Waiter_id)VALUES(4,'Available',$waiter_id) ");
    $table_id = $conn->insert_id;
    // INSERT DISH
    $conn->query("INSERT INTO Dish (Dish_name, Dish_category, Price, Preparation_timeMin, Availability_status, Ingredients) VALUES ('Chicken Inasal','Main',199.00,20,'Available','Chicken, Marinade')");
    $dish_id = $conn->insert_id;
    // INSERT ORDER
    $conn->query("INSERT INTO Orders (Order_items, Total_amount, Order_status, Customer_type, Table_id, Cashier_id) VALUES ('Chicken Inasal x1',199.00,'Preparing','Dine In',$table_id,$cashier_id)");
    $order_id = $conn->insert_id;
    // INSERT CHEF
    $conn->query("INSERT INTO Chef(Chef_name, Chef_email, Chef_contact_num, Speciality, Chef_shift, Years_of_experience, Date_hired, Order_id) VALUES ('Aki Hidori','hidori@sample.com','09333333333','Grill','Morning',5,CURDATE(),$order_id)");
    $chef_id = $conn->insert_id;
    // INSERT INGREDIENTS
    $conn->query("INSERT INTO Ingredients(Ingredients_name, Category, Quantity_available, Unit_of_measure, Date_received, Expiry_date, Restock_status, Chef_id) VALUES ('Chicken','Meat',50,'kg',CURDATE(),DATE_ADD(CURDATE(), INTERVAL 7 DAY),'Good',$chef_id)");
    // INSERT PAYMENT  
    $conn->query("INSERT INTO Payment (Amount_paid, Payment_method, Payment_status, Transaction_Num, Cashier_id, Order_id) VALUES(199.00,'Cash','Paid','TXN12345',$cashier_id,$order_id)");
    // INSERT SUPPLY
    $conn->query("INSERT INTO Supply (Supply_Name, Supply_Quantity, Unit_of_measure, Price_per_unit, Date_procured, Expiry_date, Supplier_name, Manager_id) VALUES ('Chicken',100,'kg',25.00,CURDATE(),DATE_ADD(CURDATE(), INTERVAL 30 DAY),'Local Supplier',$manager_id)");
    echo "<script>alert('Database Reset Successful!\\n\\nManager Login:\\nUsername: manager\\nPassword: jnjinasal20');</script>";
}
?>
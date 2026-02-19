# JNJ


For Zhawns part, Feb 20:
Cashierint.php and Chefint.php uses a db.php that has a database I've edited. So be careful when integrating other parts into or from it.
The commands I've used for the database were:
ALTER TABLE Payment ADD COLUMN Order_id INT, ADD CONSTRAINT fk_payment_order FOREIGN KEY (Order_id) REFERENCES Orders(Order_id);
ALTER TABLE Orders MODIFY Order_items VARCHAR(1000) NOT NULL;

1st lets orders to be linked to a payment, 2nd just increases the varchar value for Order_items

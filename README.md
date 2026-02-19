# JNJ


For Zhawns part, Feb 20:

Cashierint.php and Chefint.php uses a db.php that has a database I've edited. So be careful when integrating other parts into or from it.
The commands I've used for the database were:
ALTER TABLE Payment ADD COLUMN Order_id INT, ADD CONSTRAINT fk_payment_order FOREIGN KEY (Order_id) REFERENCES Orders(Order_id);
ALTER TABLE Orders MODIFY Order_items VARCHAR(1000) NOT NULL;

1st lets orders to be linked to a payment, 2nd just increases the varchar value for Order_items


ALTER TABLE Orders 
ADD COLUMN Chef_id INT NULL, 
ADD CONSTRAINT fk_order_chef FOREIGN KEY (Chef_id) REFERENCES Chef(Chef_id);

this 3rd just only lets it so that u can only assign a chef that exists so Orders arent sabotaged by a guy named spongebob megatron john roblox or something

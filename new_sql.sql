CREATE DATABASE dbms;

CREATE TABLE admin(email varchar(50),password varchar(20),PRIMARY KEY (email));

CREATE TABLE items(code int,name varchar(20),price float,avail int,count int,image blob,PRIMARY KEY(code));

CREATE TABLE orderitems(orderid int,code int,quantity int,PRIMARY KEY(orderid,code));

CREATE TABLE orders(orderid int,userid varchar(50),make_time int,order_issue timestamp,price int,PRIMARY KEY(orderid));


/*CREATE TABLE orders(orderid int AUTO_INCREMENT,userid varchar(50),order_issue timestamp,price int,PRIMARY KEY(orderid));*/

CREATE TABLE users(username varchar(20),email varchar(50),password varchar(20),PRIMARY KEY(email));

/*ALTER TABLE orderitems ADD CONSTRAINT  fk1 FOREIGN KEY(code) REFERENCES items(code);*/

ALTER TABLE orders ADD CONSTRAINT fk2 FOREIGN KEY(userid) REFERENCES users(email);

ALTER TABLE items ADD CONSTRAINT CHECK(count>=0);

ALTER TABLE `items` CHANGE `image` `image` BLOB NULL DEFAULT 'load_file(\"/home/pranshu/Downloads/no-image-available-icon-6.jpg.png\")';

ALTER table items ADD CONSTRAINT UNIQUE(name);

ALTER TABLE `users` CHANGE `username` `username` VARCHAR(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'user';

ALTER table users ADD CONSTRAINT UNIQUE(username);

ALTER TABLE `orders` CHANGE `price` `price` INT(11) NOT NULL;

ALTER TABLE orders ADD CONSTRAINT CHECK(price>0);

ALTER TABLE users ADD COLUMN(wallet int DEFAULT 0);

ALTER TABLE users ADD CONSTRAINT CHECK(wallet>=0);

ALTER TABLE `items` CHANGE `code` `code` INT(11) NOT NULL AUTO_INCREMENT;

DELIMITER $$
CREATE TRIGGER trigger2
BEFORE UPDATE
ON items FOR EACH ROW
BEGIN
	if new.count>0 THEN
    	set new.avail=1;
    end if;
END$$


DELIMITER $$
CREATE TRIGGER trigger1
BEFORE UPDATE
ON items FOR EACH ROW
BEGIN
	if new.count<=0 THEN
    	set new.avail=0;
    end if;
END$$

/*ALTER TABLE orderitems ADD CONSTRAINT fk3 FOREIGN KEY orderitems(orderid) REFERENCES orders(orderid);*/


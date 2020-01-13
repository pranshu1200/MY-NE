CREATE TABLE users(username varchar(20),email varchar(50),password varchar(20),PRIMARY KEY(email));

CREATE TABLE items(code int,name varchar(20),price float,make_time int,avail int,count int,PRIMARY KEY(code));

CREATE TABLE orders(orderid int AUTO_INCREMENT,userid varchar(20),make_time int,order_issue timestamp,price int,PRIMARY KEY(orderid));

CREATE TABLE orderitems(orderid int,code int,quantity int,PRIMARY KEY (orderid,code));


CREATE TABLE admin(email varchar(50),password varchar(20),PRIMARY KEY(email));
INSERT INTO admin VALUES("admin","admin");

ALTER TABLE orders ADD CONSTRAINT fk1 FOREIGN KEY (userid) REFERENCES users(email)

ALTER TABLE orderitems ADD CONSTRAINT fk2 FOREIGN KEY(code) REFERENCES items(code)

ALTER TABLE items ADD CONSTRAINT CHECK(count>=0)





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


ALTER TABLE items ADD image blob

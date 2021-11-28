/*user database*/
CREATE TABLE `sidehustle`.`user` ( `ID` INT(50) NOT NULL AUTO_INCREMENT , 
`username` VARCHAR(255) NOT NULL , 
`agent` VARCHAR(255) NOT NULL , 
`email` VARCHAR(255) NOT NULL , 
`password` VARCHAR(255) NOT NULL , 
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
PRIMARY KEY (`ID`)) ENGINE = InnoDB;

/*orders database*/
CREATE TABLE `sidehustle`.`orders` ( `ID` INT(50) NOT NULL AUTO_INCREMENT ,
`detail` VARCHAR(255) NOT NULL ,
`quantity` VARCHAR(255) NOT NULL , 
`address` VARCHAR(255) NOT NULL , 
`amount` DECIMAL(10,2) NOT NULL , 
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
PRIMARY KEY (`ID`)) ENGINE = InnoDB;

/*clients database*/
CREATE TABLE `sidehustle`.`clients` ( `ID` INT(50) NOT NULL AUTO_INCREMENT ,
`name` VARCHAR(255) NOT NULL ,
`email` VARCHAR(255) NOT NULL , 
`number` INT(13) NOT NULL , 
`address` VARCHAR(255) NOT NULL ,
`country` VARCHAR(50) NOT NULL , 
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
PRIMARY KEY (`ID`)) ENGINE = InnoDB;

/* products database */
CREATE TABLE `sidehustle`.`products` ( `product_id` 
INT(10) NOT NULL AUTO_INCREMENT , 
`name` VARCHAR(50) NOT NULL , 
`description` VARCHAR(255) NOT NULL , 
`price` FLOAT(10,2) NOT NULL , 
`category_id` INT(10) NOT NULL , 
`merchant_id` INT(10) NOT NULL , 
`upload_image` VARCHAR(50) NOT NULL , 
`date_uploaded` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
PRIMARY KEY (`product_id`)) ENGINE = InnoDB;
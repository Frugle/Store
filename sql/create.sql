-- -----------------------------------------------------
-- Database `store`
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `store` DEFAULT CHARACTER SET utf8 ;
USE `store` ;

-- -----------------------------------------------------
-- Table `store`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `store`.`user` ;

CREATE TABLE IF NOT EXISTS `store`.`user` (
  `usernameid` VARCHAR(32) NOT NULL,
  `password` BINARY(60) NOT NULL,
  `salt` BINARY(60) NOT NULL,
  `firstname` VARCHAR(32) NOT NULL,
  `lastname` VARCHAR(32) NOT NULL,
  `permissionlevel` INT NOT NULL,
  `address` VARCHAR(64) NOT NULL,
  `postcode` VARCHAR(5) NOT NULL,
  `postoffice` VARCHAR(32) NOT NULL,
  `phone` VARCHAR(16) NOT NULL,
  `email` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`usernameid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `store`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `store`.`category` ;

CREATE TABLE IF NOT EXISTS `store`.`category` (
  `categoryid` VARCHAR(32) NOT NULL,
  `parentcategory` VARCHAR(32) NULL,
  PRIMARY KEY (`categoryid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `store`.`brand`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `store`.`brand` ;

CREATE TABLE IF NOT EXISTS `store`.`brand` (
  `brandid` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`brandid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `store`.`product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `store`.`product` ;

CREATE TABLE IF NOT EXISTS `store`.`product` (
  `productid` INT NOT NULL AUTO_INCREMENT,
  `brandid` VARCHAR(32) NOT NULL,
  `model` VARCHAR(64) NOT NULL,
  `description` VARCHAR(512) NOT NULL,
  `warranty` INT NOT NULL,
  `baseprice` DECIMAL(9,2) NOT NULL,
  `discount` DECIMAL(3,2) NOT NULL,
  `image` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`productid`),
  INDEX `fk_product_brand1_idx` (`brandid` ASC),
  CONSTRAINT `fk_product_brand1`
    FOREIGN KEY (`brandid`)
    REFERENCES `store`.`brand` (`brandid`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `store`.`productcategory`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `store`.`productcategory` ;

CREATE TABLE IF NOT EXISTS `store`.`productcategory` (
  `categoryid` VARCHAR(32) NOT NULL,
  `productid` INT NOT NULL,
  INDEX `fk_productcategory_category_idx` (`categoryid` ASC),
  INDEX `fk_productcategory_product1_idx` (`productid` ASC),
  PRIMARY KEY (`categoryid`, `productid`),
  CONSTRAINT `fk_productcategory_category`
    FOREIGN KEY (`categoryid`)
    REFERENCES `store`.`category` (`categoryid`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_productcategory_product1`
    FOREIGN KEY (`productid`)
    REFERENCES `store`.`product` (`productid`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `store`.`order`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `store`.`order` ;

CREATE TABLE IF NOT EXISTS `store`.`order` (
  `orderid` INT NOT NULL AUTO_INCREMENT,
  `usernameid` VARCHAR(32) NOT NULL,
  `date` TIMESTAMP NOT NULL,
  `message` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`orderid`, `usernameid`),
  INDEX `fk_order_user1_idx` (`usernameid` ASC),
  CONSTRAINT `fk_order_user1`
    FOREIGN KEY (`usernameid`)
    REFERENCES `store`.`user` (`usernameid`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `store`.`orderproduct`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `store`.`orderproduct` ;

CREATE TABLE IF NOT EXISTS `store`.`orderproduct` (
  `orderid` INT NOT NULL,
  `productid` INT NOT NULL,
  `price` DECIMAL(9,2) NOT NULL,
  `count` INT NOT NULL,
  INDEX `fk_orderproduct_order1_idx` (`orderid` ASC),
  INDEX `fk_orderproduct_product1_idx` (`productid` ASC),
  PRIMARY KEY (`orderid`, `productid`),
  CONSTRAINT `fk_orderproduct_order1`
    FOREIGN KEY (`orderid`)
    REFERENCES `store`.`order` (`orderid`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_orderproduct_product1`
    FOREIGN KEY (`productid`)
    REFERENCES `store`.`product` (`productid`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Insert test data into `user` table
-- -----------------------------------------------------
INSERT INTO `user`
VALUES 
(
  'HessuMies5',
  '$2y$13$5mNdU6ZpTa5vviq5rYnpE.3a3zb6OC8z7ntpm2w12nxSAJ/4q64eu',
  '\0ïOBÌ“ÛzÁ\rYëè´zIÖ¤a@è8âQÆÂÀEè~ÌQîKœUÉŽ¦˜Ë3ý*ª¨…|m‘‚~\\',
  'Hessu',
  'Halko',
  0,
  'Halkotie 43',
  '40300',
  'Jyväskylä','0453953951',
  'hessu.halko@gmail.com'
),(
  'Iiro',
  '$2y$13$/D.79zB8340IMq3P4p9aw.cU7ST2UacFd65zqia53B0uc1Odp9nZ.',
  'û•²ì\r©gÿï§R¨ú(„’ÀµSÁ+*Ïá±ÈD¶ôŠ\\´ïõH†|ó¬©žìsÞ%âÁ.F˜`ˆ]ªß',
  'Iiro',
  'Iironen',
  2,
  'Iiro 10',
  '12345',
  'Iirola',
  '1234567',
  'iiro@iiro.fi'
),(
  'Kalle',
  '$2y$13$u242C9vecn0Lo8pObnLu6OiofuGv/qBhqTWfxfh4JGvfoxzEZkLuG',
  'Çü`Õ`mqùi¶–P”tR.’½2)šÑºHÌéõ¸ðJÏŒ¼PYÛ¢™0dîëÉÊ/¾Ã§HR7³B',
  'Kalle',
  'Kala',
  0,
  'Kalatie 57',
  '00000',
  'Helsinki',
  '0503762063',
  'kalle@hotmail.com'
);

-- -----------------------------------------------------
-- Insert test data into `brand` table
-- -----------------------------------------------------
INSERT INTO `brand` 
VALUES 
  ('AMD'),
  ('Antec'),
  ('Apple'),
  ('Asus'),
  ('Atari'),
  ('Blizzard Entertainment'),
  ('Electronic Arts'),
  ('Intel'),
  ('LG'),
  ('Logitech'),
  ('Media Molecule'),
  ('Microsoft'),
  ('Nokia'),
  ('Philips'),
  ('Razer'),
  ('Rockstar Games'),
  ('Samsung'),
  ('Sony'),
  ('SteelSeries'),
  ('Ubisoft');

-- -----------------------------------------------------
-- Insert test data into `category` table
-- -----------------------------------------------------
INSERT INTO `category` 
VALUES 
  ('Components',NULL),
  ('Computers',NULL),
  ('Consoles','Consumer electronics'),
  ('Consumer electronics',NULL),
  ('Desktops','Computers'),
  ('Displays','Peripherals'),
  ('Games','Software'),
  ('GamingPCs','Computers'),
  ('Graphics cards','Components'),
  ('Keyboards','Peripherals'),
  ('Laptops','Computers'),
  ('Mice','Peripherals'),
  ('OEM','Software'),
  ('PC','Games'),
  ('Peripherals',NULL),
  ('Phones','Consumer electronics'),
  ('PS3','Games'),
  ('PS4','Games'),
  ('Retail','Software'),
  ('Servers','Computers'),
  ('Software',NULL),
  ('Speakers','Peripherals'),
  ('Tablets','Consumer electronics'),
  ('Televisions','Consumer electronics'),
  ('XBox360','Games'),
  ('XBoxOne','Games');

-- -----------------------------------------------------
-- Insert test data into `product` table
-- -----------------------------------------------------
INSERT INTO `product` 
VALUES 
(
  1,
  'Blizzard Entertainment',
  'Starcraft 2 Retail - Europe',
  '',
  0,
  24.90,
  0.00,
  'http://img.gamefaqs.net/box/3/8/0/86380_front.jpg'
),(
  2,
  'Blizzard Entertainment',
  'Warcraft 3 Battle Chest','It\'s a great game, yo!',
  0,
  29.90,
  0.00,
  'http://www.gamershell.com/static/boxart/large/9115.jpg'
),(
  10,
  'Electronic Arts','Simcity 4 - Deluxe Edition',
  '',
  0,
  14.90,
  0.00,
  ''
),(
  12,
  'Blizzard Entertainment',
  'World of Warcraft - 60-day pre-pair game card',
  '',
  0,
  21.90,
  0.00,
  ''
),(
  15,
  'Media Molecule',
  'LittleBigPlanet 2',
  '',
  0,
  24.90,
  0.00,
  ''
),(
  18,
  'Microsoft',
  'Peruna',
  'very yolo, much doge',
  12,
  90.90,
  0.00,
  ''
),(
  20,
  'AMD',
  'iTater',
  'so yolo and so doge that you wouldn\'t believe...',
  12,
  390.90,
  0.00,
  'asd'
);

-- -----------------------------------------------------
-- Insert test data into `order` table
-- -----------------------------------------------------
INSERT INTO `order` 
VALUES 
(
  44,
  'Iiro',
  '2014-04-11 10:41:20',
  'Piirrä pakettiin kissa pls'
),(
  45,
  'Iiro',
  '2014-04-11 10:44:02',''
),(
  46,
  'HessuMies5',
  '2014-04-11 10:45:29',
  'cool store bro'
);

-- -----------------------------------------------------
-- Insert test data into `orderproduct` table
-- -----------------------------------------------------
INSERT INTO `orderproduct` 
VALUES 
  (44,1,24.90,1),
  (44,2,29.90,2),
  (45,10,14.90,3),
  (45,12,21.90,1),
  (45,15,24.90,1),
  (45,18,90.90,1),
  (46,20,390.90,1);

-- -----------------------------------------------------
-- Insert test data into `productcategory` table
-- -----------------------------------------------------
INSERT INTO `productcategory` 
VALUES 
  ('Games',1),
  ('Games',2),
  ('Games',10),
  ('Peripherals',18),
  ('Peripherals',20);
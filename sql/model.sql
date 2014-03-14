SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

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
  PRIMARY KEY (`categoryid`),
  INDEX `fk_category_category1_idx` (`parentcategory` ASC),
  CONSTRAINT `fk_category_category1`
    FOREIGN KEY (`parentcategory`)
    REFERENCES `store`.`category` (`categoryid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productcategory_product1`
    FOREIGN KEY (`productid`)
    REFERENCES `store`.`product` (`productid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
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
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orderproduct_product1`
    FOREIGN KEY (`productid`)
    REFERENCES `store`.`product` (`productid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

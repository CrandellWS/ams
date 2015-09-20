SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `userType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `userType` ;

CREATE  TABLE IF NOT EXISTS `userType` (
  `iduserType` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `type` VARCHAR(45) NOT NULL ,
  `option` VARCHAR(45) NULL ,
  PRIMARY KEY (`iduserType`) ,
  UNIQUE INDEX `type_UNIQUE` (`type` ASC) ,
  UNIQUE INDEX `iduserType_UNIQUE` (`iduserType` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `password` CHAR(128) NOT NULL ,
  `salt` CHAR(128) NOT NULL ,
  `userType_iduserType` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `idusers_UNIQUE` (`id` ASC) ,
  INDEX `fk_users_userType1_idx` (`userType_iduserType` ASC) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  CONSTRAINT `fk_users_userType1`
    FOREIGN KEY (`userType_iduserType` )
    REFERENCES `userType` (`iduserType` )
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COMMENT = 'This is the base account for any user who is to have access.';


-- -----------------------------------------------------
-- Table `usersessions`
-- -----------------------------------------------------

DROP TABLE IF EXISTS `usersessions` ;

CREATE  TABLE IF NOT EXISTS `usersessions` (
  `user_id` INT UNSIGNED NOT NULL ,
  `userSessionId` VARCHAR(128) NOT NULL ,
  `sessionTimeStamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `NewFormKey` VARCHAR(26) ,
  `CurrentFormKey` VARCHAR(26),
  `OldFormKey` VARCHAR(26),
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX `usersessions_UNIQUE` (`user_id` ASC) ,
  CONSTRAINT `fk_usersessions`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`id` )
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `login_attempts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `login_attempts` ;

CREATE  TABLE IF NOT EXISTS `login_attempts` (
  `user_id` INT UNSIGNED NOT NULL ,
  `time` VARCHAR(30) NOT NULL ,
  `ipaddress` VARCHAR(20) NULL ,
  CONSTRAINT `fk_login_attempts_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`id` )
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

-- -----------------------------------------------------
-- Table `pwreset`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pwreset` ;

CREATE  TABLE IF NOT EXISTS `pwreset` (
  `user_id` INT UNSIGNED NOT NULL ,
  `token` VARCHAR(35) NOT NULL ,
  `ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX `pwreset_UNIQUE` (`user_id` ASC) ,
  CONSTRAINT `fk_pwreset_users`
    FOREIGN KEY (`user_id` )
    REFERENCES `users` (`id` )
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- -----------------------------------------------------
-- Data for table `userType`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `userType` (`iduserType`, `type`, `option`)
 VALUES
 (1, 'Webmaster', NULL),
 (2, 'Admin', NULL),
 (3, 'Standard', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `users`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `salt`, `userType_iduserType`)
 VALUES
 (
   1,
   'user',
   'user@www.localhost',
   -- password = apass
   '31bf21bfffd4a8dfdf6d7324e8082c576e9fb404d59b78577c73a2ef681b85ec807c02638360bffae65a772125b116b68c6bd5877d5454e8987c93347c1b9558',
   '9b955f60da5ede0daeb2ef811edd9de131f0ac8148ec856481828044e4cfbf05bb9defcc7501d5cdbbb2992d628c3e37e2e7028d856c83662b1607736ecf0314',
   1
 );

COMMIT;

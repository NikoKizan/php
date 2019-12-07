CREATE TABLE `blog`.`comments`(
	`id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(20) NOT NULL,
    `comments` VARCHAR(255) NOT NULL,
    'dates' TIMESTAMP NOT NULL,
    primary key (`id`)
);
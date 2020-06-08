CREATE DATABASE `covid_restaurant`;
USE `covid_restaurant`;

CREATE TABLE `user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`mail` VARCHAR(32) NOT NULL,
    `password` CHAR(32) NOT NULL,
    `name` VARCHAR(32) NOT NULL,
    `admin` BOOL NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `user_log` (
	`id` INT NOT NULL AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `date` DATE NOT NULL,
    `action` VARCHAR(256) NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `ingredient` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32) NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `dish` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(32) NOT NULL,
    `waiting_time` TIME NOT NULL,
    `image` VARCHAR(128),
    PRIMARY KEY (`id`)
);

CREATE TABLE `ingredient_dish` (
    `ingredient_id` INT NOT NULL,
    `dish_id` INT NOT NULL,
    PRIMARY KEY (`ingredient_id`, `dish_id`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient`(`id`),
	FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`)
);

CREATE TABLE `table` (
	`id` INT NOT NULL AUTO_INCREMENT,
    `seats` INT NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `customer` (
	`id` INT NOT NULL AUTO_INCREMENT,
    `table_id` INT NOT NULL,
    `seating` DATE NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`table_id`) REFERENCES `table` (`id`)
);

CREATE TABLE `order` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`customer_id` INT NOT NULL,
    `dish_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
    FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`)
)
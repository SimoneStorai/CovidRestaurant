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
    `price` DECIMAL(6, 2) NOT NULL,
    `waiting_time` TIME NOT NULL,
    `image` VARCHAR(128),
    PRIMARY KEY (`id`)
);

CREATE TABLE `dish_ingredient` (
    `dish_id` INT NOT NULL,
    `ingredient_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`dish_id`, `ingredient_id`),
	FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`),
    FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient`(`id`)
);

CREATE TABLE `customer` (
	`id` INT NOT NULL AUTO_INCREMENT,
    `table_id` INT NOT NULL,
    `date` DATE NOT NULL,
    PRIMARY KEY (`id`)
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
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
    `category` VARCHAR(32) NOT NULL,
    `description` VARCHAR(256),
    `image_url` VARCHAR(128),
    PRIMARY KEY (`id`)
);

CREATE TABLE `dish_ingredient` (
    `dish_id` INT NOT NULL,
    `ingredient_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    `referral_url` VARCHAR(128),
    PRIMARY KEY (`dish_id`, `ingredient_id`),
	FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient`(`id`) ON DELETE CASCADE
);

CREATE TABLE `customer` (
	`id` INT NOT NULL AUTO_INCREMENT,
    `table_id` INT NOT NULL,
    `date` DATE NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `order` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`table_id` INT NOT NULL,
    `timestamp` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `order_dish` (
	`order_id` INT NOT NULL,
    `dish_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY (`order_id`, `dish_id`),
    FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
    FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`)
);
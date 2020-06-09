INSERT INTO dish (name, price, waiting_time, image)
VALUES ("Putenga", 30.0, 1000, "");

INSERT INTO ingredient (name, quantity)
VALUES ("Sale", 3000);
INSERT INTO ingredient (name, quantity)
VALUES ("Patata", 6000);
INSERT INTO ingredient (name, quantity)
VALUES ("Cavolo", 9000);

INSERT INTO dish_ingredient (dish_id, ingredient_id, quantity)
VALUES (1, 1, 300);
INSERT INTO dish_ingredient (dish_id, ingredient_id, quantity)
VALUES (1, 2, 450);
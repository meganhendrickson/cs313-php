CREATE TABLE "User" (
	userId serial PRIMARY KEY NOT NULL UNIQUE,
	userName varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	password varchar(255) NOT NULL
);

CREATE TABLE "Budget" (
	budgetId serial PRIMARY KEY NOT NULL UNIQUE,
	userId int references "User"(userId) NOT NULL,
	budgetName varchar(255) NOT NULL,
	budgetAmount int NOT NULL,
	created_at date NOT NULL
);

CREATE TABLE "Expense" (
	expenseId serial PRIMARY KEY NOT NULL UNIQUE,
	budgetId int references "Budget"(budgetId) NOT NULL,
	expenseAmount int NOT NULL,
	description varchar(255) NOT NULL,
	created_at date NOT NULL
);

INSERT INTO "User" (userName, email, password)
VALUES ('User1', 'user1@email.com', 'Password#1');
INSERT INTO "User" (userName, email, password)
VALUES ('User2', 'user2@email.com', 'Password#2');

INSERT INTO "Budget" (userId, budgetName, budgetAmount, created_at)
VALUES ('3', 'Food', '500', '05/18/2020');
INSERT INTO "Budget" (userId, budgetName, budgetAmount, created_at)
VALUES ('3', 'Fuel', '150', '05/18/2020');
INSERT INTO "Budget" (userId, budgetName, budgetAmount, created_at)
VALUES ('3', 'Misc', '200', '05/18/2020');

INSERT INTO "Expense" (budgetId, expenseAmount, description, created_at)
VALUES ('1', '10', 'Lunch at Sonic', '05/19/2020');
INSERT INTO "Expense" (budgetId, expenseAmount, description, created_at)
VALUES ('1', '75', 'Groceries', '05/19/2020');
INSERT INTO "Expense" (budgetId, expenseAmount, description, created_at)
VALUES ('2', '40', 'gas at Caseys', '05/19/2020');
INSERT INTO "Expense" (budgetId, expenseAmount, description, created_at)
VALUES ('3', '20', 'Movie Tickets', '05/19/2020');
CREATE TABLE "Users" (
	"userId" serial PRIMARY KEY NOT NULL UNIQUE,
	"userName" varchar(255) NOT NULL,
	"email" varchar(255) NOT NULL,
);

CREATE TABLE "Budget" (
	"budgetId" serial PRIMARY KEY NOT NULL UNIQUE,
	"userId" int references Users(userId) NOT NULL,
	"budgetName" varchar(255) NOT NULL,
	"budgetAmount" int NOT NULL,
	"created_at" datetime NOT NULL,
;

CREATE TABLE "Expense" (
	"expenseId" serial PRIMARY KEY NOT NULL UNIQUE,
	"budgetId" int references Budget(budgetId) NOT NULL,
	"expenseAmount" int NOT NULL,
	"description" varchar(255) NOT NULL,
	"created_at" datetime NOT NULL,
);

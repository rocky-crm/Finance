
CREATE TABLE rocky_finance_spending (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(255) NOT NULL
);

CREATE TABLE rocky_finance_calendar (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `spending_id` INT DEFAULT NULL COMMENT 'Related spending ID',
    `currency_id` INT NOT NULL COMMENT 'Related currency ID',
    `date` DATE NOT NULL COMMENT 'Date of this payment',
    `comment` TEXT NOT NULL,
    `amount` FLOAT NOT NULL,

    FOREIGN KEY (spending_id) REFERENCES rocky_spending(id) ON DELETE CASCADE
);

CREATE TABLE rocky_finance_income (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `currency_id` INT NOT NULL COMMENT 'Related currency ID',
    `from` varchar(255) NOT NULL,
    `date` DATE NOT NULL COMMENT 'Date of this income',
    `amount` FLOAT NOT NULL,
    `comment` TEXT NOT NULL
);

CREATE TABLE rocky_finance_currency (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `code` varchar(10) NOT NULL COMMENT 'Currency code'
);

DROP TABLE IF EXISTS manages;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS regions;

CREATE TABLE customers (
  CID INTEGER,
  name VARCHAR(128) NOT NULL,
  address VARCHAR(128),
  country VARCHAR(64),

  PRIMARY KEY (CID)
);

INSERT INTO customers (CID, name, address, country) VALUES
(1, "Sally Smith", "New York", "USA"),
(2, "Lene Sayed", "Manchester", "UK"),
(3, "Omar Zariz", "Paris", "France"),
(4, "Fred Thompson", "London", "UK");

CREATE TABLE employees (
  EID INTEGER,
  name VARCHAR(128) NOT NULL,
  title VARCHAR(128) NOT NULL,

  PRIMARY KEY (EID)
);

INSERT INTO employees (EID, name, title) VALUES
  (1, "Sara Targon", "salesperson"),
  (2, "Michael Ufah", "salesperson"),
  (3, "Muhammad Ariz", "salesperson");

CREATE TABLE regions (
  RID INTEGER,
  name VARCHAR(128) NOT NULL,
  tax FLOAT,

  PRIMARY KEY (RID)
);

INSERT INTO regions (RID, name, tax) VALUES
(1, "USA", "0.08"),
(2, "UK", "0.2"),
(3, "EMEA", "0.18"),
(4, "Asia", "0.12");

CREATE TABLE manages (
  EID INTEGER,
  RID INTEGER,

  FOREIGN KEY (EID) REFERENCES employees(EID),
  FOREIGN KEY (RID) REFERENCES regions(RID),

  PRIMARY KEY (EID, RID)
);

INSERT INTO manages (EID,RID) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4);

CREATE TABLE products (
  PID INTEGER,
  name VARCHAR(128),
  price FLOAT,

  PRIMARY KEY (PID)
);

INSERT INTO products (PID, name, price) VALUES
(1, "computers", 2000),
(2, "clothes", 100),
(3, "cars", 35000),
(4, "films", 50);

CREATE TABLE orders (
  OrderNo INTEGER AUTO_INCREMENT,
  CID INTEGER,
  PID INTEGER,
  RID INTEGER,
  quantity INTEGER,

  PRIMARY KEY (OrderNo),
  FOREIGN KEY (CID) REFERENCES customers(CID),
  FOREIGN KEY (PID) REFERENCES products(PID),
  FOREIGN KEY (RID) REFERENCES regions(RID)
);

INSERT INTO orders (OrderNO, CID, PID, RID, quantity) VALUES
(1, 1, 1, 1, 10),
(2, 2, 1, 2, 25),
(3, 4, 1, 2, 17),
(4, 3, 4, 3, 500),
(5, 3, 2, 4, 117),
(6, 3, 3, 3, 5);


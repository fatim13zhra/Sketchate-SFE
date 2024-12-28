######

Login as administrator : 

sketchate@gmail.com
SketChate26




# TABLES : 


CREATE TABLE register (
  id INT AUTO_INCREMENT PRIMARY KEY,
  fullname VARCHAR(200),
  email VARCHAR(100),
  usertype VARCHAR(100),
  password VARCHAR(255),
  status INT,
  registration_date DATETIME
);

###

CREATE TABLE files (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  data LONGBLOB NOT NULL,
  email VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

###

CREATE TABLE spaces (
  id INT AUTO_INCREMENT PRIMARY KEY,
  stairs VARCHAR(255) NOT NULL,
  space_name VARCHAR(255) NOT NULL,
  space_area VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

###

ALTER TABLE files DROP COLUMN email;
ALTER TABLE spaces DROP COLUMN email;

ALTER TABLE spaces
ADD COLUMN email VARCHAR(255) NOT NULL,
ADD CONSTRAINT fk_register_email
FOREIGN KEY (email) REFERENCES register(email);

###

CREATE TABLE price_category (
    id INT PRIMARY KEY AUTO_INCREMENT,
    choice VARCHAR(255),
    email VARCHAR(255),
    FOREIGN KEY (email) REFERENCES register(email)
);

###

CREATE TABLE competitors (
    id INT PRIMARY KEY AUTO_INCREMENT,
    competitor VARCHAR(100) NOT NULL,
    email VARCHAR(255),
    FOREIGN KEY (email) REFERENCES register(email)
);

###

CREATE TABLE details (
    id INT PRIMARY KEY AUTO_INCREMENT,
    details VARCHAR(100) NOT NULL,
    email VARCHAR(255),
    FOREIGN KEY (email) REFERENCES register(email)
);

ALTER TABLE details
ADD COLUMN place VARCHAR(100) AFTER id;


###

CREATE TABLE project (
  id INT AUTO_INCREMENT PRIMARY KEY,
  status VARCHAR(20) NOT NULL DEFAULT 'incomplete',
  expiration_time DATETIME
);


###

CREATE TABLE images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  file_name VARCHAR(255) NOT NULL,
  file_type VARCHAR(255) NOT NULL,
  file_size INT NOT NULL,
  data LONGBLOB NOT NULL,
  email VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);





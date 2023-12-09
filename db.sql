CREATE TABLE users (
   id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   username VARCHAR(50) NOT NULL UNIQUE,
   password VARCHAR(255) NOT NULL,
   created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
   role ENUM('editor', 'journalist', 'reader')
);

CREATE TABLE articles (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author_id INT NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('waiting', 'approved', 'rejected') DEFAULT 'waiting',
    status_message TEXT,
    FOREIGN KEY (author_id) REFERENCES users(id)
);

-- Articolul 1
INSERT INTO articles (title, author_id, content, category, status_message)
VALUES ('Titlu Articol 1', 1, 'Acesta este conținutul articolului 1.', 'Categoria 1', 'Articolul este în așteptare.');

-- Articolul 2
INSERT INTO articles (title, author_id, content, category, status_message)
VALUES ('Titlu Articol 2', 2, 'Acesta este conținutul articolului 2.', 'Categoria 2', 'Articolul este în așteptare.');

-- Articolul 3
INSERT INTO articles (title, author_id, content, category, status_message)
VALUES ('Titlu Articol 3', 1, 'Acesta este conținutul articolului 3.', 'Categoria 1', 'Articolul este în așteptare.');

-- Articolul 4
INSERT INTO articles (title, author_id, content, category, status_message)
VALUES ('Titlu Articol 4', 3, 'Acesta este conținutul articolului 4.', 'Categoria 3', 'Articolul este în așteptare.');

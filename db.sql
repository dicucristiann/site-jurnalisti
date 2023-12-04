CREATE TABLE journalists (
                             id INT AUTO_INCREMENT PRIMARY KEY,
                             username VARCHAR(255) NOT NULL,
                             password VARCHAR(255) NOT NULL
);

CREATE TABLE articles (
                          id INT AUTO_INCREMENT PRIMARY KEY,
                          journalist_id INT,
                          category VARCHAR(50) NOT NULL,
                          title VARCHAR(255) NOT NULL,
                          content TEXT NOT NULL,
                          published_at DATETIME,
                          is_approved BOOLEAN DEFAULT 0,
                          FOREIGN KEY (journalist_id) REFERENCES journalists(id)
);
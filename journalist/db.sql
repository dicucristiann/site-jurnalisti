-- Elimină tabelele existente dacă acestea există
DROP TABLE IF EXISTS utilizatori;
DROP TABLE IF EXISTS articole;

-- Creează tabela 'utilizatori'
CREATE TABLE utilizatori (
id INT AUTO_INCREMENT PRIMARY KEY,
nume VARCHAR(255) NOT NULL,
user VARCHAR(255) NOT NULL,
parola VARCHAR(255) NOT NULL,
rol VARCHAR(50) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Creează tabela 'articole'
CREATE TABLE articole (
id INT AUTO_INCREMENT PRIMARY KEY,
titlu VARCHAR(255) NOT NULL,
autor VARCHAR(255) NOT NULL,
continut TEXT NOT NULL,
categorie VARCHAR(50) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserează date în tabela 'utilizatori'
INSERT INTO utilizatori (nume, user, parola, rol) VALUES
('Jurnalist1', 'jurnalist1', 'password1', 'jurnalist'),
('Editor1', 'editor1', 'password1', 'editor'),
('Cititor1', 'cititor1', 'password1', 'cititor');

-- Inserează date în tabela 'articole'
INSERT INTO articole (titlu, autor, continut, categorie) VALUES
('Articol1', 'Jurnalist 1', 'Continut articol 1', 'artistic'),
('Articol2', 'Jurnalist 1', 'Continut articol 2', 'tehnic'),
('Articol3', 'Jurnalist 1', 'Continut articol 3', 'stiinta');

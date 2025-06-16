CREATE DATABASE IF NOT EXISTS portal_tech;
USE portal_tech;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    icone VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

CREATE TABLE IF NOT EXISTS carrinhos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    curso_id INT,
    data_adicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    data_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE IF NOT EXISTS itens_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT,
    curso_id INT,
    preco DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (compra_id) REFERENCES compras(id),
    FOREIGN KEY (curso_id) REFERENCES cursos(id)
);

-- Inserir categorias padrão
INSERT INTO categorias (nome, icone) VALUES
('HTML', 'fa-brands fa-html5'),
('JavaScript', 'fa-brands fa-js'),
('C#', 'fa-brands fa-microsoft'),
('Python', 'fa-brands fa-python'),
('PHP', 'fa-brands fa-php'),
('CSS3', 'fa-brands fa-css3'),
('Java', 'fa-brands fa-java'),
('React', 'fa-brands fa-react'),
('Laravel', 'fa-brands fa-laravel'); 
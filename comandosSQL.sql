CREATE DATABASE folha_de_pagamento;

USE folha_de_pagamento;

CREATE TABLE tbl_departamento (
    ID_departamento INT AUTO_INCREMENT PRIMARY KEY,
    nome_departamento VARCHAR(100) NOT NULL
);

CREATE TABLE tbl_senioridade (
    ID_senioridade INT AUTO_INCREMENT PRIMARY KEY,
    senerioridade VARCHAR(50) NOT NULL,
    salario_base DECIMAL(10, 2) NOT NULL
);

CREATE TABLE tbl_colaboradores (
    ID_colaborador INT AUTO_INCREMENT PRIMARY KEY,
    nome_colaborador VARCHAR(100) NOT NULL,
    cargo_especifico VARCHAR(100) NOT NULL,
    departamento_ID INT NOT NULL,
    senioridade_ID INT NOT NULL,
    CONSTRAINT FK_departamento FOREIGN KEY (departamento_ID) REFERENCES tbl_departamento (ID_departamento),
    CONSTRAINT FK_senioridade FOREIGN KEY (senioridade_ID) REFERENCES tbl_senioridade (ID_senioridade)
);

INSERT INTO tbl_senioridade (ID_senioridade, senerioridade, salario_base) VALUES
(1, 'estagiario', 1500),
(2, 'junior', 3500),
(3, 'pleno', 6000),
(4, 'senior', 10000),
(5, 'especialista', 13000),
(6, 'gerente', 15000),
(7, 'diretor', 22000)
ON DUPLICATE KEY UPDATE senerioridade = VALUES(senerioridade), salario_base = VALUES(salario_base);

CREATE TABLE tbl_folhaPagamento (
    ID_folhaPagamento INT AUTO_INCREMENT PRIMARY KEY,
    colaborador_ID INT NOT NULL,
    dias_trabalhados INT NOT NULL,
    extra DECIMAL(10, 2) DEFAULT 0.00,
    total_pagamento DECIMAL(10, 2) NOT NULL,
    dia_lancamento_pagamento DATE NOT NULL,
    CONSTRAINT FK_colaborador FOREIGN KEY (colaborador_ID) REFERENCES tbl_colaboradores (ID_colaborador)
);
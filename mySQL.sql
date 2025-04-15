CREATE DATABASE desafio;

use desafio;

CREATE TABLE usuarios (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(100),
  email VARCHAR(100),
  genero VARCHAR(10),
  cidade VARCHAR(100),
  pais VARCHAR(100),
  foto TEXT
);

select * from usuarios;


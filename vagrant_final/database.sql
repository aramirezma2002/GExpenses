DROP DATABASE  IF EXISTS gexpenses;

CREATE DATABASE gexpenses;

USE gexpenses;

CREATE TABLE usuari (
	username VARCHAR(20) UNIQUE PRIMARY KEY,
	nom VARCHAR(20),
	cognom VARCHAR(25),
	correu VARCHAR(50) UNIQUE,
	contrasenya VARCHAR(100)
);

CREATE TABLE activitat (
	id VARCHAR(50)  PRIMARY KEY,
	nom VARCHAR(20),
    data_creacio timestamp,
	data_modify timestamp DEFAULT CURRENT_TIMESTAMP,
    divisa VARCHAR(3),
	despeses_totals INT,
	creador VARCHAR(20),
	FOREIGN KEY (creador) REFERENCES usuari(username)
);

CREATE TABLE despesa(
	id_despesa VARCHAR(100) PRIMARY KEY,
	valor_despesa DECIMAL(4,2),
	id_activitat VARCHAR(50),
	FOREIGN KEY (id_activitat) REFERENCES activitat(id)
);

CREATE TABLE usuari_despesa(
	username VARCHAR(20),
	id_despesa VARCHAR(100),
	valor_per_usuari DECIMAL(4,2),
	FOREIGN KEY (username) REFERENCES usuari(username),
	FOREIGN KEY(id_despesa) REFERENCES despesa(id_despesa)
);

CREATE TABLE pagament(
	username VARCHAR(20),
	pagador_despesa VARCHAR(20),
	id_despesa VARCHAR(100),
	id_activitat VARCHAR(50),
	FOREIGN KEY (id_activitat) REFERENCES activitat(id),
	FOREIGN KEY (username) REFERENCES usuari(username),
	FOREIGN KEY (pagador_despesa) REFERENCES usuari(username),
	FOREIGN KEY(id_despesa) REFERENCES despesa(id_despesa)
);

CREATE TABLE token(
	id_token VARCHAR(33) PRIMARY KEY,
	invitat VARCHAR(50),
	invitant VARCHAR(50),
	id_activitat VARCHAR(50),
	data_caducitat timestamp
);

CREATE TABLE usuari_activitat (
	nom_activitat VARCHAR(50),
	nom_usuari VARCHAR(20),
	FOREIGN KEY (nom_activitat) REFERENCES activitat(id),
	FOREIGN KEY (nom_usuari) REFERENCES usuari(username)
);

CREATE TABLE invitacio(
	invitador VARCHAR(40),
	id_activitat VARCHAR(50),
	data_creacio timestamp,
	data_caducitat timestamp,
	invitat VARCHAR(100),
	acceptat boolean,
	FOREIGN KEY (invitador) REFERENCES usuari(username),
	FOREIGN KEY (id_activitat) REFERENCES activitat(id)
);

CREATE TABLE divisa (
	divisa VARCHAR(3) PRIMARY KEY
);

INSERT INTO divisa VALUES ("EUR");
INSERT INTO divisa VALUES ("USD");


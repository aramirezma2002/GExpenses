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
    divisa VARCHAR(3),
	despeses_totals INT
);

CREATE TABLE despesa(
	id_despesa VARCHAR(50),
	valor_despesa INT,
	FOREIGN KEY (id_despesa) REFERENCES activitat(id)
);

CREATE TABLE usuari_despeses(
	username VARCHAR(20),
	id_despesa VARCHAR(50),
	FOREIGN KEY (username) REFERENCES usuari(username),
	FOREIGN KEY (id_despesa) REFERENCES despesa(id_despesa)
);

CREATE TABLE token(
	id_token VARCHAR(100) PRIMARY KEY,
	invitat VARCHAR(50),
	invitant VARCHAR(50),
	id_activitat VARCHAR(50),
	data_caducitat timestamp,
	FOREIGN KEY (id_activitat) REFERENCES activitat(id)
);

CREATE TABLE usuari_activitat (
	nom_activitat VARCHAR(50),
	nom_usuari VARCHAR(20),
	FOREIGN KEY (nom_activitat) REFERENCES activitat(id),
	FOREIGN KEY (nom_usuari) REFERENCES usuari(username)
);

CREATE TABLE invitacio(
	invitador VARCHAR(20),
	id_activitat VARCHAR(50),
	data_creacio timestamp,
	data_caducitat timestamp,
	invitat VARCHAR(20),
	acceptat boolean,
	FOREIGN KEY (invitador) REFERENCES usuari(username),
	FOREIGN KEY (id_activitat) REFERENCES activitat(id)
);

CREATE TABLE divisa (
	divisa VARCHAR(3) PRIMARY KEY
);

DELETE FROM usuari_activitat;
DELETE FROM activitat;

SELECT nom,data_creacio,divisa,despeses_totals FROM activitat INNER JOIN usuari_activitat ON usuari_activitat.nom_usuari LIKE 'Alexander' group by(nom);

INSERT INTO usuari VALUES("gj","Adrian","Ramirez","test@gmail.com","1234");

INSERT INTO activitat(id, nom,data_creacio,divisa,despeses_totals) VALUES("aa", "Activitat 1", curtime(),"EUR",100);

INSERT INTO divisa VALUES ("EUR");
INSERT INTO divisa VALUES ("USD");

INSERT INTO usuari VALUES("Ag","Alexandere","Ramirez","text@gmail.com","1234");
INSERT INTO activitat(id, nom, data_creacio, divisa, despeses_totals) VALUES("hola","Activitat 1",curtime(), "EUR",100);
INSERT INTO usuari_activitat values();

INSERT INTO token(id_token, data_caducitat) VALUES("1234", curtime());

SELECT * FROM usuari;
SELECT * FROM usuari_activitat;
SELECT * FROM despesa;
SELECT * FROM activitat;
SELECT * FROM token;
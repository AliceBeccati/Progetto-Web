
--CREAZIONE DATABASE
DROP DATABASE IF EXISTS TavolateDB;
CREATE DATABASE TavolateDB;
USE TavolateDB;

-- TABELLE

CREATE TABLE UTENTE (
    email VARCHAR(100) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    bio TEXT,
    ruolo VARCHAR(50)
);

CREATE TABLE TAVOLO (
    id_tavolo INT NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(50),
    nPosti INT NOT NULL,
    emailAdmin VARCHAR(100),
    PRIMARY KEY (id_tavolo),
    FOREIGN KEY (emailAdmin) REFERENCES UTENTE(email)
);

CREATE TABLE TAVOLATA (
    id_tavolata INT NOT NULL AUTO_INCREMENT,
    data DATE NOT NULL,
    titolo VARCHAR(150),
    ora TIME,
    stato VARCHAR(50),
    max_persone INT,
    PRIMARY KEY (id_tavolata)
);

CREATE TABLE PARTECIPAZIONE (
    id_tavolata INT,
    email VARCHAR(100),
    ruolo VARCHAR(50),
    PRIMARY KEY (id_tavolata, email),
    FOREIGN KEY (id_tavolata) REFERENCES TAVOLATA(id_tavolata),
    FOREIGN KEY (email) REFERENCES UTENTE(email)
);

CREATE TABLE PRENOTAZIONE (
    id_pren INT NOT NULL AUTO_INCREMENT,
    stato VARCHAR(50),
    ora_inizio TIME,
    ora_fine TIME,
    data DATE,
    nPosti INT,
    email VARCHAR(100),
    id_tavolo INT,
    PRIMARY KEY (id_pren),
    FOREIGN KEY (email) REFERENCES UTENTE(email),
    FOREIGN KEY (id_tavolo) REFERENCES TAVOLO(id_tavolo)
);

CREATE TABLE PIATTO_DEL_GIORNO (
    id_piatto INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descrizione TEXT,
    prezzo DECIMAL(6,2),
    foto VARCHAR(255),
    emailAdmin VARCHAR(100),
    PRIMARY KEY (id_piatto),
    FOREIGN KEY (emailAdmin) REFERENCES UTENTE(email)
);

CREATE TABLE CATEGORIA (
    nome VARCHAR(100) PRIMARY KEY,
    descrizione TEXT
);

CREATE TABLE APPARTIENE (
    id_piatto INT,
    nomeCat VARCHAR(100),
    PRIMARY KEY (id_piatto, nomeCat),
    FOREIGN KEY (id_piatto) REFERENCES PIATTO_DEL_GIORNO(id_piatto),
    FOREIGN KEY (nomeCat) REFERENCES CATEGORIA(nome)
);

CREATE TABLE TAG (
    id_tavolata INT,
    nomeCat VARCHAR(100),
    PRIMARY KEY (id_tavolata, nomeCat),
    FOREIGN KEY (id_tavolata) REFERENCES TAVOLATA(id_tavolata),
    FOREIGN KEY (nomeCat) REFERENCES CATEGORIA(nome)
);

CREATE TABLE PREFERENZA (
    email VARCHAR(100),
    nomeCat VARCHAR(100),
    PRIMARY KEY (email, nomeCat),
    FOREIGN KEY (email) REFERENCES UTENTE(email),
    FOREIGN KEY (nomeCat) REFERENCES CATEGORIA(nome)
);

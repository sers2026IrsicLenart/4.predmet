CREATE DATABASE predmet4;
USE predmet4;

CREATE TABLE izvajalci (
    izvajalec_id INT NOT NULL PRIMARY KEY,
    izvajalec_ime VARCHAR(50) NOT NULL
);

CREATE TABLE uporabniki (
    uporabnik_id INT NOT NULL PRIMARY KEY,
    ime VARCHAR(50),
    email VARCHAR(50) NOT NULL,
    geslo VARCHAR(50) NOT NULL
);

CREATE TABLE albumi (
    album_id INT NOT NULL PRIMARY KEY,
    naslov VARCHAR(100) NOT NULL,
    cena DECIMAL(6,2) NOT NULL,
    leto_izdaje INT,
    zaloga INT DEFAULT 0,
    zanr VARCHAR(30),
    format VARCHAR(20) DEFAULT 'Vinyl',
    izvajalec_id INT,
    CONSTRAINT FK_albumi_izvajalci FOREIGN KEY (izvajalec_id) REFERENCES izvajalci(izvajalec_id)
);

CREATE TABLE kosarica (
    kosarica_id INT NOT NULL PRIMARY KEY,
    uporabnik_id INT,
    CONSTRAINT FK_kosarica_uporabniki FOREIGN KEY (uporabnik_id) REFERENCES uporabniki(uporabnik_id)
);

CREATE TABLE kosarica_vsebina (
    album_id INT NOT NULL,
    kosarica_id INT NOT NULL,
    kolicina INT DEFAULT 1,
    PRIMARY KEY (album_id, kosarica_id),
    CONSTRAINT FK_vsebina_albumi FOREIGN KEY (album_id) REFERENCES albumi(album_id),
    CONSTRAINT FK_vsebina_kosarica FOREIGN KEY (kosarica_id) REFERENCES kosarica(kosarica_id)
);
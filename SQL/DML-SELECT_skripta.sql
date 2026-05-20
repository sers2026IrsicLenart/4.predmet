-- SELECT

-- Izpiše 5 najbolj založenih albumov, z imeni avtorjev
SELECT a.*, i.izvajalec_ime 
FROM albumi a
JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id
ORDER BY zaloga DESC;

-- Izpiše vse albume formata Vinyl
SELECT * FROM albumi WHERE FORMAT="vinyl";

-- Izpiše kateri uporabnik ima kateri album v košarici
SELECT u.ime, a.naslov, a.format, kv.kolicina, a.cena
FROM uporabniki u
JOIN kosarica k ON u.uporabnik_id = k.uporabnik_id
JOIN kosarica_vsebina kv ON k.kosarica_id = kv.kosarica_id
JOIN albumi a ON kv.album_id = a.album_id
WHERE k.uporabnik_id = 1;

-- Albumi žarna progresivni rock, omejeno na 5 albumov
SELECT * FROM albumi a
JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id
WHERE zanr = 'Prog Rock' ORDER BY cena desc LIMIT 5;

SELECT * FROM albumi a
JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id
WHERE zanr LIKE '%Prog Rock%' OR naslov LIKE '%Prog%' OR izvajalec_ime LIKE '%Pink Floyd%' ORDER BY zaloga DESC;

-- Izpis albuma glede na njegov id
SELECT * FROM albumi a
JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id
WHERE album_id = 1;

-- Izpiše 5 naključnih albumov

SELECT a.*, i.izvajalec_ime 
FROM albumi a
JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id
WHERE a.album_id != 1 AND zanr = 'Prog Rock'
ORDER BY RAND();

-- Izpis albumov ki so v košarici uporabnika z ID-jem 1

SELECT a.album_id, i.izvajalec_ime, a.zanr, a.leto_izdaje, a.naslov, a.cena, kv.kolicina, a.format
FROM uporabniki u
JOIN kosarica k ON u.uporabnik_id = k.uporabnik_id
JOIN kosarica_vsebina kv ON k.kosarica_id = kv.kosarica_id
JOIN albumi a ON kv.album_id = a.album_id
JOIN izvajalci i ON a.izvajalec_id = i.izvajalec_id
WHERE u.uporabnik_id = 1;

SELECT naslov FROM albumi WHERE album_id = 1



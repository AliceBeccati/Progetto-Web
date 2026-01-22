-- INSERIMENTO DATI
-----------------------

INSERT INTO UTENTE VALUES
('admin@tavolate.it', 'Admin', 'pass123', 'Gestore del sistema e organizzatore.', 'admin'),
('mario.rossi@email.it', 'Mario Rossi', 'pwd1', 'Amante delle tavolate conviviali.', 'utente'),
('giulia.bianchi@email.it', 'Giulia Bianchi', 'pwd2', 'Vegetariana appassionata.', 'utente'),
('luca.verdi@email.it', 'Luca Verdi', 'pwd3', 'Sommelier amatoriale.', 'utente'),
('anna.neri@email.it', 'Anna Neri', 'pwd4', 'Appassionata di cucina casalinga.', 'utente'),
('paolo.galli@email.it', 'Paolo Galli', 'pwd5', 'Ama i pranzi sociali.', 'utente'),
('sara.monti@email.it', 'Sara Monti', 'pwd6', 'Vegetariana e amante dei piatti leggeri.', 'utente'),
('davide.ferri@email.it', 'Davide Ferri', 'pwd7', 'Fan delle tavolate piccanti.', 'utente'),
('elisa.fontana@email.it', 'Elisa Fontana', 'pwd8', 'Appassionata di brunch.', 'utente'),
('giorgio.riva@email.it', 'Giorgio Riva', 'pwd9', 'Studente amante dei pranzi di gruppo.', 'utente'),
('martina.costa@email.it', 'Martina Costa', 'pwd10', 'Sempre presente agli eventi gluten-free.', 'utente');

INSERT INTO TAVOLO (tipo, nPosti, emailAdmin) VALUES
('centrale', 2, 'admin@tavolate.it'),
('centrale', 4, 'admin@tavolate.it'),
('centrale', 6, 'admin@tavolate.it'),
('bancone', 1, 'admin@tavolate.it'),
('bancone', 2, 'admin@tavolate.it'),
('bancone', 4, 'admin@tavolate.it'),
('finestra', 2, 'admin@tavolate.it'),
('finestra', 4, 'admin@tavolate.it'),
('finestra', 6, 'admin@tavolate.it'),
('centrale', 8, 'admin@tavolate.it'),
('finestra', 8, 'admin@tavolate.it'),
('bancone', 3, 'admin@tavolate.it');

INSERT INTO TAVOLATA (data, titolo, ora, stato, max_persone) VALUES
('2025-01-15', 'Pranzo Sushi', '12:30', 'aperta', 10),
('2025-01-20', 'Tavolata Vegetariana', '13:00', 'aperta', 8),
('2025-01-25', 'Degustazione Vini a Pranzo', '12:45', 'chiusa', 6),
('2025-02-01', 'Pranzo di Carnevale', '12:30', 'aperta', 12),
('2025-02-05', 'Menù Speciale Pasta', '13:00', 'aperta', 10),
('2025-02-10', 'Tavolata Gluten Free', '12:15', 'aperta', 6),
('2025-02-12', 'Pranzo Sociale', '13:00', 'chiusa', 14);

INSERT INTO PARTECIPAZIONE VALUES
(1, 'mario.rossi@email.it', 'organizzatore'),
(1, 'giulia.bianchi@email.it', 'ospite'),
(1, 'paolo.galli@email.it', 'ospite'),
(1, 'anna.neri@email.it', 'ospite'),

(2, 'giulia.bianchi@email.it', 'organizzatore'),
(2, 'sara.monti@email.it', 'ospite'),
(2, 'anna.neri@email.it', 'ospite'),

(3, 'luca.verdi@email.it', 'organizzatore'),
(3, 'davide.ferri@email.it', 'ospite'),

(4, 'paolo.galli@email.it', 'organizzatore'),
(4, 'anna.neri@email.it', 'ospite'),
(4, 'giorgio.riva@email.it', 'ospite'),

(5, 'anna.neri@email.it', 'organizzatore'),
(5, 'mario.rossi@email.it', 'ospite'),

(6, 'martina.costa@email.it', 'organizzatore'),
(6, 'sara.monti@email.it', 'ospite'),

(7, 'paolo.galli@email.it', 'organizzatore'),
(7, 'giorgio.riva@email.it', 'ospite'),
(7, 'davide.ferri@email.it', 'ospite');

INSERT INTO PRENOTAZIONE (stato, ora_inizio, ora_fine, data, nPosti, email, id_tavolo) VALUES
('archiviata', '20:00', '22:00', '2025-01-10', 2, 'mario.rossi@email.it', 2),
('archiviata', '12:30', '14:00', '2025-01-11', 3, 'giulia.bianchi@email.it', 3),
('archiviata', '19:30', '21:30', '2025-01-18', 2, 'anna.neri@email.it', 7),
('archiviata', '21:00', '23:00', '2025-01-22', 4, 'luca.verdi@email.it', 11),
('archiviata', '20:00', '22:00', '2025-02-03', 6, 'paolo.galli@email.it', 10),
('archiviata', '13:00', '14:30', '2025-02-07', 2, 'sara.monti@email.it', 5),
('archiviata', '19:45', '21:15', '2025-02-09', 3, 'davide.ferri@email.it', 12),
('archiviata', '12:30', '14:00', '2025-03-01', 4, 'elisa.fontana@email.it', 8),
('archiviata', '20:00', '22:00', '2025-03-05', 5, 'giorgio.riva@email.it', 9),
('archiviata', '19:30', '21:00', '2025-03-20', 2, 'martina.costa@email.it', 6);

INSERT INTO CATEGORIA VALUES
('vegetariano', 'Piatti senza carne o pesce.'),
('vegano', 'Piatti totalmente vegetali.'),
('senza lattosio', 'Piatti privi di lattosio.'),
('senza glutine', 'Piatti privi di glutine.'),
('healthy', 'Piatti leggeri e salutari.'),
('gym', 'Piatti proteici per sportivi.'),
('dolce', 'Piatti dessert.');

INSERT INTO PREFERENZA VALUES
('mario.rossi@email.it', 'healthy'),
('mario.rossi@email.it', 'gym'),

('giulia.bianchi@email.it', 'vegetariano'),
('giulia.bianchi@email.it', 'healthy'),

('luca.verdi@email.it', 'dolce'),

('anna.neri@email.it', 'healthy'),

('paolo.galli@email.it', 'healthy'),
('paolo.galli@email.it', 'senza lattosio'),

('sara.monti@email.it', 'vegetariano'),
('sara.monti@email.it', 'vegano'),

('davide.ferri@email.it', 'gym'),
('davide.ferri@email.it', 'healthy'),

('elisa.fontana@email.it', 'dolce'),

('giorgio.riva@email.it', 'gym'),
('giorgio.riva@email.it', 'healthy'),

('martina.costa@email.it', 'senza glutine');

INSERT INTO PIATTO_DEL_GIORNO (nome, descrizione, prezzo, foto, emailAdmin) VALUES
('Pasta alla Carbonara', 'Spaghetti con guanciale croccante, uova e pecorino.', 11.50, 'carbonara.jpg', 'admin@tavolate.it'),
('Insalata Mediterranea', 'Pomodori, cetrioli, olive nere, feta e origano.', 8.90, 'insalata_mediterranea.jpg', 'admin@tavolate.it'),
('Pollo Arrosto', 'Pollo con patate al rosmarino.', 12.00, 'pollo_arrosto.jpg', 'admin@tavolate.it'),
('Lasagne al Ragù', 'Lasagne tradizionali alla bolognese.', 13.50, 'lasagne.jpg', 'admin@tavolate.it'),
('Tiramisù della Casa', 'Dolce con mascarpone e cacao.', 5.50, 'tiramisu.jpg', 'admin@tavolate.it');

INSERT INTO APPARTIENE VALUES
(1, 'gym'),
(2, 'vegetariano'),
(2, 'healthy'),
(2, 'senza lattosio'),
(2, 'senza glutine'),
(3, 'gym'),
(3, 'healthy'),
(3, 'senza glutine'),
(3, 'senza lattosio'),
(4, 'healthy'),
(5, 'dolce');

INSERT INTO TAG VALUES
(1, 'healthy'),
(1, 'gym'),
(2, 'vegetariano'),
(2, 'healthy'),
(3, 'dolce'),
(4, 'senza lattosio'),
(4, 'dolce'),
(5, 'vegetariano'),
(5, 'healthy'),
(6, 'senza glutine'),
(6, 'healthy'),
(7, 'healthy'),
(7, 'dolce');


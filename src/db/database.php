<?php
class DatabaseHelper{
    private $db;

    public function __construct($host, $user, $pass, $dbname, $port){
        $this->db = mysqli_init();
        if (!$this->db) {
            throw new Exception("Errore mysqli_init()");
        }

        $caPath = __DIR__ . '/../../cert/ca.pem';
        if (!file_exists($caPath)) {
            throw new Exception("Certificato CA non trovato in: " . $caPath);
        }

        if (!$this->db->ssl_set(null, null, $caPath, null, null)) {
            throw new Exception("Impossibile impostare SSL per mysqli");
        }

        $connected = $this->db->real_connect(
            $host,
            $user,
            $pass,
            $dbname,
            $port,
            null,
            MYSQLI_CLIENT_SSL
        );
        if (!$connected) {
            throw new Exception("Connessione fallita: " . $this->db->connect_error);
        }
    }

    public function checkLogin($email, $password){
        $query = "SELECT *
                FROM UTENTE
                WHERE email = ? AND password = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function registrazione($name, $bio, $email, $password){
        $query = "INSERT INTO UTENTE (email, name, password, bio, ruolo)
                VALUES (?, ?, ?, ?, 'utente')";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssss', $email, $name, $password, $bio);


        try {

            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function inserisciPiatto($nome, $descrizione, $prezzo, $foto, $emailAdmin){
        $query = "INSERT INTO PIATTO_DEL_GIORNO (nome, descrizione, prezzo, foto, emailAdmin)
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssdss', $nome, $descrizione, $prezzo, $foto, $emailAdmin);

        try {
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getPiatto(){
        $query = "SELECT *
                FROM PIATTO_DEL_GIORNO";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deletePiatto($id){
        $query = "DELETE FROM PIATTO_DEL_GIORNO
                WHERE id_piatto = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        try {
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
        
    }

    public function updatePiatto($id, $nome, $descrizione, $prezzo) {
            $query = "UPDATE PIATTO_DEL_GIORNO SET nome = ?, descrizione = ?, prezzo = ?
                WHERE id_piatto = ?";

            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssdi', $nome, $descrizione, $prezzo, $id);

        return $stmt->execute();
    }

public function getTavolate(string $email){
    $query = "
        SELECT
          t.id_tavolata,
          t.stato,
          t.ora,
          t.titolo,
          t.max_persone,

          (SELECT COUNT(*)
           FROM PARTECIPAZIONE p
           WHERE p.id_tavolata = t.id_tavolata) AS num_persone_partecipanti,

          (SELECT u.name
           FROM PARTECIPAZIONE p2
           JOIN UTENTE u ON u.email = p2.email
           WHERE p2.id_tavolata = t.id_tavolata
             AND p2.ruolo = 'organizzatore'
           LIMIT 1) AS organizzatore,

          EXISTS(
            SELECT 1
            FROM PARTECIPAZIONE pm
            WHERE pm.id_tavolata = t.id_tavolata
              AND pm.email = ?
          ) AS gia_partecipa,

          (SELECT pm2.ruolo
           FROM PARTECIPAZIONE pm2
           WHERE pm2.id_tavolata = t.id_tavolata
             AND pm2.email = ?
           LIMIT 1) AS mio_ruolo

        FROM TAVOLATA t
        WHERE t.data = CURDATE()
        ORDER BY t.ora
    ";

    $stmt = $this->db->prepare($query);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $res = $stmt->get_result();
    return $res->fetch_all(MYSQLI_ASSOC);
}


public function partecipaTavolata(int $idTavolata, string $email){
        // Inserimento partecipazione utente
        $qIns = "
            INSERT INTO PARTECIPAZIONE (id_tavolata, email, ruolo)
            SELECT t.id_tavolata, ?, 'ospite'
            FROM TAVOLATA t
            WHERE t.id_tavolata = ?
              AND LOWER(t.stato) = 'aperta'
              AND NOT EXISTS (
                  SELECT 1 FROM PARTECIPAZIONE p
                  WHERE p.id_tavolata = t.id_tavolata AND p.email = ?
              )
              AND (SELECT COUNT(*) FROM PARTECIPAZIONE p2
                   WHERE p2.id_tavolata = t.id_tavolata) < t.max_persone
        ";
        $stmt = $this->db->prepare($qIns);
        $stmt->bind_param("sis", $email, $idTavolata, $email);
        $stmt->execute();

        // Se dopo l'inserimento è piena => chiude
        $qClose = "
            UPDATE TAVOLATA t
            SET t.stato = 'chiusa'
            WHERE t.id_tavolata = ?
              AND (SELECT COUNT(*) FROM PARTECIPAZIONE p
                   WHERE p.id_tavolata = t.id_tavolata) >= t.max_persone
        ";
        $stmt2 = $this->db->prepare($qClose);
        $stmt2->bind_param("i", $idTavolata);
        return $stmt2->execute();
}

public function annullaPartecipazione(int $idTavolata, string $email){

    /* controllo ruolo
    $qRole = "SELECT ruolo FROM PARTECIPAZIONE WHERE id_tavolata = ? AND email = ? LIMIT 1";
    $st = $this->db->prepare($qRole);
    $st->bind_param("is", $idTavolata, $email);
    $st->execute();
    $res = $st->get_result();

    if ($res->num_rows === 0) return false;

    $ruolo = strtolower($res->fetch_assoc()["ruolo"]);
    if ($ruolo === "organizzatore") return false;*/

    // cancella la partecipazione
    $qDel = "DELETE FROM PARTECIPAZIONE WHERE id_tavolata = ? AND email = ?";
    $st2 = $this->db->prepare($qDel);
    $st2->bind_param("is", $idTavolata, $email);
    $st2->execute();

    // se era chiusa -> riapri
    $qReopen = "
        UPDATE TAVOLATA t
        SET t.stato = 'aperta'
        WHERE t.id_tavolata = ?
          AND LOWER(t.stato) = 'chiusa'
          AND (SELECT COUNT(*) FROM PARTECIPAZIONE p WHERE p.id_tavolata = t.id_tavolata) < t.max_persone
    ";
    $st3 = $this->db->prepare($qReopen);
    $st3->bind_param("i", $idTavolata);
    return $st3->execute();
}

public function getMieTavolateOrganizzatore(string $email) {
    $q = "
      SELECT t.*
      FROM TAVOLATA t
      JOIN PARTECIPAZIONE p ON p.id_tavolata = t.id_tavolata
      WHERE p.email = ? AND p.ruolo = 'organizzatore'
      AND t.data >= CURDATE() AND t.ora >= CURTIME()
      ORDER BY t.data DESC, t.ora DESC
    ";
    $st = $this->db->prepare($q);
    $st->bind_param("s", $email);
    $st->execute();
    return $st->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function getMiaTavolataById(int $idTavolata, string $email) {
    $q = "
      SELECT t.*
      FROM TAVOLATA t
      JOIN PARTECIPAZIONE p ON p.id_tavolata = t.id_tavolata
      WHERE t.id_tavolata = ? AND p.email = ? AND p.ruolo = 'organizzatore'
      LIMIT 1
    ";
    $st = $this->db->prepare($q);
    $st->bind_param("is", $idTavolata, $email);
    $st->execute();
    $res = $st->get_result();
    if ($res->num_rows === 0) return null;
    return $res->fetch_assoc();
}

public function creaTavolata(string $titolo, string $data, string $ora, int $maxPersone, string $emailOrg) {
    // inserisci tavolata
    $q1 = "INSERT INTO TAVOLATA (titolo, data, ora, max_persone, stato) VALUES (?, ?, ?, ?, 'aperta')";
    $st1 = $this->db->prepare($q1);
    $st1->bind_param("sssi", $titolo, $data, $ora, $maxPersone);
    if (!$st1->execute()) return false;

    $id = (int)$this->db->insert_id;

    // inserisci partecipazione organizzatore
    $q2 = "INSERT INTO PARTECIPAZIONE (id_tavolata, email, ruolo) VALUES (?, ?, 'organizzatore')";
    $st2 = $this->db->prepare($q2);
    $st2->bind_param("is", $id, $emailOrg);
    return $st2->execute();
}

public function aggiornaTavolata(int $idTavolata, string $titolo, string $data, string $ora, int $maxPersone, string $emailOrg) {
    $q = "
      UPDATE TAVOLATA t
      JOIN PARTECIPAZIONE p ON p.id_tavolata = t.id_tavolata
      SET t.titolo = ?, t.data = ?, t.ora = ?, t.max_persone = ?
      WHERE t.id_tavolata = ? AND p.email = ? AND p.ruolo = 'organizzatore'
    ";
    $st = $this->db->prepare($q);
    $st->bind_param("sssiis", $titolo, $data, $ora, $maxPersone, $idTavolata, $emailOrg);
    return $st->execute();
}

public function creaPrenotazioneOggi(string $email, string $oraInizio, int $posti) {

    $oraFine = 

    // 1) Trovo un tavolo disponibile con posti >= richiesti e non occupato nell'intervallo
    $qTavolo = "
        SELECT t.id_tavolo
        FROM TAVOLO t
        WHERE t.posti >= ?
          AND NOT EXISTS (
              SELECT 1
              FROM RISERVA r
              JOIN PRENOTAZIONE p ON p.id_prenotazione = r.id_prenotazione
              WHERE r.id_tavolo = t.id_tavolo
                AND p.data = CURDATE()
                AND NOT (p.ora_fine <= ? OR p.ora_inizio >= ?)
          )
        ORDER BY t.posti ASC, t.id_tavolo ASC
        LIMIT 1
    ";
    $st = $this->db->prepare($qTavolo);
    $st->bind_param("iss", $posti, $oraInizio, $oraFine);
    $st->execute();
    $res = $st->get_result();
    if ($res->num_rows === 0) return false;

    $idTavolo = (int)$res->fetch_assoc()["id_tavolo"];

    // 2) Inserisco prenotazione
    $qInsPren = "
        INSERT INTO PRENOTAZIONE (data, ora_inizio, ora_fine, n_posti, stato)
        VALUES (CURDATE(), ?, ?, ?, 'confermata')
    ";
    $st2 = $this->db->prepare($qInsPren);
    $st2->bind_param("ssi", $oraInizio, $oraFine, $posti);
    if (!$st2->execute()) return false;

    $idPren = (int)$this->db->insert_id;

    // 3) Collego tavolo
    $qRis = "INSERT INTO RISERVA (id_prenotazione, id_tavolo) VALUES (?, ?)";
    $st3 = $this->db->prepare($qRis);
    $st3->bind_param("ii", $idPren, $idTavolo);
    if (!$st3->execute()) return false;

    // 4) Collego utente
    $qEff = "INSERT INTO EFFETTUA (id_prenotazione, email) VALUES (?, ?)";
    $st4 = $this->db->prepare($qEff);
    $st4->bind_param("is", $idPren, $email);
    if (!$st4->execute()) return false;

    return true;
}

public function getPrenotazioniOggi(string $email): array {
    $q = "
        SELECT
          p.id_prenotazione,
          p.data,
          p.ora_inizio,
          p.ora_fine,
          p.n_posti,
          p.stato,
          t.id_tavolo,
          t.posti AS posti_tavolo
        FROM PRENOTAZIONE p
        JOIN EFFETTUA e ON e.id_prenotazione = p.id_prenotazione
        JOIN RISERVA r ON r.id_prenotazione = p.id_prenotazione
        JOIN TAVOLO t ON t.id_tavolo = r.id_tavolo
        WHERE p.data = CURDATE()
          AND e.email = ?
        ORDER BY p.ora_inizio
    ";
    $st = $this->db->prepare($q);
    $st->bind_param("s", $email);
    $st->execute();
    return $st->get_result()->fetch_all(MYSQLI_ASSOC);
}

    // Funzione per inserire la prenotazione
    public function inserisciPrenotazione($oraInizio, $oraFine, $data, $nPosti, $emailUtente, $idTavolo) {
        // Corretto 'ora_inizic' in 'ora_inizio'
        $query = "INSERT INTO PRENOTAZIONE (stato, ora_inizio, ora_fine, data, nPosti, email, id_tavolo) 
                VALUES ('attiva', ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssisi', $oraInizio, $oraFine, $data, $nPosti, $emailUtente, $idTavolo);
        
        return $stmt->execute();
    }

    // Funzione per trovare il tavolo
    public function trovaTavoloDisponibile($data, $oraInizio, $oraFine, $postiRichiesti) {
        $query = "SELECT id_tavolo 
                FROM TAVOLO 
                WHERE nPosti >= ? 
                AND id_tavolo NOT IN (
                    SELECT id_tavolo 
                    FROM PRENOTAZIONE 
                    WHERE data = ? 
                    AND stato = 'attiva'
                    AND NOT (ora_fine <= ? OR ora_inizio >= ?)
                )
                ORDER BY nPosti ASC 
                LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('isss', $postiRichiesti, $data, $oraInizio, $oraFine);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        return $result ? $result['id_tavolo'] : null;
    }

    // Recupera solo le prenotazioni attive per la gestione sala
    public function getPrenotazioniAttive() {
        $query = "SELECT * FROM PRENOTAZIONE WHERE stato = 'attiva' ORDER BY data ASC, ora_inizio ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Cambia lo stato di una prenotazione in 'archiviata'
    public function archiviaPrenotazione($idPrenotazione) {
        $query = "UPDATE PRENOTAZIONE SET stato = 'archiviata' WHERE id_pren = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idPrenotazione);
        return $stmt->execute();
    }

    public function getPrenotazioniUtente($email) {
        $query = "SELECT * FROM PRENOTAZIONE WHERE email = ? ORDER BY data DESC, ora_inizio DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

}
?>

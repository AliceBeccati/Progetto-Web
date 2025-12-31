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

public function getTavolate(){
    $query = "
        SELECT
            t.id_tavolata,
            t.stato,
            t.ora,
            t.titolo,
            COUNT(DISTINCT p_all.email) AS num_persone_partecipanti,
            t.max_persone,
            u.name AS organizzatore
        FROM TAVOLATA t
        LEFT JOIN PARTECIPAZIONE p_all
               ON p_all.id_tavolata = t.id_tavolata
        LEFT JOIN PARTECIPAZIONE p_org
               ON p_org.id_tavolata = t.id_tavolata
              AND p_org.ruolo = 'organizzatore'
        LEFT JOIN UTENTE u
               ON u.email = p_org.email
        WHERE t.data = CURDATE()
        GROUP BY
            t.id_tavolata, t.stato, t.ora, t.titolo, t.max_persone, u.name
        ORDER BY t.ora
    ";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function partecipaTavolata(int $idTavolata, string $email): bool {
    $this->db->begin_transaction();

    try {
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

        if ($stmt->affected_rows === 0) {
            $this->db->rollback();
            return false;
        }

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
        $stmt2->execute();

        $this->db->commit();
        return true;

    } catch (\Throwable $e) {
        $this->db->rollback();
        return false;
    }
}



}
?>

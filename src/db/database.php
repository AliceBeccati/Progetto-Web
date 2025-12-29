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
            $stmt->bind_param('ssii', $nome, $descrizione, $prezzo, $id);

    return $stmt->execute();
}

}
?>

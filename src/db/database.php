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

        // Attivo SSL
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
        $query = "SELECT email, name, ruolo 
                FROM UTENTE 
                WHERE email = ? AND password = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


}
?>

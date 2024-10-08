<?php
class ModeloUsuario {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Método para buscar usuario por email
    public function buscarPorEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE usu_email = ?");
        
        // Verificar si la preparación de la consulta fue exitosa
        if (!$stmt) {
            die('Error en la consulta SQL: ' . $this->db->error);
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para buscar usuario por token de recuperación
    public function buscarPorToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM seguridad WHERE token_recuperacion = ?");
        
        if (!$stmt) {
            die('Error en la consulta SQL: ' . $this->db->error);
        }

        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Método para guardar el token de recuperación
    public function guardarTokenRecuperacion($userId, $token, $expiracion) {
        $stmt = $this->db->prepare("UPDATE seguridad SET token_recuperacion = ?, token_expiracion = ? WHERE usu_num_doc = ?");
        
        if (!$stmt) {
            die('Error en la consulta SQL: ' . $this->db->error);
        }

        $stmt->bind_param('ssi', $token, $expiracion, $userId);
        return $stmt->execute();
    }

    // Método para actualizar la contraseña
    public function actualizarContraseña($userId, $nuevaContraseña) {
        $stmt = $this->db->prepare("UPDATE seguridad SET seg_clave_hash = ? WHERE usu_num_doc = ?");
        
        if (!$stmt) {
            die('Error en la consulta SQL: ' . $this->db->error);
        }

        $stmt->bind_param('si', $nuevaContraseña, $userId);
        return $stmt->execute();
    }

    // Método para limpiar el token de recuperación después de usarlo
    public function limpiarTokenRecuperacion($userId) {
        $stmt = $this->db->prepare("UPDATE seguridad SET token_recuperacion = NULL, token_expiracion = NULL WHERE usu_num_doc = ?");
        
        if (!$stmt) {
            die('Error en la consulta SQL: ' . $this->db->error);
        }

        $stmt->bind_param('i', $userId);
        return $stmt->execute();
    }
}
?>

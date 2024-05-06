<?php
class Usuario
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function search_by_email($email)
    {
        $sql = "SELECT * FROM usuario WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) return false;

        $usuario = new stdClass();
        while ($row = $result->fetch_assoc()) {
            $usuario->id = $row["id_usuario"];
            $usuario->nombre = $row["nombre"];
            $usuario->apellido = $row["apellido"];
            $usuario->cargo = $row["cargo"];
            $usuario->rol = $row["rol"];
            $usuario->email = $row["email"];
            $usuario->pass = $row["pass"];
        }
        return $usuario;
        $stmt->close();
    }

    public function get_all_users()
    {
        $sql = "SELECT * FROM usuario";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function insert_user($data)
    {
        $sql = "INSERT INTO usuario (nombre, apellido, cargo, email, pass, rol) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssss", $data["name"], $data["lastname"], $data["cargo"], $data["email"], $data["password"], $data["rol"]);
        mysqli_stmt_execute($stmt);
        return $stmt->insert_id;
    }

    public function remove_user($id)
    {
        $sql = "DELETE FROM usuario WHERE id_usuario=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        return $stmt->affected_rows;
    }

    public function search_by_id($id)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result->fetch_assoc();
    }

    public function update_password_user($password, $id)
    {
        $sql = "UPDATE usuario SET pass = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $password, $id);
        $stmt->execute();
        return $stmt->affected_rows;
        $stmt->close();
    }
}

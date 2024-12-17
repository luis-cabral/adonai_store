<?php
class RolVentanas
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsRol_ventanas($estado = 'TODO', $id_ventana = 'TODO', $id_rol = -1)
    {
        // Obtenga el número total de registros de nuestra tabla "rol_ventanas".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener rol_ventanas
        $sql = "SELECT COUNT(*) total_registros FROM rol_ventanas where 1 = 1";
        if ($estado != 'TODO') {
            $sql = "$sql and estado = '$estado'";
        }
        if ($id_rol > -1) {
            $sql = "$sql and id_rol = $id_rol";
        }
        if ($id_ventana != 'TODO') {
            $sql = "$sql and id_ventana = '$id_ventana'";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_registros = $row['total_registros'];
        }
        $stmt->close();
        return $total_registros;
    }

    public function getRolVentanas($estado = 'TODO', $page = 1, $num_results_on_page = 5, $id_rol = -1, $id_ventana = 'TODO')
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener rol_ventanas
        $sql = "SELECT * FROM rol_ventanas where 1 = 1";
        if ($estado != 'TODO') {
            $sql = "$sql and estado = '$estado'";
        }
        if ($id_rol > -1) {
            $sql = "$sql and id_rol = $id_rol";
        }
        if ($id_ventana != 'TODO') {
            $sql = "$sql and id_ventana = '$id_ventana'";
        }
        $sql = "$sql ORDER BY id_ventana, id_rol LIMIT ?,?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("ii", $calc_page, $num_results_on_page);
        if (false === $result) {
            die('bind_param() failed');
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();
        $stmt->close();

        return $result;
    }

    public function getRolVentanaPorRol($id_rol)
    {
        $conn = $this->dbConnect;
        // Función para obtener rol_ventanas
        $sql = "SELECT * FROM rol_ventanas where id_rol = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_rol);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getRolVentanaPorVentana($id_ventana)
    {
        $conn = $this->dbConnect;
        // Función para obtener rol_ventanas
        $sql = "SELECT * FROM rol_ventanas where id_ventana = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_ventana);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function insertRolVentana($_post)
    {
        $conn = $this->dbConnect;
        $id_ventana = mysqli_real_escape_string($conn, $_post['id_ventana']);
        $id_rol = mysqli_real_escape_string($conn, $_post['id_rol']);
        // Insertar rolventana
        $sql = "INSERT INTO rol_ventanas (id_ventana, id_rol) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("si", $id_ventana, $id_rol);
        if (false === $result) {
            die('bind_param() failed');
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

    public function updateRolVentana($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_ventana = mysqli_real_escape_string($conn, $_post['id_ventana']);
        $id_rol = mysqli_real_escape_string($conn, $_post['id_rol']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar rolventana
        $sql = "UPDATE rol_ventanas set estado = ? where id_ventana = ? and id_rol = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("ssi", $estado, $id_ventana, $id_rol);
        if (false === $result) {
            die('bind_param() failed');
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }
}

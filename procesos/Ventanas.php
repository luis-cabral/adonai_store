<?php
class Ventanas
{
    private $dbConnect = null;
    //
    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsVentanas($estado = 'TODO')
    {
        // Obtenga el número total de registros de nuestra tabla "ventanas".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener ventanas
        $sql = "SELECT COUNT(*) total_registros FROM ventanas";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?)";
        } else {
            $sql = "$sql where estado = ?";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("s", $estado);
        if (false === $result) {
            die('bind_param() failed');
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

    public function getVentanas($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener ventanas
        $sql = "SELECT * FROM ventanas";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?) ORDER BY id_ventana LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_ventana LIMIT ?,?";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sii", $estado, $calc_page, $num_results_on_page);
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

    public function getVentanasPorRolGrupo($id_rol, $grupo)
    {
        $conn = $this->dbConnect;
        // Función para obtener ventanas
        $sql = "SELECT distinct vent.id_ventana, vent.descripcion FROM ventanas vent, rol_ventanas rove where rove.id_ventana=vent.id_ventana and vent.estado='ACTIVO' and rove.estado='ACTIVO' and rove.id_rol = ? and vent.grupo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_rol, $grupo);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getGruposVentanasPorRol($id_rol)
    {
        $conn = $this->dbConnect;
        // Función para obtener ventanas
        $sql = "SELECT distinct vent.grupo FROM ventanas vent, rol_ventanas rove where rove.id_ventana=vent.id_ventana and vent.estado='ACTIVO' and rove.estado='ACTIVO' and rove.id_rol = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_rol);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getVentana($id_ventana)
    {
        $conn = $this->dbConnect;
        // Función para obtener ventanas
        $sql = "SELECT * FROM ventanas where id_ventana = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id_ventana);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }
}

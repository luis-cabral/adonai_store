<?php
class Clientes
{
    private $dbConnect = null;

    public function __construct()
    {
        include_once("Conexion.php");
        $Conexion = new Conexion();
        $this->dbConnect = $Conexion->conectar();
    }

    public function getTotalItemsClientes($estado = 'TODO', $id_cliente = -1)
    {
        // Obtenga el número total de registros de nuestra tabla "clientes".
        $total_registros  = 1;
        $conn = $this->dbConnect;
        // Función para obtener clientes
        $sql = "SELECT COUNT(*) total_registros FROM clientes";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?)";
        } else {
            $sql = "$sql where estado = ?";
        }
        if ($id_cliente > -1) {
            $sql = "$sql and id_cliente = ?";
        }
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        if ($id_cliente > -1) {
            $result = $stmt->bind_param("si", $estado, $id_cliente);
        } else {
            $result = $stmt->bind_param("s", $estado);
        }
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

    public function getClientes($estado = 'TODO', $page = 1, $num_results_on_page = 5)
    {
        // Calcule la página para obtener los resultados que necesitamos de nuestra tabla.
        $calc_page = ($page - 1) * $num_results_on_page;
        //
        $conn = $this->dbConnect;
        // Función para obtener clientes
        $sql = "SELECT * FROM clientes";
        if ($estado == 'TODO') {
            $sql = "$sql where estado in ('ACTIVO', 'INACTIVO', ?) ORDER BY id_cliente LIMIT ?,?";
        } else {
            $sql = "$sql where estado = ? ORDER BY id_cliente LIMIT ?,?";
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

    public function getCliente($id_cliente)
    {
        $conn = $this->dbConnect;
        // Función para obtener clientes
        $sql = "SELECT * FROM clientes where id_cliente = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_cliente);
        $result = $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    public function getClientePorCedula($cedula)
    {
        $conn = $this->dbConnect;
        // Función para obtener clientes
        $sql = "SELECT * FROM clientes where cedula = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("s", $cedula);
        if (false === $result) {
            die('bind_param() failed' . $stmt->error);
        }
        $result = $stmt->execute();
        if (false === $result) {
            die('execute() failed: ' . $stmt->error);
        }
        $result = $stmt->get_result();

        return $result;
    }

    public function getNextIdCliente()
    {
        $next_id_cliente = 1;
        $conn = $this->dbConnect;
        // Función para obtener clientes
        $sql = "SELECT coalesce(max(id_cliente), 0) + 1 next_id_cliente FROM clientes";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $next_id_cliente = $row['next_id_cliente'];
        }
        if (!(isset($next_id_cliente) && $next_id_cliente >= 0)) {
            $next_id_cliente = 1;
        }

        return $next_id_cliente;
    }

    public function insertCliente($_post)
    {
        $conn = $this->dbConnect;
        $id_cliente = $this->getNextIdCliente();
        $cedula = mysqli_real_escape_string($conn, $_post['cedula']);
        $ruc = mysqli_real_escape_string($conn, $_post['ruc']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $apellido = mysqli_real_escape_string($conn, $_post['apellido']);
        $direccion = mysqli_real_escape_string($conn, $_post['direccion']);
        $telefono = mysqli_real_escape_string($conn, $_post['telefono']);
        // Insertar cliente
        $sql = "INSERT INTO clientes (id_cliente, cedula, ruc, nombre, apellido, direccion, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("issssss", $id_cliente, $cedula, $ruc, $nombre, $apellido, $direccion, $telefono);
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

    public function updateCliente($_post)
    {
        $conn = $this->dbConnect;
        // Obtener los datos del formulario
        $id_cliente = mysqli_real_escape_string($conn, $_post['id_cliente']);
        $cedula = mysqli_real_escape_string($conn, $_post['cedula']);
        $ruc = mysqli_real_escape_string($conn, $_post['ruc']);
        $nombre = mysqli_real_escape_string($conn, $_post['nombre']);
        $apellido = mysqli_real_escape_string($conn, $_post['apellido']);
        $direccion = mysqli_real_escape_string($conn, $_post['direccion']);
        $telefono = mysqli_real_escape_string($conn, $_post['telefono']);
        $estado = mysqli_real_escape_string($conn, $_post['estado']);

        // Insertar cliente
        $sql = "UPDATE clientes set cedula = ?, ruc = ?, nombre = ?, apellido = ?, direccion = ?, telefono = ?, estado = ? where id_cliente = ?";
        $stmt = $conn->prepare($sql);
        if (false === $stmt) {
            die('prepare() failed: ' . $conn->error);
        }
        $result = $stmt->bind_param("sssssssi", $cedula, $ruc, $nombre, $apellido, $direccion, $telefono, $estado, $id_cliente);
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

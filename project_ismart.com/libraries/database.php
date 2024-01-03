<?php

class Model
{
    public $table;
    public $fields = array();

    public function __construct()
    {
        global $conn;
        if (!$conn) {
            $this->db_connect();
        }
    }

    // Hàm kết nối db
    function db_connect()
    {
        global $conn;
        global $db;
        $conn = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
        mysqli_set_charset($conn, 'UTF8');
        if (!$conn) {
            die("Kết nối không thành công " . mysqli_connect_error());
        }
    }

    // Hàm đóng kết nối db
    public function db_close()
    {
        global $conn;
        return mysqli_close($conn);
    }


    // Hàm select
    public function select($fields = "*", $condition = '1>0', $start = '0', $limit = '')
    {
        global $conn;
        $sql = "SELECT {$fields} FROM {$this->table} WHERE {$condition}";
        if (!empty($limit)) {
            $sql = $sql . " LIMIT {$start}, {$limit}";
        }
        // echo $sql."<br>";
        $mysqli_result = mysqli_query($conn, $sql);
        if ($mysqli_result) {
            $data = array();
            while ($row = mysqli_fetch_assoc($mysqli_result)) {
                $data[] = $row;
            }
            mysqli_free_result($mysqli_result);
            return $data;
        }
        return 0;
    }

    public function add($data)
    {
        global $conn;
        $fields = "(" . implode(", ", array_keys($data)) . ")";
        $values = "";
        foreach ($data as $field => $value) {
            if ($value === NULL)
                $values .= "NULL, ";
            else
                $values .= "'" . escape_string($value) . "', ";
        }
        $values = substr($values, 0, -2);
        db_query("
            INSERT INTO $this->table $fields
            VALUES($values)
        ");
        // $sql = "INSERT INTO $this->table $fields VALUES($values)";
        // echo $sql;
        return mysqli_insert_id($conn);
    }

    public function update($data, $condition)
    {
        global $conn;
        $sql = "";
        foreach ($data as $field => $value) {
            if ($value === NULL)
                $sql .= "$field= NULL, ";
            else
                $sql .= "$field='" . escape_string($value) . "', ";
        }
        $sql = substr($sql, 0, -2);
        db_query("
                UPDATE $this->table
                SET $sql
                WHERE $condition
       ");
        return mysqli_affected_rows($conn);
    }


    function delete($where)
    {
        global $conn;
        $query_string = "DELETE FROM " . $this->table . " WHERE $where";
        db_query($query_string);
        return mysqli_affected_rows($conn);
    }

    function countItems($pk = 'id', $condition = '1>0')
    {
        global $conn;
        $return = array();
        $sql = "SELECT COUNT(`$pk`) AS count FROM `" . $this->table . "` WHERE $condition";
        return mysqli_fetch_row(mysqli_query($conn, $sql));
    }
}




// Hàm kết nối dữ liệu
function db_connect()
{
    global $conn;
    $db = func_get_arg(0);
    $conn = mysqli_connect($db['hostname'], $db['username'], $db['password'], $db['database']);
    mysqli_set_charset($conn, 'UTF8');
    if (!$conn) {
        die("Kết nối không thành công " . mysqli_connect_error());
    }
    //    mysqli_set_charset($conn, "utf8");

}

//Thực thi chuổi truy vấn
function db_query($query_string)
{
    global $conn;
    $result = mysqli_query($conn, $query_string);
    if (!$result) {
        db_sql_error('Query Error', $query_string);
    }
    return $result;
}

// Lấy một dòng trong CSDL
function db_fetch_row($query_string)
{
    global $conn;
    $result = array();
    $mysqli_result = db_query($query_string);
    $result = mysqli_fetch_assoc($mysqli_result);
    mysqli_free_result($mysqli_result);
    return $result;
}

//Lấy một mảng trong CSDL
function db_fetch_array($query_string)
{
    global $conn;
    $result = array();
    $mysqli_result = db_query($query_string);
    while ($row = mysqli_fetch_assoc($mysqli_result)) {
        $result[] = $row;
    }
    mysqli_free_result($mysqli_result);
    return $result;
}
//Lấy số bản ghi
function db_num_rows($query_string)
{
    global $conn;
    $mysqli_result = db_query($query_string);
    return mysqli_num_rows($mysqli_result);
}

function db_insert($table, $data)
{
    global $conn;
    $fields = "(" . implode(", ", array_keys($data)) . ")";
    $values = "";
    foreach ($data as $field => $value) {
        if ($value === NULL)
            $values .= "NULL, ";
        else
            $values .= "'" . escape_string($value) . "', ";
    }
    $values = substr($values, 0, -2);
    db_query("
            INSERT INTO $table $fields
            VALUES($values)
        ");
    return mysqli_insert_id($conn);
}

function db_update($table, $data, $where)
{
    global $conn;
    $sql = "";
    foreach ($data as $field => $value) {
        if ($value === NULL)
            $sql .= "$field=NULL, ";
        else
            $sql .= "$field='" . escape_string($value) . "', ";
    }
    $sql = substr($sql, 0, -2);
    db_query("
            UPDATE $table
            SET $sql
            WHERE $where
   ");
    return mysqli_affected_rows($conn);
}

function db_delete($table, $where)
{
    global $conn;
    $query_string = "DELETE FROM " . $table . " WHERE $where";
    db_query($query_string);
    return mysqli_affected_rows($conn);
}

function escape_string($str)
{
    global $conn;
    return mysqli_real_escape_string($conn, $str);
}

// Hiển thị lỗi SQL

function db_sql_error($message, $query_string = "")
{
    global $conn;

    $sqlerror = "<table width='100%' border='1' cellpadding='0' cellspacing='0'>";
    $sqlerror .= "<tr><th colspan='2'>{$message}</th></tr>";
    $sqlerror .= ($query_string != "") ? "<tr><td nowrap> Query SQL</td><td nowrap>: " . $query_string . "</td></tr>\n" : "";
    $sqlerror .= "<tr><td nowrap> Error Number</td><td nowrap>: " . mysqli_errno($conn) . " " . mysqli_error($conn) . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> Date</td><td nowrap>: " . date("D, F j, Y H:i:s") . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> IP</td><td>: " . getenv("REMOTE_ADDR") . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> Browser</td><td nowrap>: " . getenv("HTTP_USER_AGENT") . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> Script</td><td nowrap>: " . getenv("REQUEST_URI") . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> Referer</td><td nowrap>: " . getenv("HTTP_REFERER") . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> PHP Version </td><td>: " . PHP_VERSION . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> OS</td><td>: " . PHP_OS . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> Server</td><td>: " . getenv("SERVER_SOFTWARE") . "</td></tr>\n";
    $sqlerror .= "<tr><td nowrap> Server Name</td><td>: " . getenv("SERVER_NAME") . "</td></tr>\n";
    $sqlerror .= "</table>";
    $msgbox_messages = "<meta http-equiv=\"refresh\" content=\"9999\">\n<table class='smallgrey' cellspacing=1 cellpadding=0>" . $sqlerror . "</table>";
    echo $msgbox_messages;
    exit;
}

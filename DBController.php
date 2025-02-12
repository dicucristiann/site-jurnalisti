<?php //! Asta cred ca trebuie sters!
class DBController
{
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $database = "store";
    public $conn;
    public $port = '3306';

    function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database, $this->port);
    }

    public function getConnection()
    {
        if (empty($this->conn))
        {
            new DBController();
        }
    }

    function getDBResult($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
        if (!empty($params))
        {
            $this->bindParams($sql_statement, $params);
        }

        $sql_statement->execute();
        $result = $sql_statement->get_result();

        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $resultset[] = $row;
            }
        }

        if (!empty($resultset))
        {
            return $resultset;
        }
    }

    function updateDB($query, $params = array())
    {
        $sql_statement = $this->conn->prepare($query);
        if (!empty($params))
        {
            $this->bindParams($sql_statement, $params);
        }
        $sql_statement->execute();
    }

    function bindParams($sql_statement, $params)
    {
        $param_type = "";
        foreach ($params as $query_param)
        {
            $param_type .= $query_param["param_type"];
        }

        $bind_params[] = &$param_type;
        foreach ($params as $k => $query_param)
        {
            $bind_params[] = &$params[$k]["param_value"];
        }

        call_user_func_array(
            array(
                $sql_statement,
                'bind_param'
            ), $bind_params);
    }
}
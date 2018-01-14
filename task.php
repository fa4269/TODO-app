<?php

class task{
    public $taskCount;
    public $tableName;
    public $db;

    function __construct($tableName, &$db){
        $this->tableName = $tableName;
        $this->db = $db;
        $call = "SELECT * FROM ".$tableName;

        if ($stmt = mysqli_prepare($db, $call)){

            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $this->taskCount = mysqli_stmt_num_rows($stmt);
        }
    }
}

?>
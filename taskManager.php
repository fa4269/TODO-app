<?php

class taskManager{

    public function addTask($obj, $taskName, $taskDate){
        $obj->taskCount = $obj->taskCount + 1;
        mysqli_query($obj->db, "INSERT INTO ".$obj->tableName."(Task_Name, Due_Date) VALUES  ('".$taskName."', '".$taskDate."');");
    }
    public function delTask($obj, $taskID){
        $obj->taskCount = $obj->taskCount - 1;
        mysqli_query($obj->db, "DELETE FROM ".$obj->tableName." WHERE Task_ID=".$taskID.";");
    }
    public function getTasks($obj){
        $call = "SELECT * FROM ".$obj->tableName.";";
        $result = $obj->db->query($call);
        while($row = $result->fetch_assoc()){
            echo $row["Task_ID"]."&emsp;".$row["Task_Name"]."&emsp;".$row["Due_Date"]."&emsp;".$obj->tableName."<br>";
        }
        $result->close();
    }
}

?>
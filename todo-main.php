<?php

class overview {
    private $totalTasks;

    function count($obj1, $obj2, $obj3, $obj4){
        $this->totalTasks = $obj1->taskCount + $obj2->taskCount + $obj3->taskCount + $obj4->taskCount;

    }
    function getCount(){
        return $this->totalTasks;
    }
}

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
            echo $row["Task_ID"]."\t".$row["Task_Name"]."\t".$row["Due_Date"]."\n";
            //printf("%s  %s  %s\n", $row["Task_ID"], $row["Task_Name"], $row["Due_Date"]);
        }
        $result->close();
    }
}

$dbCon=mysqli_connect("localhost", "root", "123abc", "todo");
if(mysqli_connect_errno()){
        echo "Failed to connect ".mysqli_connect_error();
}

$master = new taskManager;

$cMgr = new task("completed", $dbCon);
$pMgr = new task("pending", $dbCon);
$sMgr = new task("strted", $dbCon);
$lMgr = new task("late", $dbCon);

$over = new overview();
$over->count($cMgr, $pMgr, $sMgr, $lMgr);
echo "Total tasks: ".$over->getCount();


if($_POST["Name"] and $_POST["Date"]){
    if($_POST["Status"] == "pending"){
        $master->addTask($pMgr, $_POST["Name"], $_POST["Date"]);
    }
    else if($_POST["Status"] == "completed"){
        $master->addTask($cMgr, $_POST["Name"], $_POST["Date"]);
    }
    else if($_POST["Status"] == "strted"){
        $master->addTask($sMgr, $_POST["Name"], $_POST["Date"]);
    }
    else{
        $master->addTask($lMgr, $_POST["Name"], $_POST["Date"]);
    }
}

if($_POST["ID"]){
    if($_POST["delStatus"] == "pending"){
        $master->delTask($pMgr, $_POST["ID"]);
    }
    else if($_POST["delStatus"] == "completed"){
        $master->delTask($cMgr, $_POST["ID"]);
    }
    else if($_POST["delStatus"] == "strted"){
        $master->delTask($sMgr, $_POST["ID"]);
    }
    else
        $master->delTask($lMgr, $_POST["ID"]);
    }
}

if($_GET['compButton']){$master->getTasks($cMgr);}
if($_GET['strtButton']){$master->getTasks($sMgr);}
if($_GET['pendButton']){$master->getTasks($pMgr);}
if($_GET['lateButton']){$master->getTasks($lMgr);}
if($_GET['iniButton']){initializeDB($dbCon);}


mysqli_close($dbCon);

function initializeDB(&$db){

    echo "database initialized";

    mysqli_query($db, "DROP TABLE IF EXISTS pending, strted, completed, late;");
    mysqli_query($db, "CREATE TABLE pending(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");
    mysqli_query($db, "CREATE TABLE strted(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");
    mysqli_query($db, "CREATE TABLE completed(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");
    mysqli_query($db, "CREATE TABLE late(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");

    mysqli_query($db, "INSERT INTO pending VALUES (1, 'Go to Gym', '9PM');");
    mysqli_query($db, "INSERT INTO pending VALUES (2, 'Cook Breakfast', '8PM');");
    mysqli_query($db, "INSERT INTO strted VALUES (1, 'Create to do list program', '1/15');");
    mysqli_query($db, "INSERT INTO strted VALUES (2, 'Create test data for database', '1/23');");
    mysqli_query($db, "INSERT INTO strted VALUES (3, 'Call mom', '1/30');");
    mysqli_query($db, "INSERT INTO completed VALUES (1, 'Clean house', '1/10');");
    mysqli_query($db, "INSERT INTO completed VALUES (2, 'Do homework', '1/11');");
    mysqli_query($db, "INSERT INTO late VALUES (1, 'Feed dog', '1/14');");


    exit();
}
?>
<html>
<head>
<titles><?php echo ""; ?></titles>
</head>
<body>

<p>
<button id="compButton" name = "compButton" onClick='location.href="?compButton=1"'>Completed Tasks: <?php echo $cMgr->taskCount ?></button><p>
<button id="strtButton" name = "strtButton" onClick='location.href="?strtButton=1"'>Started Tasks: <?php echo $sMgr->taskCount ?></button><p>
<button id="pendButton" name = "pendButton" onClick='location.href="?pendButton=1"'>Pending Tasks: <?php echo $pMgr->taskCount ?></button><p>
<button id="lateButton" name = "lateButton" onClick='location.href="?lateButton=1"'>Late Tasks: <?php echo $lMgr->taskCount ?></button><p>
<button id="dbiniButton" name = "dbiniButton" onClick='location.href="?iniButton=1"'>Initialize Database With Sample Data</button>


    <form action = "<?php $_PHP_SELF ?>" method = "POST">
        Task Name: <input type = "text" name = "Name"/>
        Task Date: <input type = "text" name = "Date"/>
        <select name ="Status">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="strted">Started</option>
            <option value="late">Late</option>
        </select-->
        <input type = "submit" />
    </form>

    <form action = "<?php $_PHP_SELF ?>" method = "POST">
        Task ID: <input type = "text" name = "ID"/>
        <select name ="delStatus">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="strted">Started</option>
            <option value="late">Late</option>
        </select-->
        <input type = "submit" />
    </form>

</body>
</html>
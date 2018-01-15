<!-- 

todo program by Brandon Jackson fa4269


-->

<html>
<body>

<b>ID &emsp; Name &emsp; Due Date &emsp; Status</b><p>

<?php

require_once("overview.php");
require_once("task.php");
require_once("taskManager.php");
//class files

$dbCon = mysqli_connect("localhost", "root", "123abc", "todo");
if(mysqli_connect_errno()){
        echo "Failed to connect ".mysqli_connect_error();
}
//database connection


$master = new taskManager;

$cMgr = new task("completed", $dbCon);
$pMgr = new task("pending", $dbCon);
$sMgr = new task("strted", $dbCon);
$lMgr = new task("late", $dbCon);

$over = new overview();
$over->count($cMgr, $pMgr, $sMgr, $lMgr);


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
    $over->count($cMgr, $pMgr, $sMgr, $lMgr);
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
    else{
        $master->delTask($lMgr, $_POST["ID"]);
    }
    $over->count($cMgr, $pMgr, $sMgr, $lMgr);
}
//buttons

if($_GET['compButton']){$master->getTasks($cMgr);}
if($_GET['strtButton']){$master->getTasks($sMgr);}
if($_GET['pendButton']){$master->getTasks($pMgr);}
if($_GET['lateButton']){$master->getTasks($lMgr);}
if($_GET['showAllButton']){
    $master->getTasks($cMgr); ?><p><?php
    $master->getTasks($sMgr); ?><p><?php 
    $master->getTasks($pMgr); ?><p><?php 
    $master->getTasks($lMgr); ?><p><?php 
}
if($_GET['iniButton']){initializeDB($dbCon);}
//if button pressed

mysqli_close($dbCon);

function initializeDB(&$db){

    echo "Database initialized.";

    mysqli_query($db, "DROP TABLE IF EXISTS pending, strted, completed, late;");
    mysqli_query($db, "CREATE TABLE pending(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");
    mysqli_query($db, "CREATE TABLE strted(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");
    mysqli_query($db, "CREATE TABLE completed(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");
    mysqli_query($db, "CREATE TABLE late(Task_ID int NOT NULL AUTO_INCREMENT, Task_Name varchar(255) NOT NULL, Due_Date varchar(255) NOT NULL, PRIMARY KEY(Task_ID));");

    /*
    mysqli_query($db, "INSERT INTO pending VALUES (1, 'Go to Gym', '9PM');");
    mysqli_query($db, "INSERT INTO pending VALUES (2, 'Cook Breakfast', '8PM');");
    mysqli_query($db, "INSERT INTO strted VALUES (1, 'Create to do list program', '1/15');");
    mysqli_query($db, "INSERT INTO strted VALUES (2, 'Create test data for database', '1/23');");
    mysqli_query($db, "INSERT INTO strted VALUES (3, 'Call mom', '1/30');");
    mysqli_query($db, "INSERT INTO completed VALUES (1, 'Clean house', '1/10');");
    mysqli_query($db, "INSERT INTO completed VALUES (2, 'Do homework', '1/11');");
    mysqli_query($db, "INSERT INTO late VALUES (1, 'Feed dog', '1/14');");
    */

}

?>

<p>
<b>-----------------------------------------------</b><p>

<p>
<button id="showAllButton" name = "showAllButton" onClick='location.href="?showAllButton=1"'>Total Tasks: <?php echo $over->getCount(); ?></button><p>
<button id="compButton" name = "compButton" onClick='location.href="?compButton=1"'>Completed Tasks: <?php echo $cMgr->taskCount ?></button><p>
<button id="strtButton" name = "strtButton" onClick='location.href="?strtButton=1"'>Started Tasks: <?php echo $sMgr->taskCount ?></button><p>
<button id="pendButton" name = "pendButton" onClick='location.href="?pendButton=1"'>Pending Tasks: <?php echo $pMgr->taskCount ?></button><p>
<button id="lateButton" name = "lateButton" onClick='location.href="?lateButton=1"'>Late Tasks: <?php echo $lMgr->taskCount ?></button><p>

<p>
<b>-----------------------------------------------</b>

<p>
<b>Add Task: </b><p>
    <form action = "<?php $_PHP_SELF ?>" method = "POST">
        Task Name: <input type = "text" name = "Name"/>
        Task Date: <input type = "text" name = "Date"/>
        Status: 
        <select name ="Status">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="strted">Started</option>
            <option value="late">Late</option>
        </select-->
        <input type = "submit" />
    </form>
<b>Delete Task: </b><p>
    <form action = "<?php $_PHP_SELF ?>" method = "POST">
        Task ID: <input type = "text" name = "ID"/>
        Status: 
        <select name ="delStatus">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="strted">Started</option>
            <option value="late">Late</option>
        </select-->
        <input type = "submit" />
    </form>

<p><button id="dbiniButton" name = "dbiniButton" onClick='location.href="?iniButton=1"'>Initialize Database (Must be run first time)</button>
</body>
</html>
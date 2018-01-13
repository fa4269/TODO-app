<html>
<head>
<titles><?php echo ""; ?></titles>
</head>
<body>


<!--a href="test.php">Pending Tasks: </a-->

<?php

$dbCon=mysqli_connect("localhost", "root", "123abc", "todo");

if(mysqli_connect_errno())
    {
        echo "Fail" . mysqli_connect_error();
    }

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
    mysqli_query($db, "INSERT INTO strted VALUES (2, '', '1/23');");
    mysqli_query($db, "INSERT INTO strted VALUES (3, '', '1/30');");
    mysqli_query($db, "INSERT INTO completed VALUES ()");

}
?>

    <button id="dbiniButton" name = "dbiniButton" onClick='location.href="?iniButton=1"'>Initialize Database With Sample Data</button>

<!--input type="submit" class="button" name="Initialize" value"Initialize" /-->

<!--form method"post" action=initializeDB()>
    <button type="button">Initialize</button>
</form-->

</body>
</html>
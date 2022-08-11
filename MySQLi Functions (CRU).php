<?php
function  MySQLSelect($Items)
{
    $servername = "localhost";
    $username = "ibrahim";
    $password = "1234";
    $dbname = "Website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT * FROM $Items[0] WHERE $Items[2]=? ";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $Items[1]);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if (empty($user)) {
        $line = "0 results";
    } else {
        $line = $user;
    }
    return $line;

    $stmt->close();
    $conn->close();
}

function MySQLSelectCheck($table, $username, $column)
{
    $SelectItems = [$table, $username, $column];

    $SQLresult = MySQLSelect($SelectItems);

    if ($SQLresult == "0 results") {
        echo $SQLresult;
    } else {
        print_r($SQLresult);
    }
}

// MySQLSelectCheck(
//     "", // Tablename
//     "", // Field Info
//     ""  // Column
// );

function MySQLInsert($tablename, $columns, $Items): false | int
{
    $servername = "localhost";
    $username = "ibrahim";
    $password = "1234";
    $dbname = "Website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $ItemsCount = count($Items);
    $str = [];
    $PreparedAmount = [];

    for ($StrFor = 1; $StrFor <= $ItemsCount; $StrFor++) {
        $str[] = "s";
        $PreparedAmount[] = "?";
    }

    $FinalStr = implode("", $str);
    $PreparedImplode = implode(",", $PreparedAmount);

    $sql = "INSERT INTO $tablename (" . implode(',', $columns) . ")
    VALUES ($PreparedImplode)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("$FinalStr", ...$Items);

    $execute = $stmt->execute();


    if ($execute == false) {

        print_r($stmt->error);
        $result = false;
    } else {
        $result = $stmt->insert_id;
    }

    $stmt->close();
    $conn->close();

    return $result;
}

function MySQLInsertCheck($table, $username, $firstname, $lastname, $password, $column1, $column2, $column3, $column4)
{
    $values = [$username, $firstname, $lastname, $password];
    $columns = [$column1, $column2, $column3, $column4];
    $SQLresult = MySQLInsert($table, $columns, $values);
    echo "Added Values! Number of Rows: " . $SQLresult;
}

// MySQLInsertCheck(
//     "",     // Tablename
//     "",     // Username
//     "",     // Firstname
//     "",     // Lastname
//     "",     // Password
//     "",     // Column1
//     "",     // Column2
//     "",     // Column3
//     ""      // Column4
// );

function MySQLUpdate($tableName, $SetColumns, $WhereColumn, $SetValues, $WhereValues)
{
    $servername = "localhost";
    $username = "ibrahim";
    $password = "1234";
    $dbname = "Website";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $Values = array_merge($SetValues, $WhereValues);
    $SetCount = count($Values) - 1;
    $PreparedAmount = [];

    for ($ForCount = 0; $ForCount <= $SetCount; $ForCount++) {
        $PreparedAmount[] = "s";
    }

    $ImplodeSColumns = implode(",", $SetColumns);
    $ImplodePrepared = implode("", $PreparedAmount);
    $ImplodeWColumns = implode(" ", $WhereColumn);

    $sql = "UPDATE $tableName SET $ImplodeSColumns where $ImplodeWColumns";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("$ImplodePrepared", ...$Values);

    $execute = $stmt->execute();


    if ($execute == false) {

        print_r($stmt->error);
        $result = false;
    } else {
        $result = "Sucessfully Updated";
    }

    $stmt->close();
    $conn->close();

    return $result;
}

function MySQLUpdateCheck($Table, $SetColumns, $WhereColumn, $SetValues, $WhereValue)
{
    $SQLresult = MySQLUpdate($Table, $SetColumns, $WhereColumn, $SetValues, $WhereValue);
    echo $SQLresult;
}

// MySQLUpdateCheck(
//     "", // Tablename
//     [""], // SetColumns
//     [""], // WhereColumns
//     [''], // SetVals
//     []    // WhereVals
// );
?>
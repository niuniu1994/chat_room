<?php
define("USER", "root");
define("PASSWORD", "root");
define("SERVER", "localhost");
define("DATABASE", "efreimessenger");
define("PORT", 8889);

$conn = new mysqli(SERVER, USER, PASSWORD, DATABASE, PORT);

if ($conn->connect_error) {
    die("connect failed: " . $conn->connect_error);
}

function checkVar($var)
{
    $var = str_replace("\n", " ", $var);
    $var = str_replace(" ", "", $var);
    if (isset($var) && !empty($var) && $var != '') {
        return true;
    } else {
        return false;
    }
}

function hasData($sql, $conn)
{
    $res = $conn->query($sql)->num_rows;
    if ($res > 0) {
        return true;
    } else {
        return false;
    }
}

function recycle_username($conn){
    $sql = "select user_name from join_room where to_days(NOW()) - TO_DAYS(last_time) >= 1";
    $rows = $conn->query($sql);
    while ($row = $rows->fetch_assoc()){
        $userName = $row["user_name"];
        $conn->query("delete from join_room where user_name = '$userName'");
        $conn->query("delete from chat_users where username = '$userName'");
    }
}
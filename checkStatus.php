<?php
require_once("utlis.php");
session_start();

/***
 * All api are in this file and the judgement of request dependant on the content of action.
 */

$action = '';
$newName = '';
$roomName = '';
$userName = '';
$text = '';
$res = array();

if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

if (isset($_GET["newName"])) {
    $newName = $_GET["newName"];
}

if (isset($_SESSION["roomName"])){
    $roomName = $_SESSION["roomName"];
}

if (isset($_SESSION["userName"])){
    $userName = $_SESSION["userName"];
}

if (isset($_GET["text"])){
    $text = $_GET["text"];
}

/**
 * check availability of new entered username
 * @return: sta status of name
 */
if ($action == "checkUserName") {

    $sql = "select * from chat_users where username = '$newName'";

    if (!empty($newName)) {
        if (hasData($sql, $conn)) {
            $res['sta'] = "Name unavailable";
        } else {
            $res['sta'] = "Name available";
        }
        echo json_encode($res);
    }
}

/**
 * check availability of new entered room name
 * @return: sta status of name
 */
if ($action == "checkRoomName") {

    $sql = "select * from chat_rooms where name = '$newName'";

    if (!empty($newName)) {
        if (hasData($sql, $conn)) {
            $res['sta'] = "Name unavailable";
        } else {
            $res['sta'] = "Name available";
        }
        echo json_encode($res);
    }
}

/**
 * create new user and store it in database
 * @return: null
 */
if ($action == "createUser") {

    $sql = "select * from chat_users where username = '$newName'";

    if (!hasData($sql, $conn) && !empty($newName)) {
        $sqlInset = "insert into chat_users (username) value ('$newName')";
        $conn->query($sqlInset);
        $_SESSION["userName"] = "$newName";
        $res['sta'] = "User created successfully";
        header("Location:http://localhost:8888/efreimessenger/hall.php");
    } else {
        header("Location: ./");
    }

}

/**
 * return list of room stored in database
 * @return: array of room available
 */
if ($action == "readRooms") {

    $rows = $conn->query("select * from chat_rooms");
    $rooms = array();
    while ($row = $rows->fetch_assoc()) {
        $roomName = $row['name'];
        $numOfUsers = $conn->query("select * from join_room where room_name = '$roomName'")->num_rows;
        $rooms[] = array("name" => $roomName, "num" => $numOfUsers);
    }

    $res['rooms'] = $rooms;
    echo json_encode($res);
}

/**
 * create new room and store it in database
 * @return: null
 */
if ($action == "createRoom") {

    $sql = "select * from chat_rooms where name = '$newName'";

    if (!hasData($sql, $conn) && !empty($newName)) {

        $sql = "insert into chat_rooms (name) value ('$newName')";
        $conn->query($sql);
        $res['sta'] = "User created successfully";
    }
}

/**
 * return all users in the current room
 * @return: array of users
 */
if ($action == "readUsers"){

    if (!empty($roomName)){
        $users= array();
        $rows = $conn->query("select user_name from join_room where room_name = '$roomName'");
        while ($row = $rows->fetch_assoc()) {
            $users[] = array("userName"=> $row['user_name']);
        }
        $res["users"] = $users;
    }
    echo json_encode($res);
}

/**
 * return chat record stored in the database
 * @return: array of record
 */
if ($action == "readChatRecord"){
    if (!empty($roomName)) {
        $records = array();
        $rows = $conn->query("select * from chat_record where room_name = '$roomName'");
        while ($row = $rows->fetch_assoc()){
            $records[] = array("userName"=>$row['user_name'],"text"=>$row['text']);
        }
        $res["records"] = $records;
        echo json_encode($res);
    }
}

/**
 * create new record
 * @return: null
 */
if ($action == "inputText"){
    if (!empty($text)){
        $sql = "insert into chat_record (user_name, room_name, text) values ('$userName','$roomName','$text')";
        $conn->query($sql);
    }
}

if ($action == "quitRoom"){
    $sql = "update join_room set room_name = 'hall' where user_name = '$userName'";
    $conn->query($sql);
}
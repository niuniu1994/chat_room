<?php
session_start();
require_once("utlis.php");
$userName = '';
$roomName = '';

if (checkVar($_SESSION["userName"] && checkVar($_GET["roomName"]))) {
    $userName = $_SESSION["userName"];
    $_SESSION["roomName"] = $_GET["roomName"];
    $roomName = $_SESSION["roomName"];

    $sql = "select * from join_room where user_name = '$userName'";

    /**update room_name(prevent form redundancy)*/
    if (hasData($sql, $conn)) {
        $conn->query("update join_room set room_name = '$roomName' , last_time = NOW() where user_name = '$userName'");
    }

    recycle_username($conn);
}
?>
<!DOCTYPE>
<html lang="en">
<head>
    <title>Chat room</title>
    <link rel="stylesheet" type="text/css" href="css/chatRoom.css"/>
</head>


<body>
<div class="room" id="app" >
    <div class="header">
        <img src="imgs/efrei.png" alt="img not found">
    </div>
    <div>
        <span id="roomName"><?php echo $roomName ?></span>
        <span id="userName">User:<?php echo $userName ?></span>
    </div>
    <div class="chatBord">
        <ul id="chatArea" v-for="record in records">
            <li>{{record.userName}} : {{record.text}}</li>
        </ul>
    </div>
    <div class="inputSection">
        <form id="inputArea">
            <input type="text" id="typeIn" v-model="text">
            <button type="button" id="send" v-on:click="inputText">Send</button>
        </form>
    </div>
    <div class="userSection">
        <ul id="userList" v-for="user in users">
            <li>{{user.userName}}</li>
        </ul>
    </div>
    <div>
        <button id="btn-return"><a href="hall.php"></a>back to hall</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="js/jsChatRooms.js"></script>
</body>
</html>

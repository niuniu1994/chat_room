<?php
session_start();
require_once("utlis.php");

if (checkVar($_SESSION["userName"])):
    $userName = $_SESSION["userName"];
    $_SESSION["roomName"] = "hall";

    $sql = "select * from join_room where user_name = '$userName'";

    if (hasData($sql, $conn)) {
        $conn->query("update join_room set room_name = 'hall', last_time = NOW() where user_name = '$userName'");
    } else {
        $conn->query("insert into join_room (user_name) value ('$userName')");
    }

    recycle_username($conn);
    ?>
    <!DOCTYPE>
    <html lang="en">
    <head>
        <title>Chat room</title>
        <link rel="stylesheet" type="text/css" href="css/hall.css"/>
    </head>
    <body>
    <div class="room" id="app">
        <div class="header">
            <img src="imgs/efrei.png" alt="img not found">
        </div>
        <div class="roomBord">
            <h1 id="hall">Hall</h1>
            <ul id="roomList" v-for="room in rooms" >
                <li><div><a  v-bind:href="'./chatRoom.php?roomName='+room.name">{{room.name}}<span style='color:rgb(234,255,134);'> : {{room.num}} users </span></a></div></li>
            </ul>
        </div>
        <div class="createBord">
            <h3>Create new rome</h3>
            <form method="post">
                <input type="text" id="inputArea" name="newName" v-on:keyup="checkName" v-model="roomName">
                <button type="button" id="create" v-on:click="createRoom">Create</button>
                <div id="roomStatus">
                    {{msg}}
                </div>
            </form>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript" src="js/jsHall.js" ></script>
    </body>
    </html>
<?php
else:
    session_destroy();
    header("Location:./");
endif;
?>
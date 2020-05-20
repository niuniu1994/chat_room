<?php
session_start();
if (!isset($_SESSION["userName"])) :
    ?>
    <!DOCTYPE>
    <html lang="en">
    <head>
        <title>Efrei Messenger</title>
        <link rel="stylesheet" type="text/css" href="css/main.css"/>
    </head>
    <body>
    <div id="app">
        <div class="header">
            <img src="imgs/efrei.png" alt="img not found">
        </div>
        <div class="content">
            <form action="#" method="get">
                User name : <input type="text" class="userName" name="newName" v-on:keyup="checkName()" v-model="username">
                <button  v-on:click="logIn">Enter</button>
            </form>
            <div class="status" id="status" style="color: aqua" v-if="msg">{{msg}}</div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="js/jsIndex.js" type="text/javascript"></script>
    </body>
    </html>
<?php
else:
    header("Location: ./hall.php");
endif;
?>


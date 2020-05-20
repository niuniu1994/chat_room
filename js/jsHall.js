let app = new Vue({
    el: "#app",
    data: {
        roomName: "",
        msg: "",
        status: false,
        rooms: []
    },
    created() {
        this.updateRoomList();
    },
    mounted() {
        window.setInterval(() => {
            this.updateRoomList();
        }, 2000)
    },
    methods: {
        checkName() {
            let regExp = /([a-z]|\d]){0,12}/;
            if (regExp.test(app.roomName)) {
                axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                    params: {
                        newName: app.roomName,
                        action: "checkRoomName"
                    }
                }).then(function (response) {
                    if (response.data.sta === "Name available") {
                        app.status = true;
                    } else {
                        app.status = false;
                    }
                    app.msg = response.data.sta;
                })
            } else {
                app.msg = "Room name can only contain english characters and numbers";
            }
        },

        updateRoomList() {
            axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                params: {
                    action: "readRooms"
                }
            }).then(function (response) {
                app.rooms = response.data.rooms;
            })
        },

        createRoom() {
            if (app.status) {
                axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                    params: {
                        newName: app.roomName,
                        action: "createRoom"
                    }
                }).then(function (response) {
                    app.updateRoomList();
                })
            }
        }
    }

})
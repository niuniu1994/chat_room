let app = new Vue({
    el: "#app",
    data: {
        username: "",
        msg: "",
        status: false,
    },
    methods: {
        checkName() {
            let regExp = /([a-z]|\d]){0,12}/;
            if (regExp.test(app.username)) {
                axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                    params: {
                        newName: app.username,
                        action: "checkUserName"
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
                app.msg = "username can only contain english characters and numbers";
            }
        },

        logIn() {
            if (app.status === true) {
                axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                    params: {
                        newName: app.username,
                        action: "createUser"
                    }
                })
            }
        }
    }
});

let app = new Vue({
    el: "#app",
    data: {
        text: '',
        users: [],
        records: [],
    },
    created() {
    },
    mounted() {
        //window.addEventListener('beforeunload', this.fun());
        this.updateUserList();
        this.updateRecords();
        window.setInterval(() => {
            this.updateUserList();
            this.updateRecords();
        }, 1000)
    },
    methods: {
        updateUserList() {
            axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                params: {
                    action: "readUsers"
                }
            }).then(function (response) {
                app.users = response.data.users;
            })
        },

        updateRecords() {
            axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                params: {
                    action: "readChatRecord"
                }
            }).then(function (response) {
                app.records = response.data.records;
            })
        },

        inputText() {
            if (app.text.length > 0) {
                axios.get("http://localhost:8888/efreimessenger/checkStatus.php?", {
                    params: {
                        action: "inputText",
                        text: app.text
                    }
                }).then(function (response) {
                    app.text = '';
                    this.updateRecords();
                })
            }
        },
    }
})
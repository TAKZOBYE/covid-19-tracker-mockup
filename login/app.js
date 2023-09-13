const app = Vue.createApp({
    data() {
        return {
            url: 'http://10.10.51.144:8888/covid_tracker_sillapa/api',

            username: '',
            password: '',
            errorMessage: '',
        }
    },
    methods: {
        async confirmLogin() {
            try {
                const res = await fetch(`${this.url}/auth/login.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: this.username,
                        password: this.password
                    })
                });

                const data = await res.json();

                console.log(data);

                if (!data.isAuthenticated) {
                    this.errorMessage = data.message;
                    return;
                };

                window.location.pathname = '/dashboard';
            } catch (error) {
                this.errorMessage = error?.message || error;
                console.log(error);
            }
        },
    },
    mounted() {
    },
}).mount('.wrapper');
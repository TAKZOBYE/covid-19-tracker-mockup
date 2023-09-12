const app = Vue.createApp({
    data() {
        return {
            url: 'http://127.0.0.1:8888/covid_tracker_sillapa/api',

            infected: {
                new: 835,
                sum: 1837
            },
            heal: {
                new: 835,
                sum: 1837
            },
            recovered: {
                new: 835,
                sum: 1837
            },
            dead: {
                new: 835,
                sum: 1837
            },

            patients: [],

            typeSelected: 'all',
            dateSelected: null,

        }
    },
    methods: {
        async getDataCount() {
            const res = await fetch(`${this.url}/patient/get_count.php`, {});
            const data = await res.json();

            this.infected = data.infected;
            this.heal = data.heal;
            this.recovered = data.recovered;
            this.dead = data.dead;
        },
        async getPatients() {
            let targetDateFormat = '';

            if (this.dateSelected) {
                targetDateFormat = new Date(this.dateSelected).toISOString().split('T')[0];
            }

            const res = await fetch(`${this.url}/patient/index.php?type=${this.typeSelected}&date=${targetDateFormat}`, {});
            const data = await res.json();

            console.log(data);

            this.patients = data;
        }
    },
    watch: {
        typeSelected() {
            this.getPatients();
        },
        dateSelected() {
            this.getPatients();
        }
    },
    mounted() {
        this.getDataCount();
        this.getPatients();
    },
}).mount('.wrapper');
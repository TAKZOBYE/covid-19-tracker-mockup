const app = Vue.createApp({
    data() {
        return {
            popupDisplay: false,

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
            patient: {},

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
        },
        editPatient(data) {
            this.patient = { ...data };
            this.popupDisplay = true;
        },
        async confirmPatient() {
            const res = await fetch(`${this.url}/patient/edit.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    patientId: this.patient.patientId,
                    firstName: this.patient.firstName,
                    lastName: this.patient.lastName,
                    age: this.patient.age,
                    sex: this.patient.sex,
                    hospitalId: this.patient.hospitalId,
                    // infectedDate: this.patient.infectedDate,
                    // healDate: this.patient.healDate,
                    // recoveredDate: this.patient.recoveredDate,
                    // deadDate: this.patient.deadDate,
                })
            });

            const data = await res.json();

            console.log(data);

            // console.log(data);
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
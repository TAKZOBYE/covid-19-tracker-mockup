const app = Vue.createApp({
    data() {
        return {
            popupDisplay: false,

            url: 'http://10.10.51.144:8888/covid_tracker_sillapa/api',

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
        async checkAuth() {
            try {
                const res = await fetch(`${this.url}/auth/index.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                
                
                const data = await res.json();
                
                if (!data.isAuthenticated) {
                    window.location.pathname = '/login';
                }

                console.log(data);

                this.getDataCount();
                this.getPatients();
            } catch (error) {
                console.log(error);
            }
        },
        async getDataCount() {
            try {
                const res = await fetch(`${this.url}/patient/get_count.php`, {});
                const data = await res.json();

                this.infected = data.infected;
                this.heal = data.heal;
                this.recovered = data.recovered;
                this.dead = data.dead;
            } catch (error) {
                console.log(error);
            }
        },
        async getPatients() {
            try {
                let targetDateFormat = '';

                if (this.dateSelected) {
                    targetDateFormat = new Date(this.dateSelected).toISOString().split('T')[0];
                }

                const res = await fetch(`${this.url}/patient/index.php?type=${this.typeSelected}&date=${targetDateFormat}`, {});
                const data = await res.json();

                console.log(data);

                this.patients = data;
            } catch (error) {
                console.log(error);
            }
        },
        editPatient(data) {
            this.patient = { ...data };
            this.popupDisplay = 'edit';
        },
        async deletePatient() {
            const res = await fetch(`${this.url}/patient/delete.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    patientId: this.patient.patientId
                })
            });

            await res.json();
            await this.getPatients();

            this.patient = {};
            this.popupDisplay = false;
        },
        async confirmPatient() {
            try {
                const url = this.popupDisplay == 'add' ? `${this.url}/patient/add.php` : `${this.url}/patient/edit.php`

                const res = await fetch(url, {
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
                        infectedDate: this.patient.infectedDate,
                        healDate: this.patient.healDate,
                        recoveredDate: this.patient.recoveredDate,
                        deadDate: this.patient.deadDate,
                    })
                });

                const data = await res.text();

                console.log(data);

                await this.getPatients();

                this.patient = {};
                this.popupDisplay = false;
            } catch (error) {
                console.log(error);
            }
        },
        async logout () {
            try {
                const res = await fetch(`${this.url}/auth/logout.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ })
                });

                await res.json();

                this.patient = {};
                this.popupDisplay = false;

                this.checkAuth();
            } catch (error) {
                console.log(error);
            }
        },
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
        this.checkAuth();
    },
}).mount('.wrapper');
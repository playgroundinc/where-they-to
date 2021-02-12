<template>
    <div>
        <div class="hero">
            <h1>Where They To</h1>
            <Button 
                label="Get Started"
                link="/register"
            />
        </div>
        <main>
            <form>
                <div class="row">
                    <div class="col-md-4">
                        <Input 
                            type="date"
                            name="date"
                            :value="today"
                            v-on:update="getTodaysEvents"
                        />
                    </div>
                    <div class="col-md-4">
                        <Input
                            name="province"
                            type="select"
                            :value="province"
                            :options="provinces"
                            v-on:update="updateValue"
                        />
                    </div>
                    <div class="col-md-4">
                        <Input 
                            v-if="'OE' === province || '' === province"
                            name="timezone"
                            :value="timezone"
                            type="select"
                            :required="true"
                            :errors="errors"
                            :options="timezones"
                            v-on:update="updateValue"            
                        />
                        <Autocomplete 
                            v-if="'OE' !== province && '' !== province && '' === city"
                            :errors="errors"
                            label="City"
                            route="cities"
                            :additionalRoute="province"
                            :currentValue="city"
                            v-on:selection="updateCity"
                        />
                        <Input 
                            v-else-if="'' !== city"
                            name="city"
                            :value="city"
                            type="text"
                            :required="true"
                            :errors="errors"
                            :disabled="true"
                            :clearButton="true"
                            v-on:update="updateValue"
                        />
                    </div>
                </div>
            </form>
            <h2>On Tonight</h2>
            <ul v-if="todaysEvents.events && todaysEvents.events.length"> 
                <li v-for="event in todaysEvents.events" v-bind:key="event.id">
                    <a :href="'/events/' + event.id">{{ event.name }}</a>
                </li>
            </ul>
            <p v-else>No one you're following has an event this night.</p>
            <h2>This Week</h2>
            <div v-if="weeksEvents"> 
                <div v-for="(date, key) in weeksEvents" v-bind:key="date">
                    <h3>{{ key }}</h3>
                    <ul>
                        <li v-for="event in date.events" v-bind:key="event.id">
                            <a :href="'/events/' + event.id">{{ event.name }}</a>
                        </li>
                    </ul>            
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    import Location from "../Location";

    import Button from "../components/Button";
    import Input from "../components/Input";
    import Autocomplete from "../components/Autocomplete";

    export default {
        data() {
            return {
                errors: [],
                todaysEvents: [],
                weeksEvents: [],
                province: "",
                cities: [],
                city: "",
                date: '',
                timezone: '',
            }
        },
        computed: {
            ...mapState(['user']),
            dateObj() {
                return new Date();
            },
            day() {
                return  this.dateObj.getDate();
            },
            year() {
                return this.dateObj.getFullYear();
            },
            month() {
                let month = this.dateObj.getMonth() + 1;
                if (Number(month) < 10) {
                    month = '0' + month;
                }
                return month;
            },
            today: {
                get: function() {
                    if (this.date === '') {
                        const todaysDate = `${this.year}-${this.month}-${this.day}`;
                        this.date = todaysDate;
                    }
                    return this.date;
                },
                set: function(update) {
                    this.date = update;
                }
            },
            location() {
                return new Location();
            },
            provinces() {
                return this.location.getProvinces();
            },
            timezones() {
                return this.location.getTimezones();
            }
        },
        components: {
            Autocomplete,
            Button,
            Input,
        },
        methods: {
            updateCity: function(selection) {
                this.city = selection.name;
            },
            updateValue: function(updateObject) {
                this[updateObject.name] = updateObject.value;
            },
            getTodaysEvents: async function(updateObject) {
                try {
                    if (updateObject) {
                        this.updateValue(updateObject);
                    }
                    const resp = await this.$store.dispatch('fetchDate', {
                        date: this.today,
                    });
                    if (resp.status === 200) {
                        this.todaysEvents = resp.data;
                        this.getThisWeeksEvents();
                    }
                } catch(err) {
                    console.log(err);
                }
            },
            getThisWeeksEvents: async function() {
                try {
                    const resp = await this.$store.dispatch('fetchDate', {
                        date: `week/${this.today}`,
                    });
                    if (resp.status === 200) {
                        this.weeksEvents = resp.data;
                    }
                } catch(err) {
                    console.log(err);
                }
            }
        },
        mounted() {
            this.getTodaysEvents();
        }
    }
</script>
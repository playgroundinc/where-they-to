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
                            v-on:update="updateValue"
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
            <ul v-if="todays.length"> 
                <li v-for="event in todays" v-bind:key="event.id">
                    <a :href="'/events/' + event.id">{{ event.name }}</a>
                </li>
            </ul>
            <h2>This Week</h2>
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
                todays: {},
                weeks: [],
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
                    console.log(update);
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
            }
        },
        mounted() {
            

            // this.$store.dispatch('fetchDate', {
            //     parameter: 'date',
            //     date: today,
            // }).then((response) => {
            //     this.todays = JSON.parse(response.data.events);
            // });
            // const tempArray = [];
            // for (let i = 1; i < 7; i = i + 1) {
            //     const thisWeeks = {};
            //     let weekdate = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate() + i}`;
            //     this.$store.dispatch('fetchDate', {
            //         parameter: 'date',
            //         date: weekdate,
            //     }).then((response) => {
            //         thisWeeks[response.data.date] = JSON.parse(response.data.events);
            //         tempArray.push(thisWeeks);
            //     });
            // }
            // this.weeks = tempArray;
        }
    }
</script>
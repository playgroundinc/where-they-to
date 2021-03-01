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
                            v-on:update="handleDateChange"
                        />
                    </div>
                    <div class="col-md-4">
                        <Button 
                            label="Clear filters"
                            v-on:clicked="clearFilters"
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
                <div v-for="(date, key) in weeksEventsFiltered" v-bind:key="key">
                    <h3>{{ key }}</h3>
                    <ul>
                        <li v-for="event in date.events" v-bind:key="event.id">
                            <a :href="'/events/' + event.id">{{ event.name }}</a>
                        </li>
                        <Button
                            v-if="date.page + 1 <= date.total"
                            label="View more" 
                            v-on:clicked="loadMoreEvents(key, date.date, date.page)"   
                        />
                    </ul>            
                </div>
            </div>
        </main>
    </div>
</template>

<script>
    import { mapState } from 'vuex'

    import Location from "../core/Location";

    import Button from "../components/Button";
    import Input from "../components/Input";
    import Autocomplete from "../components/Autocomplete";

    export default {
        data() {
            return {
                errors: [],
                todaysEvents: [],
                todaysEventsFiltered: {},
                weeksEvents: [],
                weeksEventsFiltered: {},
                date: '',
            }
        },
        computed: {
            ...mapState(['user']),
            dateObj() {
                return new Date();
            },
            day() {
                const date = this.dateObj.getDate();
                if (Number(date) < 10) {
                    return '0' + date;
                }
                return  date;
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
            },
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
            getTodaysEvents: async function() {
                try {
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
            handleDateChange: async function(updateObject) {
                try {
                    this.updateValue(updateObject);
                    await this.getTodaysEvents();
                    await this.getThisWeeksEvents();
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
                        this.updateValue({ name: 'weeksEvents', value: {}});
                        this.updateValue({ name: 'weeksEventsFiltered', value: {}});
                        for (let date in resp.data) {
                            this.weeksEventsFiltered[date] = resp.data[date];
                        }
                        this.weeksEvents = resp.data;
                    }
                } catch(err) {
                    console.log(err);
                }
            },
            loadMoreEvents: async function(key, date, page) {
                try {
                    const resp = await this.$store.dispatch('fetchDate', {
                        date,
                        query: `page=${page}`,
                    })
                    if (resp.status === 200) {
                        this.weeksEvents[key].events = this.weeksEvents[key].events.concat(resp.data.events);
                        this.weeksEvents[key].page = resp.data.page
                    }
                } catch(err) {
                    console.log(err);
                }
                
            },
            clearFilters: function() {
                this.updateValue({ name: "today", value: ''});
                this.getTodaysEvents();
            }
        },
        
        mounted() {
            this.getTodaysEvents();
        }
    }
</script>
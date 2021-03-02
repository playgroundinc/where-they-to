<template>
    <main>
        <div class="container">
            <h1 class="copy--center">Search</h1>
        </div>
        <ErrorsContainer :errors="errors"/>
        <form v-on:submit.prevent="handleSubmit" novalidate>
            <div class="row">
                <div class="col-md-3">
                    <Input 
                        name="category"
                        :value="category"
                        type="select"
                        :options="types"
                        v-on:update="updateValue"
                        :defaultValue="false"
                    />
                </div>
                <div class="col-md-9">
                    <Input 
                        :errors="errors"
                        name="search"
                        :value="search"
                        type="text"
                        v-on:update="updateValue"
                    />
                </div>
            </div>
            <Filters 
                :type="category"
                :accessibility="accessibility"
                :venue="venue"
                :province="province"
                :city="city"
                :timezone="timezone"
                v-on:update="updateValue"
                :date="today"
                :family="family"
                :families="families"
                :performers="performers"
                :eventTypes="eventTypes"
                :performerTypes="performerTypes"
            />
            <div class="row">
                <div class="col-md-12">
                    <Button 
                        label="Search"
                        variation="input"
                    />
                </div>
            </div>
            <SearchResult 
                :results="searchResults.current"
                :total="searchResults.total"
                :page="searchResults.page"
                v-on:loadMore="loadMore"
            />
            
        </form>
    </main>
</template>
<script>
import { mapState } from "vuex";

import Accessibility from "../components/Accessibility";
import Button from "../components/Button";
import ErrorsContainer from "../components/ErrorsContainer";
import Input from "../components/Input";
import Filters from "../components/Filters"
import SearchResult from "../components/SearchResult";

//Components

export default {
    data() {
        return {
            accessibility: [],
            errors: [],
            search: '',
            date: '',
            types: {
                events: 'Events',
                performers: 'Performers',
                venues: 'Venues',
                families: 'Families'
            },
            route: '',
            searchResults: [],
            venue: '',
            province: '',
            city: '',
            timezone: '',
            family: '',
            performers: [],
            eventTypes: [],
            performerTypes: [],
            page: 0,
            total: 0,
        };
    },
    computed: {
        ...mapState(['user']),
        category: {
            get: function() {
                if (this.route === '') {
                    this.route = 'events';
                    return this.route;
                }
                return this.route;
            },
            set: function(newValue) {
                if (newValue === '') {
                    this.route = 'events';
                    return;
                }
                this.route = newValue;
            }
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
        dateObj() {
            return new Date();
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
        valid: function() {
            return this.errors.length > 0;
        },
        families: {
            get: function() {
                return this.family;
            },
            set: function(value) {
                this.family = value;
            }
        },
        nextPage: function() {
            return Number(this.page) + 1;
        }
    },
    components: {
        Accessibility,
        Button,
        ErrorsContainer,
        Filters,
        Input,
        SearchResult,
    },
    methods: {
        clearResults: function() {
            this.page = 0;
            this.searchResults = {
                current: [],
                total: 0,
                page: 0,
            }
        },
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
        buildQuery: function() {
            let fields = [];
            if (this.route === 'events') {
                fields = ['family', 'eventTypes', 'date', 'city', 'performers', 'province', 'venue', 'timezone', 'accessibility', 'page'];
            } else if (this.route === 'performers') {
                fields = ['families', 'performerTypes'];
            } else if (this.route === 'venues') {
                fields = ['province', 'city'];
            } else if (this.route === 'families') {
                fields = ['performers'];
            }
            let first = true;
            let query = '';
            fields.forEach((field) => { 
                if (this[field] && this[field] !== '' ) {
                    let value;
                    if (field === 'performers' || field === 'eventTypes') {
                        value = this[field].map((item) => {
                            if (item.name) {
                                return encodeURIComponent(item.name);
                            }
                            return encodeURIComponent(item);
                        });
                    } else if (field === 'city') {
                        value = this[field].replace('_', ' ');
                        value = encodeURIComponent(value);
                    } else {
                        value = encodeURIComponent(this[field]);
                    }
                    if (Array.isArray(value)) { 
                        value = value.join();
                    }
                    if (first) {
                        query += `${field}=${value}`;
                        first = false;
                    } else {
                        query += `&${field}=${value}`;
                    }
                }
            });
            return query;
        },
        handleSubmit: async function() {
            this.clearResults();
            const query = this.buildQuery();
            const term = this.search !== '' ? this.search : '*';
            const resp = await this.$store.dispatch('search', { route: this.route, term, query });
            if (resp.status === 200) { 
                this.searchResults = resp.data;
            }
        },
        loadMore: async function() {
            this.updateValue({ name: 'page', value: this.nextPage });
            const query = this.buildQuery();
            const term = this.search !== '' ? this.search : '*';
            const resp = await this.$store.dispatch('search', { route: this.route, term, query });
            if (resp.status === 200) {
                const events = resp.data;
                const currentEvents = this.searchResults.current;
                events.current = currentEvents.concat(events.current);
                console.log(events);
                this.updateValue('page', events.page);
                this.updateValue({
                    name: 'searchResults',
                    value: events,
                })
            }
        }
    }
};
</script>

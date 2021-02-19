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
                :date="date"
                :family="family"
                :performers="performers"
                :eventTypes="eventTypes"
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
                :results="searchResults"
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
                families: 'families'
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
        valid: function() {
            return this.errors.length > 0;
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
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
        buildQuery: function() {
            const fields = ['family', 'eventTypes', 'date', 'city', 'performers', 'province', 'venue', 'timezone', 'accessibility'];
            let first = true;
            let query = '';
            fields.forEach((field) => { 
                if (this[field] && this[field] !== '' && this[field].length ) {
                    let value;
                    if (field === 'performers' || field === 'eventTypes') {
                        value = this[field].map((item) => {
                            if (item.name) {
                                return encodeURIComponent(item.name);
                            }
                            return encodeURIComponent(item);
                        });
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
            console.log(query);
            return query;
        },
        handleSubmit: async function() {
            const query = this.buildQuery();
            const term = this.search !== '' ? this.search : '*';
            const resp = await this.$store.dispatch('search', { route: this.route, term, query });
            if (resp.status === 200) { 
                this.searchResults = resp.data;
            }
        }
    }
};
</script>

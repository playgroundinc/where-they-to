<template>
    <main>
        <div class="container">
            <h1 class="copy--center">Search</h1>
        </div>
        <ErrorsContainer :errors="errors"/>

        <form v-on:submit.prevent="handleSubmit">
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
            <div class="row" v-if="category === 'events'">
                <Accessibility 
					:value="accessibility"
					v-on:update="updateValue"
				/>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <Button 
                        label="Search"
                        variation="input"
                    />
                </div>
            </div>
            
            
        </form>
    </main>
</template>
<script>
import { mapState } from "vuex";

import Form from "../core/form";

import Accessibility from "../components/Accessibility";
import Button from "../components/Button";
import ErrorsContainer from "../components/ErrorsContainer";
import Input from "../components/Input";

//Components

export default {
    data() {
        return {
            accessibility: [],
            errors: [],
            search: '',
            types: {
                events: 'Events',
                performers: 'Performers',
                venues: 'Venues',
                families: 'families'
            },
            route: '',
            searchResults: [],
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
        Input,
    },
    methods: {
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
        handleSubmit: async function() {
            const data = {
                search: this.search,
            }
            const FormClass = new Form(data, "search", data);
			this.errors = FormClass.checkRequiredFields(data);
            if (!this.valid) {
                const resp = await this.$store.dispatch('search', { route: this.route, term: this.search});
                if (resp.status === 200) { 
                    this.searchResults = resp.data[this.route];
                }
            }
        }
    }
};
</script>

// This is a template for an autocomplete input
// When a selection is made it emits a "selection" action
// Takes in an array as "values"

<template>
    <div class="autocomplete">
        <div class="row">
            <div class="col-xxs-12">
                <label :for="this.labelId" class="label label--floating">
                    <span :class="floating">{{this.label}}</span>
                </label>
                <input 
                    type="text" 
                    :id="this.labelId" 
                    v-model="query" class="input" 
                    @keyup="addAutocomplete" 
                    v-on:focus="floatLabel"
                    v-on:blur="descendLabel"
                />
                <ul>
                    <li v-if="searching">Searching...</li>
                    <li
                        v-else-if="matches.length > 0"
                        v-for="match in matches"
                        v-bind:key="match.id"
                    >
                        <a @click.prevent="function() { handleSelect(match) }" href="#">{{ match.name }}</a>
                    </li>
                    <li v-else-if="query">No results found. <a href="#" @click.prevent="function() { newTerm(query) }">Add a new term.</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    data() {
        return {
            query: "",
            timer: null,
            matches: [],
            searching: false,
            floating: 'sink',
        };
    },
    props: {
        label: {
            type: String,
            required: true,
        },
        values: { 
            type: Array,
            required: true,
        },
        currentArray: {
            type: Array,
            required:false,
        },
        currentValue: {
            type: String,
            required: false,
        }
    },
    computed: {
        labelId() {
            return this.label.toLowerCase();
        }
    },
    methods: {
        addAutocomplete: function() {
            clearTimeout(this.timer);
            this.matches = [];
            this.searching = true;
            this.timer = setTimeout(this.handleAutocomplete, 200);
            return;
            this.searching = false;
        },
        handleAutocomplete: function() {
            if (this.query.length > 0) {
                const regExp = new RegExp(`${this.query}`, "gi");
                this.matches = this.values.filter(value => {
                    return regExp.test(value.name);
                });
                if (this.matches > 10) {
                    this.matches = this.matches.slice(0, 10);
                }
            }
            this.searching = false;
        },
        handleSelect: function(performer) {
            this.clearQuery();
            this.$emit("selection", performer);
        },
        clearQuery: function() {
            this.matches = [];
            this.query = "";
        },
        newTerm: function(term) {
            this.clearQuery();
            this.$emit("new", term);
        },
        floatLabel: function(e) {
            this.floating = "float";
        },
        descendLabel: function() {
            if (this.value === "") {
                this.floating = "sink";
            } else {
                this.floating = "float";
            }
        }
    }
};
</script>

<template>
    <div class="autocomplete">
        <label :for="this.labelId">{{this.label}}</label>
        <input type="text" :id="this.labelId" v-model="query" @keyup="addAutocomplete" />
        <ul>
            <li v-if="searching">Searching...</li>
            <li
                v-else-if="matches.length > 0"
                v-for="match in matches"
                v-bind:key="match.id"
                v-text="match.name"
                @click.prevent="function() { handleSelect(match) }"
            ></li>
            <li v-else>No results found. Please try a different term</li>
        </ul>
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
            searching: false
        };
    },
    props: {
        label: String,
        values: Array
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
            this.timer = setTimeout(this.handleAutocomplete, 2000);
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
            this.$emit("selection", performer);
        }
    }
};
</script>

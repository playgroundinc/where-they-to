// This is a template for an autocomplete input
// When a selection is made it emits a "selection" action
// Takes in an array as "value"

<template>
    <div class="autocomplete">
        <div class="row">
            <div class="col-xxs-12">
                <Input
                    :name="label"
                    :value="value"
                    type="text"
                    :required="true"
                    :errors="errors"
                    v-on:update="addAutocomplete"
                />
                <ul class="autocomplete__list row">
                    <li class="col-xxs-12 autocomplete__single no-link" v-if="searching && acitveSearch">Searching...</li>
                    <li 
                        class="autocomplete__single col-xxs-12 col-md-4"
                        v-else-if="matches.length > 0"
                        v-for="match in matches"
                        v-bind:key="match.id"
                    >
                        <a class="autocomplete__single__link" @click.prevent="function() { handleSelect(match) }" href="#">{{ match.name }}</a>
                    </li>
                    <li class="autocomplete__single col-xxs-12 no-link" v-else-if="value">No results found. <a href="#" @click.prevent="function() { newTerm(value) }">Add a new term.</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";

// Components 
import Input from "../components/Input";

export default {
    data() {
        return {
            value: "",
            timer: null,
            matches: [],
            searching: false,
            floating: 'sink',
        };
    },
    components: {
        Input,
    },
    props: {
        errors: {
            type: Array,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        route: {
            type: String, 
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
		},
		acitveSearch() {
			return this.value !== '';
		}
    },
    methods: {
        updateValue: function(updateObject) {
            this.value = updateObject.value;
		},
        addAutocomplete: function(updateObject) {
            this.updateValue(updateObject);
            clearTimeout(this.timer);
            this.matches = [];
            this.searching = true;
            this.timer = setTimeout(this.handleAutocomplete, 1000);
            return;
        },
        triggerSearch: async function() {
            const resp = await this.$store.dispatch('search', { route: this.route, term: this.value });
            if (resp.status === 200) {
                return resp.data[this.route];
            }
            return [];
        },
        handleAutocomplete: async function() {
			if (!this.acitveSearch) {
				return;
			}
            this.matches = await this.triggerSearch()
            this.searching = false;
        },
        handleSelect: function(selection) {
            this.clearQuery();
            this.$emit("selection", selection);
        },
        clearQuery: function() {
            this.matches = [];
            this.value = "";
        },
        newTerm: function(term) {
            // this.clearQuery();
            this.$emit("new", term);
        },
    }
};
</script>

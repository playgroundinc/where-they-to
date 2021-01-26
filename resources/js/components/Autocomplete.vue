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
                    <li class="autocomplete__single col-xxs-12 no-link" v-else-if="value">No results found. <a href="#" @click.prevent="toggleModal">Add a new term.</a></li>
                </ul>
            </div>
			<Modal
				title="Are you sure?"
				:open="newTermModal"
				:copy="'Looks like you\'re the first person to use this tag. Please confirm the spelling of your tag before hitting the button below. The spelling you\'ve provided is \' ' + value + ' \''"
				button="Yes, I'm sure."
				v-on:close="toggleModal"
				v-on:confirm="newTerm"
			/>
        </div>

    </div>
</template>

<script>
import { mapState } from "vuex";

// Components 
import Input from "../components/Input";
import Modal from "../components/Modal";

export default {
    data() {
        return {
            value: "",
            timer: null,
            matches: [],
            searching: false,
			floating: 'sink',
			newTermModal: false,
        };
    },
    components: {
		Input,
		Modal,
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
		additionalRoute: {
			type: String,
			required: false,
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
		},
		activeRoute() {
			const route = this.additionalRoute ? `${this.route}/${this.additionalRoute}` : this.route;
			return route;
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
          console.log(this.activeRoute);
            const resp = await this.$store.dispatch('search', { route: this.activeRoute, term: this.value });
            
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
		toggleModal: function() {
			this.newTermModal = !this.newTermModal;
		},
		newTerm: function() {
			this.$emit('new', this.value);
			this.toggleModal();
		}

    }
};
</script>

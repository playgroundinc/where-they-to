<template>
    <div class="row form-group">
        <div class="col-xxs-12">
            <h3 class="copy--center">{{ type }} Types</h3>
        </div>
        <div class="col-xxs-12 col-md-6">
            <Autocomplete 
                :label="label"
                :errors="errors"
                :route="route"
                :values="allTypes"
                v-on:new="addTerm"
                v-on:selection="updateValue"
            />
        </div>
        <div class="col-xxs-12 col-md-6">
            <p class="label label--floating"><span class="float">Current Selections</span></p>
            <ul class="row selections__list">
                <li class="selections__single col-md-4 col-xxs-6" v-for="type in currentTypes" v-bind:key="type.id">
                    <a href="#" class="selections__single__link" @click.prevent="function() { removeValue(type.id) }">
                        {{ type.name }} 
                        <svg class="selections__single__close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" height="18" width="18" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
import Input from "./Input";
import Autocomplete from "./Autocomplete";
export default {
    data() {
        return {
            allTypes: [],
        }
    },
    computed: {
        currentTypes: function() {
            return this.allTypes.filter((type) => {
                return this.types.includes(type.id);
            });
        },
        label: function() {
            return `${this.type}_types`
        }
    },
    props: {
        errors: {
            type: Array,
            required: true,
        },
        types: {
            type: Array,
            required: true,
        },
        route: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
    },
    components: {
        Input,
        Autocomplete
    },
    mounted() {
        this.getAllTypes();
    },
    methods: {
        updateValue: function(updateObject) {
            const updateArray = {
                name: this.route,
                add: true,
                value: updateObject.id,
            }
            this.$emit("update", updateArray);
        },
        removeValue: function(updateObject) {
            const updateArray = {
                name: this.route,
                add: false,
                value: updateObject,
            };
            this.$emit("update", updateArray);
        },
        getAllTypes: async function() {
            try {
                const resp = await this.$store.dispatch('fetchState', { route: this.route });
                if (resp.data) {
                    this.allTypes = resp.data;
                }
            } catch (err) {
                console.log(err);
            }
        },
        addTerm: async function(term) {
            const data = {
                name: term,
                type: this.type,
            }
            const payload = {
                route: "types",
                data,
            }
            const resp = await this.$store.dispatch('create', payload);
            if (resp && resp.data && resp.data.addition) {
                this.updateValue(resp.data.addition);
                this.getAllTypes();
            }
        }
    }
}
</script>

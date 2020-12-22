<template>
    <div class="row form-group">
        <div class="col-xxs-12">
            <h3 class="copy--center">Performer Types</h3>
        </div>
        <div class="col-xxs-12 col-md-6">
            <Autocomplete 
                label="Performer Types"
                :values="allPerformerTypes"
                v-on:new="addTerm"
                v-on:selection="updateValue"
            />
        </div>
        <div class="col-xxs-12 col-md-6">
            <p class="label label--floating"><span class="float">Current Selections</span></p>
            <ul class="row selections__list">
                <li class="selections__single col-md-4 col-xxs-6" v-for="type in currentPerformerTypes" v-bind:key="type.id">
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
            allPerformerTypes: [],
        }
    },
    computed: {
        currentPerformerTypes: function() {
            return this.allPerformerTypes.filter((type) => {
                return this.performerTypes.includes(type.id);
            });
        }
    },
    props: {
        errors: {
            type: Array,
            required: true,
        },
        performerTypes: {
            type: Array,
            required: true,
        }
    },
    components: {
        Input,
        Autocomplete
    },
    mounted() {
        this.getAllPerformerTypes();
    },
    methods: {
        updateValue: function(updateObject) {
            const updateArray = {
                name: 'performerTypes',
                add: true,
                value: updateObject.id,
            }
            this.$emit("update", updateArray);
        },
        removeValue: function(updateObject) {
            const updateArray = {
                name: "performerTypes",
                add: false,
                value: updateObject,
            };
            this.$emit("update", updateArray);
        },
        getAllPerformerTypes: async function() {
            try {
                const resp = await this.$store.dispatch('fetchState', { route: 'performerTypes' });
                if (resp.data) {
                    this.allPerformerTypes = resp.data;
                }
            } catch (err) {
                console.log(err);
            }
        },
        addTerm: async function(term) {
            const data = {
                name: term,
                type: 'performer',
            }
            const payload = {
                route: "types",
                data,
            }
            const resp = await this.$store.dispatch('create', payload);
            if (resp && resp.data && resp.data.addition) {
                this.updateValue(resp.data.addition);
                this.getAllPerformerTypes();
            }
        }
    }
}
</script>

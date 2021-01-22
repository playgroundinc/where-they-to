<template>
    <div class="row form-group">
        <div class="col-xxs-12">
            <h3 class="copy--center">{{label}}</h3>
        </div>
        <div class="col-xxs-12 col-md-6">
            <Autocomplete 
                :errors="errors"
                :label="label"
                :values="currentArray"
                :route="route"
                v-on:search="search"
                v-on:selection="updateValue"
            />
        </div>
        <div class="col-xxs-12 col-md-6">
            <div class="input__container">
                <p class="label label--floating"><span class="float">Current {{ label }}</span></p>
                <ul class="row selections__list">
                    <li class="selections__single col-md-4 col-xxs-6" v-for="item in currentArray" v-bind:key="item.id">
                        <a href="#" class="selections__single__link" @click.prevent="function() { removeValue(item.id) }">
                            {{ item.name }} 
                            <svg class="selections__single__close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" height="18" width="18" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
import Input from "./Input";
import Autocomplete from "./Autocomplete";
export default {
    data() {
        return {
            allOptions: [],
        }
    },
    computed: {
    },
    props: {
        errors: {
            type: Array,
            required: true,
        },
        currentArray: {
            type: Array,
            required: true,
        },
        route: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        }
    },
    components: {
        Input,
        Autocomplete
    },
    methods: {
        updateValue: function(updateObject) {
            const updateArray = {
                name: this.route,
                add: true,
                value: {
                    id: updateObject.id,
                    name: updateObject.name,
                }
            }
            this.$emit("update", updateArray);
        },
        search: async function(term) {
            const resp = await this.$store.dispatch('search', { route: this.route, term });
            if (resp.status === 200) {
                this.currentArray = resp.data[this.route];
            }
        },
        removeValue: function(updateObject) {
            const updateArray = {
                name: this.route,
                add: false,
                value: {
                    id: updateObject,
                }
            };
            this.$emit("update", updateArray);
        },
    }
}
</script>

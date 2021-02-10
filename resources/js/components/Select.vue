<template>
    <div class="row form-group">
        <div class="col-xxs-12">
            <h3 class="copy--center">{{label}}</h3>
        </div>
        <div class="col-xxs-12 col-md-6">
            <Autocomplete 
                :errors="errors"
                :label="label"
                :values="allSelections"
                :route="route"
                v-on:search="search"
                v-on:selection="updateValue"
				newBtn="Add performer without profile."
				v-on:new="handleNoProfile"
            />
        </div>
        <div class="col-xxs-12 col-md-6">
            <div class="input__container">
                <p class="label label--floating"><span class="float">Current {{ label }}</span></p>
                <ul class="row selections__list">
                    <li class="selections__single col-md-4 col-xxs-6" v-for="item in allSelections" v-bind:key="item.id !== 0 ? item.id : item.name">
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
    computed: {
		allSelections() {
			if (this.noProfile.length) {
				const newArray = this.currentArray.concat(this.noProfile);
				return newArray;
			}
			return this.currentArray;
		}
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
        },
		noProfile: {
			type: Array,
			required: false,
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
			let name = this.route;
			if (updateObject === 0) {
				name = `${this.route}_no_profile` 
			}
            const updateArray = {
                name,
                add: false,
                value: {
                    id: updateObject,
                }
            };
            this.$emit("update", updateArray);
        },
		handleNoProfile: function(newTerm) {
			this.$emit('update', { name: `${this.route}_no_profile`, value: { id: 0, name: newTerm }, add: true });
		}
    }
}
</script>

<template>
    <div class="col-xs-12">
        <SelectTypes 
            :errors="errors"
            :types="eventTypes"
            :route="route"
            :type="type"
            v-on:update="updateArray"
        />
    </div>
</template>
<script>
import SelectTypes from "../SelectTypes";
export default {
    props: {
        eventTypes: {
            type: Array,
            required: true,
            default: () => [],
        },
        errors: {
            type: Array,
            required: true,
            default: () => [],
        },
        route: {
            type: String,
            required: true,
            default: '',
        },
        type: {
            type: String,
            required: true,
            default: '',
        }
    },
    components: {
        SelectTypes,
    },
    methods: {
        addToArray: function(updateObject, currentArray) {
            const index = this.findValue(currentArray, updateObject.value);
            if (index <= -1) {
                currentArray.push(updateObject.value);
                this[updateObject.name] = currentArray;
            }
        },
        findValue: function(currentArray, updateObject) {
            let index = -1;
            currentArray.forEach((item, i) => {
                if (item === updateObject) {
                    index = i;
                    return index;
                }
            });
            return index;
        },
        deleteFromArray: function(updateObject, currentArray) {
            const index = this.findValue(currentArray, updateObject.value);
            if (index > -1) {
                currentArray.splice(index, 1);
                this[updateObject.name] = currentArray;
            }
        },
        updateArray: function(updateObject) {
            const currentArray = this[updateObject.name];
            if (currentArray && updateObject.add) {
                this.addToArray(updateObject, currentArray);
            } 
            if (currentArray && !updateObject.add) {
                this.deleteFromArray(updateObject, currentArray);
            }
        },
    }
}
</script>
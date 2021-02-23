<template>
    <div class="row">
        <div class="col-xs-12">
            <Select
                label="Performers"
                route="performers"
                :errors="errors"
                :currentArray="performers"
                v-on:update="updateArray"
            />	
        </div>
    </div>
</template>

<script>
import Select from "../Select";

export default {
    props: {
        errors: {
            type: Array,
            required: false,
            default: () => { return []},
        },
        performers: {
            type: Array,
            required: true,
            default: () => [],
        }
    },
	components: {
        Select,
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
					if (item.id === updateObject.id) {
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
        
    },

};
</script>

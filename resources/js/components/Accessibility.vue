<template>
	<div class="form-group row">
		<div class="col-xxs-12">
			<h2 class="copy--center">Accessibility</h2>
			<fieldset v-if="options.length > 0">
				<legend>Accessibility Features:</legend>
				<Input 
					v-for="option in options"
					v-bind:key="option['value']"
					type="checkbox"
					:name="option['value']"
					:value="option['value']"
					:checked="option['checked']"
					v-on:update="updateArray"
				/>
			</fieldset>
		</div>
	</div>
</template>
<script>
// Data 
import accessibilityFields from "../core/accesssibility";

// Components
import Input from '../components/Input';

export default {
    props: {

        value: {
            type: Array,
            required: true,
        },
	},
	
	data() {
		return {
			fields: accessibilityFields,
		}
	},
	computed: {
		options() {
			const allOptions = this.fields.map((field) => {
				const option = {};
				const name = field.replace(/_/g, ' ');
				option['label'] = name;
				option['value'] = field;
				option['checked'] = this.value.includes(field);
				return option;
			});
			return allOptions;
		}
	},
    components: {
        Input,
	},
	mounted() {
		console.log(this.options);
	},
    methods: {
		addToArray: function(updateObject, currentArray) {
			const index = this.findValue(currentArray, updateObject.value);
			if (index <= -1) {
				currentArray.push(updateObject.value);
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
			}
		},
		updateArray: function(updateObject) {
			const currentArray = this.value;
			if (updateObject.checked) {
				this.addToArray(updateObject, currentArray);
				return;
			} 
			this.deleteFromArray(updateObject, currentArray);
		},
    }
}
</script>
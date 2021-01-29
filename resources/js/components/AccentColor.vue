<template>
	<div class="form-group row">
		<div class="col-xxs-12">
			<h2 class="copy--center">Accent Color</h2>
			<Input
				name="accent_color"
				:value="value"
				type="color"
				:required="true"
				:errors="errors"
				v-on:update="updateValue"
				errorMsg="Your color selection does not meet accessibility standards. Try a darker shade."
				helperText="Please select an accent color."
			/>

		</div>
	</div>
</template>
<script>
// Classes
import ContrastChecker from "../core/contrast-checker";

// Components
import Input from '../components/Input';

export default {
    props: {
        value: {
            type: String,
            required: true,
        },
        errors: {
			type: Array,
			required: true,
        }
    },
    components: {
        Input,
    },
    methods: {
        updateValue: function(updateObject) {
			const valid = this.checkContrast(updateObject.value);
			if (!valid) {
				this.errors.push(updateObject.name);
			}
			this.$emit('update', updateObject);
		},
		checkContrast: function(color) {
			const contrastCheck = new ContrastChecker(color);
			const contrast = contrastCheck.checkContrast();
			return contrast;
		}
    }
}
</script>
<template>
    <div class="input__container">
        <label class="label label--floating" v-if="type !== 'submit'" :for="name">
            <span :class="floating">{{ label }}</span>
        </label>
        <textarea
            v-if="type === 'textarea'"
            class="input"
            :name="name"
            :id="name"
            :required="required"
            cols="30"
            rows="5	"
            :value="value"
            :aria-invalid="invalid"
            v-on:keyup="onChange"
            v-on:focus="floatLabel"
            v-on:blur="floatLabel"
        ></textarea>
        <select
            v-else-if="type === 'select'"
            class="input"
            :name="name"
            :id="name"
            :required="required"
            :value="value"
            :aria-invalid="invalid"
            v-on:change="onChange"
            v-on:focus="floatLabel"
            v-on:blur="floatLabel"
        >
            <option class="input__default" default="true" value="">Select</option>
            <option
                v-for="(option, index) in options"
                :value="index"
                v-bind:key="index"
            >
                {{ option }}
            </option>
        </select>
		<input 
			v-else-if="type === 'color'"
			:style="'background-color: ' + value + '; color: ' + value"
			type="color"
			class="input input--color"
			:name="name"
            :id="name"
            :required="required"
            :value="value"
            :aria-invalid="invalid"
            v-on:change="onChange"
		>
		<input 
			v-else-if="type === 'checkbox'" 
			:id="name" 
			type="checkbox" 
			:value="value" 
			:required="required"
			:aria-checked="checked"
			:checked="checked"
			:aria-describedby="helperText ? 'helper-text' : null"
            v-on:change="onCheck"
		>
        <input
            v-else-if="type === 'date'"
            class="input"
            :id="name"
            :type="type"
            :name="name"
            :value="value"
            :required="required"
            :aria-invalid="invalid"
            :aria-describedby="helperText ? 'helper-text' : null"
            v-on:change="onChange"
            v-on:focus="floatLabel"
            v-on:blur="floatLabel"
			:disabled="disabled"
		/>
        <input
            v-else
            class="input"
            :id="name"
            :type="type"
            :name="name"
            :value="value"
            :required="required"
            :aria-invalid="invalid"
            :aria-describedby="helperText ? 'helper-text' : null"
            v-on:keyup="onChange"
            v-on:focus="floatLabel"
            v-on:blur="floatLabel"
			:disabled="disabled"
		/>
		<Button 
			v-if="clearButton" 
			:label="'Clear '+ name"
			v-on:clicked="clearValue"
		/>
        <p class="input__error-msg copy--error copy--small copy--italic" v-if="errorMsg">{{ errorMsg }}</p>
        <p id="helper-text" class="copy--small copy--italic input__helper-text" v-if="helperText">{{ helperText }}</p>
    </div>
</template>

<script>
// Components.
import Button from "../components/Button";

export default {
    props: {
        name: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true
        },
        value: {
            type: String,
            required: true
        },
        required: {
            type: Boolean,
            default: false
        },
        errorMsg: {
            type: String,
            required: false,
            default: "This field is required"
        },
        helperText: {
            type: String,
            required: false
        },
        errors: {
            type: Array,
            required: false,
            default: () => []
        },
        options: {
            type: Object,
            required: false,
            default: () => {}
		},
		disabled: {
			type: Boolean,
			required: false,
			default: false,
		},
		clearButton: {
			type: Boolean,
			required: false,
			default: false,
		},
		checked: {
			type: Boolean,
			required: false,
			default:false,
		}
    },
    data() {
        return {
            active: false,
        }
	}, 
	components: {
		Button,
	},
	mounted() {
		if (this.type === 'color') {
			this.floatLabel();
		}
	},
    methods: {
        removeError: function() {
            const index = this.errors.indexOf(this.name);
            if (-1 !== index) {
                this.errors.splice(index, 1);
                this.$emit("update", {
                    name: "errors",
                    value: this.errors
                });
            }
        },
        onChange: function(event) {
			this.removeError();
            this.$emit("update", {
                name: this.name,
                value: event.target.value
            });
		},
		onCheck: function(event) {
			this.removeError();
            this.$emit("update", {
                name: this.name,
				value: event.target.value,
				checked: event.target.checked,
            });
        },
        floatLabel: function(e) {
            this.active = !this.active;
		},
		clearValue: function() {
			this.$emit("update",{
				name: this.name,
				value: "",
			})
		},
    },
    computed: {
        floating() {
            if (this.type === 'select' || this.type === 'date') {
                return 'float';
            }
            return this.active || this.value !== '' ? 'float' : 'sink';
        },
        label() {
            const labelText = this.name.replace(/_/g, " ");
            return labelText;
        },
        invalid() {
            if (this.errors.length) {
                return this.errors.includes(this.name);
            }
		}
		
    }
};
</script>

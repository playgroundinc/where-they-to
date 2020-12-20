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
            rows="10"
            :value="value"
            :aria-invalid="invalid"
            v-on:keyup="onChange"
            v-on:focus="floatLabel"
            v-on:blur="descendLabel"
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
            v-on:blur="descendLabel"
        >
            <option class="input__default" default="true" value="" disabled></option>
            <option
                v-for="(option, index) in options"
                :value="index"
                v-bind:key="index"
            >
                {{ option }}
            </option>
        </select>
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
            v-on:blur="descendLabel"
        />
        <p class="input__error-msg copy--error copy--small copy--italic" v-if="errorMsg">{{ errorMsg }}</p>
        <p id="helper-text" class="copy--small copy--italic input__helper-text" v-if="helperText">{{ helperText }}</p>
    </div>
</template>

<script>
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
    },
    data() {
        return {
            floating: "sink",
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
        floatLabel: function(e) {
            this.floating = "float";
        },
        descendLabel: function() {
            if (this.value === "") {
                this.floating = "sink";
            } else {
                this.floating = "float";
            }
        }
    },
    computed: {
        label() {
            const labelText = this.name.replace("_", " ");
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

<template>
    <div>
        <label v-if="type !== 'submit'" :for="name">{{ label }}</label>
        <textarea
            v-if="type === 'textarea'"
            :name="name"
            :id="name"
            :required="required"
            cols="30"
            rows="10"
            :value="value"
            :aria-invalid="invalid"
            v-on:keyup="onChange"
        ></textarea>
        <input
            v-else
            :id="name"
            :type="type"
            :name="name"
            :value="value"
            :required="required"
            :aria-invalid="invalid"
            v-on:keyup="onChange"
        />
        <p v-if="type !== 'submit'" class="error">{{ errorMsg }}</p>
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
            default: "Something is wrong with this field"
        },
        errors: {
            type: Array,
            required: false,
            default: () => []
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
        }
    },
    computed: {
        label() {
            return this.name.toUpperCase();
        },
        invalid() {
            if (this.errors.length) {
                return this.errors.includes(this.name);
            }
        }
    }
};
</script>

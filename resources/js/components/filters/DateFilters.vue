<template>
    <div class="col-md-12">
        <Input 
            type="date"
            :value="date"
            name="date"
            v-on:update="updateValue"
        />
    </div>
</template>
<script>
import Input from "../Input";
export default {
    props: {
        date: {
            type: String,
            required: true,
        }
    },
    components: {
        Input,
    },
    methods: {
        updateValue: function(updateObject) {
            this.$emit('update', updateObject);
        }
    }
}
</script>
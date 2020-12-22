<template>
    <div class="row form-group">
        <div class="col-xxs-12">
            <h3 class="copy--center">Social Media</h3>
        </div>
        <div class="col-md-6 col-xxs-12">
            <Input
                name="website"
                :value="website"
                type="text"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Please provide the full url."
            />
        </div>
        <div class="col-md-6 col-xxs-12">
            <Input
                name="facebook"
                :value="facebook"
                type="text"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Please provide your user handle"
            />
        </div>
        <div class="col-md-6 col-xxs-12">
            <Input
                name="instagram"
                :value="instagram"
                type="text"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Please provide your handle without the @ symbol."
            />
        </div>
        <div class="col-md-6 col-xxs-12">
            <Input
                name="tiktok"
                :value="tiktok"
                type="text"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Please provide your handle without the @ symbol."
            />
        </div>
        <div class="col-md-6 col-xxs-12">
            <Input
                name="twitter"
                :value="twitter"
                type="text"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Please provide your handle without the @ symbol."
            />
        </div>
        <div class="col-md-6 col-xxs-12">
            <Input
                name="twitch"
                :value="twitch"
                type="text"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Please provide your channel's name"
            />
        </div>
        <div class="col-md-6 col-xxs-12">
            <Input
                name="youtube"
                :value="youtube"
                type="text"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Please provide your channel's name"
            />
        </div>
    </div>
</template>
<script>
import Input from "./Input";
export default {
    props: {
        errors: {
            type: Array,
            required: true,
        },
        facebook: {
            type: String,
        },
        instagram: {
            type: String,
        },
        twitch: {
            type: String,
        },
        twitter: {
            type: String,
        },
        tiktok: {
            type: String,
        },
        website: {
            type: String,
        },
        youtube: {
            type: String,
        }
    },
    components: {
        Input,
    },
    methods: {
        updateValue: function(updateObject) {
            console.log(updateObject);
            this.$emit("update", updateObject);
        },
    }
}
</script>

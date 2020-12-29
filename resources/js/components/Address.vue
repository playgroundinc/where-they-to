<template>
<div class="form-group row">
    <div class="col-xxs-12">
        <h2 class="copy--center">Address</h2>
        <p class="copy--center">This site is only currently set up to support Canadian addresses or web addresses. If you're creating a profile for a digital platform, make the address the web address and set the province to Online. Rather than a city, we ask that you provide the timezone.</p>
        <p class="copy--center">{{ helperText }} <a v-if="buttonText" href="#" @click.prevent="handleClick">{{ buttonText }}</a></p>
        <Input
            name="address"
            :value="address"
            type="text"
            :required="true"
            :errors="errors"
            v-on:update="updateValue"
        />
    </div>
    <div class="col-md-6"> 
        <Input
            name="province"
            :value="province"
            type="select"
            :options="provinces"
            :required="true"
            :errors="errors"
            v-on:update="updateValue"
        />
    </div>
    <div class="col-md-6">
        <Input 
            v-if="'OE' === province"
            name="timezone"
            :value="timezone"
            type="select"
            :required="true"
            :errors="errors"
            :options="timezones"
            v-on:update="updateValue"            
        />
        <Input
            v-else
            name="city"
            :value="city"
            type="text"
            :required="true"
            :errors="errors"
            v-on:update="updateValue"
        />
    </div>
</div>
</template>
<script>
// Components
import Input from '../components/Input';

// Classes
import Location from "../Location";

export default {
    props: {
        address: {
            type: String,
            required: true,
        },
        buttonText: {
          type: String,
          required: false,
        },
        helperText: {
          type: String,
          required: false,
        },
        province: {
            type: String,
            required: true,
        },
        city: {
            type: String,
            required: true,
        },
        errors: {
            type: Array,
            required: true,
        },
        timezone: {
            type: String,
            required: true,
        }
    },
    components: {
        Input,
    },
    computed: {
        location() {
            return new Location();
        },
        provinces() {
            return this.location.getProvinces();
        },
        timezones() {
            return this.location.getTimezones();
        }
    },
    methods: {
        updateValue: function(updateObject) {
            this.$emit("update", updateObject);
        },
        handleClick: function() {
          this.$emit("buttonClick");
        }
    }
}
</script>
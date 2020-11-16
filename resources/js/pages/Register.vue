<template>
    <div>
        <div>
            <p>
                Have an Account?
                <a href="/login">Log-In</a>
            </p>
        </div>
        <ErrorsContainer :errors="errors" />
        <form
            autocomplete="off"
            novalidate
            @submit.prevent="register"
            v-if="!success"
            method="post"
        >
            <div class="form-group">
                <Input
                    name="email"
                    :value="email"
                    type="email"
                    :required="true"
                    :errors="errors"
                    v-on:update="updateValue"
                />
            </div>
            <div class="form-group">
                <Input
                    name="password"
                    :value="password"
                    type="password"
                    :required="true"
                    :errors="errors"
                    v-on:update="updateValue"
                    helperText="Passwords must be at least 6 characters long."
                />
            </div>
            <div class="form-group">
                <Input
                    name="password_confirmation"
                    :value="password_confirmation"
                    type="password"
                    :required="true"
                    :errors="errors"
                    v-on:update="updateValue"
                    errorMsg="Passwords must match"
                />
            </div>
            <Input
                name="province"
                :value="province"
                type="select"
                :options="provinces"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input
                name="city"
                :value="city"
                type="text"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input
                name="timezone"
                :value="timezone"
                type="select"
                :required="true"
                :errors="errors"
                :options="timezones"
                v-on:update="updateValue"
            />
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</template>
<script>
import { mapState } from "vuex";
import Input from "../components/Input";
import ErrorsContainer from "../components/ErrorsContainer";
import Errors from "../core/errors";
import Location from "../Location";
export default {
    data() {
        return {
            email: "",
            password: "",
            password_confirmation: "",
            city: "",
            province: "",
            country: "CA",
            timezone: "",
            errors: [],
            success: false
        };
    },
    computed: {
        location() {
            return new Location();
        },
        timezones() {
            return this.location.getTimezones();
        },
        provinces() {
            return this.location.getProvinces();
        }
    },
    components: {
        Input,
        ErrorsContainer
    },
    methods: {
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
        registerUser: function(data) {
            this.$store
                .dispatch("register", data)
                .then(resp => {
                    this.$router.push("/dashboard");
                })
                .catch(err => console.log(err));
        },
        register: function() {
            let data = {
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                city: this.city,
                country: this.country,
                province: this.province,
                timezone: this.timezone
            };
            const match = this.verifyPasswords();
            if (match) {
                let valid = this.checkRequiredFields(data);
                this.registerUser(data);
                return;
            }
            this.errors.push("password_confirmation");
        },
        verifyPasswords: function() {
            return this.password === this.password_confirmation;
        },
        checkRequiredFields: function(data) {
            const errors = new Errors(data);
            this.errors = errors.checkFields();
            if (this.errors.length) {
                return false;
            }
            return true;
        }
    }
};
</script>

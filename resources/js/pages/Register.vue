<template>
    <main class="container--core container">
        <h1 class="copy--center">Register</h1>
        <p class="copy--center copy--italic">
            Already have an account?
            <a href="/login">Log-In</a>
        </p>
        <div class="copy">
            <p>If you're a performer, venue, or someone else who plans/organizes events in your city, you will need to make an account in order to create a profile for yourself/your venue, your family/troupe/circus, and list events.</p>
            <p>If you're a fan, there's nothing you can do with an account that you can't do without one.</p>
            <p class="copy--italic"><em>IMPORTANT:</em> This application is only setup to support Canadian artists, or shows happening in Canada. There is an eventual plan to expand its capabilities, but for the time being it does not support non-Canadian addresses.</p>
        </div>

        <ErrorsContainer :errors="errors" />
        <form
            autocomplete="off"
            novalidate
            @submit.prevent="register"
            v-if="!success"
            method="post"
        >
            <div class="form-group row between-md">
                <div class="col-xxs-12">
                    <h3 class="copy--center">Account Information</h3>
                    <Input
                        name="email"
                        :value="email"
                        type="email"
                        :required="true"
                        :errors="errors"
                        v-on:update="updateValue"
                    />
                </div>
                <div class="col-md-6">
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
                <div class="col-md-6">
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
            </div>
            <div class="form-group row">
                    <div class="col-xxs-12">
                        <h3 class="copy--center">Geographic Information</h3>
                        <Input
                            name="timezone"
                            :value="timezone"
                            type="select"
                            :required="true"
                            :errors="errors"
                            :options="timezones"
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
                            name="city"
                            :value="city"
                            type="text"
                            :required="true"
                            :errors="errors"
                            v-on:update="updateValue"
                        />
                    </div>
                    <div class="col-xxs-12">
                        <button type="submit" class="btn btn-default">Sign Up</button>
                    </div>
            </div>
        </form>
    </main>
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

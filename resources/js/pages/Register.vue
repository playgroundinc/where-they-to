<template>
    <main class="container--core container">
        <h1 class="copy--center">Register</h1>
        <p class="copy--center copy--italic subtitle">
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
            method="post"
            novalidate
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
                            name="city"
                            :value="city"
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
                    <div class="col-xxs-12">
                        <Button variation="input" classes="btn btn-default" label="Sign Up" />
                    </div>
            </div>
        </form>
    </main>
</template>
<script>
import { mapState } from "vuex";

//Components
import Button from "../components/Button";
import Input from "../components/Input";
import ErrorsContainer from "../components/ErrorsContainer";
import Form from "../core/form";
import Location from "../core/Location";
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
        },
        valid() {
            return this.errors.length === 0;
        }
    },
    components: {
        Button,
        Input,
        ErrorsContainer
    },
    methods: {
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
        registerUser: async function(FormClass) {
            const resp = await FormClass.submitForm();
            if (resp.status === 'success') {
                await this.$store.dispatch('findUser');
                this.$router.push('/dashboard');
            }
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
            const FormClass = new Form(data, "register");
            const match = FormClass.verifyPasswords();
            if (match) {
                this.errors = FormClass.checkRequiredFields();
                if (this.valid) {
                    this.registerUser(FormClass);
                }
                return;
            }
            this.errors.push("password_confirmation");
        },
    }
};
</script>

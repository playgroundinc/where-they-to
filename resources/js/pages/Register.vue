<template>
    <div>
        <div>
            <p>
                Have an Account?
                <a href="/login">Log-In</a>
            </p>
        </div>
        <form
            autocomplete="off"
            @submit.prevent="register"
            v-if="!success"
            method="post"
        >
            <div
                class="form-group"
                v-bind:class="{ 'has-error': error && errors.email }"
            >
                <label class="label" for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    class="input form-control"
                    placeholder="user@example.com"
                    v-model="email"
                    required
                />
                <span class="help-block" v-if="error && errors.email">{{
                    errors.email
                }}</span>
            </div>
            <div
                class="form-group"
                v-bind:class="{ 'has-error': error && errors.password }"
            >
                <label class="label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    class="input form-control"
                    v-model="password"
                    required
                />
                <span class="help-block" v-if="error && errors.password">{{
                    errors.password
                }}</span>
            </div>
            <div
                class="form-group"
                v-bind:class="{ 'has-error': error && errors.password }"
            >
                <label class="label" for="password_confirmation"
                    >Confirm Password</label
                >
                <input
                    type="password"
                    id="password_confirmation"
                    class="input form-control"
                    v-model="password_confirmation"
                    required
                />
                <span class="help-block" v-if="error && errors.password">{{
                    errors.password
                }}</span>
            </div>
            <Location
                :country="country"
                :city="city"
                :state="state"
                @changed="echoLocation"
            ></Location>
            <label for="timezone" class="label">Timezone</label>
            <select
                name="timezone"
                id="timezone"
                class="input"
                v-model="timezone"
            >
                <option
                    v-for="timezone in timezones"
                    v-bind:key="timezone"
                    :value="timezone"
                    >{{ timezone }}</option
                >
            </select>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</template>
<script>
import { mapState } from "vuex";
import Location from "../components/Location";
import Timezones from "../Timezones";
export default {
    data() {
        return {
            email: "",
            password: "",
            password_confirmation: "",
            city: "",
            state: "",
            country: "",
            timezones: Timezones,
            timezone: "",
            error: false,
            errors: {},
            success: false
        };
    },
    components: {
        Location
    },
    methods: {
        register: function() {
            let data = {
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
                city: this.city,
                country: this.country,
                region: this.state,
                timezone: this.timezone
            };
            this.$store
                .dispatch("register", data)
                .then(resp => {
                    this.$router.push("/dashboard");
                })
                .catch(err => console.log(err));
        },
        echoLocation: function(location) {
            if (location.key === "country") {
                this.state = "";
                this.city = "";
            }
            this[location.key] = location.value;
        }
    }
};
</script>

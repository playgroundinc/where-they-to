<template>
    <div>
        <div>
            <p>
                Have an Account?
                <a href="/login">Log-In</a>
            </p>
        </div>
        <Errors
          :errors="errors"
        />

        <form
            autocomplete="off"
            @submit.prevent="register"
            method="post"
            novalidate
        >
            <Input
                name="email"
                :value="email"
                type="email"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
                :errorMsg="duplicate ? 'An account already existis for this email' : 'This field is required'"

            />
            <Input
                name="password"
                :value="password"
                type="password"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input
                name="password_confirmation"
                :value="password_confirmation"
                type="password"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input
              name="province"
              :value="province"
              type="select"
              :required="true"
              :errors="errors"
              v-on:update="updateValue"
              :options="provinces"
            />
            <Input
              name="city"
              :value="city"
              type="text"
              :required="true"
              :errors="errors"
              v-on:update="updateValue"
            />

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</template>
<script>
import { mapState } from "vuex";
import Input from "../components/Input";
import Errors from "../components/Error";

import LocationClass from "../core/location";
import FormClass from "../core/form";

import { updateValue } from "../core/utilities";

export default {
  data() {
    return {
      email: "",
      password: "",
      password_confirmation: "",
      city: "",
      province: "",
      country: "Canada",
      errors: [],
      duplicate: false,
    };
  },
  computed: {
    provinces() {
      const Location = new LocationClass();
      const provinces = Location.getProvinces();
      return provinces;
    }
  },
    components: {
        Input, Errors,
    },
    methods: {
      updateValue,
      checkRequiredFields: function(data) {
        const errors = new ErrorsClass(data);
      },
      verifyEmail: async function() {
        if (this.email.length) {
          const existing = await this.$store.dispatch('checkEmail', { email });
          if (!existing) {
            return false;
          }
        }
        this.errors.push('email');
        return true;
      },
      register: async function() {
        let data = {
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
            city: this.city,
            country: this.country,
            province: this.province,
          };
        const form = new FormClass(data, 'register', this.$store);
        const duplicate = await this.verifyEmail();
        console.log(duplicate);
        if (duplicate) {
          this.duplicate = true;
          return;
        }
        const resp = await form.handleSubmit();
        if (resp.status === 'error') {
          this.errors = resp.errors;
          return;
        }
        this.$router.push('/dashboard');
      }
    }
};
</script>

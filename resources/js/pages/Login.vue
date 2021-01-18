<template>
    <div>
    <main class="container--core container">
        <h1 class="copy--center">Log-In</h1>
        <ErrorsContainer :errors="errors" />
        <form autocomplete="off" @submit.prevent="verifyForm" method="post" novalidate>
            <div class="form-group row between-md">
                <div class="col-xxs-12">
                    <Input
                        name="email"
                        :value="email"
                        type="email"
                        :required="true"
                        :errors="errors"
                        v-on:update="updateValue"
                    />
                </div>
                <div class="col-xxs-12">
                  <Input
                        name="password"
                        :value="password"
                        type="password"
                        :required="true"
                        :errors="errors"
                        v-on:update="updateValue"
                  />
                </div>
            </div>

            <button type="submit" class="btn btn-default">Sign in</button>
        </form>
      </main>
    </div>
</template>
<script>
  import Input from "../components/Input";
  import ErrorsContainer from "../components/ErrorsContainer";
  import Errors from "../core/errors";
  import Form from "../core/form";
  export default {
    data(){
      return {
        email: '',
        password: '',
        errors: [],
      }
    },
    computed: {
      valid: function() {
        return this.errors.length === 0;
      }
    },
    components: {
      Input,
      ErrorsContainer,
    },
    methods: {
      updateValue: function(updateObject) {
        this[updateObject.name] = updateObject.value;
      },
      login: async function(FormClass) {
        const resp  = await FormClass.submitForm();
        if (resp.status === 'success') {
          await this.$store.dispatch('findUser');
          this.$router.push('/dashboard');
        }
      },
      verifyForm(){
        const data = {
          email: this.email,
          password: this.password
        }
        const FormClass = new Form(data, 'login');
        this.errors = FormClass.checkRequiredFields();
        if (this.valid) {
          this.login(FormClass);
        } 
        return;
      },
    }
  } 
</script>
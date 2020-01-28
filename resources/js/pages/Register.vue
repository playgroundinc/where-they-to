<template>
    <div>
        <div class="alert alert-danger" v-if="error && !success">
            <p>There was an error, unable to complete registration.</p>
        </div>
        <div class="alert alert-success" v-if="success">
            <p>Registration completed. You can now <router-link :to="{name:'login'}">sign in.</router-link></p>
        </div>
        <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                <label class="label" for="username">Username</label>
                <input type="text" id="username" class="input form-control" v-model="username" required>
                <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
                <label class="label" for="email">E-mail</label>
                <input type="email" id="email" class="input form-control" placeholder="user@example.com" v-model="email" required>
                <span class="help-block" v-if="error && errors.email">{{ errors.email }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
                <label class="label" for="password">Password</label>
                <input type="password" id="password" class="input form-control" v-model="password" required>
                <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
                <label class="label" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" class="input form-control" v-model="password_confirmation" required>
                <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
              <label for="type" class="label">Type</label>
              <select class="input" name="type" id="type" v-model="type">
                <option value="1" selected>Performer</option>
                <option value="2">Venue</option>
                <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
              </select>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</template>
<script> 
  export default {
    data(){
      return {
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        type: "1",
        error: false,
        errors: {},
        success: false
      };
    },
    mounted: function() {
      console.log(this.$store);
    },
    methods: {
      register(){
        console.log(this.$store);
        var app = this
        this.$auth.register({
          data: {
            username: app.username,
            email: app.email,
            password: app.password,
            password_confirmation: app.password_confirmation,
            type: app.type,
          }, 
          success: function (res) {
            const { user } = res.data;
            this.$store.commit('set_state', {
              name: 'user',
              value: res.data.user.id,
            });
            // app.success = true
          },
          error: function (resp) {
            app.error = true;
            app.errors = resp.response.data.errors;
          },
          redirect: null
        });                
      }
    }
  }
</script>
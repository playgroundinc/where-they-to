<template>
  <div class="main">
    <div  v-if="!user.socialLinks">
      <h1>Create Social Links</h1>
      <form action="/socialLinks" v-on:submit.prevent="handleSubmit"> 
        <label class="label" for="facebook">Facebook</label>
        <input type="text" class="input" id="facebook" name="facebook" v-model="facebook">
        <label for="instagram" class="label">Instagram</label>
        <input type="text" class="input" id="instagram" name="instagram" v-model="instagram">
        <label for="twitter" class="label">Twitter</label>
        <input type="text" class="input" id="twitter" name="twitter" v-model="twitter">
        <label for="youtube" class="label">Youtube</label>
        <input type="text" class="input" id="youtube" name="youtube" v-model="youtube">
        <label for="website" class="label">Website</label>
        <input type="text" class="input" id="website" name="website" v-model="website">
        <input type="submit" class="btn">
      </form>
    </div>
    <div v-if="user.socialLinks">
      <h2>Looks like we already have your socials</h2>
      <p>If you'd like to edit them:</p>
      <a :href="'/users/' + user.id + '/social-links/' + user.socialLinks.id + '/edit'">Click here</a>
    </div>
    <div v-if="!user.profile">
      <h2>Looks like you have yet to complete your profile. To do so:</h2>
      <p> If you're looking to create a new profile:</p>
      <a v-if="user.type === 1" href="/performers/create" class="btn">Click Here</a>
      <a v-if="user.type !== 1" href="/venues/create" class="btn">Click Here</a>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
    data() {
      return {
        facebook: '',
        instagram: '',
        twitter: '',
        website: '',
        youtube: '',
      }
    },
    computed: {
      ...mapState(['user']),
    },
    methods: {
      handleSubmit: function() {
        let data = {
          user_id: this.user.id,
          facebook: this.facebook,
          instagram: this.instagram,
          twitter: this.twitter,
          website: this.website,
          youtube: this.youtube,
        }
        this.$store
        .dispatch('create', { 
          route: 'social-links',  
          data 
        })
        .then(() => {
          this.$router.push('/');
        }).catch((err) => {
          console.log(err);
        })
      }
    },
    async mounted() {
      if(this.user === 0) {
        this.$store.dispatch('findUser');
      }
    }

  }
</script>
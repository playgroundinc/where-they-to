<template>
  <div class="main">
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
          user_id: this.user,
          facebook: this.facebook,
          instagram: this.instagram,
          twitter: this.twitter,
          website: this.website,
          youtube: this.youtube,
        }
        this.$store
        .dispatch('createSocialLinks', data)
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
<template>
  <div class="main">
    <div v-if="!family_id && !event_id">
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
    </div>
    <div v-if="family_id || event_id">
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
        family_id: this.$route.params.id || null,
        event_id: this.$route.params.eid || null,
      }
    },
    computed: {
      ...mapState(['user']),
    },
    methods: {
      handleSubmit: function() {
        let data = {
          facebook: this.facebook,
          instagram: this.instagram,
          twitter: this.twitter,
          website: this.website,
          youtube: this.youtube,
        }
        if (this.family_id) {
          data['family_id'] = this.family_id;
        } else if (this.event_id) {
          data['event_id'] = this.event_id;
        } else {
          data['user_id'] = this.user.id;
        }
        this.$store
        .dispatch('create', { 
          route: 'social-links',  
          data 
        })
        .then((resp) => {
          if (this.event_id) {
            this.$store.dispatch('fetchState', {
              route: 'events'
            })
            return this.$router.push(`/events/${this.event_id}`);
          }
          if (this.family_id) {
            this.$store.dispatch('fetchState', {
              route: 'families'
            })
            return this.$router.push(`/families/${this.family_id}`);
          }
          this.$store.dispatch('fetchState', {
            route: 'performers'
          })
          this.$store.dispatch('fetchState', {
            route: 'venues'
          })
          this.$store.dispatch('findUser');
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
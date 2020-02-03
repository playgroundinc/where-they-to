<template>
  <div class="main" v-if="id">
    <h1>Edit Venue profile</h1>
    <form v-on:submit.prevent="handleSubmit" action="'/venues/' + id">
      <div >
        <label class="label" for="name">Name</label>
        <input class="input" type="text" name="name" v-model="name">
        <label class="label" for="description">Bio</label>
        <textarea class="input" name="description" id="description" cols="30" rows="10" placeholder="Venue description" v-model="description"></textarea>
        <label class="label" for="address">Address</label>
        <input class="input" type="text" name="address" v-model="address">
        <label class="label" for="city">City</label>
        <input class="input" type="text" name="city" v-model="city">
      </div>
      <input class="btn" type="submit" value="Edit Profile">
      
    </form>
    <button class="btn btn--danger" v-on:click="handleDelete">Delete Profile</button>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {

    data() {
      return {
        id: this.$route.params.id,
        name: '',
        description: '',
        address: '',
        city: ''
      }
    },
    computed: {
      ...mapState(['venues', 'user']),
    },
    methods: {
      handleSubmit: function() {
        let data = {
          name: this.name,
          description: this.description,
          address: this.address,
          city: this.city,
        }
        let route = `venues`;
        this.$store
          .dispatch('edit', {
            route, 
            id: this.id,
            data
          }).then(() => {
            this.$router.push(`/venues/${this.id}`)
          }).catch((err)=>{
            console.log(err);
          });
      },
      handleDelete: function() {
        this.$store.dispatch('destroy', {
          route: 'venues',
          id: this.id,
        }).then(()=>{
          this.$router.push('/venues');
        });
      }
    },
    async mounted() {
      const response = await this.$store.dispatch('fetchSingle', {
        route: 'venues',
        id: this.id,
      })
      if(this.user === 0) {
        this.$store.dispatch('findUser');
      }
      this.name = response.data.venue.name;
      this.description = response.data.venue.description;
      this.address = response.data.venue.address;
      this.city = response.data.venue.city;
    }

  }
</script>
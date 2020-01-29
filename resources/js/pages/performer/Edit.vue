<template>
  <div class="main" v-if="id">
    <h1>Edit Performer profile</h1>
    <form v-on:submit.prevent="handleSubmit" action="'/performers/' + id">
      <div >
        <label class="label" for="name">Name</label>
        <input class="input" type="text" name="name" v-model="name">
        <label class="label" for="bio">Bio</label>
        <textarea class="input" name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio" v-model="bio"></textarea>
      </div>
      <label class="label" for="performerType0">Performer Type</label>
      <select class="input" name="performerType[0]" id="performerType0" v-model="performerType">
        <option v-bind:value="performerType.id" v-for="performerType in performerTypes.performerTypes" :key="performerType.id" v-text="performerType.name" ></option>
      </select>
      <input class="btn" type="submit" value="Edit Profile">
      
    </form>
    <a class="btn btn--danger" :href="'/performers/' + id">Delete Profile</a>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {

    data() {
      return {
        id: this.$route.params.id,
        performerType: '',
        name: '',
        bio: ''
      }
    },
    computed: {
      ...mapState(['performers', 'user', 'performerTypes']),
    },
    methods: {
      handleSubmit: function() {
        let data = {
          name: this.name,
          bio: this.bio,
          performerType: [this.performerType],
        }
        let route = `performers/${this.id}`;
        this.$store
          .dispatch('edit', {
            route, 
            data
          }).then(() => {
            this.$router.push(`/performers/${this.id}`)
          }).catch((err)=>{
            console.log(err);
          });
      }
    },
    async mounted() {
      const response = await this.$store.dispatch('fetchSingle', {
        route: 'performers',
        id: this.id,
      })
      if(this.user === 0) {
        this.$store.dispatch('findUser');
      }
      this.name = response.data.performer.name;
      this.bio = response.data.performer.bio;
      this.type = response.data.performer.type;
      this.$store.dispatch('fetchState', { 
        route: 'performerTypes',
      })
    }

  }
</script>
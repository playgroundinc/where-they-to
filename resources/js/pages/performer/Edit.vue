<template>
  <div class="main" v-if="performer">
    {{ performerTypes }}
    <h1>Edit Performer profile</h1>
    <form method="POST" action="'/performers/' + performer.id">
      <div >
        <label class="label" for="name">Name</label>
        <input class="input" type="text" name="name" v-model="performer.name">
        <label class="label" for="bio">Bio</label>
        <textarea class="input" name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio" v-model="performer.bio"></textarea>
      </div>
      <label class="label" for="performerType0">Performer Type</label>
      <select class="input" name="performerType[0]" id="performerType0" v-model="performer.type">
        <option v-for="performerType in performerTypes" :key="performerType.id"></option>
      </select>
      
    </form>
    <a class="btn btn--danger" :href="'/performers/' + performer.id">Delete Profile</a>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {

    data() {
      return {
        id: this.$route.params.id,
        performer: {},
        socialLinks: [],
        family: {},
        platforms: [],
        type: '',
      }
    },
    computed: {
      ...mapState(['performers', 'user', 'performerTypes']),
    },
    async mounted() {
      const response = await this.$store.dispatch('fetchSingle', {
        route: 'performers',
        id: this.id,
      })
      if(this.user === 0) {
        this.$store.dispatch('findUser');
      }
      this.performer = response.data.performer;
      this.socialLinks = response.data.socialLinks;
      this.family = response.data.family;
      this.platforms = response.data.platforms;
      this.type = response.data.type;
      this.$store.dispatch('fetchState', { 
        route: 'performerTypes',
      })
    }

  }
</script>
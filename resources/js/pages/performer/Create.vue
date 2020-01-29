<template>
  <div class="main" v-if="user">
    <h1>Edit Performer profile</h1>
    <form method="POST" action="/performers" v-on:submit.prevent="handleSubmit">
      <div >
        <label class="label" for="name">Name</label>
        <input class="input" type="text" name="name" v-model="name">
        <label class="label" for="bio">Bio</label>
        <textarea class="input" name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio" v-model="bio"></textarea>
      </div>
      <label class="label" for="performerType0">Performer Type</label>
      <select class="input" name="performerType[0]" id="performerType0" v-model="performerType">
        <option v-bind:value="performerType.id" v-for="performerType in performerTypes.performerTypes" :key="performerType.id" v-text="performerType.name"></option>
      </select>
      <input type="hidden" name="id" v-model="user">
      <input class="btn" type="submit">
    </form>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {

    data() {
      return {
        name: '',
        bio: '',
        performerType: '',
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
          performerType: this.performerType,
          id: this.user.id
        }
        this.$store
          .dispatch('createPerformer', data)
          .then(() => {
            this.$router.push('/social-links/create');
          }).catch((err) => {
            console.log(err)
          });
      }
    },
    async mounted() {
      if(this.user === 0) {
        this.$store.dispatch('findUser');
      }
      this.$store.dispatch('fetchState', { 
        route: 'performerTypes',
      })
    }

  }
</script>
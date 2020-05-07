<template>
  <div class="main" v-if="user">
    <h1>Create Performer profile</h1>
    <form method="POST" action="/performers" v-on:submit.prevent="handleSubmit">
      <div >
        <label class="label" for="name">Name</label>
        <input class="input" type="text" name="name" v-model="name">
        <label class="label" for="bio">Bio</label>
        <textarea class="input" name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio" v-model="bio"></textarea>
      </div>
      <fieldset class="input" name="performerTypes" id="performerTypes">
        <legend for="performerTypes" class="label">Performer Types</legend>
        <ul class="list">
          <li class="list-item" v-for="performerType in performerTypes" v-bind:key="performerType.id" >
            <input type="checkbox" :name="performerType.name" :value="performerType.id" :id="performerType.name" v-model="newPerformerTypes">
            <label :for="performerType.name" v-text="performerType.name"></label>
          </li>
        </ul> 
      </fieldset>
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
        newPerformerTypes: [],
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
          performerType: this.newPerformerTypes,
          user_id: this.user.id
        }
        this.$store
          .dispatch('create', { route: 'performers', data})
          .then(async() => {
            await this.$store.dispatch('fetchState', {
              route: 'events',
            })
            this.$store.dispatch('findUser');
            this.$router.push('/dashboard');
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
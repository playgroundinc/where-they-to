<template>
  <div class="main" v-if="user">
    <h1>Create Family</h1>
    <form action="/families/" v-on:submit.prevent="handleSubmit">
      <label class="label" for="name">Name</label>
      <input class="input" type="text" name="name" id="name" v-model="name">
      <label class="label" for="description">Description:</label>
      <textarea class="input" name="description" id="description" cols="30" rows="10" v-model="description"></textarea>
      <fieldset class="input" name="newPerformers" id="newPerformers">
      <legend for="newPerformers" class="label">New Performers</legend>
      <ul class="list">
          <li class="list-item" v-for="performer in performers" v-bind:key="performer.id" >
            <input v-if="performer.id !== user.profile.id" type="checkbox" :name="performer.name" :value="performer.id" :id="performer.name" v-model="newPerformers">
            <label v-if="performer.id !== user.profile.id" :for="performer.name" v-text="performer.name"></label>
          </li>
        </ul> 
      </fieldset>
      <input class="btn" type="submit" value="Submit">
    </form>    
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
        newPerformers: [],
      }
    },
    computed: {
      ...mapState(['user', 'families', 'performers']),
    },
    methods: {
      handleSubmit: function() {
        let data = {
          name: this.name,
          description: this.description,
          performers: this.newPerformers,
        }
        let route = `families`;
        this.$store
          .dispatch('create', {
            route, 
            id: this.id,
            data
          }).then(() => {
            this.$router.push(`/families`)
          }).catch((err)=>{
            console.log(err);
          });
      },
    }
  }
</script>
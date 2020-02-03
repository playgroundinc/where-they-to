<template>
  <div class="main" v-if="family">
    <h1>Edit Family</h1>
    <form action="/families/" v-on:submit.prevent="handleSubmit">
      <label class="label" for="name">Name</label>
      <input class="input" type="text" name="name" id="name" v-model="family.name">
      <label class="label" for="description">Description:</label>
      <textarea class="input" name="description" id="description" cols="30" rows="10" v-model="family.description"></textarea>
      <input class="btn" type="submit" value="Submit">
    </form>
    <h2>Current Performers</h2>
    <ul class="list container--inner">
        <li class="list-item list-item--flex" v-for="performer in family.performers" v-bind:key="performer.id">
          <a :href="'/performers/' + performer.id" v-text="performer.name"></a>
          <button v-on:click.prevent="removePerformer(performer.id)">Remove Performer</button>
        </li>
    </ul>
    <h2>Add New Performer</h2>
    <select name="performers" id="performers" v-model="newPerformer">
      <option v-for="performer in performers" v-bind:key="performer.id" v-text="performer.name" :value="performer.id"></option>
    </select>
    <button class="btn" v-on:click.prevent="addPerformer">Add New Performer</button>
  </div>
</template>

<script>
  import { mapState } from 'vuex';

  export default {
    data() {
      return {
        id: this.$route.params.id,
        newPerformer: '',
      }
    },
    computed: {
      ...mapState(['families', 'performers']),
      family: function() {
        return this.families.find(entry => Number(entry.id) === Number(this.id))
      },
      familyMember: function() {
        if (this.user && this.user.profile) {
          return this.family.performers.find(entry => Number(entry.id) === Number(this.user.profile.id)) 
        } 
        return false;
      }
    },
    methods: {
      removePerformer: function(id) {
        this.$store.dispatch('destroy', {
          route: 'families', 
          id: `performers/${id}/delete`,
        })
      },
      addPerformer: function() {
        let data = {
          performer: this.newPerformer,
        }
        this.$store.dispatch('create', {
          route: `families/${this.id}/performer`,
          data,
        }).then(()=> {
          this.$store.dispatch('fetchState', {
            route: 'families',
          })
        })
      },
      handleSubmit: function() {
        let data = {
          name: this.family.name,
          description: this.family.description,
        }
        let route = `families`;
        this.$store
          .dispatch('edit', {
            route, 
            id: this.id,
            data
          }).then(() => {
            this.$router.push(`/families/${this.id}`)
          }).catch((err)=>{
            console.log(err);
          });
      },
    }
  }
</script>
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
      <h2>Performer Types</h2>
      <ul class="list container--inner">
        <li class="list-item list-item--flex" v-for="type in types" v-bind:key="type.id">
          <p v-text="type.name"></p>
          <button v-on:click.prevent="removePerformerType(type.id)">Remove Type</button>
        </li>
      </ul>
      <h2>Add New Type</h2>
      <fieldset v-if="filteredPerformerTypes">
          <legend for="newPerformers" class="label">Performer Types</legend>
          <ul class="list">
            <li class="list-item" v-for="performerType in filteredPerformerTypes" v-bind:key="performerType.id" >
              <p>{{ performerType.name }}</p>
              <button @click.prevent="addPerformerTyper(performerType.id)">Add Type</button>
            </li>
        </ul> 
      </fieldset>
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
        bio: ''
      }
    },
    computed: {
      ...mapState(['performers', 'user', 'performerTypes']),
      performer: function() {
        return this.performers.find(entry => Number(entry.id) === Number(this.id))
      },
      types: {
        get: function() { 
          if (this.performer) { 
            return this.performer.type 
          }
          return []
        },
        set: function(value) {
          if (this.performer) {
            this.performer.type = value;
          }
        }
      },
      filteredPerformerTypes: function() {
        if (this.performerTypes.performerTypes) {
          return this.performerTypes.performerTypes.filter(entry => !this.performer.type.find((item) => Number(item.id) === Number(entry.id)));
        }
      },
    },
    methods: {
      handleSubmit: function() {
        let data = {
          name: this.name,
          bio: this.bio,
          performerType: [this.performerType],
        }
        let route = `performers`;
        this.$store
          .dispatch('edit', {
            route, 
            id: this.id,
            data
          }).then(() => {
            this.$router.push(`/performers/${this.id}`)
          }).catch((err)=>{
            console.log(err);
          });
      },
      handleDelete: function() {
        this.$store.dispatch('destroy', {
          route: 'performers',
          id: this.id,
        }).then(()=>{
          this.$router.push('/performers');
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
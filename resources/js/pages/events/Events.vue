<template>
  <div class="main">
    <h1>Events</h1>
    <ul>
      <li v-for="event in events" v-bind:key="event.id">
        <a :href="'events/' + event.id"> {{ event.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
import {mapState} from 'vuex';
export default {
    data() {
      return {
      }
    },
    computed: {
      ...mapState(['events', 'user'])
    }
  }
</script>
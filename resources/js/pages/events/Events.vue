<template>
  <div class="main">
    <h1>Events</h1>
    <ul>
      <li v-for="event in events" v-bind:key="event.id">
        <a :href="'events/' + event.id"> {{ event.name }}</a>
      </li>
    </ul>
    <Button link="/events/create" label="Create Event" />
  </div>
</template>

<script>
import {mapState} from 'vuex';

// Components.
import Button from "../../components/Button";

export default {
    data() {
      return {
      }
    },
    components: {
      Button,
    },
    computed: {
      ...mapState(['events', 'user'])
    }
  }
</script>
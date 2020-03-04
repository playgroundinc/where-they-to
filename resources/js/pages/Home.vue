<template>
  <div>
    <h1>Where They To</h1>
    <h2>On Tonight</h2>
    <ul>
      <li v-if="!todays.length > 0">Nothing On Tonight</li>
      <li v-for="today in todays" v-bind:key="today.id">
        <a> {{ today.name }}</a>
      </li>
    </ul>
    <h2>This Week</h2>
    <div>
      <p v-if="!weeks.length > 0">Nothing On This Week</p>
      <div v-for="week in weeks" v-bind:key="week.id">
        {{ week }}
        <h3><a :href="'/events/' + week.id ">{{ week.name }}</a></h3>
        <p>{{week.date }} @ {{ week.time }}</p>
        <p>Venue: <a :href="'/venues/' + venue(week['venue_id'], 'link')"> {{ venue(week['venue_id']) }}</a></p>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
  export default {
    data() {
      return {
        todays: {},
        weeks: {},
      }
    },
    computed: {
      ...mapState(['user', 'events', 'families', 'venues', 'performers']),
    },
    methods: {
      family(id) {
        return this.families.find((entry) => Number(entry.id) === Number(id))
      },
      venue(id, field) {
        const venue = this.venues.find((entry) => Number(entry.id) === Number(id));
        if (field === 'link' && venue) {
          return venue.id
        }
        if (venue) {
          return venue.name
        }
      }
    },
    mounted() {
      const date = new Date();
      const today = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
      this.$store.dispatch('fetchDate', {
        parameter: 'date',
        date: today,
      }).then((response) => {
        this.todays = response.data;
      });
      this.$store.dispatch('fetchDate', {
        parameter: 'week',
        date: today,
      }).then((response) => {
        this.weeks = response.data;
      })
    }
  }
</script>
<template>
  <div>
    <h1>Where They To</h1>
    <h2>On Tonight</h2>
    <div>
      <p v-if="!todays.length > 0">Nothing On Tonight</p>
      <div v-for="today in todays" v-bind:key="today.id">
        <a :href="'/events/' + today.id">
          <h3>
            {{ today.name }}
          </h3>
        </a>
        <p>{{ today.time }}</p>
        <a :href="'/venues' + venue(today.venue_id, 'link')">{{ venue(today.venue_id ) }}</a>
      </div>
    </div>
    <h2>This Week</h2>
    <div>
      <p v-if="!weeks.length">Nothing On This Week</p>
      <div v-for="weekdays in weeks" v-bind:key="weekdays.id">
        <div v-for="(weekday, index) in weekdays" v-bind:key="weekday.id">
          <h2 class="title">{{ index }}</h2>
          <div v-for="day in weekday" v-bind:key="day.id">
            <a :href="'/events/' + day.id">
              <h3>
                {{day.name}}
              </h3>
            </a>
            <p>{{ day.time }}</p>
            <a :href="'/venues' + venue(day.venue_id, 'link')">{{ venue(day.venue_id ) }}</a>
          </div>
        </div>
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
        weeks: [],
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
      },
    },
    mounted() {
      const date = new Date();
      const today = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
      this.$store.dispatch('fetchDate', {
        parameter: 'date',
        date: today,
      }).then((response) => {
        this.todays = JSON.parse(response.data.events);
      });
      const tempArray = [];
      for (let i = 1; i < 7; i = i + 1) {
        const thisWeeks = {};
        let weekdate = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate() + i}`;
        this.$store.dispatch('fetchDate', {
          parameter: 'date',
          date: weekdate,
        }).then((response) => {
          thisWeeks[response.data.date] = JSON.parse(response.data.events);
          tempArray.push(thisWeeks);
        });
      }
      this.weeks = tempArray;
    }
  }
</script>
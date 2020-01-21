<template>
  <div>
    <h1>Home</h1>
    <h2>Performers</h2>
    <ul>
      <li v-for="performer in performers">
        <a :href="'performers/' + performer.id"> {{ performer.name }}</a>
      </li>
    </ul>
    <h2>Events</h2>
    <ul>
      <li v-for="event in events">
        <a :href="'events/' + event.id"> {{ event.name }}</a>
      </li>
    </ul>
    <h2>Venues</h2>
    <ul>
      <li v-for="venue in venues">
        <a :href="'venues/' + venue.id"> {{ venue.name }}</a>
      </li>
    </ul>
    <h2>Families</h2>
    <ul>
      <li v-for="family in families">
        <a :href="'families/' + family.id"> {{ family.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        performers: [],
        events: [],
        venues: [],
        families: [],
      }
    },
    methods: {
      _getData(route) {
        axios.get(`/${route}`)
        .then(({data}) => {
          this[route] = data;
        })
      }
    },
    created() {
      this._getData('performers');
      this._getData('events');
      this._getData('venues');
      this._getData('families');
    }
  }
</script>
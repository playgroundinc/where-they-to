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
export default {
    data() {
      return {
        events: [],
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
      this._getData('events');
    }
  }
</script>
<template>
  <div class="main">
    <h1>Users</h1>
    <ul>
      <li v-for="event in events">
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
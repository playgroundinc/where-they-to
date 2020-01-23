<template>
  <div class="main">
    <h1>Performers</h1>
    <ul>
      <li v-for="performer in performers" v-bind:key="performer.id">
        <a :href="'performers/' + performer.id"> {{ performer.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
    data() {
      return {
        performers: [],
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
    }
  }
</script>
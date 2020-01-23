<template>
  <div class="main">
    <h1>Families</h1>
    <ul>
      <li v-for="family in families" v-bind:key="family.id">
        <a :href="'families/' + family.id"> {{ family.name }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
    data() {
      return {
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
      this._getData('families');
    }
  }
</script>
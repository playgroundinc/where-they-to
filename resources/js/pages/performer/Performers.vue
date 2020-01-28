
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
  import { mapState } from 'vuex';

export default {

    data() {
      return {
      }
    },
    computed: mapState(['performers', 'user']),
    mounted() {
      if (!this.performers.length > 0) {
      }
    }
  }
</script>
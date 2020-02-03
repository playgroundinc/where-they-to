
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
  import { mapState } from 'vuex';

export default {
    data() {
      return {
      }
    },
    computed: mapState(['families', 'user']),
  }
</script>
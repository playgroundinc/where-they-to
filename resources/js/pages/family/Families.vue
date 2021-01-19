
<template>
  <div class="main">
    <h1>Families</h1>
    <ul>
      <li v-for="family in families" v-bind:key="family.id">
        <a :href="'families/' + family.id"> {{ family.name }}</a>
      </li>
    </ul>
    <Button link="/families/create" label="Create a Family" />
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  // Components
  import Button from "../../components/Button";

export default {
    data() {
      return {
      }
    },
    components: {
      Button
    },
    computed: mapState(['families', 'user']),
  }
</script>
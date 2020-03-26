<template>
    <div v-if="listitems"><h2>{{ title }}</h2>
      <div v-if="listitems.length > 0">
        <h3>Edit {{ slug }}:</h3>
        <ul>
          <li v-for="item in listitems" v-bind:key="item.id">
            <a :href="'/' + slug + '/' + item.id">{{ item.name }}</a>
          </li>
        </ul>
      </div>
      <div v-else>
        <p>You currently have no {{ slug }}.</p>
      </div>
      <a class="btn" :href="'/' + slug + '/create'">Create New {{ title }}</a>
    </div>
</template>

<script>
export default {
  props: {
    listitems: {
      required: true,
    },
    slug: {
      type: String,
      required: true,
    }, 
    title: {
      type: String,
      required: true,
    }
  }
}
</script>
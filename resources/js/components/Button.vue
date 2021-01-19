// This is a Button component.
// If you need to use the click event, use button variation.
// On click this will emit the "clicked" event. 

<template>
    <div v-if="label">
      <input v-if="variation === 'input'" type="submit" :class="classes ? classes : 'btn'" :value="label">
      <a v-else-if="link" :href="link" :class="classes ? classes : 'btn copy--center'">{{ label }}</a>
      <button v-else :class="classes ? classes : 'btn'" @click.prevent="handleClick">{{ label }}</button>
    </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    link: {
      type: String,
      required: false,
    }, 
    variation: {
      type: String,
      required: false,
    },
    classes: {
      type: String,
      required: false,
    }
  },
  methods: {
    handleClick: function(e) {
      this.$emit('clicked', e);
    }
  }
}
</script>
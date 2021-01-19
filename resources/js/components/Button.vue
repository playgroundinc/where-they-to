// This is a Button component.

<template>
    <div v-if="label">
      <input v-if="variation === 'input'" type="submit" class="btn" :value="label">
      <a v-else-if="link" :href="link" class="btn">{{ label }}</a>
      <button v-else class="btn">{{ label }}</button>
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
      required: true,
    }
  }
}
</script>
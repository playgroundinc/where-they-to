<template>
	<div>
    <div v-if="name">
      <h2 class="copy--center">Current Family</h2>
      <p class="copy--center">
        <a href="#" @click.prevent="clearValues" type="button">Clear current family</a>		
      </p>
      <p class="copy--bold copy--center">{{ name }}</p>
    </div>
    <div v-else>	
      <h2 class="copy--center">Family</h2>
      <Autocomplete 
        label="Family"
        :errors="errors"
        route="families"
        v-on:selection="updateValue"
      />
    </div>
	</div>
</template>
<script>
import Autocomplete from "../components/Autocomplete";

export default {
	props: {
		name: {
			type: String,
			required: true,
    },
    errors: {
      type: Array,
      required: true,
    }
	},
	components: {
		Autocomplete,
	},
	methods: {
		clearValues: function() {
      this.$emit('update', { name: '', id: '' });
		},
		updateValue: function(updateObject) {
			this.$emit("update", updateObject);
		},
		toggleExisting: function() {
			this.clearValues();
		}
	}
}
</script>
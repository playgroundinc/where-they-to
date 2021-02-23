<template>
	<div>
		<div v-if="existing">
			<div v-if="address">
				<h2 class="copy--center">Current Venue</h2>
				<p class="copy--center">
					<a href="#" @click.prevent="clearValues" type="button">Clear current venue.</a>		
				</p>
				<p class="copy--bold copy--center">{{ name }}</p>
				<p class="copy--center">{{ address }}</p>
				<p class="copy--center"> {{city }}, {{ province }}</p>
			</div>
			<div v-else>	
				<h2 class="copy--center">Venue</h2>
				<p class="copy--center">
					Can't find your venue? <a href="#" @click.prevent="toggleExisting" type="button">Add venue details.</a>		
				</p>
				<Autocomplete 
					label="Venue"
					:errors="errors"
					route="venues"
					v-on:selection="updateVenue"
				/>
			</div>
		</div>
		<div v-else>
			<h2 class="copy--center">Venue</h2>
			<p class="copy--center">
				Does your venue already have a profile? <a href="#" @click.prevent="toggleExisting" type="button">Search venues</a>		
			</p>
			<Input 
				type="text"
				name="venue_name"
				:value="name"
				v-on:update="updateValue"
			/>
			<Address 
				:address="address"
				:province="province"
				:city="city"
				:errors="errors"
				:timezone="timezone"
				v-on:update="updateValue"
				v-on:buttonClick="toggleExisting"
			/>
		</div>
	</div>
</template>
<script>
import Address from "../components/Address";
import Autocomplete from "../components/Autocomplete";
import Input from "../components/Input";

export default {
	data() {
		return {
			existing: true,
		}
	},
	props: {
		address: {
			type: String,
			required: true,
		},
		name: {
			type: String,
			required: true,
		},
		venue_name: {
			type: String,
			requited: false,
		},
		province: {
			type: String,
			required: true,
		},
		city: {
			type: String,
			required: true,
		},
		errors: {
			type: Array,
			required: true,
		},
		timezone: {
			type: String,
			required: true,
		}
	},
	components: {
		Address,
		Autocomplete,
		Input,
	},
	methods: {
		clearValues: function() {
			const fields = ['address', 'city', 'province', 'venue_id', 'timezone', 'venue_name'];
			fields.forEach(field => {
				this.$emit('update', { name: field, value: '' });
			});
		},
		updateVenue: function(updateObject) {
			this.$emit("updateVenue", updateObject);
		},
		updateValue: function(updateObject) {
			this.$emit("update", updateObject);
		},
		toggleExisting: function() {
			this.clearValues();
			this.existing = !this.existing;
		}
	}
}
</script>
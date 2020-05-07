<template>
	<div class="main" v-if="user">
		<h1>Create Venue Profile</h1>
		<form v-on:submit.prevent="handleSubmit" action="'/venues/' + id">
			<div>
				<label class="label" for="name">Name</label>
				<input class="input" type="text" name="name" v-model="name">
				<label class="label" for="description">Bio</label>
				<textarea class="input" name="description" id="description" cols="30" rows="10" placeholder="Venue description" v-model="description"></textarea>
				<label class="label" for="address">Address</label>
				<input class="input" type="text" name="address" v-model="address">
				<label class="label" for="city">City</label>
				<input class="input" type="text" name="city" v-model="city">
			</div>
			<input class="btn" type="submit" value="Edit Profile">
		</form>
	</div>
</template>

<script>
import { mapState } from 'vuex';
import Location from "../../components/Location";
export default {
    data() {
		return {
			name: '',
			description: '',
			address: '',
			city: '',
		}
    },
    computed: {
		...mapState(['user']),
    },
    methods: {
		handleSubmit: async() => {
			let data = {
				name: this.name,
				description: this.description,
				address: this.address,
				city: this.city,
				id: this.user.id,
			}
			try {
				const response = await this.$store.dispatch('create', { route: 'venues', data});
				await this.$store.dispatch('fetchState', {
					route: 'venues'
				});
				this.$store.dispatch('findUser');
				this.$router.push('/dashboard');
			} catch(err) {
				console.log(err);
			}
		}
    },
    mounted() {
		if(this.user === 0) {
			this.$store.dispatch('findUser');
		}
	}
}
</script>
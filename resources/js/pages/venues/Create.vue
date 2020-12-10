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
			</div>
			<h2>Create Social Links</h2>
			<label class="label" for="facebook">Facebook</label>
			<input type="text" class="input" id="facebook" name="facebook" v-model="facebook">
			<label for="instagram" class="label">Instagram</label>
			<input type="text" class="input" id="instagram" name="instagram" v-model="instagram">
			<label for="twitter" class="label">Twitter</label>
			<input type="text" class="input" id="twitter" name="twitter" v-model="twitter">
			<label for="youtube" class="label">Youtube</label>
			<input type="text" class="input" id="youtube" name="youtube" v-model="youtube">
			<label for="website" class="label">Website</label>
			<input type="text" class="input" id="website" name="website" v-model="website">
			<input class="btn" type="submit" value="Create Venue">
		</form>
	</div>
</template>

<script>
import { mapState } from 'vuex';
export default {
    data() {
		return {
			name: '',
			description: '',
			address: '',
			country: '',
			state: '',
			city: '',
			facebook: '',
			instagram: '',
			twitter: '',
			youtube: '',
			website: '',
		}
    },
    computed: {
		...mapState(['user']),
	},
	components: {
        
    },
    async beforeMount() {
		if(this.user === 0) {
			await this.$store.dispatch('findUser');
		}
		this.setLocation('country', this.user);
		this.setLocation('state', this.user);
		this.setLocation('city', this.user);
	},
	methods: {
		handleSubmit: async function() {
			let data = {
				name: this.name,
				description: this.description,
				address: this.address,
				city: this.city,
				state: this.state,
				country: this.country,
				id: this.user.id,
				facebook: this.facebook,
				instagram: this.instagram,
				twitter: this.twitter,
				youtube: this.youtube,
				website: this.website,
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
		},
		setLocation: function (key, user) {
			if (user[key]) {
				this[key] = user[key];
			}
		},
		echoLocation: function(locationObject) {
			if (locationObject.key === "country") {
                this.state = "";
                this.city = "";
            }
            this[locationObject.key] = locationObject.value;
		}
	}
}
</script>
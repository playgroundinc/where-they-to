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
				<Location
					:country="country"
					:city="city" 
					:state="state"
					@changed="echoLocation"
				></Location>
			</div>
			<input class="btn" type="submit" value="Create Venue">
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
			country: '',
			state: '',
			city: '',
		}
    },
    computed: {
		...mapState(['user']),
	},
	components: {
        Location
    },
    async mounted() {
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
		echoLocation: function() {
			if (location.key === "country") {
                this.state= "";
            }
            if (location.key === "country" || location.key === "state") {
                this.city = "";
            }
            this[location.key] = location.value;
		}
	}
}
</script>
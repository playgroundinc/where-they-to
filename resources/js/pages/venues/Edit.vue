<template>
	<div class="main" v-if="id">
		<h1>Edit Venue profile</h1>
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
			<div>
				<h2>Edit Social Links</h2>
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
			</div>
			<input class="btn" type="submit" value="Edit Profile">

		</form>
		<button class="btn btn--danger" v-on:click="handleDelete">Delete Profile</button>
	</div>
</template>

<script>
	import { mapState } from 'vuex';
	export default {

    data() {
		return {
			id: this.$route.params.id,
			name: '',
			description: '',
			address: '',
			city: '',
			facebook: '',
			instagram: '',
			twitter: '',
			website: '',
			youtube: '',
		}
    },
    computed: {
		...mapState(['venues', 'user']),
		venue: {
			get: function() {
				const venue = this.venues.find(entry => Number(entry.id) === Number(this.id));
				this.name = venue.name;
				this.description = venue.description;
				this.address = venue.address;
				this.city = venue.city;
				this.facebook = venue.social_links.facebook;
				this.instagram = venue.social_links.instagram;
				this.twitter = venue.social_links.twitter;
				this.website = venue.social_links.website;
				this.youtube = venue.social_links.youtube;
				return venue;
			}
		},
    },
    methods: {
		handleSubmit: function() {
			let data = {
				name: this.name,
				description: this.description,
				address: this.address,
				city: this.city,
				facebook: this.facebook,
				instagram: this.instagram,
				twitter: this.twitter,
				website: this.website,
				youtube: this.youtube,
				socialLinksId: this.venue.social_links.id,
			}
			let route = `venues`;
			this.$store
				.dispatch('edit', {
					route, 
					id: this.id,
					data
			}).then(() => {
				this.$router.push(`/venues/${this.id}`)
			}).catch((err)=>{
				console.log(err);
			});
		},
		handleDelete: function() {
			this.$store.dispatch('destroy', {
				route: 'venues',
				id: this.id,
			}).then(()=>{
				this.$router.push('/venues');
			});
		}
    },
    async mounted() {
		if(this.user === 0) {
			this.$store.dispatch('findUser');
		}
    }
}
</script>
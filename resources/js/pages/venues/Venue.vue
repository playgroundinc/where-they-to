
<template>
	<div class="main" v-if="venue">
		<h1>{{ venue.name }}</h1>
		<h2>Description</h2>
		<p>{{ venue.description }}</p>
		<div>
			<p v-if="venue.address">{{ venue.address }}</p>
			<p><span v-if="venue.city">{{ venue.city }},</span> {{ venue.province }} </p>
		</div>
		<div v-if="venue.social_links">
			<h2>Social Links</h2>
			<ul>
				<li>Facebook: {{ venue.social_links.facebook }}</li> 
				<li>Twitter: {{ venue.social_links.twitter }}</li>
				<li>Instagram: {{ venue.social_links.instagram }}</li>
				<li>YouTube: {{ venue.social_links.youtube }}</li>
				<li>Website: {{ venue.social_links.website }}</li>
			</ul>
		</div>
		<div v-if="venue.user_id && user && venue.user_id === user.id">
			<a class="btn" :href="'/venues/' + venue.id + '/edit'" >Edit Profile</a>
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex';

export default {

    data() {
		return {
			id: this.$route.params.id,
			platforms: [],
		}
    },
    computed: {
		...mapState(['user', 'venues', 'families']),
		venue: function() {
			return this.venues.find(entry => Number(entry.id) === Number(this.id))
		},
    },
    created() {
		if (!this.user) {
			this.$store.dispatch('findUser');
		}
    }

}
</script>
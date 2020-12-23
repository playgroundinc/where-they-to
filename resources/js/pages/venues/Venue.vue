
<template>
	<div v-if="venue">
		<main class="container">
			<h1 class="copy--center">{{ venue.name }}</h1>
			<div class="row">
				<div class="col-md-6 col-xxs-12">

				</div>
				<div class="col-md-6 col-xxs-12">
					<h2>About</h2>
					<p>{{ venue.description }}</p>
					<div>
						<p v-if="venue.address">{{ venue.address }}</p>
						<p><span v-if="venue.city">{{ venue.city }},</span> {{ venue.province }} </p>
					</div>
					<SocialLinks 
						:socialLinks="socialLinks"
					/>
				</div>
			</div>
			<div v-if="venue.user_id && user && venue.user_id === user.id">
				<a class="btn copy--center" :href="'/venues/' + venue.id + '/edit'" >Edit Profile</a>
			</div>
		</main>
	</div>
</template>

<script>
import { mapState } from 'vuex';

import SocialLinks from "../../components/SocialLinks";

export default {

    data() {
		return {
			id: this.$route.params.id,
			platforms: [],
			venue: [],
			socialLinks: [],
		}
    },
    computed: {
		...mapState(['user']),
    },
	mounted() {
		this.getVenue();
	},
	components: {
		SocialLinks,
	},
	methods: {
		getVenue: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "venues", id: this.id });
			if (resp.status === 200) {
				this.venue = resp.data.venue;
				this.socialLinks = resp.data.socialLinks;
			}
		},
		toggleModal: function() {
			this.tipModal = !this.tipModal;
		}
	}
}
</script>
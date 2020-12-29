<template>
	<div>
		<main class="container">
			<div class="row">
				<div class="col-xxs-12">
					<h1 class="copy--center">{{ event.name }}</h1>
					<ul v-if="eventTypes.length">
						<li v-for="eventType in eventTypes" v-bind:key="eventType.id">{{ eventType.name }}</li>
					</ul>
				</div>
				<div class="col-xxs-12 col-md-6">

				</div>
				<div class="col-xxs-12 col-md-6">
					<p>{{ event.date }} at {{ event.show_time }}</p>
					<p v-if="event.doors">Doors @ {{ event.doors }}</p>
					<div v-if="venue">
						<p>{{ venue.name }}</p>
						<p>{{ venue.address }}</p>
						<p>{{ venue.city}}, {{ venue.province }}</p>
					</div>
					<div v-else>
						<p>{{ event.address }}</p>
						<p>{{ event.city}}, {{ event.province }}</p>
					</div>
					<div>
						<p>{{ event.description	 }}</p>
					</div>
					<div v-if="family && family.name">
						<h2>Family</h2>
						<a :href="familyLink">{{ family.name }}</a>
					</div>
					<div v-if="performers.length">
						<h2>Performers</h2>
						<ul>
							<li v-for="performer in performers" v-bind:key="performer.id">
								<a :href="'/performers/' + performer.id">{{ performer.name }}</a>
							</li>
						</ul>
					</div>
					<div>
						<a class="btn copy--center" :href="'/events/' + id + '/edit'" >Edit Profile</a>
					</div>
				</div>
				<SocialLinks 
					:socialLinks="socialLinks"
				/>
				
			</div>
		</main>
	</div>
</template>

<script>
import { mapState } from 'vuex';

import SocialLinks from "../../components/SocialLinks";
import Lists from "../../components/Lists";

export default {

	data() {
		return {
			id: this.$route.params.id || '',
			family: "",
			event: {},
			eventTypes: [],
			performers: [],
			socialLinks: [],
			venue: {},	
		}
	},
	computed: {
		...mapState(['user']),
		familyLink: function() {
			return `/families/${this.family.id}`;
		}
    },
    created() {
		this.getEvent();
	},
	components: {
		Lists,
		SocialLinks,
	},
	methods: {
		setState: function(update) {
			const fields = ['event', 'eventTypes', 'family', 'performers', 'socialLinks', 'venue'];
			fields.forEach((field) => {
				this[field] = update[field];
			});
		},
		getEvent: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "events", id: this.id });
			this.setState(resp.data);
		}
	}
}
</script>
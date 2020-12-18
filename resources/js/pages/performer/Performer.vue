
<template>
	<div class="main" v-if="performer">
		<h1>{{ performer.name }}</h1>
		<h2>Bio</h2>

		<p>{{ performer.bio }}</p>
		<div v-if="family">
			<h2>Family</h2>
			<a :href="'/families/' + family.id" >{{ family.name }}</a>
		</div> 
		<div v-if="events.length > 0">
			<h2>Events</h2>
			<ul>
				<li v-for="event in events" v-bind:key="event.id">
					<a :href="'/events/' + event.id">
						<p>{{event.name}}</p>
						<p>{{event.date}}</p>
						<p>{{event.time}}</p>
						<p>{{event.venue.name}}</p>
					</a>
				</li>
			</ul>
		</div>

		<div v-if="performer.socialLinks">
			<h2>Social Links</h2>
			<ul>
				<li>Facebook: {{ performer.socialLinks.facebook }}</li> 
				<li>Twitter: {{ performer.socialLinks.twitter }}</li>
				<li>Instagram: {{ performer.socialLinks.instagram }}</li>
				<li>YouTube: {{ performer.socialLinks.youtube }}</li>
				<li>Website: {{ performer.socialLinks.website }}</li>
			</ul>
		</div>
		<div v-if="performer.user_id && user && performer.user_id === user.id">
			<a class="btn" :href="'/performers/' + performer.id + '/edit'" >Edit Profile</a>
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
			events: [],
		}
    },
    computed: {
		...mapState(['user', 'performers', 'families']),
		performer: function() {
			return this.performers.find(entry => Number(entry.id) === Number(this.id))
		},
		family: function() {
			return this.families.find(entry => Number(entry.id) === Number(this.performer.family_id));
		}
	},
	async mounted() {
		const date = new Date();
		const resp = await axios.get(`http://127.0.0.1:8000/api/performers/${this.id}/events`);
		this.events = resp.data.events;
	},
    created() {
		if (!this.user) {
			this.$store.dispatch('findUser');
		}
    }
}
</script>
<template>
	<div>
		<main class="container">
			<div class="row">
				<div class="col-xxs-12">
					<h1 class="copy--center">{{ event.name }}</h1>
					<ul v-if="eventTypes && eventTypes.length">
						<li v-for="eventType in eventTypes" v-bind:key="eventType.id">{{ eventType.name }}</li>
					</ul>
				</div>
				<div class="col-xxs-12 col-md-6">

				</div>
				<div class="col-xxs-12 col-md-6">
					<Button 
						:label="attendanceText"
						v-on:clicked.prevent="handleAttendance"
					/>
					<p>{{ event.date }} at {{ event.show_time }}</p>
					<p v-if="event.doors">Doors @ {{ event.doors }}</p>
					<div v-if="venue.id">
						<p><a :href="'/venues/' + venue.slug">{{ venue.name }}</a></p>
						<p>{{ venue.address }}</p>
						<p>{{ venue.city}}, {{ venue.province }}</p>
					</div>
					<div v-else-if="event.address">
                        <p class="copy--bold">{{ event.venue_name }}</p>
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
					<div v-if="performers.length || (event.performers_no_profile && event.performers_no_profile.length)">
						<h2>Performers</h2>
						<ul v-if="performers && performers.length">
							<li v-for="performer in performers" v-bind:key="performer.id">
								<a :href="'/performers/' + performer.slug">{{ performer.name }}</a>
							</li>
						</ul>
						<ul v-if="event.performers_no_profile && event.performers_no_profile.length">
							<li v-for="performer_no_profile in event.performers_no_profile" v-bind:key="performer_no_profile.name">{{ performer_no_profile	.name }}</li>
						</ul>
					</div>
					<SocialLinks 
                        :socialLinks="socialLinks"  
					/>
					<div>
						<Button :link="'/events/' + slug + '/edit'" label="Edit Event" />
					</div>
					<Updates 
						type="event"
						:id="id"
					/>
				</div>

				
			</div>
		</main>
	</div>
</template>

<script>
import { mapState } from 'vuex';

// Components.
import SocialLinks from "../../components/SocialLinks";
import Lists from "../../components/Lists";
import Button from "../../components/Button";
import Updates from "../../components/Updates";

export default {

	data() {
		return {
			slug: this.$route.params.slug,
            id: '',
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
			return `/families/${this.family.slug}`;
		},
		attendanceText: function(){
			if (!this.user.attending || this.user.attending.indexOf(this.id) === -1) {
				return 'RSVP';
			}
			return 'Cancel RSVP';
		}
	},
	created() {
		this.getEvent();
	},
	components: {
        Button,
		Lists,
        SocialLinks,
        Updates,
	},
	methods: {
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
		setState: function(update) {
			const fields = ['event', 'eventTypes', 'family', 'performers', 'socialLinks', 'venue'];
			fields.forEach((field) => {
                if (update[field]) {
                    this[field] = update[field];
                }
			});
    },
    async handleAttendance() {
		const data = {
			user_id: this.user.id,
			route: 'attendance',
			route_id: this.id,
		}
		const resp = await this.$store.dispatch('toggleEngagement', data)
		if (resp.data.status && resp.data.status === 'success') {
			this.$store.dispatch('findUser');
		}
	},
		getEvent: async function() {
			try {
				const resp = await this.$store.dispatch('fetchSingle', { route: "events", id: this.slug });
                if (resp.status === 200) {
                    this.updateValue({ name: 'id', value: `${resp.data.event.id}`});
                    this.setState(resp.data);
                }
			} catch(err) {
				console.log(err);
			}
		}
	}
}
</script>
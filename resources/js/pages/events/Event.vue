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
          <Button 
            :label="attendanceText"
            v-on:clicked.prevent="handleAttendance"
          />
					<p>{{ event.date }} at {{ event.show_time }}</p>
					<p v-if="event.doors">Doors @ {{ event.doors }}</p>
					<div v-if="venue">
						<p>{{ venue.name }}</p>
						<p>{{ venue.address }}</p>
						<p>{{ venue.city}}, {{ venue.province }}</p>
					</div>
					<div v-else-if="event.address">
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
					<SocialLinks 
					:socialLinks="socialLinks"
					/>
					<div>
						<Button :link="'/events/' + id + '/edit'" label="Edit Event" />
					</div>
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
	},
	methods: {
		setState: function(update) {
			const fields = ['event', 'eventTypes', 'family', 'performers', 'socialLinks', 'venue'];
			fields.forEach((field) => {
				this[field] = update[field];
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
				const resp = await this.$store.dispatch('fetchSingle', { route: "events", id: this.id });
				this.setState(resp.data);
			} catch(err) {
				console.log(err);
			}
		}
	}
}
</script>
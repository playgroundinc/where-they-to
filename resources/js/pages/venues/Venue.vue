
<template>
	<div v-if="venue">
		<main class="container">
			<h1 class="copy--center">{{ venue.name }}</h1>
			<div class="row">
				<div class="col-md-6 col-xxs-12">

				</div>
				<div class="col-md-6 col-xxs-12">
                    <Button 
                        :label="followinglabel"
                        v-on:clicked.prevent="toggleFollowing"
                    />
					<h2>About</h2>
					<p>{{ venue.description }}</p>
					<div>
						<p v-if="venue.address">{{ venue.address }}</p>
						<p><span v-if="venue.city">{{ venue.city }},</span> {{ venue.province }} </p>
					</div>
					<SocialLinks 
						:socialLinks="socialLinks"
					/>
                    <Updates 
                        type="venue"
                        :id="id"
                    />
                    <UpcomingEvents 
                        :events="events.current"
                        :total="events.total"
                        :page="events.page"
                        :id="id"
                        route="venues"
                        v-on:update="updateValue"
                    />
				</div>
			</div>
			<div v-if="venue.user_id && user && venue.user_id === user.id">
				<Button :link="'/venues/' + venue.id + '/edit'" label="Edit Venue" />
			</div>
		</main>
	</div>
</template>

<script>
import { mapState } from 'vuex';

// Components
import Button from "../../components/Button";
import SocialLinks from "../../components/SocialLinks";
import Updates from "../../components/Updates";
import UpcomingEvents from "../../components/UpcomingEvents";

export default {

    data() {
		return {
			id: this.$route.params.id,
			platforms: [],
			venue: [],
			socialLinks: [],
            events: {
                current: [],
                total: 0,
                page: 0,
            },
		}
    },
    computed: {
        ...mapState(['user']),
        followinglabel: function() {
            const venues = this.user.following_venues;
            if (!venues || !venues.length || venues.indexOf(this.id) === -1) {
            return 'Follow';
        }
        return 'Unfollow'; 
        }
    },
	mounted() {
		this.getVenue();
	},
	components: {
        Button,
        SocialLinks,
        Updates,
        UpcomingEvents,
	},
	methods: {
		getVenue: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "venues", id: this.id });
			if (resp.status === 200) {
				this.venue = resp.data.venue;
				this.socialLinks = resp.data.socialLinks;
                this.events = resp.data.events;
			}
        },
        async toggleFollowing() {
            const data = {
                user_id: this.user.id,
                route: 'follow/venue',
                route_id: this.id,
            }
            const resp = await this.$store.dispatch('toggleEngagement', data)
            if (resp.data.status && resp.data.status === 'success') {
                this.$store.dispatch('findUser');
            }
        },
		toggleModal: function() {
			this.tipModal = !this.tipModal;
		},
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        }
	}
}
</script>
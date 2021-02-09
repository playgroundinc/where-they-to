<template>
	<div v-if="performer">
		<main class="container">
		<h1 class="copy--center">{{ performer.name }}</h1>
		<ul class="selections__list row center-md" v-if="performer.performer_types">
			<li class="selections__single" v-for="type in performer.performer_types" v-bind:key="type.id">{{ type.name }}</li>
		</ul>
		<div class="row">
			<div class="col-xxs-12 col-md-6">

			</div>
			<div class="col-xxs-12 col-md-6">
        <Button 
			:label="followinglabel"
			v-on:clicked.prevent="toggleFollowing"
        />
				<p>{{ performer.bio }}</p>
				<div v-if="socialLinks">
					<SocialLinks
						:socialLinks="socialLinks"
					/>
				</div>
				<Button
					v-if="performer.tips" 
					v-on:clicked.prevent="toggleModal" 
					:label="'Tip ' + performer.name" 
				/>			
			</div>
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
		<div v-if="performer.user_id && user && performer.user_id === user.id">
			<Button :link="'/performers/' + performer.id + '/edit'" label="Edit Profile"/>
		</div>
    <div v-if="performer.user_id && user && performer.user_id === user.id">
			<Update 
        type="performer"
        :id="id"
      />
		</div>
		<Modal 
			:title="tipTitle"
			:copy="performer.tips || ''"
			:open="tipModal"
			v-on:close="toggleModal"
		/>
		</main>
	</div>
</template>

<script>
import { mapState } from 'vuex';

// Components 
import Button from "../../components/Button";
import Modal from "../../components/Modal";
import SocialLinks from "../../components/SocialLinks";
import Update from "../../components/Updates";

export default {

    data() {
		return {
			id: this.$route.params.id,
			platforms: [],
			events: [],
			performer: [],
			socialLinks: [],
			family: [],
			types: [],
			accent_color: "#000000",
			tipModal: false,
		}
    },
    computed: {
		...mapState(['user']),
		tipTitle() {
			return `How to tip ${this.performer.name}`
    },
    followinglabel: function() {
        const performers = this.user.following_performers;
        if (!performers|| !performers.length || performers.indexOf(this.id) === -1) {
			return 'Follow';
        }
		return 'Unfollow'; 
		}
	},
	components: {
    Button,
		Modal,
    SocialLinks,
    Update,
	},
	mounted() {
		this.getPerformer();
	},
	methods: {
		getPerformer: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "performers", id: this.id });
			(resp.data);
			if (resp.status === 200) {
				this.performer = resp.data.performer;
				this.types = resp.data.types;
				this.family = resp.data.family;
				this.socialLinks = resp.data.socialLinks;
			}
    },
    async toggleFollowing() {
      const data = {
        user_id: this.user.id,
        route: 'follow/performer',
        route_id: this.id,
      }
      const resp = await this.$store.dispatch('toggleEngagement', data)
      if (resp.data.status && resp.data.status === 'success') {
        this.$store.dispatch('findUser');
      }
    },
		toggleModal: function() {
			this.tipModal = !this.tipModal;
		}
	}
}
</script>
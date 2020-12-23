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
				<p>{{ performer.bio }}</p>
				<div v-if="socialLinks">
					<SocialLinks
						:socialLinks="socialLinks"
					/>
				</div>
				<button class="btn" @click.prevent="toggleModal" v-if="performer.tips">Tip {{ performer.name}}</button>
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
			<a class="btn copy--center" :href="'/performers/' + performer.id + '/edit'" >Edit Profile</a>
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
import Modal from "../../components/Modal";
import SocialLinks from "../../components/SocialLinks";

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
			tipModal: false,
		}
    },
    computed: {
		...mapState(['user']),
		tipTitle() {
			return `How to tip ${this.performer.name}`
		}
	},
	components: {
		Modal,
		SocialLinks,
	},
	mounted() {
		this.getPerformer();
	},
	methods: {
		getPerformer: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "performers", id: this.id });
			if (resp.status === 200) {
				this.performer = resp.data.performer;
				this.types = resp.data.types;
				this.family = resp.data.family;
				this.socialLinks = resp.data.socialLinks;
			}
		},
		toggleModal: function() {
			this.tipModal = !this.tipModal;
		}
	}
}
</script>
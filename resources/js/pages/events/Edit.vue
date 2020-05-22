<template>
	<div class="main" v-if="user && event">
		<h1>Edit Event</h1>
		<form action="/events" v-on:submit.prevent="handleSubmit">
			<label class="label" for="name" >Name</label>
			<input class="input" type="text" name="name" id="name" v-model="event.name">
			<label class="label" for="description">description</label>
			<textarea class="input" name="description" id="description" cols="30" rows="10" v-model="event.description"></textarea>
			<label class="label" for="date">Date</label>
			<input class="input" type="text" name="date" id="date" v-model="event.date">
			<label class="label" for="venue">Venue</label>
			<div v-if="venue">
				<select class="input" name="venue" id="venue" v-model="event.venue_id">
					<option v-for="venue in venues" v-bind:key="venue.id" :value="venue.id" v-text="venue.name" :selected="{ true: venue.id === event.venue_id }"></option>
				</select>
			</div>
			<fieldset v-if="eventTypes">
				<legend for="type" class="label">Event Type</legend>
				<ul class="list">
					<li class="list-item" v-for="eventType in eventTypes" v-bind:key="eventType.id" >
						<input type="radio" name="type" :value="eventType.id" :id="eventType.name" :checked="Number(eventType.id) === Number(event['event_type_id'])" v-model="type">
						<label :for="eventType.name" v-text="eventType.name"></label>
					</li>
				</ul> 
			</fieldset>
			<div v-if="family">
				<label class="label" for="family">Family</label>
				<select class="input" name="family" id="family" v-model="event.family_id">
					<option v-for="family in families" v-bind:key="family.id" :value="family.id" v-text="family.name"></option>
				</select>
			</div>
			<fieldset v-if="event.performers">
				<legend class="label">Current Performers</legend>
				<ul class="list">
					<li class="list-item" v-for="eventPerformer in event.performers" v-bind:key="eventPerformer.id" >
						<div v-if="eventPerformer.id !== user.id">
							<p>{{ eventPerformer.name }}</p>
							<button @click.prevent="removePerformer(eventPerformer.id)">Remove Performer</button>
						</div>
					</li>
				</ul> 
			</fieldset>
			<fieldset v-if="performers">
				<Autocomplete
                    label="Performers"
                    :values="filteredPerformers"
                    @selection="function(performer) { addPerformer(performer.id) }"
                ></Autocomplete>
			</fieldset>
			<label class="label" for="tickets">Ticket Information</label>
			<textarea class="input" name="tickets" id="tickets" cols="30" rows="10" v-model="event.tickets"></textarea>
			<label class="label" for="tickets_url">Ticket Url</label>
			<input class="input" type="url" name="tickets_url" id="tickets_url" v-model="event.tickets_url">
			<input class="btn" type="submit" value="Update Event">
		</form>
		<a v-if="this.event.social_links" :href="'/events/' + this.id + '/social-links/' + this.event.social_links.id">Update Social Links</a>
		<a v-else :href="'/events/' + this.id + '/social-links'">Create Social Links</a>
		<button class="btn btn--danger" @click.prevent="handleDelete">Delete Event</button>
	</div>
</template>

<script>
import { mapState } from 'vuex';
import Autocomplete from '../../components/Autocomplete';
export default {
	data() {
		return {
			id: this.$route.params.id || '',
			newPerformers: [],
		}
	},
	components: {
		Autocomplete,
	},
	computed: {
		...mapState(['user', 'events', 'venues', 'performers', 'families', 'eventTypes']),
		event: function() {
			return this.events.find(entry => Number(entry.id) === Number(this.id))
		},
		family: function() {
			return this.families.find((entry) => Number(entry.id) === Number(this.event.family_id))
		},
		venue: function() {
			return this.venues.find((entry) => Number(entry.id) === Number(this.event.venue_id))
		},
		filteredPerformers: function() {
			return this.performers.filter(entry => !this.event.performers.find((item) => Number(item.id) === Number(entry.id)));
		},
		type: {
			get() {
				return this.event.event_type_id;
			},
			set(value) {
				this.event.event_type_id = value;
			}	
		}
	},
	methods: {
		handleSubmit: function() {
			let data = {
				name: this.event.name,
				description: this.event.description,
				date: this.event.date,
				time: this.event.time,
				eventType: this.type,
				tickets: this.event.tickets,
				tickets_url: this.event.tickets_url,
			}

			if (this.venue) {
				data['venue'] = this.venue['id']
			}
			if (this.family) {
				data['family'] = this.family['id']
			}
			this.$store.dispatch('edit', {
				route: 'events',
				id: this.id,
				data,
			}).then((resp) => {
				this.$router.push({path: `/events/${this.id}`})
			});
		},
		handleDelete: function() {
			let data = {}
			this.$store.dispatch('destroy', {
				route: 'events',
				id: this.id,
				data,
			}).then(() => {
				this.$router.push('/events');
			}).catch((err) => {
				console.log(err)
			})
		},

		addPerformer: function(performer) {
			let data = {
				performer,
			}
			this.$store.dispatch('edit', {
				route: 'events',
				id: `${this.id}/performers`,
				data
			})
		},
		removePerformer: function(performer) {
			let data = {
				performer
			}
			this.$store.dispatch('destroy', {
				route: 'events',
				id: `${this.id}/performers`,
				data,
			})
		},
	},
	mounted: function() {
		this.$store.dispatch('fetchState', { 
			route: 'eventTypes',
		});
	}
}
</script>
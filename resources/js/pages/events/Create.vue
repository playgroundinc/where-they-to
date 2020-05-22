<template>
	<div class="main">	
		<h1>Create Event</h1>
		<form action="/events" v-on:submit.prevent="handleSubmit">
			<!-- NAME -->
			<label class="label" for="name" >Name</label>
			<input class="input" type="text" name="name" id="name" v-model="name">
			<!-- DESCRIPTION -->
			<label class="label" for="description">Description</label>
			<textarea class="input" name="description" id="description" cols="30" rows="10" v-model="description"></textarea>
			<!-- DATE -->
			<label class="label" for="date">Date</label>
			<input class="input" type="text" name="date" id="date" v-model="date">
			<!-- TIME -->
			<label for="date" class="label">Time</label>
			<input class="input" type="text" id="time" name="time" v-model="time">
			<!-- TIMEZONE -->
			<label for="timezone" class="label">Timezone</label>
			<select name="timezone" id="timezone" class="input" v-model="timezone">
				<option v-for="timezone in timezones" v-bind:key="timezone" :value="timezone">{{ timezone }}</option>
			</select>
			<!-- VENUE -->
			<label class="label" for="venue">Venue</label>
			<select class="input" name="venue" id="venue" v-model="venue">
				<option v-for="venue in venues" v-bind:key="venue.id" :value="venue.id" v-text="venue.name"></option>
			</select>
			<!-- EVENT TYPES -->
			<fieldset v-if="eventTypes">
				<legend for="type" class="label">Event Type</legend>
				<ul class="list">
					<li class="list-item" v-for="eventType in eventTypes" v-bind:key="eventType.id" >
						<input type="radio" name="type" :value="eventType.id" :id="eventType.name" v-model="type">
						<label :for="eventType.name" v-text="eventType.name"></label>
					</li>
				</ul> 
			</fieldset>
			<!-- FAMILY -->
			<div v-if="family">
				<label class="label" for="family">Family</label>
				<select class="input" name="family" id="family" v-model="family">
					<option v-for="family in families" v-bind:key="family.id" :value="family.id" v-text="family.name"></option>
				</select>
			</div>
			<!-- PERFORMERS -->
			<fieldset v-if="performers">
				<Autocomplete
                    label="Performers"
                    :values="performers"
                    @selection="function(performer) { addPerformer(performer) }"
                ></Autocomplete>
                <div v-if="newPerformers.length > 0">
                    <h2>Current Performers</h2>
                    <ul>
                        <li v-for="(performer, index) in newPerformers" v-bind:key="performer.id">
                            {{ performer.name }}
                            <a
                                href="#"
                                @click.prevent="() => removePerformer(index)"
                            >Remove</a>
                        </li>
                    </ul>
                </div>
			</fieldset>
			<!-- TICKETS -->
			<label class="label" for="tickets">Ticket Information</label>
			<textarea class="input" name="tickets" id="tickets" cols="30" rows="10" v-model="tickets"></textarea>
			<label class="label" for="tickets_url">Ticket Url</label>
			<input class="input" type="url" name="tickets_url" id="tickets_url" v-model="tickets_url">
			<input class="btn" type="submit" value="Create Event">
		</form>
	</div>
</template>

<script>
import { mapState } from "vuex";
import timezones from "../../Timezones";
import Autocomplete from "../../components/Autocomplete";

export default {
	data() {
		return {
			id: this.$route.params.id || '',
			name: '',
			description: '',
			date: '',
			time: '',
			venue: '',
			newPerformers: [],
			family: '',
			type: '',
			timezones: timezones || '',
			errors: [],
			tickets: '',
			tickets_url: '',
		}
	},
	computed: {
		...mapState(['user', 'events', 'venues', 'performers', 'families', 'eventTypes']),
		timezone: {
			get: function() {
				if (this.user.timezone) {
					return this.user.timezone;
				}
				return '';
			},
			set: function(newValue) {
				this.user.timezone = newValue
			}
		}
	},
	components: {
        Autocomplete
    },
	methods: {
		handleSubmit: function() {
			let data = {
				name: this.name,
				description: this.description,
				date: this.date,
				time: this.time,
				venue: this.venue,
				family: this.family,
				eventType: this.type,
				performers: this.newPerformers,
				timezone: this.timezone,
				tickets: this.tickets,
				tickets_url: this.tickets_url
			}
			this.$store.dispatch('create', {
				route: 'events',
				data,
			}).then(async(resp) => {
				await this.$store.dispatch('fetchState', {
					route: 'events',
				})
				this.$store.dispatch('findUser');
				this.$router.push({path: `/dashboard?events=1`})
			});
		},
		addPerformer: function(performer) {
			if (this.newPerformers.indexOf(performer) === -1) {
				this.newPerformers.push(performer);
			}
		},
		removePerformer: function(index) {
			this.newPerformers.splice(index, 1);
		},
	},
	async mounted() {
		try {
			this.$store.dispatch('fetchState', { 
				route: 'eventTypes',
			});

		} catch(error) {
			this.errors.push(error);
		}
		
	}
}
</script>
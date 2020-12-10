<template>
	<div class="main" v-if="id">
    <h1>Edit Performer profile</h1>
    <form v-on:submit.prevent="handleSubmit" action="'/performers/' + id">
		<div>
			<label class="label" for="name">Name</label>
			<input class="input" type="text" name="name" v-model="name">
			<label class="label" for="bio">Bio</label>
			<textarea class="input" name="bio" id="bio" cols="30" rows="10" placeholder="Performer bio" v-model="bio"></textarea>
		</div>
		<h2>Performer Types</h2>
		<ul v-if="types" class="list container--inner">
			<li class="list-item list-item--flex" v-for="type in types" v-bind:key="type.id">
				<p v-text="type.name"></p>
				<button v-on:click.prevent="removePerformerType(type.id)">Remove Type</button>
			</li>
		</ul>
		<h2>Add New Type</h2>
		<fieldset v-if="filteredPerformerTypes">
			<legend for="newPerformers" class="label">Performer Types</legend>
			<ul class="list">
				<li class="list-item" v-for="performerType in filteredPerformerTypes" v-bind:key="performerType.id" >
					<p>{{ performerType.name }}</p>
					<button @click.prevent="addPerformerType(performerType.id)">Add Type</button>
				</li>
			</ul> 
		</fieldset>
		<div>
			<h2>Edit Social Links</h2>
			<label class="label" for="facebook">Facebook</label>
			<input type="text" class="input" id="facebook" name="facebook" v-model="facebook">
			<label for="instagram" class="label">Instagram</label>
			<input type="text" class="input" id="instagram" name="instagram" v-model="instagram">
			<label for="twitter" class="label">Twitter</label>
			<input type="text" class="input" id="twitter" name="twitter" v-model="twitter">
			<label for="youtube" class="label">Youtube</label>
			<input type="text" class="input" id="youtube" name="youtube" v-model="youtube">
			<label for="website" class="label">Website</label>
			<input type="text" class="input" id="website" name="website" v-model="website">
		</div>
		<input class="btn" type="submit" value="Edit Profile">
	</form>
    <button class="btn btn--danger" v-on:click="handleDelete">Delete Profile</button>
</div>
</template>

<script>
	import { mapState } from 'vuex';
	export default {

	data() {
		return {
			id: this.$route.params.id,
			name: '',
			bio: '',
			facebook: '',
			instagram: '',
			twitter: '',
			youtube: '',
			website: '',
		}
    },
    computed: {
		...mapState(['performers', 'user', 'performerTypes']),
		performer: {
			get: function() {
				const performer = this.performers.find(entry => Number(entry.id) === Number(this.id));
				if (performer) {
					this.name = performer.name;
					this.bio = performer.bio;
					this.facebook = performer.social_links.facebook;
					this.instagram = performer.social_links.instagram;
					this.twitter = performer.social_links.twitter;
					this.website = performer.social_links.website;
					this.youtube = performer.social_links.youtube;
				}
				return performer;
			},
		},
		types: {
			get: function() { 
				if (this.performer) { 
					return this.performer.type 
				}
				return []
			},
			set: function(value) {
				if (this.performer) {
					this.performer.type = value;
				}
			}
		},
		filteredPerformerTypes: function() {
			if (this.performerTypes && this.performer) {
				return this.performerTypes.filter(entry => !this.performer.type.find((item) => Number(item.id) === Number(entry.id)));
			}
		},
    },
    methods: {
		handleSubmit: function() {
			let data = {
				name: this.name,
				bio: this.bio,
				performerType: [this.performerType],
				facebook: this.facebook,
				instagram: this.instagram,
				twitter: this.twitter,
				website: this.website,
				youtube: this.youtube,
				socialLinksId: this.performer.social_links.id,
			}
			let route = `performers`;
			this.$store
				.dispatch('edit', {
					route, 
					id: this.id,
					data
			}).then(() => {
				this.$router.push(`/performers/${this.id}`)
			}).catch((err)=>{
				console.log(err);
			});
		},
		handleDelete: function() {
			this.$store.dispatch('destroy', {
				route: 'performers',
				id: this.id,
			}).then(()=>{
				this.$router.push('/performers');
			});
		},
		addPerformerType: function(performerType_id) {
			let data = {
				performerType_id,
			}
			this.$store.dispatch('edit', {
				route: 'performers',
				id: `${this.id}/performerType`, 
				data
			}).then((resp)=> {
				this.$store.dispatch('fetchState', {
					route: 'performers'
				});
			})
		},
		removePerformerType: function(performerType_id) {
			let data = {
				performerType_id,
			}
			this.$store.dispatch('destroy', {
				route: 'performers',
				id: `${this.id}/performerType`, 
				data
			}).then((resp)=> {
				this.$store.dispatch('fetchState', {
					route: 'performers'
				});
			})
		}
    },
    async mounted() {
		if(this.user === 0) {
			this.$store.dispatch('findUser');
		}
		this.$store.dispatch('fetchState', { 
			route: 'performerTypes',
		})
    }

}
</script>
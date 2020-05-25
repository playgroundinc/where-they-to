<template>
	<div class="main" v-if="family && user">
		<h1>Edit Family</h1>
		<form action="/families/" v-on:submit.prevent="handleSubmit">
			<label class="label" for="name">Name</label>
			<input class="input" type="text" name="name" id="name" v-model="family.name">
			<label class="label" for="description">Description:</label>
			<textarea class="input" name="description" id="description" cols="30" rows="10" v-model="family.description"></textarea>
			<h2>Current Performers</h2>
			<ul class="list container--inner">
				<li class="list-item list-item--flex" v-for="performer in family.performers" v-bind:key="performer.id">
					<a :href="'/performers/' + performer.id" v-text="performer.name"></a>
					<button v-if="performer.id !== user.id" v-on:click.prevent="removePerformer(performer.id)">Remove Performer</button>
					<button v-if="performer.id === user.id" v-on:click.prevent="leaveFamily(performer.id)">Leave Family</button>
				</li>
			</ul>
			<h2>Add New Performer</h2>
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
			<input class="btn" type="submit" value="Submit">
		</form>
		<button class="btn btn--danger" @click.prevent="destroyFamily">Delete Family</button>
	</div>
</template>

<script>
	import { mapState } from 'vuex';
	import Autocomplete from '../../components/Autocomplete';
	export default {
		data() {
			return {
				id: this.$route.params.id,
				newPerformers: [],
			}
	},
	components: {
		Autocomplete,
	},
    computed: {
		...mapState(['families', 'performers', 'user']),
		family: function() {
			return this.families.find(entry => Number(entry.id) === Number(this.id))
		},
		filteredPerformers: function() {
			return this.performers.filter(entry => !this.family.performers.find((item) => Number(item.id) === Number(entry.id)));
		},
	},
	created() {
		if (!this.user) {
			this.$store.dispatch('findUser');
		}
    },
    methods: {
		removePerformer: function(id) {
			this.$store.dispatch('destroy', {
				route: 'families', 
				id: `performers/${id}/delete`,
			})
		},
		addPerformer: function(id) {
			let data = {
				performer: id,
			}
			this.$store.dispatch('create', {
				route: `families/${this.id}/performer`,
				data,
			}).then(()=> {
				this.$store.dispatch('fetchState', {
					route: 'families',
				})
			})
		},
		leaveFamily: function(id) {
			this.$store.dispatch('destroy', {
				route: 'families',
				id: `performers/${id}/delete`
			}).then(() => {
				this.$router.push({path: `families/${id}`});
			}).catch((err) => {
				console.log(err)
			})
		},
		handleSubmit: function() {
			let data = {
				name: this.family.name,
				description: this.family.description,
			}
			let route = `families`;
			this.$store
				.dispatch('edit', {
					route, 
					id: this.id,
					data
			}).then(() => {
				this.$router.push(`/families/${this.id}`)
			}).catch((err)=>{
				console.log(err);
			});
		},
		destroyFamily: function() {
			let data = {}
			this.$store.dispatch('destroy', {
				route: 'families',
				id: this.id,
				data
			}).then(() => {
				this.$router.push('/families');
			}).catch((err) => {
				console.log(err)
			});
		},
    }
}
</script>
<template>
	<div class="main" v-if="user">
		<h1>Create Family</h1>
		<form action="/families/" v-on:submit.prevent="handleSubmit">
			<label class="label" for="name">Name</label>
			<input class="input" type="text" name="name" id="name" v-model="name">
			<label class="label" for="description">Description:</label>
			<textarea class="input" name="description" id="description" cols="30" rows="10" v-model="description"></textarea>
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
			<input class="btn" type="submit" value="Create Family">
		</form>    
	</div>
</template>

<script>
	import { mapState } from 'vuex';
	import Autocomplete from '../../components/Autocomplete';
	export default {
		data() {
			return {
				name: '',
				description: '',
				newPerformers: [],
			}
		},
		computed: {
			...mapState(['user', 'families', 'performers']),
		},
		components: {
			Autocomplete,
		},
		methods: {
			handleSubmit: function() {
			let data = {
				name: this.name,
				description: this.description,
				performers: this.newPerformers,
			}
			let route = `families`;
			this.$store
				.dispatch('create', {
					route, 
					data
				}).then((res) => {
					this.$store.dispatch('fetchState', {
						route: 'families',
					})
					this.$router.push(`/families`)
				}).catch((err)=>{
					console.log(err);
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
		}
	}
</script>
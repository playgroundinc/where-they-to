
<template>
	<div v-if="family">
		<main class="container">
			<h1 class="copy--center">{{ family.name }}</h1>
			<div class="row">
				<div class="col-xxs-12 col-md-6">
				</div>
				<div class="col-xxs-12 col-md-6">
					<p>{{ family.description }}</p>
					<div>
						<h2>Family Members</h2>
						<ul>
							<li v-for="performer in family.performers" v-bind:key="performer.id">
								<a :href="'/performers/' + performer.id " v-text="performer.name"></a>
							</li>
						</ul>
					</div>
					<div v-if="socialLinks">
						<SocialLinks
							:socialLinks="socialLinks"
						/>
					</div>
					<div class="copy--center" v-if="familyMember">
						<a class="btn" :href="'/families/' + family.id + '/edit'" >Edit Profile</a>
					</div>
				</div>
			</div>
			
		</main>
		
	</div>
</template>

<script>
import { mapState } from 'vuex';
// Components 
import SocialLinks from "../../components/SocialLinks";

export default {

    data() {
		return {
			id: this.$route.params.id,
			family: '',
			socialLinks: [],
			performers: [],

		}
    },
    computed: {
		...mapState(['user']),
		familyMember: function() {
			if (this.user && this.family) {
				return Number(this.family.user_id) === Number(this.user.id); 
			} 
			return false;
		}
	},
	methods: {
		setStates: function(fields, object) {
			if (fields.length > 0) {
				fields.forEach((field) => {
					if (object[field]) {
						this[field] = object[field];
					}
				});
			}
		},
		getFamily: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "families", id: this.id });
			if (resp.status === 200) {
				console.log(resp);
				const fields = ['family', 'socialLinks', 'performers' ];
				this.setStates(fields, resp.data);
			}
		},
	},
	components: {
		SocialLinks,
	},
    mounted() {
		this.getFamily();
    }	
	}
</script>
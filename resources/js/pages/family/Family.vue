
<template>
	<div v-if="family">
		<main class="container">
			<h1 class="copy--center">{{ family.name }}</h1>
			<div class="row">
				<div class="col-xxs-12 col-md-6">
				</div>
				<div class="col-xxs-12 col-md-6">
          <Button 
            :label="followinglabel"
            v-on:clicked.prevent="toggleFollowing"
          />
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
          <Updates 
            type="family"
            :id="id"
          />
					<div class="copy--center" v-if="familyMember">
						<Button :link="'/families/' + family.id + '/edit'" label="Edit Family" />
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
import Button from "../../components/Button";
import Updates from "../../components/Updates";

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
    },
    followinglabel: function() {
        const families = this.user.following_families;
        if (!families|| !families.length || families.indexOf(this.id) === -1) {
          return 'Follow';
        }
        return 'Unfollow'; 
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
				const fields = ['family', 'socialLinks', 'performers' ];
				this.setStates(fields, resp.data);
			}
    },
    async toggleFollowing() {
      const data = {
        user_id: this.user.id,
        route: 'follow/family',
        route_id: this.id,
      }
      const resp = await this.$store.dispatch('toggleEngagement', data)
      if (resp.data.status && resp.data.status === 'success') {
        this.$store.dispatch('findUser');
      }
    },
	},
	components: {
    Button,
    SocialLinks,
    Updates,
	},
    mounted() {
		this.getFamily();
    }	
	}
</script>
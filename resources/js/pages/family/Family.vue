
<template>
	<div class="main" v-if="family">
		<h1>{{ family.name }}</h1>
		<h2>Bio</h2> 
		<p>{{ family.description }}</p>
		<div>
			<h2>Family Members</h2>
			<ul>
				<li v-for="performer in family.performers" v-bind:key="performer.id">
					<a :href="'/performers/' + performer.id " v-text="performer.name"></a>
				</li>
			</ul>
		</div>
		
		<div v-if="family.socialLinks">
			<h2>Social Links</h2>
			<ul>
				<li>Facebook: {{ family.socialLinks.facebook }}</li> 
				<li>Twitter: {{ family.socialLinks.twitter }}</li>
				<li>Instagram: {{ family.socialLinks.instagram }}</li>
				<li>YouTube: {{ family.socialLinks.youtube }}</li>
				<li>Website: {{ family.socialLinks.website }}</li>
			</ul>
			<a v-if="user && family.performers" :href="'/families/' + family.id + '/social-links/' + family.socialLinks.id + '/edit'" class="btn">Edit Social Links</a>
		</div>
		<div v-if="familyMember">
			<a class="btn" :href="'/families/' + family.id + '/edit'" >Edit Profile</a>
		</div>
	</div>
</template>

<script>
import { mapState } from 'vuex';

export default {

    data() {
		return {
			id: this.$route.params.id,
			platforms: [],
		}
    },
    computed: {
		...mapState(['user', 'families']),
		family: function() {
			return this.families.find(entry => Number(entry.id) === Number(this.id))
		},
		familyMember: function() {
			if (this.user) {
				return Number(this.family.user_id) === Number(this.user.id); 
			} 
			return false;
		}
    },
    created() {
		if (!this.user) {
			this.$store.dispatch('findUser');
		}
    }

  }
</script>
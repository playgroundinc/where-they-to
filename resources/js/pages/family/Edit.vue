<template>
	<div class="main" v-if="user">
		<main class="container container--core">
			<h1 class="copy--center">Create Family</h1>
			<ErrorsContainer :errors="errors"/>
			<form novalidate v-on:submit.prevent="handleSubmit">
				<div class="form-group row between-md">
					<div class="col-xxs-12">
						<Input
							name="name"
							:value="name"
							type="text"
							:required="true"
							:errors="errors"
							v-on:update="updateValue"
						/>
						<Input
							name="description"
							:value="description"
							type="textarea"
							:required="true"
							:errors="errors"
							v-on:update="updateValue"
						/>
					</div>
				</div>
				<SelectPerformers 
					:errors="errors"
					:performers="performers"
					v-on:update="updateArray"
				/>	
				<SocialMedia 
					:errors="errors"
					:facebook="facebook"
					:instagram="instagram"
					:twitch="twitch"
					:twitter="twitter"
					:tiktok="tiktok"
					:website="website"
					:youtube="youtube"
					v-on:update="updateValue"
				/>
				<input class="btn" type="submit" value="Create Family">
			</form>    
		</main>
	</div>
</template>

<script>
	import { mapState } from 'vuex';
	// Classes
	import socials from "../../core/social-media";
	import Form from "../../core/form";

	// Components
	import ErrorsContainer from "../../components/ErrorsContainer";
	import Input from "../../components/Input";
	import SocialMedia from "../../components/SocialMedia";
	import SelectPerformers from "../../components/SelectPerformers";
	export default {
		data() {
			return {
				id: this.$route.params.id,
				name: '',
				description: '',
				performers: [],
				errors: [],
				facebook: '',
				twitter: '',
				website: '',
				tiktok: '',
				twitch: '',
				youtube: '',
				instagram: '',
				socials,
			}
		},
		computed: {
			...mapState(['user']),
			performerIds() {
				return this.performers.map((performer) => performer.id);
			},
			valid() {
				return this.errors.length === 0;
			}
		},
		components: {
			ErrorsContainer, 
			Input,
			SocialMedia,
			SelectPerformers,
		},
		methods: {
			updateValue: function(updateObject) {
				this[updateObject.name] = updateObject.value;
			},
			createFamily: async function(FormClass) {
				const resp = await FormClass.submitForm();
				if (resp.status === 'success') {
					await this.$store.dispatch("findUser");
					this.$router.push('/dashboard');
				}
			},
			handleSubmit: function() {
				let data = {
					name: this.name,
					description: this.description,
					performers: this.performerIds,
				}
				const FormClass = new Form(data, "create", { route: "families" });
				this.errors = FormClass.checkRequiredFields(data);
				if (this.valid) {
					const additionalData = this.getSocialMediaData();
					FormClass.setAdditionalFields(additionalData);
					this.createFamily(FormClass);
				}

			},
			addToArray: function(updateObject, currentArray) {
				const index = currentArray.findIndex(this.findValue, updateObject.value);
				if (index <= -1) {
					currentArray.push(updateObject.value);
					this[updateObject.name] = currentArray;
				}
			},
			findValue: function(value) {
				return (array) => array.value === value;
			},
			deleteFromArray: function(updateObject, currentArray) {
				const index = currentArray.findIndex(this.findValue, updateObject.value);
				if (index > -1) {
					currentArray.splice(index, 1);
					this[updateObject.name] = currentArray;
				}
			},
			updateArray: function(updateObject) {
				const currentArray = this[updateObject.name];
				if (currentArray && updateObject.add) {
					this.addToArray(updateObject, currentArray);
				} 
				if (currentArray && !updateObject.add) {
					this.deleteFromArray(updateObject, currentArray);
				}
			},
			getSocialMediaData: function() {
				const socialMediaData = {};
				for (let social in this.socials) {
					socialMediaData[social] = this[social];
				}
				return socialMediaData;
			}, 
		}
	}
</script>
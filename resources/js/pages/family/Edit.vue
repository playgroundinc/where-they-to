<template>
	<div class="main" v-if="user">
		<main class="container container--core">
			<h1 class="copy--center">Edit Family</h1>
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
                <Location 
                    :errors="errors"
                    :city="city"
                    :province="province"
                    v-on:update="updateValue"
                />
				<Select
                    label="performers"
                    route="performers"
					:errors="errors"
					:currentArray="performers"
					v-on:update="updateArray"
					:noProfile="performers_no_profile"
				/>
				<AccentColor 
					:value="accent_color"
					:errors="errors"
					v-on:update="updateValue"
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
				<Button 
					variation="input"
					label="Edit Family"
					:disabled="errors.length > 0"
				/>
			</form>    
			<div class="copy--center">
				<Button 
					classes="btn--inline copy--center" 
					v-on:clicked.prevent="toggleModal" 
					label="Delete Family" 
				/>
			</div>
		</main>
		<Modal 
			title="Are you sure?"
			copy="This action will permanently delete this family."
			:open="confirmModal"
			button="Confirm Delete"
			v-on:confirm="handleDelete"
			v-on:close="toggleModal"
		/>
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
	import Select from "../../components/Select";
	import Modal from "../../components/Modal";
	import Button from "../../components/Button";
	import AccentColor from "../../components/AccentColor";
    import Location from "../../components/Location";

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
				socialLinksId: '',
				confirmModal: false,
				accent_color: "#000000",
				performers_no_profile: [],
                city: '',
                province: '',
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
			AccentColor,
			ErrorsContainer, 
			Button,
			Input,
            Location,
			Modal,
			SocialMedia,
			Select,
		},
		mounted() {
			this.getFamily();
		},
		methods: {
			updateValue: function(updateObject) {
				this[updateObject.name] = updateObject.value;
			},
			setStates: function(fields, object) {
				if (fields.length > 0) {
					fields.forEach((field) => {
						if (object[field]) {
							this[field] = object[field];
						}
					});
				}
			},
			setSocialLinks: function(socialLinks) {
				const socials = ['facebook', 'instagram', 'twitch', 'twitter', 'tiktok', 'youtube', 'website'];
				this.setStates(socials, socialLinks);
				this.socialLinksId = socialLinks.id;
			},
			setState: function(name, value) {
				this[name] = value;
			},

			updateFamily: async function(FormClass) {
				const resp = await FormClass.submitForm();
				if (resp.status === 'success') {
					await this.$store.dispatch("findUser");
					this.$router.push(`/families/${this.id}`);
				}
			},
			setFamily: function(family) {
				const fields = ['name', 'description', 'accent_color', 'city', 'province'];
				this.setStates(fields, family);
			},
			getFamily: async function() {
				const resp = await this.$store.dispatch('fetchSingle', { route: "families", id: this.id });
				if (resp.status === 200) {
					this.setFamily(resp.data.family);
					this.setSocialLinks(resp.data.family.social_links);
					this.setState('performers', resp.data.family.performers);
					this.setState('performers_no_profile', resp.data.family.performers_no_profile);
					return;
				}
			},
			getSocialMediaData: function() {
				const socialMediaData = {};
				for (let social in this.socials) {
					socialMediaData[social] = this[social];
				}
				return socialMediaData;
			}, 
			handleSubmit: function() {
				let data = {
					name: this.name,
					description: this.description,
					performers: this.performerIds,
					accent_color: this.accent_color,
				}
				const FormClass = new Form(data, "edit", { route: "families", id: this.id });
				this.errors = FormClass.checkRequiredFields(data);
				if (this.valid) {
					const socialMediaData = this.getSocialMediaData();
					const additionalData = this.addAdditionalData(socialMediaData);
					FormClass.setAdditionalFields(additionalData);
					this.updateFamily(FormClass);
				}

			},
			addToArray: function(updateObject, currentArray) {
				const index = this.findValue(currentArray, updateObject.value);
				if (index <= -1) {
					currentArray.push(updateObject.value);
					this[updateObject.name] = currentArray;
				}
			},
			findValue: function(currentArray, updateObject) {
				let index = -1;
				currentArray.forEach((item, i) => {
					if (updateObject.id === 0) {
						if (item.name === updateObject.name) {
							index = i;
							return index;
						}
					}
					if (updateObject.id && item.id === updateObject.id) {
						index = i;
						return index;
					}
					if (item.id === updateObject) {
						index = i;
						return index;
					}
				});
				return index;
			},
			addAdditionalData: function(currentFields) {
				const fields = ['socialLinksId', 'performers_no_profile', 'city', 'province'];
				fields.forEach((field) => {
					currentFields[field] = this[field];
				});
				return currentFields;
			},
			deleteFromArray: function(updateObject, currentArray) {
				const index = this.findValue(currentArray, updateObject.value);
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
			toggleModal: function() {
				this.confirmModal = !this.confirmModal;
			},
			handleDelete: async function() {
				const data = {
					user_id: this.user.id,
				}
				const DeleteForm = new Form(data, 'destroy', { route: 'families', id: this.id });
				const resp = await DeleteForm.submitForm();
				if (resp.status === 'success') {
					await this.$store.dispatch('findUser');
					this.$router.push('/dashboard');
				}
			},
		}
	}
</script>
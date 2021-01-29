<template>
	<div class="main" v-if="id">
		<main class="container container--core">
			<ErrorsContainer :errors="errors"/>
		<h1>Edit Venue Profile</h1>
		<form v-on:submit.prevent="handleSubmit" action="'/venues/' + id">
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
					<AccentColor 
						:value="accent_color"
						:errors="errors"
						v-on:update="updateValue"
					/>
				</div>
			</div>
			<Address
				:address="address"
				:city="city"
				:province="province"
				:timezone="timezone"
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
			<div class="col-xxs-12">
                <Button variation="input" label="Update Venue" :disabled="errors.length > 0"/>
            </div>

		</form>
		<div class="copy--center">
			<Button v-on:clicked.prevent="toggleModal" label="Delete Venue" />
		</div>
		</main>
		<Modal 
			title="Are you sure?"
			copy="This action will permanently delete this performer profile and any families and/or events created by it."
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
import Button from "../../components/Button";
import ErrorsContainer from "../../components/ErrorsContainer";
import Input from "../../components/Input";
import SocialMedia from "../../components/SocialMedia";
import Address from "../../components/Address";
import Modal from "../../components/Modal";
import AccentColor from "../../components/AccentColor"

export default {
	data() {
		return {
			errors: [],
			id: this.$route.params.id,
			name: '',
			description: '',
			address: '',
			city: '',
			province: '',
			timezone: '',
			facebook: '',
			instagram: '',
			tiktok: '',
			twitter: '',
			twitch: '',
			youtube: '',
			website: '',
			youtube: '',
			socials,
			socialLinksId: '',
			confirmModal: false,
			accent_color: "#000000",
		}
    },
    computed: {
		...mapState(['user']),
		valid() {
			return this.errors.length === 0;
		}
	},
	components: {
		AccentColor,
		Address,
		Button,
		ErrorsContainer,
		Input,
		Modal,
		SocialMedia,
	},
    methods: {
		updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
		},
		getSocialMediaData: function() {
            const socialMediaData = {};
            for (let social in this.socials) {
                socialMediaData[social] = this[social];
            }
            return socialMediaData;
		},
		getAdditionalData: function(additionalData) {
			const fields = ['timezone', 'city', 'socialLinksId'];
			fields.forEach((field) => {
				additionalData[field] = this[field];
			});
			return additionalData;
		},
		updateVenue: async function(FormClass) {
            const resp = await FormClass.submitForm();
            if (resp.status === 'success') {
                await this.$store.dispatch("findUser");
                this.$router.push(`/venues/${this.id}`);
            }
        },
		handleSubmit: function() {
			let data = {
				name: this.name,
				description: this.description,
				address: this.address,
				province: this.province,
				accent_color: this.accent_color,
				user_id: this.user.id,
			}
			const FormClass = new Form(data, "edit", { route: "venues", id: this.id });
			this.errors = FormClass.checkRequiredFields(data);
			if (this.valid) {
				const socialMediaData = this.getSocialMediaData();
				const additionalData = this.getAdditionalData(socialMediaData);
				FormClass.setAdditionalFields(additionalData);
                this.updateVenue(FormClass);
            }
		},
		toggleModal: function() {
			this.confirmModal = !this.confirmModal;
		},
		handleDelete: async function() {
			const data = {
				user_id: this.user.id,
			}
			const DeleteForm = new Form(data, 'destroy', { route: 'venues', id: this.id });
			const resp = await DeleteForm.submitForm();
			if (resp.status === 'success') {
				await this.$store.dispatch('findUser');
				this.$router.push('/dashboard');
			}
		},
		setStates: function(fields, object) {
			fields.forEach((field) => {
				if (object[field]) {
					this[field] = object[field];
				}
			});
		},
		setVenue: function(venue) {
			const fields = ['name', 'description', 'address', 'province', 'city', 'timezone', 'accent_color'];
			this.setStates(fields, venue);
			this.socialLinksId = venue.social_links.id;
		},
		setSocialLinks: function(socialLinks) {
			const socials = ['facebook', 'instagram', 'twitch', 'twitter', 'tiktok', 'youtube', 'website'];
			this.setStates(socials, socialLinks );
		},
		getVenue: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "venues", id: this.id });
			if (resp.status === 200) {
				this.setVenue(resp.data.venue);
				this.setSocialLinks(resp.data.socialLinks);
			}
		},
    },
    async mounted() {
		this.getVenue();
    }
}
</script>
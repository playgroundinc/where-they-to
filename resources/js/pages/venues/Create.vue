<template>
	<div v-if="user">
        <main class="container container--core">
			<h1 class="copy--center">Create Venue Profile</h1>
			<ErrorsContainer :errors="errors" />
			<form v-on:submit.prevent="handleSubmit" novalidate>
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
			<Accessibility 
				:value="accessibility"
				:description="accessibility_description"
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
                <Button variation="input" label="Create Venue" :disabled="errors.length > 0"/>
            </div>
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
import Address from "../../components/Address";
import Button from "../../components/Button";
import AccentColor from "../../components/AccentColor";
import Accessibility from '../../components/Accessibility.vue';

export default {
    data() {
		return {
			errors: [],
			name: '',
			description: '',
			address: '',
			province: '',
			city: '',
			timezone: '',
            instagram: '',
			facebook: '',
            twitter: '',
            website: '',
            tiktok: '',
            twitch: '',
			youtube: '',
			socials,
			accessibility: [],
			accessibility_description: '',
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
		SocialMedia,
		Accessibility,
	},
	watch: {
		user: function(newUser, oldUser) {
			const fields = ['city', 'province'];
			fields.forEach((field) => {
				this.setLocation(field, newUser);
			});
		}
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
			const fields = ['timezone', 'city', 'accessibility', 'accessibility_description'];
			fields.forEach((field) => {
				additionalData[field] = this[field];
			});
			return additionalData;
		},
		createVenue: async function(FormClass) {
            const resp = await FormClass.submitForm();
            if (resp.status === 'success') {
                await this.$store.dispatch("findUser");
                this.$router.push('/dashboard');
            }
        },
		handleSubmit: async function() {
			let data = {
				name: this.name,
				description: this.description,
				address: this.address,
				province: this.province,
				user_id: this.user.id,
				accent_color: this.accent_color,
			}
			const FormClass = new Form(data, "create", { route: "venues" });
			this.errors = FormClass.checkRequiredFields(data);
			if (this.valid) {
				const socialMediaData = this.getSocialMediaData();
				const additionalData = this.getAdditionalData(socialMediaData);
				FormClass.setAdditionalFields(additionalData);
                this.createVenue(FormClass);
            }
			return;
		},
		setLocation: function (key, user) {
			if (user[key]) {
				this[key] = user[key];
			}
		},
	}
}
</script>
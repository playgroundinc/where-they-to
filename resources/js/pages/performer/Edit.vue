<template>
	<div class="main" v-if="id">
		<main class="container container--core">
        <h1 class="copy--center">Create Performer Profile</h1>
        <ErrorsContainer :errors="errors" />
        <form
            novalidate
            method="POST"
            action="/performers"
            v-on:submit.prevent="handleSubmit"
        >
            <Input
                name="name"
                :value="name"
                type="text"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input
                name="bio"
                :value="bio"
                type="textarea"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input
                name="tips"
                :value="tips"
                type="textarea"
                :required="false"
                :errors="errors"
                v-on:update="updateValue"
                helperText="Provide instructions on how people can leave you a tip."
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
            <PerformerTypes
                :errors="errors"
                :performerTypes="performerTypes"
                v-on:update="updateArray"
            />
            <div class="col-xxs-12">
                <button type="submit" class="btn btn-default">Update Performer</button>
            </div>
        </form>
		<div class="copy--center">
			<button class="btn--inline copy--center" @click.prevent="toggleModal">Delete Profile</button>
		</div>
		<Modal 
			title="Are you sure?"
			copy="This action will permanently delete this performer profile and any families and/or events created by it."
			:open="confirmModal"
			button="Confirm Delete"
			v-on:confirm="handleDelete"
			v-on:close="toggleModal"
		/>
	</main>
</div>
</template>

<script>
	import { mapState } from 'vuex';
	// Classes.
	import socials from "../../core/social-media";
	import Form from "../../core/form";
	
	// Components
	import Input from "../../components/Input";
	import ErrorsContainer from "../../components/ErrorsContainer";
	import SocialMedia from "../../components/SocialMedia";
	import PerformerTypes from "../../components/PerformerTypes";
	import Modal from "../../components/Modal";

	export default {

	data() {
		return {
			id: this.$route.params.id,
			name: '',
			bio: '',
			tips: '',
			facebook: '',
			instagram: '',
			twitter: '',
			youtube: '',
			website: '',
			twitch: '',
			tiktok: '',
			performerTypes: [],
			errors: [],
			social_links_id: '',
			socials,
			confirmModal: false,
		}
    },
    computed: {
		...mapState(['user']),
		valid: function() {
			return this.errors.length === 0;
		}
	},
	components: {
		Input,
		ErrorsContainer,
		PerformerTypes,
		SocialMedia,
		Modal,
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
		addToArray: function(updateObject, currentArray) {
            if (!currentArray.includes(updateObject.value)) {
                currentArray.push(updateObject.value);
                this[updateObject.name] = currentArray;
            }
        },
        deleteFromArray: function(updateObject, currentArray) {
            if (currentArray.includes(updateObject.value)) {
                const index = currentArray.indexOf(updateObject.value);
                if (index > -1) {
                    currentArray.splice(index, 1);
                    this[updateObject.name] = currentArray;
                }
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
		setPerformer: function(performer) {
			const fields = ['name', 'bio', 'tips'];
			this.setStates(fields, performer);
			this.social_links_id = performer.social_links.id;
		},
		setSocialLinks: function(socialLinks) {
			const fields = ['facebook', 'instagram', 'tiktok', 'twitch', 'twitter', 'youtube', 'website'];
			this.setStates(fields, socialLinks);
		},
		getSocialMediaData: function() {
            const socialMediaData = {};
            for (let social in this.socials) {
                socialMediaData[social] = this[social];
            }
            return socialMediaData;
        },
		setPerformerTypes: function(performerTypes) {
			if (performerTypes.length > 0) {
				this.performerTypes = performerTypes.map((type) => type.id);
				return;
			}
		},
		getPerformer: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "performers", id: this.id });
			if (resp.status === 200) {
				this.setPerformer(resp.data.performer);
				this.setSocialLinks(resp.data.socialLinks);
				this.setPerformerTypes(resp.data.types);
				return;
			}
		},
		toggleModal: function() {
			this.confirmModal = !this.confirmModal;
		},
		editPerformer: async function(FormClass) {
			const resp = await FormClass.submitForm();
			if (resp.status === 'success') {
				this.$router.push(`/performers/${this.id}`);
			}
		},
		handleSubmit: function() {
            let data = {
                name: this.name,
				bio: this.bio,
                user_id: this.user.id,
            };
			const FormClass = new Form(data, "edit", { route: "performers", id: this.id });
            this.errors = FormClass.checkRequiredFields(data);
            if (this.valid) {
                const additionalData = this.getSocialMediaData();
				additionalData.performerTypes = this.performerTypes;
				additionalData.socialLinksId = this.social_links_id;
				additionalData.tips = this.tips;
				FormClass.setAdditionalFields(additionalData);
                this.editPerformer(FormClass);
            }
        },
		handleDelete: async function() {
			const data = {
				user_id: this.user.id,
			}
			const DeleteForm = new Form(data, 'destroy', { route: 'performers', id: this.id });
			const resp = await DeleteForm.submitForm();
			if (resp.status === 'success') {
				await this.$store.dispatch('findUser');
				this.$router.push('/dashboard');
			}
		},
    },
    async mounted() {
		this.getPerformer();
    }

}
</script>
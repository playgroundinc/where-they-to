<template>
    <div>
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
            <SelectTypes
                :errors="errors"
                :types="performerTypes"
                route="performerTypes"
                type="performer"
                v-on:update="updateArray"
            />
            <div class="col-xxs-12">
                <Button variation="input" label="Create Performer" :disabled="errors.length > 0" />
            </div>
        </form>
        </main>
    </div>
</template>

<script>
import { mapState } from "vuex";
// Classes.
import socials from "../../core/social-media";
import Form from "../../core/form";

// Components.
import AccentColor from "../../components/AccentColor";
import Input from "../../components/Input";
import SocialMedia from "../../components/SocialMedia";
import ErrorsContainer from "../../components/ErrorsContainer";
import SelectTypes from "../../components/SelectTypes";
import Button from "../../components/Button";

export default {
    data() {
        return {
            name: "",
            bio: "",
            errors: [],
            instagram: "",
            facebook: "",
            twitter: "",
            website: "",
            tiktok: "",
            twitch: "",
            youtube: "",
            tips: "",
            accent_color: "#000000",
            socials,
            performerTypes: [],
        }
    },
    computed: {
        ...mapState(["user"]),
        valid: function() {
            return this.errors.length <= 0;
        }
    },
    components: {
		AccentColor,
        Button,
        Input,
        ErrorsContainer,
        SocialMedia,
        SelectTypes,
    },
    methods: {
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
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
        createPerformer: async function(FormClass) {
            const resp = await FormClass.submitForm();
            if (resp.status === 'success') {
                await this.$store.dispatch("findUser");
                this.$router.push('/dashboard');
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
                bio: this.bio,
                user_id: this.user.id,
				accent_color: this.accent_color,
            };
            const FormClass = new Form(data, "create", { route: "performers" });
            this.errors = FormClass.checkRequiredFields(data);
            if (this.valid) {
                const additionalData = this.getSocialMediaData();
                additionalData.performerTypes = this.performerTypes;
                additionalData.tips = this.tips;
                FormClass.setAdditionalFields(additionalData);
                this.createPerformer(FormClass);
            }
		},
    },
    async mounted() {
        if (this.user === 0) {
            this.$store.dispatch("findUser");
        }
        this.$store.dispatch("fetchState", {
            route: "performerTypes"
        });
    }
};
</script>

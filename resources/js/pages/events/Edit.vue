<template>
	<div class="main" v-if="user">
		<main class="container container--core">
			<h1 class="copy--center">Update Event</h1>
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
                        <Input
							name="date"
							:value="date"
							type="text"
							:required="true"
							:errors="errors"
							v-on:update="updateValue"
						/>
						<Input
							name="doors"
							:value="doors"
							type="text"
							:required="false"
							:errors="errors"
							v-on:update="updateValue"
						/>
                        <Input
							name="show_time"
							:value="show_time"
							type="text"
							:required="true"
							:errors="errors"
							v-on:update="updateValue"
						/>
					</div>
				</div>
				<FamilySelect 
					:name="family"
					:errors="errors"
					v-on:update="updateFamily"
				/>
                <Select
                    label="Performers"
                    route="performers"
					:errors="errors"
					:currentArray="performers"
					v-on:update="updateArray"
				/>	
                <SelectTypes 
                    :errors="errors"
                    :types="eventTypes"
                    route="eventTypes"
                    type="event"
					v-on:update="updateArray"
                />
				<VenueSelect 
					:errors="errors"
					:province="province"
					:city="city"
					:timezone="timezone"
					:address="address"
					:name="venue_name"
					v-on:updateVenue="updateVenue"
					v-on:update="updateValue"
				/>
				<h2 class="copy--center">Tickets</h2>
				<Input
					name="tickets"
					:value="tickets"
					type="text"
					:required="true"
					:errors="errors"
					v-on:update="updateValue"
				/>
				<Input
					name="tickets_url"
					:value="tickets_url"
					type="text"
					:required="true"
					:errors="errors"
					v-on:update="updateValue"
				/>
				<AccentColor 
					:value="accent_color"
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
				<Button variation="input" label="Update Event" :disabled="errors.length > 0"/>
			</form>    
		</main>
    </div>
</template>

<script>
import { mapState } from "vuex";

// Classes
import socials from "../../core/social-media";
import Form from "../../core/form";

// Components
import Accessibility from "../../components/Accessibility";
import Autocomplete from "../../components/Autocomplete";
import ErrorsContainer from "../../components/ErrorsContainer";
import Input from "../../components/Input";
import SocialMedia from "../../components/SocialMedia";
import Address from "../../components/Address";
import Select from "../../components/Select";
import SelectTypes from "../../components/SelectTypes";
import FamilySelect from "../../components/FamilySelect";
import VenueSelect from "../../components/VenueSelect";
import Button from "../../components/Button";
import AccentColor from "../../components/AccentColor";

export default {
    data() {
        return {
			id: this.$route.params.id || "",
			accent_color: "#000000",
            errors: [],
            name: "",
            description: "",
			date: "",
			doors: "",
            eventTypes: [],
            show_time: "",
            venue: "",
            performers: [],
			province: "",
			city: "",
			address: "",
			family: "",
			family_id: "",
            type: "",
            facebook: "",
            instagram: "",
            twitter: "",
            twitch: "",
            tiktok: "",
            youtube: "",
            website: "",
            tickets: "",
			tickets_url: "",
			venue_id: "",
			venue_name: "",
			socialLinksId: "",
			accessibility: [],
			accessibility_description: "",
        };
    },

    computed: {
        ...mapState([
            "user",
		]),
		valid: function() {
			return this.errors.length === 0;
		},
        timezone: {
            get: function() {
                if (this.user.timezone) {
                    return this.user.timezone;
                }
                return "";
            },
            set: function(newValue) {
                this.user.timezone = newValue;
            }
        }
    },
    components: {
		Accessibility,
		AccentColor,
        Address,
		ErrorsContainer,
		FamilySelect,
		Input,
        SocialMedia,
        Select,
        SelectTypes,
        Autocomplete,
		VenueSelect,
		Button,
    },
    methods: {
		createEvent: async function(FormClass) {
			const resp = await FormClass.submitForm();
			if (resp.status === 'success') {
				await this.$store.dispatch("findUser");
                this.$router.push('/dashboard');
			}
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
		setValue: function(name, value) {
			this[name] = value;
		},
		setFamily: function(family) {
			const fields = ['name', 'description'];
			this.setStates(fields, family);
		},
		setEvent: function(event) {
			const fields = ['accessibility', 'accessibility_description', 'accent_color', 'name', 'description', 'date', 'doors', 'show_time', 'tickets', 'tickets_url'];
			this.setStates(fields, event);
		},
		getEvent: async function() {
			try {
				const resp = await this.$store.dispatch('fetchSingle', { route: "events", id: this.id });
				if (resp.status === 200) {
					this.setEvent(resp.data.event);
					this.setSocialLinks(resp.data.socialLinks);
					if (resp.data.family) {
						this.setFamily(resp.data.family);
					}
					if (resp.data.eventTypes) {
						this.setValue('eventTypes', resp.data.eventTypes);
					}
					if (resp.data.performers) {
						this.setValue('performers', resp.data.performers);
					}
					return;
				}
			} catch(err) {
				console.log(err)
			}
		},
		handleSubmit: function() {
			let data = {
				name: this.name,
				description: this.description,
				date: this.date,
				show_time: this.show_time,
				accent_color: this.accent_color,
				accessibility: this.accessibility,
				accessibility_description: this.accessibility_description,
			}
			const FormClass = new Form(data, "edit", { route: "events", id: this.id });
			this.errors = FormClass.checkRequiredFields(data);
			if (this.valid) {
				const socialMediaData = this.getSocialMediaData();
				const additionalData = this.getAdditionalData(socialMediaData);
				FormClass.setAdditionalFields(additionalData);
				this.createEvent(FormClass);
			}
		},
		updateFields: function(venue, fields) {
			fields.forEach((field) => {
				this[field] = venue[field];
			});
		},
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
		},
		updateVenue: function(updateObject) {
			const fields = ['address', 'city', 'province', 'timezone'];
			this.updateFields(updateObject, fields);
			this.venue_id = updateObject.id;
			this.venue_name = updateObject.name;
		},
		updateFamily: function(updateObject) {
			this.family = updateObject.name;
			this.family_id = updateObject.id;
		},
		getSocialMediaData: function() {
            const socialMediaData = {};
            for (let social in this.socials) {
                socialMediaData[social] = this[social];
            }
            return socialMediaData;
		},
		getAdditionalData: function(additionalData) {
			const fields = ['address', 'city', 'doors', 'eventTypes', 'family_id', 'performers', 'province', 'socialLinksId', 'tickets', 'tickets_url', 'timezone', 'venue_id'];
			fields.forEach((field) => {
				additionalData[field] = this[field];
			});
			return additionalData;
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
					if (item.id === updateObject.id) {
						index = i;
						return index;
					}
				});
				return index;
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
    },
    async mounted() {
        try {
            this.$store.dispatch("fetchState", {
                route: "eventTypes"
			});
			this.getEvent();
        } catch (error) {
            this.errors.push(error);
        }
    }
};
</script>

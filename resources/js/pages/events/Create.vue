<template>
	<div class="main" v-if="user">
		<main class="container container--core">
			<h1 class="copy--center">Create Event</h1>
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
							name="time"
							:value="time"
							type="text"
							:required="true"
							:errors="errors"
							v-on:update="updateValue"
						/>
					</div>
				</div>
                <Autocomplete 
                    label="Venue"
                    :errors="errors"
                    route="venues"
                    v-on:selection="updateVenue"
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
				<input class="btn" type="submit" value="Create Event">
			</form>    
		</main>

            <!-- VENUE
            <label class="label" for="venue">Venue</label>
            <select class="input" name="venue" id="venue" v-model="venue">
                <option
                    v-for="venue in venues"
                    v-bind:key="venue.id"
                    :value="venue.id"
                    v-text="venue.name"
                ></option>
            </select>
            <fieldset v-if="eventTypes">
                <legend for="type" class="label">Event Type</legend>
                <ul class="list">
                    <li
                        class="list-item"
                        v-for="eventType in eventTypes"
                        v-bind:key="eventType.id"
                    >
                        <input
                            type="radio"
                            name="type"
                            :value="eventType.id"
                            :id="eventType.name"
                            v-model="type"
                        />
                        <label
                            :for="eventType.name"
                            v-text="eventType.name"
                        ></label>
                    </li>
                </ul>
            </fieldset>

            <div v-if="family">
                <label class="label" for="family">Family</label>
                <select
                    class="input"
                    name="family"
                    id="family"
                    v-model="family"
                >
                    <option
                        v-for="family in families"
                        v-bind:key="family.id"
                        :value="family.id"
                        v-text="family.name"
                    ></option>
                </select>
            </div>

            <label class="label" for="tickets">Ticket Information</label>
            <textarea
                class="input"
                name="tickets"
                id="tickets"
                cols="30"
                rows="10"
                v-model="tickets"
            ></textarea>
            <label class="label" for="tickets_url">Ticket Url</label>
            <input
                class="input"
                type="url"
                name="tickets_url"
                id="tickets_url"
                v-model="tickets_url"
            /> -->
        </form>
    </div>
</template>

<script>
import { mapState } from "vuex";

// Classes
import socials from "../../core/social-media";
import Form from "../../core/form";

// Components
import Autocomplete from "../../components/Autocomplete";
import ErrorsContainer from "../../components/ErrorsContainer";
import Input from "../../components/Input";
import SocialMedia from "../../components/SocialMedia";
import Address from "../../components/Address";
import Select from "../../components/Select";
import SelectTypes from "../../components/SelectTypes";

export default {
    data() {
        return {
            id: this.$route.params.id || "",
            errors: [],
            name: "",
            description: "",
            date: "",
            eventTypes: [],
            time: "",
            venue: "",
            performers: [],
            family: "",
            type: "",
            facebook: "",
            instagram: "",
            twitter: "",
            twitch: "",
            tiktok: "",
            youtube: "",
            website: "",
            tickets: "",
            tickets_url: ""
        };
    },

    computed: {
        ...mapState([
            "user",
        ]),
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
        Address,
		ErrorsContainer,
		Input,
        SocialMedia,
        Select,
        SelectTypes,
        Autocomplete,
    },
    methods: {
        handleSubmit: function() {
            let data = {
                name: this.name,
                description: this.description,
                date: this.date,
                time: this.time,
                venue: this.venue,
                family: this.family,
                eventType: this.type,
                performers: this.newPerformers,
                timezone: this.timezone,
                tickets: this.tickets,
                tickets_url: this.tickets_url,
                facebook: this.facebook,
                instagram: this.instagram,
                twitter: this.twitter,
                youtube: this.youtube,
                website: this.website
            };
            this.$store
                .dispatch("create", {
                    route: "events",
                    data
                })
                .then(async resp => {
                    await this.$store.dispatch("fetchState", {
                        route: "events"
                    });
                    this.$store.dispatch("findUser");
                    this.$router.push({ path: `/dashboard?events=1` });
                });
        },
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
			const fields = ['timezone', 'city'];
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
                console.log(updateObject);
				const currentArray = this[updateObject.name];
				if (currentArray && updateObject.add) {
					this.addToArray(updateObject, currentArray);
				} 
				if (currentArray && !updateObject.add) {
					this.deleteFromArray(updateObject, currentArray);
				}
            },
            updateVenue: function(venue) {
                console.log(venue);
            }
    },
    async mounted() {
        try {
            this.$store.dispatch("fetchState", {
                route: "eventTypes"
            });
        } catch (error) {
            this.errors.push(error);
        }
    }
};
</script>

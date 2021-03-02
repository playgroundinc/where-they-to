<template>
	<div v-if="slug && id">
		<main class="container">
            <h1 class="copy--center">{{ performer.name }}</h1>
            <ul class="selections__list row center-md" v-if="performer.performer_types">
                <li class="selections__single" v-for="type in performer.performer_types" v-bind:key="type.id">{{ type.name }}</li>
            </ul>
            <div class="row">
                <div class="col-xxs-12 col-md-6">

                </div>
                <div class="col-xxs-12 col-md-6">
            <Button 
                :label="followinglabel"
                v-on:clicked.prevent="toggleFollowing"
            />
                    <p>{{ performer.bio }}</p>
                    <div v-if="socialLinks">
                        <SocialLinks
                            :socialLinks="socialLinks"
                        />
                    </div>
                    <Button
                        v-if="performer.tips" 
                        v-on:clicked.prevent="toggleModal" 
                        :label="'Tip ' + performer.name" 
                    />			
                </div>
            </div>
            <UpcomingEvents 
                :events="events.current"
                :total="events.total"
                :page="events.page"
                :id="id"
                route="performers"
                v-on:update="updateValue"
            />
            <div v-if="performer.user_id && user && performer.user_id === user.id">
                <Button :link="'/performers/' + performer.id + '/edit'" label="Edit Profile"/>
            </div>
            <div v-if="performer.user_id && user && performer.user_id === user.id">
                <Update 
                type="performer"
                :id="id"
                />
            </div>
            <Modal 
                :title="tipTitle"
                :copy="performer.tips || ''"
                :open="tipModal"
                v-on:close="toggleModal"
            />
		</main>
	</div>
</template>

<script>
import { mapState } from 'vuex';

// Components 
import Button from "../../components/Button";
import Modal from "../../components/Modal";
import SocialLinks from "../../components/SocialLinks";
import Update from "../../components/Updates";
import UpcomingEvents from "../../components/UpcomingEvents";

export default {

    data() {
		return {
            id: 0,
			slug: this.$route.params.slug,
			platforms: [],
			events: {},
			performer: [],
			socialLinks: [],
			family: [],
			types: [],
            events: [],
			accent_color: "#000000",
			tipModal: false,
		}
    },
    computed: {
		...mapState(['user']),
		tipTitle() {
			return `How to tip ${this.performer.name}`
        },
        allEvents() {
            return this.events.entries;
        },
        followinglabel: function() {
            const performers = this.user.following_performers;
            if (!performers|| !performers.length || performers.indexOf(this.id) === -1) {
                return 'Follow';
            }
            return 'Unfollow'; 
        }
	},
	components: {
        Button,
		Modal,
        SocialLinks,
        Update,
        UpcomingEvents,
	},
	mounted() {
		this.getPerformer();
	},
	methods: {
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
        setStates: function(fields, data) {
            fields.forEach((field) => {
                if (data[field] && this[field]) {
                    this[field] = data[field];
                }
            });
        },
		getPerformer: async function() {
			const resp = await this.$store.dispatch('fetchSingle', { route: "performers", id: this.slug });
			if (resp.status === 200) {
                this.updateValue({name: 'id', value: `${resp.data.performer.id}` });
                const fields = ['performer', 'types', 'family', 'socialLinks', 'events', 'id'];
                this.setStates(fields, resp.data);
			}
        },
        async toggleFollowing() {
            const data = {
                user_id: this.user.id,
                route: 'follow/performer',
                route_id: this.id,
            }
            const resp = await this.$store.dispatch('toggleEngagement', data)
            if (resp.data.status && resp.data.status === 'success') {
                this.$store.dispatch('findUser');
            }
        },
		toggleModal: function() {
			this.tipModal = !this.tipModal;
		}
	}
}
</script>
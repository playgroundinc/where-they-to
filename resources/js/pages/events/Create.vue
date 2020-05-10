<template>
    <div class="main" v-if="user">
        <h1>Create Event</h1>
        <form action="/events" v-on:submit.prevent="handleSubmit">
            <label class="label" for="name">Name</label>
            <input class="input" type="text" name="name" id="name" v-model="name" />
            <label class="label" for="description">Description</label>
            <textarea
                class="input"
                name="description"
                id="description"
                cols="30"
                rows="10"
                v-model="description"
            ></textarea>
            <label class="label" for="date">Date</label>
            <input class="input" type="text" name="date" id="date" v-model="date" />
            <label for="date" class="label">Time</label>
            <input class="input" type="text" id="time" name="time" v-model="time" />
            <label for="timezone" class="label">Timezone</label>
            <select name="timezone" id="timezone" class="input" v-model="timezone">
                <option
                    v-for="timezone in timezones"
                    v-bind:key="timezone"
                    :value="timezone"
                >{{ timezone }}</option>
            </select>
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
                    <li class="list-item" v-for="eventType in eventTypes" v-bind:key="eventType.id">
                        <input
                            type="radio"
                            name="type"
                            :value="eventType.id"
                            :id="eventType.name"
                            v-model="type"
                        />
                        <label :for="eventType.name" v-text="eventType.name"></label>
                    </li>
                </ul>
            </fieldset>
            <div v-if="family">
                <label class="label" for="family">Family</label>
                <select class="input" name="family" id="family" v-model="family">
                    <option
                        v-for="family in families"
                        v-bind:key="family.id"
                        :value="family.id"
                        v-text="family.name"
                    ></option>
                </select>
            </div>
            <div>
                <Autocomplete
                    label="Performers"
                    :values="performers"
                    @selection="function(performer) { addPerformer(performer) }"
                ></Autocomplete>
                <div v-if="newPerformers.length > 0">
                    <h2>Current Performers</h2>
                    <ul>
                        <li v-for="(performer, index) in newPerformers" v-bind:key="performer.id">
                            {{ performer.name }}
                            <a
                                href="#"
                                @click.prevent="() => removePerformer(index)"
                            >Remove</a>
                        </li>
                    </ul>
                </div>
            </div>
            <fieldset v-if="tickets">
                <legend for="tickets" class="label">Tickets</legend>
                <ul class="list">
                    <li class="list-item" v-for="ticket in tickets" v-bind:key="ticket.id">
                        <input
                            type="checkbox"
                            :name="ticket.id"
                            :value="ticket.id"
                            :id="ticket.id"
                            v-model="newTickets"
                        />
                        <label :for="ticket.id">${{ ticket.price}} {{ ticket.description }}</label>
                    </li>
                </ul>
                <div v-if="newTicket">
                    <label class="label" for="ticketPrice">Ticket Price</label>
                    <input class="input" type="number" name="ticketPrice" v-model="ticketPrice" />
                    <label for="ticketDescription" class="label">Description</label>
                    <input
                        class="input"
                        type="text"
                        name="ticketDescription"
                        id="ticketDescription"
                        v-model="ticketDescription"
                    />
                    <label class="label" for="ticketUrl">Ticket URL</label>
                    <input class="input" type="url" name="ticketUrl" v-model="ticketUrl" />
                    <button class="btn" v-on:click.prevent="createTicket">Add Ticket</button>
                </div>
                <button v-if="!newTicket" class="btn" @click.prevent="addTicket">Create New Ticket</button>
            </fieldset>
            <input class="btn" type="submit" value="Create Event" />
        </form>
    </div>
</template>

<script>
import { mapState } from "vuex";
import timezones from "../../Timezones";
import Autocomplete from "../../components/Autocomplete";

export default {
    data() {
        return {
            id: this.$route.params.id || "",
            name: "",
            description: "",
            date: "",
            time: "",
            venue: "",
            newPerformers: [],
            newTickets: [],
            family: "",
            type: "",
            newTicket: false,
            ticketPrice: 0,
            ticketDescription: "",
            ticketUrl: "",
            timezone: "",
            timezones: timezones || ""
        };
    },
    computed: {
        ...mapState([
            "user",
            "events",
            "venues",
            "performers",
            "families",
            "eventTypes",
            "tickets"
        ])
    },
    components: {
        Autocomplete
    },
    methods: {
        addTicket: function() {
            this.newTicket = true;
        },
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
                tickets: this.newTickets,
                timezone: this.timezone
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
        updateTickets: function(ticket) {
            let data = {
                ticket
            };
            this.$store.dispatch("edit", {
                route: "events",
                id: `${this.id}/tickets`,
                data
            });
        },
        createTicket: function() {
            let data = {
                price: this.ticketPrice,
                description: this.ticketDescription,
                url: this.ticketUrl
            };
            this.$store
                .dispatch("create", {
                    route: "tickets",
                    data
                })
                .then(resp => {
                    this.$store.dispatch("fetchState", {
                        route: "tickets"
                    });
                    this.ticketPrice = 0;
                    this.ticketDescription = "";
                    this.ticketUrl = "";
                    this.newTicket = false;
                });
        },
        deleteTicket: function(ticket) {
            let data = {
                ticket
            };
            this.$store.dispatch("destroy", {
                route: "events",
                id: `${this.id}/tickets`,
                data
            });
        },

        addPerformer: function(performer) {
            this.newPerformers.push(performer);
        },
        removePerformer: function(index) {
            this.newPerformers.splice(index, 1);
        }
    },
    mounted: function() {
        this.$store.dispatch("fetchState", {
            route: "eventTypes"
        });
        this.$store.dispatch("fetchState", {
            route: "tickets"
        });
    }
};
</script>
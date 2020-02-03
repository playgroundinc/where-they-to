<template>
  <div class="main" v-if="user && event">
    <h1>Edit Event</h1>
    <form action="/events" v-on:submit.prevent="handleSubmit">
      <label class="label" for="name" >Name</label>
      <input class="input" type="text" name="name" id="name" v-model="event.name">
      <label class="label" for="description">description</label>
      <textarea class="input" name="description" id="description" cols="30" rows="10" v-model="event.description"></textarea>
      <label class="label" for="date">Date</label>
      <input class="input" type="text" name="date" id="date" v-model="event.date">
      <label class="label" for="venue">Venue</label>
      <div v-if="venue">
        <select class="input" name="venue" id="venue" v-model="event.venue_id">
          <option v-for="venue in venues" v-bind:key="venue.id" :value="venue.id" v-text="venue.name"></option>
        </select>
      </div>
      <fieldset v-if="eventTypes">
        <legend for="type" class="label">Event Type</legend>
        <ul class="list">
          <li class="list-item" v-for="eventType in eventTypes" v-bind:key="eventType.id" >
            <input type="radio" :name="eventType.name" :value="eventType.id" :id="eventType.name" v-model="type">
            <label :for="eventType.name" v-text="eventType.name"></label>
          </li>
        </ul> 
      </fieldset>
      <div v-if="family">
        <label class="label" for="family">Family</label>
        <select class="input" name="family" id="family" v-model="event.family_id">
            <option v-for="family in families" v-bind:key="family.id" :value="family.id" v-text="family.name"></option>
        </select>
      </div>
      <fieldset v-if="performers">
        <legend for="newPerformers" class="label">Performers</legend>
        <ul class="list">
          <li class="list-item" v-for="performer in performers" v-bind:key="performer.id" >
            <input v-if="performer.id !== user.profile.id" type="checkbox" :name="performer.name" :value="performer.id" :id="performer.name" v-model="newPerformers">
            <label v-if="performer.id !== user.profile.id" :for="performer.name" v-text="performer.name"></label>
          </li>
        </ul> 
      </fieldset>
      <h2>Current Tickets</h2>
      <fieldset v-if="event.tickets">
        <legend for="eventTickets" class="label">Current Tickets</legend>
        <ul class="list">
          <li class="list-item" v-for="ticket in event.tickets" v-bind:key="ticket.id" >
            ${{ticket.price}} {{ticket.description }}
          </li>
        </ul> 
      </fieldset>
      <fieldset v-if="tickets">
        <legend for="tickets" class="label">Tickets</legend>
        <ul class="list">
          <li class="list-item" v-for="ticket in tickets" v-bind:key="ticket.id" >
            <input v-if="!ticket.url" type="checkbox" :name="ticket.id" :value="ticket.id" :id="ticket.id" v-model="newTickets">
            <label v-if="!ticket.url" :for="ticket.id" v-text="'$' + ticket.price + ' ' + ticket.description"></label>
          </li>
        </ul> 
        <div v-if="newTicket">
          <label for="ticketDescription" class="label">Description</label>
          <input class="input" type="text" name="ticketDescription" id="ticketDescription" v-model="ticketDescription">
          <label class="label" for="ticketPrice">Ticket Price</label>  
          <input class="input" type="number" name="ticketPrice" v-model="ticketPrice">
          <label class="label" for="ticketUrl">Ticket URL</label>
          <input class="input" type="url" name="ticketUrl" v-model="ticketUrl">
          <button class="btn" v-on:click.prevent="createTicket">Add Ticket</button>
        </div>
        <button v-if="!newTicket" class="btn" v-on:click.prevent="addTicket">Create New Ticket</button>
      </fieldset>
      <input class="btn" type="submit" value="Update Event">
    </form>
  </div>
</template>

<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {
      id: this.$route.params.id || '',
      newPerformers: [],
      newTickets: [],
      type: 0,
      newTicket: false,
      ticketPrice: 0,
      ticketDescription: '',
      ticketUrl: '',
    }
  },
  computed: {
    ...mapState(['user', 'events', 'venues', 'performers', 'families', 'eventTypes', 'tickets']),
    event: function() {
      return this.events.find(entry => Number(entry.id) === Number(this.id))
    },
    family: function() {
      return this.families.find((entry) => Number(entry.id) === Number(this.event.family_id))
    },
    venue: function() {
      return this.venues.find((entry) => Number(entry.id) === Number(this.event.venue_id))
    },
  },
  methods: {
    addTicket: function() {
      this.newTicket = true;
    },
    handleSubmit: function() {
      let data = {
        name: this.event.name,
        description: this.event.description,
        date: this.event.date,
        time: this.event.time,
        venue: this.venue['id'],
        family: this.family['id'],
        eventType: this.type,
        tickets: this.newTickets,
        performers: this.newPerformers,
      }
      this.$store.dispatch('edit', {
        route: 'events',
        id: this.id,
        data,
      }).then((resp) => {
        this.$router.push({path: `/events/${this.id}`})
      });
    },
    createTicket: function() {
      let data = {
        price: this.ticketPrice,
        description: this.ticketDescription,
        url: this.ticketUrl,
      }
      this.$store.dispatch('create', {
        route: 'tickets',
        data,
      }).then(() => {
        this.ticketPrice = 0;
        this.ticketDescription = '';
        this.ticketUrl = '';
        this.newTicket = false;
      })
    }
  },
  mounted: function() {
    this.$store.dispatch('fetchState', { 
      route: 'eventTypes',
    });
    this.$store.dispatch('fetchState', { 
      route: 'tickets',
    })
  }
}
</script>
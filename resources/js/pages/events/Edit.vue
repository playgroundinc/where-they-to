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
          <option v-for="venue in venues" v-bind:key="venue.id" :value="venue.id" v-text="venue.name" :selected="{ true: venue.id === event.venue_id }"></option>
        </select>
      </div>
      <fieldset v-if="eventTypes">
        <legend for="type" class="label">Event Type</legend>
        <ul class="list">
          <li class="list-item" v-for="eventType in eventTypes" v-bind:key="eventType.id" >
            <input type="radio" name="type" :value="eventType.id" :id="eventType.name" :checked="Number(eventType.id) === Number(event['event_type_id'])" v-model="type">
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
      <fieldset v-if="event.performers">
        <legend class="label">Current Performers</legend>
        <ul class="list">
          <li class="list-item" v-for="eventPerformer in event.performers" v-bind:key="eventPerformer.id" >
            <div v-if="eventPerformer.id !== user.profile.id">
              <p>{{ eventPerformer.name }}</p>
              <button @click.prevent="removePerformer(eventPerformer.id)">Remove Performer</button>
            </div>
          </li>
        </ul> 
      </fieldset>
      <fieldset v-if="performers">
        <legend for="newPerformers" class="label">Performers</legend>
        <ul class="list">
          <li class="list-item" v-for="performer in filteredPerformers" v-bind:key="performer.id" >
            <p>{{ performer.name }}</p>
            <button @click.prevent="addPerformer(performer.id)">Add Performer</button>
          </li>
        </ul> 
      </fieldset>
      <h2>Current Tickets</h2>
      <fieldset v-if="event.tickets">
        <legend for="eventTickets" class="label">Current Tickets</legend>
        <ul class="list">
          <li class="list-item" v-for="eventTicket in event.tickets" v-bind:key="eventTicket.id" >
            <p>${{eventTicket.price}} {{eventTicket.description }}</p>
            <button @click.prevent="deleteTicket(eventTicket.id)">Remove Ticket</button>
          </li>
        </ul> 
      </fieldset>
      <fieldset v-if="tickets">
        <legend for="tickets" class="label">Tickets</legend>
        <ul class="list">
          <li class="list-item" v-for="ticket in filteredTickets" v-bind:key="ticket.id" >
            <p>${{ ticket.price }} {{ ticket.description}}</p>
            <button @click.prevent="updateTickets(ticket.id)">Add Ticket to Event</button>
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
        <button v-if="!newTicket" class="btn" @click.prevent="addTicket">Create New Ticket</button>
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
    filteredTickets: function() {
      return this.tickets.filter(entry => !this.event.tickets.find((item) => Number(item.id) === Number(entry.id)));
    },
    filteredPerformers: function() {
      return this.performers.filter(entry => !this.event.performers.find((item) => Number(item.id) === Number(entry.id)));
    },
    type: {
      get() {
        return this.event.event_type_id;
      },
      set(value) {
        this.event.event_type_id = value;
      }
    }
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
        eventType: this.type,
      }
      if (this.venue) {
        data['venue'] = this.venue['id']
      }
      if (this.family) {
        data['family'] = this.family['id']
      }
      this.$store.dispatch('edit', {
        route: 'events',
        id: this.id,
        data,
      }).then((resp) => {
        this.$router.push({path: `/events/${this.id}`})
      });
    },
    updateTickets: function(ticket) {
      let data = {
        ticket,
      }
      this.$store.dispatch('edit', {
        route: 'events',
        id: `${this.id}/tickets`,
        data
      })
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
      }).then((resp) => {
        const ticket = resp.data[0].id;
        this.updateTickets(ticket);
        this.ticketPrice = 0;
        this.ticketDescription = '';
        this.ticketUrl = '';
        this.newTicket = false;
      })
    },
    deleteTicket: function(ticket) {
      let data = {
        ticket
      }
      this.$store.dispatch('destroy', {
        route: 'events',
        id: `${this.id}/tickets`,
        data,
      })
    },

    addPerformer: function(performer) {
      let data = {
        performer,
      }
      this.$store.dispatch('edit', {
        route: 'events',
        id: `${this.id}/performers`,
        data
      })
    },
    removePerformer: function(performer) {
      let data = {
        performer
      }
      this.$store.dispatch('destroy', {
        route: 'events',
        id: `${this.id}/performers`,
        data,
      })
    },
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
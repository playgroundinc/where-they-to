
<template>
  <div class="main" v-if="event">
    <h1>{{ event.name }}</h1>
    <div>
      <p>
        <span v-if="event.date">{{ event.date }}</span>
        <span v-if="event.time">{{ event.time }}</span>
      </p>
      <p>{{ event.description }}</p>
    </div>
    <div v-if="venue">
      <h2>Venue</h2>
      <p>
        <a :href="'/venues/' + venue.id">{{ venue.name }}</a></p>
      <p>
        <span v-if="venue.address">{{ venue.address}}</span>
        <span v-if="venue.city">{{ venue.city }}</span>
        <span v-if="venue.province">{{ venue.province }}</span>
      </p>
      <p v-if="venue.description">{{venue.description}}</p>
    </div>
    <div v-if="family">
      <h2>Family</h2>
      <li>
        <a :href="'/families/' + family.id"> {{ family.name }} </a>
      </li>
    </div>
    <div>
      <h2>Performers</h2>
      <ul v-if="event.performers.length > 0">
        <li v-for="performer in event.performers" v-bind:key="performer.id">
          <a :href="'/performers/' + performer.id " v-text="performer.name"></a>
        </li>
      </ul>
      <p v-else>No performers currently listed</p>
    </div>
    <div>
      <h2>Tickets</h2>
      <ul v-if="event.tickets.length > 0">
        <li v-for="ticket in event.tickets" v-bind:key="ticket.id">
          <p>
            <span>${{ ticket.price }}</span>
            <span> {{ticket.description }}</span>
          </p>
        </li>
      </ul>
      <p v-else>No tickets currently listed</p>
    </div>
    <div>
      <h2>Social Links</h2>
      <ul v-if="event.social_links">
        <li v-if="event.social_links.facebook">Facebook: {{event.social_links.facebook }}</li>
        <li v-if="event.social_links.instagram">Instagram: {{event.social_links.instagram }}</li>
        <li v-if="event.social_links.twitter">Twitter: {{ event.social_links.twitter }}</li>
        <li v-if="event.social_links.youtube">Youtube: {{ event.social_links.youtube }}</li>
        <li v-if="event.social_links.website">Website: {{ event.social_links.website }}</li>
      </ul>
    </div>
    <div>

    </div>
    <a v-if="user && user.id === event.user_id" :href="'/events/' + event.id + '/edit'" class="btn">Edit Event</a>

  </div>
</template>

<script>
  import { mapState } from 'vuex';

export default {

    data() {
      return {
        id: this.$route.params.id || '',
        family_id: null,
      }
    },
    computed: {
      ...mapState(['user', 'events', 'families', 'venues', 'performers']),
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
    created() {
      if (!this.user) {
        this.$store.dispatch('findUser');
      }
    }

  }
</script>
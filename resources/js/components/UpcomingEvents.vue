<template>
    <div v-if="events.length">
        <ul>
            <li v-for="event in events" v-bind:key="event.id">{{ event.name }}</li>
            <Button 
                v-if="loadMore"
                label="Load More"
                v-on:clicked="handleLoadMore"
            />
        </ul>
    </div>

</template>
<script>
import Button from "../components/Button";

export default {
    props: {
        events: {
            type: Array,
            required: true,
            default: () => [],
        },
        total: {
            type: Number, 
            required: true,
            default: 0,
        },
        page: {
            type: Number,
            required: true,
            default: 0,
        },
        id: {
            type: String,
            required: true,
        },
        route: {
            type: String,
            required: true,
        }
    },
    components: {
        Button,
    },
    computed: {
        loadMore: function() {
            const totalPages = Math.floor(this.total / 10);
            return this.page < totalPages;
        },
        nextPage: function() {
            return Number(this.page) + 1;
        }
    },
    methods: {
        handleLoadMore: async function() {
            const data = {
                route: `${this.route}/${this.id}`,
                query: `page=${this.nextPage}`,
            }
            const resp = await this.$store.dispatch('upcomingEvents', data);
            if (resp.status === 200 && resp.data) {
                const events = {};
                events.current = this.events;
                events.total = Number(resp.data.total);
                events.page = Number(resp.data.page);
                if (resp.data.current) {
                    events.current = this.events.concat(resp.data.current);
                } 
                this.$emit('update', { name: 'events', value: events });
            }
        }
    }
}
</script>
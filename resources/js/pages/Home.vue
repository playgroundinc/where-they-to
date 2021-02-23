<template>
    <div>
        <h1>Where They To</h1>
        <h2>On Tonight</h2>
        <h2>This Week</h2>
    </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
    data() {
        return {
            todays: {},
            weeks: [],
        }
    },
    computed: {
        ...mapState(['user']),
    },
    mounted() {
        const date = new Date();
        const today = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`;
        this.$store.dispatch('fetchDate', {
            parameter: 'date',
            date: today,
        }).then((response) => {
            this.todays = JSON.parse(response.data.events);
        });
        const tempArray = [];
        for (let i = 1; i < 7; i = i + 1) {
            const thisWeeks = {};
            let weekdate = `${date.getFullYear()}-${date.getMonth()+1}-${date.getDate() + i}`;
            this.$store.dispatch('fetchDate', {
                parameter: 'date',
                date: weekdate,
            }).then((response) => {
                thisWeeks[response.data.date] = JSON.parse(response.data.events);
                tempArray.push(thisWeeks);
            });
        }
        this.weeks = tempArray;
    }
}
</script>
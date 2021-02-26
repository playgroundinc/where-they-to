<template>
    <div>
        <ul v-if="results.length">
            <li v-for="result in results" v-bind:key="result.id">
                {{ result.name }}
            </li>
        </ul>
        <div v-else>
            <h2>Nothing found.</h2>
        </div>
        <div v-if="loadMore">
            <Button 
                label="Load More"
                v-on:clicked="handleLoadMore"
            />
        </div>
    </div>
</template>
<script>
import Button from "../components/Button";

export default {
    props: {
        results: {
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
        }
    },
    computed: {
        loadMore: function() {
            const count = Number(this.page + 1) * 10;
            return this.total > count;
        }
    },
    components: {
        Button,
    },
    methods: {
        handleLoadMore: function() {
            this.$emit('loadMore');
        }
    }
}
</script>
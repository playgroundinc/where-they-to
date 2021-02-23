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
    </div>
</template>
<script>
export default {
    props: {
        results: {
            type: Array,
            required: true,
            default: () => [],
        }
    }
}
</script>
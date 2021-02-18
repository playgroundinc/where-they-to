<template>
    <div>
        <ul>
            <li v-for="result in results" v-bind:key="result.id">
                {{ result.name }}
            </li>
        </ul>
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
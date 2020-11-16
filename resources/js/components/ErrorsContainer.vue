<template>
    <div v-if="errors.length > 0">
        <p>There are {{ errors.length }} errors.</p>
        <ul>
            <li v-for="error in errors" v-bind:key="error">
                <a :href="`#${error}`">{{ error.replace("_", " ") }}</a>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    props: {
        errors: {
            type: Array,
            required: true
        }
    }
};
</script>

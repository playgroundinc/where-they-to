<template>
    <div class="errors" v-if="errors.length > 0">
        <p class="copy--center">We found the following <strong class="copy--large copy--error">{{ errors.length }}</strong> errors in this form.</p>
        <ul class="errors__list row center-xxs bottom-xxs"> 
            <li class="errors__single col-md-2 col-xxs-3" v-for="error in errors" v-bind:key="error">
                <a class="errors__single__link copy--error" :href="`#${error}`">{{ error.replace("_", " ") }}</a>
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

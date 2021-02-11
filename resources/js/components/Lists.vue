<template>
    <div v-if="listitems"><h2 class="copy--center">{{ title }}</h2>
        <div v-if="listitems.length > 0">
            <h3>Edit {{ slug }}:</h3>
            <ul>
                <li v-for="item in listitems" v-bind:key="item.id">
                    <a :href="'/' + slug + '/' + item.id">{{ item.name }}</a>
                </li>
            </ul>
        </div>
        <div v-else>
            <p class="copy--italic">You currently have no {{ slug }}.</p>
        </div>
        <Button 
            :label="'Create new ' + title"
            :link="'/' + slug + '/create'"
        />
    </div>
</template>

<script>
// Components.
import Button from "./Button";

export default {
    props: {
        listitems: {
            required: true,
        },
        slug: {
            type: String,
            required: true,
        }, 
        title: {
            type: String,
            required: true,
        }
    },
    components: {
        Button,
    }
}
</script>
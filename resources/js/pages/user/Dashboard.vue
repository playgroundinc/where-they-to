<template>
    <div class="container">
        <h1>Dashboard</h1>
        <list :listitems="user.performers" title="Performer" slug="performers"></list>
        <list :listitems="user.venues" title="Venue" slug="venues"></list>
        <list :listitems="user.events" title="Event" slug="events"></list>
    </div>
</template>
<script>
import { mapState } from "vuex";
import List from "../../components/Lists";

export default {
    data() {
        return {
            //
        };
    },
    computed: {
        ...mapState([
            "user",
            "profile"
        ])
    },
    beforeMount() {
        this.$store.dispatch('findUser');
    },
    components: {
        //
        List
	},
};
</script>
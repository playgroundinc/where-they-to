<template>
    <div class="container">
        <h1>Dashboard</h1>
        <List
            :listitems="user.performers"
            title="Performer"
            slug="performers"
        ></List>
        <List :listitems="user.venues" title="Venue" slug="venues"></List>
        <List :listitems="user.events" title="Event" slug="events"></List>
        <List :listitems="user.families" title="Family" slug="families"></List>
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
        ...mapState(["user", "profile"])
    },
    mounted() {
        this.$store.dispatch("findUser");
    },
    components: {
        //
        List
    }
};
</script>

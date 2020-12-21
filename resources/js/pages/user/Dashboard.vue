<template>
    <div>
        <main class="container">
            <div class="row">
                <div class="col-xxs-12">
                    <h1 class="copy--center">Dashboard</h1>
                    <p class="copy--center">Welcome to your Dashboard. Here you'll find lists for everything you've created on the site.</p>
                </div>
            </div>
            <div class="content__row">
                <div class="row">
                    <div class="col-md-6 col-xxs-12">
                        <List :listitems="user.performers" title="Performer" slug="performers"></List>
                    </div>
                    <div class="col-md-6 col-xxs-12">
                        <List :listitems="user.venues" title="Venue" slug="venues"></List>
                    </div> 
                </div>
            </div>
            <div class="content__row">
                <div class="row">
                    <div class="col-md-6 col-xxs-12">
                        <List :listitems="user.events" title="Event" slug="events"></List>
                    </div>
                    <div class="col-md-6 col-xxs-12">
                        <List :listitems="user.families" title="Family" slug="families"></List>
                    </div>
                </div>
            </div>
        </main>
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
        ...mapState(["user"])
    },
    async mounted() {
        if (this.user === 0) {
            await this.$store.dispatch("findUser");
            console.log(this.user);
        }
    },
    components: {
        //
        List
    }
};
</script>

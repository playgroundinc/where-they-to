<template>
    <div id="content" class="container">
        <ul v-if="$auth.ready()">
            <li>
                <router-link to="/">Home</router-link>
            </li>
            <li v-if="!user">
                <router-link to="/register">Log-In / Register</router-link>
            </li>
            <li v-if="user">
                <router-link to="/dashboard">Dashboard</router-link>
            </li>
            <li v-if="user">
                <a href="#" @click.prevent="logout">Logout</a>
            </li>
        </ul>
        <router-view></router-view>
    </div>
</template>
<script>
import { mapState } from "vuex";
import List from "./components/Lists";
export default {
    data() {
        return {
            //
        };
    },
    computed: {
        ...mapState([
            "performers",
            "events",
            "venues",
            "families",
            "user",
            "profile"
        ])
    },
    methods: {
        logout: function() {
            this.$store.dispatch("logout");
        }
    },
    async mounted() {
        this.$store.dispatch("fetchState", {
            route: "performers"
        });
        this.$store.dispatch("fetchState", {
            route: "events"
        });
        this.$store.dispatch("fetchState", {
            route: "venues"
        });
        this.$store.dispatch("fetchState", {
            route: "families"
        });
        this.$store.dispatch("findUser");
    },
    components: {
        //
        List
    }
};
</script>

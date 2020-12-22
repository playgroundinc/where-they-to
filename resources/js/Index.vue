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
            "user",
        ])
    },
    methods: {
        logout: function() {
            this.$store.dispatch("logout");
        }
    },
    async mounted() {
        if (this.user === 0) {
            try {
                this.$store.dispatch('findUser');
            } catch (err) {
                return;
            }
        }
    },
    components: {
        //
        List
    }
};
</script>

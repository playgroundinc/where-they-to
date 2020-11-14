<template>
    <div class="main">
        <h1>Create Performer profile</h1>
        <div v-if="errors.length > 0">
            <p>There are {{ errors.length }} errors.</p>
            <ul>
                <li v-for="error in errors" v-bind:key="error">
                    <a :href="`#${error}`">{{ error }}</a>
                </li>
            </ul>
        </div>
        <form
            novalidate
            method="POST"
            action="/performers"
            v-on:submit.prevent="handleSubmit"
        >
            <Input
                name="name"
                :value="name"
                type="text"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input
                name="bio"
                :value="bio"
                type="textarea"
                :required="true"
                :errors="errors"
                v-on:update="updateValue"
            />
            <Input name="submit" value="Create Performer" type="submit" />
            <Input
                v-for="(social, index) in socialMedia"
                v-bind:key="index"
                :value="social"
                :name="index"
                type="text"
                :errors="errors"
            />
        </form>
    </div>
</template>

<script>
import { mapState } from "vuex";
import socialMedia from "../../core/social-media";
import Input from "../../components/Input";
import Errors from "../../core/errors";
export default {
    data() {
        return {
            name: "",
            bio: "",
            errors: [],
            socialMedia: socialMedia
        };
    },
    computed: {
        ...mapState(["performers", "user", "performerTypes"])
    },
    components: {
        Input
    },
    methods: {
        updateValue: function(updateObject) {
            this[updateObject.name] = updateObject.value;
        },
        createPerformer: function(data) {
            return console.log(data);
            this.$store
                .dispatch("create", { route: "performers", data })
                .then(async () => {
                    await this.$store.dispatch("fetchState", {
                        route: "events"
                    });
                    this.$store.dispatch("findUser");
                    this.$router.push("/dashboard");
                })
                .catch(err => {
                    console.log(err);
                });
        },
        addSocialMedia: function(data) {
            for (let social in this.socialMedia) {
                data[social] = this.socialMedia[social];
            }
            this.createPerformer(data);
        },
        checkRequiredFields: function(data) {
            const errors = new Errors(data);
            this.errors = errors.checkFields();
            if (this.errors.length) {
                return false;
            }
            return true;
        },
        handleSubmit: function() {
            let data = {
                name: this.name,
                bio: this.bio
            };
            const valid = this.checkRequiredFields(data);
            if (valid) {
                this.addSocialMedia(data);
                return;
            }
        }
    },
    async mounted() {
        if (this.user === 0) {
            this.$store.dispatch("findUser");
        }
        this.$store.dispatch("fetchState", {
            route: "performerTypes"
        });
    }
};
</script>

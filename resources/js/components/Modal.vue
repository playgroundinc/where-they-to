<template>
    <div v-if="open" class="modal">
        <div class="modal__container">

            <Button 
              classes="modal__close-btn btn--inline" 
              v-on:clicked.prevent="closeModal"  
              label="close"
            />
            <h2 class="copy--center" v-if="title">{{title}}</h2>
            <p class="copy--center"> {{ copy }}</p>
            <Button v-if="button" v-on:clicked.prevent="handleClick" :label="button" />
        </div>
    </div>
</template>
<script>
// Components
import Button from "./Button";

export default {
    props: {
        title: {
            type: String,
            required: false,
        },
        copy: {
            type: String,
            required: true,
        },
        open: {
            type: Boolean,
            required: true,
        },
        button: {
            type: String,
            required: false,
        }
    },
    components: {
      Button,
    },
    methods: {
        closeModal: function() {
            this.$emit('close');
        },
        handleClick: function() {
            this.$emit('confirm');
        }
    }
}
</script>
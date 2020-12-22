<template>
    <div v-if="open" class="modal">
        <div class="modal__container">
            <button class="modal__close-btn btn--inline" @click.prevent="closeModal">close 
                <svg class="selections__single__close-icon" xmlns="http://www.w3.org/2000/svg" fill="none" height="18" width="18" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </button>
            <h2 class="copy--center" v-if="title">{{title}}</h2>
            <p class="copy--center"> {{ copy }}</p>
        </div>
    </div>
</template>
<script>
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
        }
    },
    methods: {
        closeModal: function() {
            this.$emit('close');
        }
    }
}
</script>
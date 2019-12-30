<template>

</template>

<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        name: "Thread",

        props:['dataRepliesCount', 'dataLocked'],

        components: {Replies, SubscribeButton},

        data() {
            return {
                repliesCount: this.dataRepliesCount,
                locked: this.dataLocked
            }
        }
    }
</script>

<style scoped>

</style>

<template>

</template>

<script>
    import Replies from '../components/Replies.vue';

    export default {
        name: "Thread",

        props:['initialRepliesCount'],

        components: {Replies},

        data() {
            return {
                repliesCount: this.initialRepliesCount
            }
        }
    }
</script>

<style scoped>

</style>

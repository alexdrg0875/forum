<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="material-icons">favorite</span>
        <span v-text="Count"></span>
    </button>
</template>

<script>
    export default {
        name: "Favorite",

        props: ['reply'],

        data() {
            return {
                Count: this.reply.favoritesCount,
                active : this.reply.isFavorited,
            }
        },

        computed: {
            classes(){
                return ['btn',
                    this.active ? 'btn-primary' : 'btn-outline-secondary'];
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                this.active ? this.unfavorite() :  this.favorite();
            },

            unfavorite(){
                    axios.delete(this.endpoint);

                    this.active = false;
                    this.Count--;
            },

            favorite() {

                    axios.post(this.endpoint);

                    this.active = true;
                    this.Count++;
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <div :id="'reply-'+id" class="card">
        <div class="card-header" :class="isBest ? 'text-white bg-success' : 'bg-light'">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/'+reply.owner.name"
                       v-text="reply.owner.name">
                    </a> said <span v-text="ago"></span>
                </h5>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>
                    <button class="btn btn-primary btn-xs">Update</button>
                    <button class="btn btn-link btn-xs" @click="editing = false" type="button">Cancel</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>

        <div class="card-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns',reply)">
                <button class="btn btn-outline-primary btn-xs mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
            </div>
            <button class="btn btn-outline-secondary btn-xs ml-auto" @click="markBestReply" v-if="authorize('owns', reply.thread)" v-show="! isBest">Best
                Reply?
            </button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: {Favorite},

        name: "Reply",

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        computed: {

            ago() {
                return moment(this.reply.created_at).fromNow() + '...';
            }
        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });
                this.editing = false;
                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.id);
                this.$emit('deleted', this.id);
            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');
                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>

<style scoped>

</style>

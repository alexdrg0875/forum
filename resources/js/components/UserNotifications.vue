<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
            <span class="material-icons">notifications</span>
        </a>
        <ul class="dropdown-menu">
            <li v-for="notification in notifications">
                <a :href="notification.data.link"
                   v-text="notification.data.message"
                   @click="markAsRead(notification)">
                </a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        name: "UserNotifications",

        data() {
            return {notifications: false}
        },

        created() {
            axios.get("/profiles/" + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id)
            }
        }
    }

</script>

<style scoped>

</style>

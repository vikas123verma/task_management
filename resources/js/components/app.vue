<template>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand">Task Management</a>
            <ul class="nav-menu">
                <li class="nav-item">
                    <router-link :to="{ name: 'Home' }" class="nav-link">Home</router-link>
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{ name: 'Login' }" class="nav-link">Login</router-link>
                </li>
                <li class="nav-item" v-if="!isLoggedIn">
                    <router-link :to="{ name: 'Register' }" class="nav-link">Register</router-link>
                </li>
                <li class="nav-item" v-if="isLoggedIn">
                    <router-link :to="{ name: 'Tasks' }" class="nav-link">Tasks</router-link>
                </li>
                <li class="nav-item" v-if="isLoggedIn">
                    <a @click="logout" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <main>
        <router-view />
    </main>
</template>
<script>
export default {
    data() {
        return {
            isLoggedIn: false
        };
    },
    watch: {
        '$route': {
            handler: function (route) {
                console.log(route)
                const token = localStorage.getItem('api_token');
                if (token !== null && token !== undefined) {
                    this.isLoggedIn = true;
                } else {
                    this.isLoggedIn = false;
                }
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        async logout() {
            try {
                localStorage.removeItem('api_token');
                this.$router.push('/login');

            } catch (error) {
                console.error('Logout error:', error);
            }
        },
    }
};
</script>
<style>
.navbar {
    background-color: #2f4f4f;
    color: #fff;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar-container {
    display: flex;
    align-items: center;
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.2rem;
}

.nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.nav-item {
    margin-right: 1rem;
}

.nav-link {
    color: #fff;
    text-decoration: none;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease-in-out;
}

.nav-link:hover {
    background-color: #17a2b8;
    color: #fff;
}
</style>

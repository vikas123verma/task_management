export default function authGuard(to, from, next) {
    if (isAuthenticated()) {
        next();
    } else {
        next('/login');
    }
}

function isAuthenticated() {
    const token = localStorage.getItem('api_token');
    return token !== null && token !== undefined;
}

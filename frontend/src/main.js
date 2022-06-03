import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.bundle'
import 'bootstrap-icons/font/bootstrap-icons.css'

import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import axios from "axios";
import auth from "./auth/auth";

auth.init()

auth.fetchUser()

axios.interceptors.request.use(request => {
    const user = JSON.parse(localStorage.getItem('user'))
    if (request.url !== '/token' && user) {
        let now = Date.now()
        if (now >= user.expires_in) {
            return auth.refreshTokens().then(() => {
                return request
            })
        }
    }
    return request
})

const app = createApp(App)
app.use(router)
app.mount('#app')
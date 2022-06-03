import axios from "axios";
import qs from "qs";

class tokenData {
    access_token
    refresh_token
    token_type
    expires_in
}

function fetchUser() {
    return axios.get('/api/profile/me').then(response => {
        localStorage.setItem('userinfo', JSON.stringify(response.data))
    })
}

function logout() {
    localStorage.removeItem('user')
    localStorage.removeItem('userinfo')
    delete axios.defaults.headers.common['Authorization']
}

function updateTokensData(payload) {
    let now = Date.now()
    payload.expires_in = payload.expires_in * 1000 + now
    localStorage.setItem('user', JSON.stringify(payload))
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + payload.access_token
}

function init() {
    const userData = localStorage.getItem('user')
    if (userData) {
        const user = JSON.parse(userData)
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + user.access_token
    }
}

function refreshTokens() {
    const userData = localStorage.getItem('user')
    if (userData) {
        const user = JSON.parse(userData)
        return axios.post('/token', qs.stringify({
            grant_type: 'refresh_token',
            refresh_token: user.refresh_token,
            client_id: 'app'
        }), {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(response => {
            updateTokensData(response.data)
        })
    }
}

const auth = {
    refreshTokens: refreshTokens,
    updateTokensData: updateTokensData,
    init: init,
    logout: logout,
    fetchUser: fetchUser,
    google: {
        generateAuthUrl: function () {
            const param = {
                client_id: '1008903433922-2dvj2e5sbfeq80u2ta60pof4i5npd2qm.apps.googleusercontent.com',
                response_type: 'code',
                scope: 'email profile',
                redirect_uri: 'http://dockerlocalhost.com/glogin'
            }
            const url = 'https://accounts.google.com/o/oauth2/auth?' + qs.stringify(param)
            console.log(url)
            return url
        }
    }
}

export default auth
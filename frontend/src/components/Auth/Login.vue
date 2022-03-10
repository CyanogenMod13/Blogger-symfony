<template>
	<form v-on:submit.prevent="login" class="mt-5 mx-auto w-40">
		<div v-if="!isCorrect" class="p-2 mb-3 border border-3 border-danger bg-light">
			Username or password is invalid
		</div>
		<div class="d-flex flex-column bg-light p-4">
			<strong class="form-label">Login</strong>
			<div class="mt-2">
				<strong>E-mail</strong>
				<input v-model="loginData.username" name="email" class="form-control" type="email" placeholder="your e-mail" v-bind:disabled="isButtonLoad" required>
			</div>
			<div class="mt-2">
				<strong>Password</strong>
				<input v-model="loginData.password" name="password" class="form-control" type="password" placeholder="enter your password" v-bind:disabled="isButtonLoad" required>
			</div>
			<div class="dropdown-divider"></div>
			<button type="submit" class="btn btn-primary"  v-bind:disabled="isButtonLoad">
				<span v-if="isButtonLoad" class="spinner-border spinner-border-sm"></span>
				<span v-else>Log in</span>
			</button>
			<div class="dropdown-divider">Log with</div>
			<button type="button" v-on:click="gClick" class="btn btn-danger">
				<i class="bi bi-google"></i> Log in with Google
			</button>
		</div>
	</form>
</template>

<script>
import axios from "axios";
import qs from "qs"
import auth from "../../auth/auth";

export default {
	name: "Login",
	methods: {
		login: function () {
			this.isButtonLoad = true
			axios.post('/token', qs.stringify(this.loginData), {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				}
			}).then(response => {
				auth.updateTokensData(response.data)
				return auth.fetchUser()
			}).then(() => {
				window.location.href = '/'
			}).catch(reason => {
				this.failed()
			})
		},
		failed: function () {
			this.isButtonLoad = false
			this.isCorrect = false
		},
		gClick: function () {
			window.location.replace(auth.google.generateAuthUrl())
		}
	},
	data() {
		return {
			isButtonLoad: false,
			isCorrect: true,
			loginData: {
				username: null,
				password: null,
				grant_type: 'password',
				client_id: 'app'
			}
		}
	}
}
</script>

<style scoped>

</style>
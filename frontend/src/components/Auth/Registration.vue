<template>
	<div class="mt-4 mx-auto w-50">
		<div v-if="!isCorrect" class="p-2 mb-3 border border-3 border-danger bg-light">
			Some fields is not correct
		</div>
		<div class="d-flex flex-column bg-light p-4">
			<strong class="form-label">Registration</strong>
			<div class="mt-2">
				<strong>E-mail</strong>
				<input v-model="registrationData.username" autocomplete="off" name="email" class="form-control" type="email" placeholder="your e-mail" required>
			</div>
			<div class="mt-2">
				<strong>First Name</strong>
				<input v-model="registrationData.firstName" autocomplete="off" name="firstName" class="form-control" type="text" placeholder="your first name" required>
			</div>
			<div class="mt-2">
				<strong>Second Name</strong>
				<input v-model="registrationData.lastName" autocomplete="off" name="secondName" class="form-control" type="text" placeholder="your second name" required>
			</div>
			<div class="mt-2">
				<strong>Pen Name</strong>
				<input v-model="registrationData.penName" autocomplete="off" name="penName" class="form-control" type="text" placeholder="your pen name" required>
			</div>
			<div class="mt-2">
				<strong>Password</strong>
				<input v-model="registrationData.password" autocomplete="off" name="password" class="form-control" type="password" placeholder="enter your password" required>
			</div>
			<div class="dropdown-divider"></div>
			<button v-on:click="reg" class="btn btn-primary" v-bind:disabled="isButtonLoad">
				<span v-if="isButtonLoad" class="spinner-border spinner-border-sm"></span>
				<span v-else>Register</span>
			</button>
		</div>
	</div>
</template>

<script>
import axios from "axios";

export default {
	name: "Registration",
	methods: {
		reg: function () {
			this.isButtonLoad = true
			axios.post('/api/registration', this.registrationData).
			then(response => {
				localStorage.setItem('user', JSON.stringify(response.data))
				this.$router.push('/')
			}).catch(reason => {
				this.failed()
			})
		},
		failed: function () {
			this.isButtonLoad = false
			this.isCorrect = false
		}
	},
	data() {
		return {
			isButtonLoad: false,
			isCorrect: true,
			registrationData: {
				username: '',
				firstName: '',
				lastName: '',
				penName: '',
				password: ''
			}
		}
	}
}
</script>

<style scoped>

</style>
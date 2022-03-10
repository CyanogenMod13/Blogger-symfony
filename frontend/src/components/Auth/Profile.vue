<template>
	<div v-if="userProfile">
		<div class="dropdown">
			<button class="btn text-light" data-bs-toggle="dropdown" id="d">
				<i class="bi bi-person-circle"></i>
				{{userProfile.firstName}} {{userProfile.lastName}}
			</button>
			<div class="dropdown-menu" aria-labelledby="d">
				<button class="dropdown-item">
					<i class="bi bi-person-rolodex"></i> Profile
				</button>
				<button v-on:click="$router.push('/publish')" class="dropdown-item">
					<i class="bi bi-pencil"></i> Publish
				</button>
				<div class="dropdown-divider"></div>
				<button v-on:click="logout" class="dropdown-item">
					<i class="bi bi-back"></i> Log out
				</button>
			</div>
		</div>
	</div>
	<div v-else class="d-flex">
		<button v-on:click="$router.push('/signin')" class="btn btn-outline-secondary mx-1" style="background-color: #548eaa">Sign in</button>
		<button v-on:click="$router.push('/registration')" class="btn btn-primary mx-1" style="background-color: #548eaa">Sign up</button>
	</div>
</template>

<script>
import axios from "axios";
import auth from "../../auth/auth";

export default {
	name: "Profile",
	methods: {
		logout: function () {
			auth.logout()
			window.location.href = '/'
		}
	},
	computed: {
		userProfile: function () {
			return JSON.parse(localStorage.getItem('userinfo'))
		}
	}
}
</script>

<style scoped>

</style>
<template>
	Redirecting...
</template>

<script>
import axios from "axios";
import qs from "qs";
import auth from "../../auth/auth";

export default {
	name: "GLogin",
	mounted() {
		axios.post('/token', qs.stringify({
			grant_type: 'google_code_grant',
			client_id: 'app',
			code: this.$route.query['code']
		}), {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			}
		}).then(response => {
			auth.updateTokensData(response.data)
			window.location.href = '/'
		})
	}
}
</script>

<style scoped>

</style>
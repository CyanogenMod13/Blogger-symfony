<template>
	<Header/>
	<div class="container mb-auto">
		<div class="d-flex p-3">
			<div class="w-100">
				<router-view/>
			</div>
		</div>
	</div>
	<Footer/>
</template>

<script>
import Header from "../components/Header.vue";
import Footer from "../components/Footer.vue";
export default {
	name: "Main",
	components: {Header, Footer}
}
</script>

<style scoped>

</style>
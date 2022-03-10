<template>
	<header id="headerNav" class="d-flex border-bottom py-1 px-5" style="background-color: #303b44">
		<a class="fs-4 text-light text-decoration-none me-auto" href="#">My Blog Container</a>
		<ul class="nav nav-pills">
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/">Home</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/categories">Categories</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/blogs">Blogs</router-link>
			</li>
			<li class="nav-item">
				<router-link class="nav-link me-1 text-light" to="/articles">Articles</router-link>
			</li>
		</ul>
		<profile/>
	</header>
</template>

<script>
import Profile from "./Auth/Profile.vue";
export default {
	name: "Header",
	components: {Profile}
}
</script>

<style scoped>

</style>
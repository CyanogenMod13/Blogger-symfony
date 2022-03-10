<template>
	<footer class="d-flex py-1 px-5 text-muted border-top" style="background-color: #303b44">
		<div class="py-2 me-auto">© My Blog Container, 2021</div>
		<div>
			<ul class="nav nav-pills">
				<li class="nav-item">
					<router-link class="nav-link text-muted" to="/">Home</router-link>
				</li>
				<li class="nav-item">
					<router-link class="nav-link text-muted" to="/categories">Categories</router-link>
				</li>
				<li class="nav-item">
					<router-link class="nav-link text-muted" to="/blogs">Blogs</router-link>
				</li>
				<li class="nav-item">
					<router-link class="nav-link text-muted" to="/articles">Articles</router-link>
				</li>
			</ul>
		</div>
	</footer>
</template>

<script>
export default {
	name: "Footer"
}
</script>

<style scoped>

</style>
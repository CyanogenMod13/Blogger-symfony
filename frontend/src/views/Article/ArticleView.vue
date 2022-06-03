<template>
	<LoadSpinner v-if="isLoading"/>
	<div v-else>
		<div class="bg-light p-3">
			<div>
				<i class="bi bi-person-circle"></i> {{ article.author.firstName }} {{ article.author.lastName }}
				<span class="text-muted ms-3">{{ article.publishedAt }}</span>
			</div>
			<h3>{{ article.title }}</h3>
			<div v-html="article.content"></div>
			<div class="d-flex flex-row border-top pt-2">
				<button class="btn btn-primary d-flex">
					<i class="bi bi-heart"></i> Like me
				</button>
			</div>
		</div>
		<div id="comments" class="bg-light p-3 mt-2">
			<div class="border-bottom mb-2">
				<p>{{numberComments}} Comments</p>
			</div>
			<CommentViewer v-bind:comments="article.comments"/>
		</div>
	</div>
</template>

<script>
import LoadSpinner from "../../components/LoadSpinner.vue";
import CommentViewer from "./CommentViewer.vue";
import axios from "axios";

export default {
	name: "ArticleView",
	components: {CommentViewer, LoadSpinner},
	methods: {
		loadArticle: function () {
			axios.get(`/api/articles/${this.$route.params.id}`).then((response) => {
				this.isLoading = false
				this.article = response.data
			})
		}
	},
	data() {
		return {
			isLoading: true,
			article: null,
			numberComments: 3
		}
	},
	mounted() {
		this.loadArticle()
	}
}
</script>

<style scoped>

</style>
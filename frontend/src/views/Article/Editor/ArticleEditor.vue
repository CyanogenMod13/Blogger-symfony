<template>
	<div class="bg-light">
		<div class="d-flex flex-column p-5">
			<div class="pb-1">
				<input v-model="article.title" class="input-text w-100 " type="text" name="title" placeholder="Title of article">
			</div>

			<div class="d-flex flex-column" style="min-height: 400px">
				<div ref="edit" contenteditable class="input-text w-100" v-on:mousedown.left="onFocus"></div>
				<div class="dropdown insert-element-button" ref="insert-button">
					<button  data-bs-toggle="dropdown" class="insert-element-button" id="ddb">
						<h5><i class="bi bi-plus-circle"></i></h5>
					</button>
					<div class="dropdown-menu">
						<button v-on:click="addHeaderElement" class="dropdown-item">
							<i class="bi bi-type-h3"></i> Header
						</button>
						<button class="dropdown-item">
							<i class="bi bi-list-ul"></i> List
						</button>
						<button class="dropdown-item">
							<i class="bi bi-image"></i> Picture
						</button>
						<button class="dropdown-item">
							<i class="bi bi-quote"></i> Quote
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="dropdown-divider"></div>
		<div class="d-flex p-2" v-on:click="publish">
			<button class="btn btn-outline-success me-2">
				<span v-if="isPublishing">Publishing...</span>
				<span v-else>Ready to publish</span>
			</button>
			<div class="py-1"><span>Saved at 15:04</span></div>
		</div>
	</div>
</template>

<script>
import axios from "axios";

let lasDiv = null

export default {
	name: "ArticleEditor",
	methods: {
		onFocus: function (event) {
			const div = lasDiv = event.target
			const rect = div.getBoundingClientRect()
			const button = this.$refs["insert-button"]

			console.log(rect)

			button.style.left = rect.left - 30 + 'px'
			button.style.top = rect.top + 'px'
			button.style.visibility = 'visible'
		},
		onFocusout: function (event) {
			const button = this.$refs["insert-button"];
			console.log(event.target)
			console.log(button)
			if (event.target.ref === "insert-button") return;
			button.style.visibility = 'hidden'
		},
		addHeaderElement: function (event) {
			document.execCommand('formatBlock', false, 'h5')
		},
		publish: function () {
			this.isPublishing = true
			this.article.content = this.$refs['edit'].innerHTML
			axios.post('/api/articles/publish', this.article).then(response => {
				const articleId = response.data.articleId
				this.$router.push('/articles/' + articleId)
			})
		}
	},
	data() {
		return {
			isPublishing: false,
			article: {
				title: null,
				content: null
			}
		}
	}
}
</script>

<style scoped>
	.input-text {
		border: none;
		outline: none;
		background: none;
	}

	.input-text[contenteditable]:empty::before {
		content: 'Enter text';
		color: gray;
	}

	.insert-element-button {
		background: none;
		border: none;
		padding: unset;
		position: absolute;
	}
</style>
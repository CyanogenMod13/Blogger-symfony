import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue';
import CategoriesView from "../views/List/CategoriesView.vue";
import BlogsView from "../views/List/BlogsView.vue";
import ArticlesView from "../views/List/ArticlesView.vue";
import ArticleView from "../views/Article/ArticleView.vue";
import Login from "../components/Auth/Login.vue";
import Registration from "../components/Auth/Registration.vue";
import ArticleEditor from "../views/Article/Editor/ArticleEditor.vue";
import Main from "../views/Main.vue";
import axios from "axios";
import qs from "qs";
import GLogin from "../components/Auth/GLogin.vue";


const router = createRouter({
	history: createWebHistory(import.meta.env.BASE_URL),
	routes: [
		{
			path: '/',
			name: 'Main',
			component: Main,
			children: [
				{
					path: '/',
					name: 'Home',
					component: HomeView
				},
				{
					path: '/categories',
					name: 'Categories',
					component: CategoriesView
				},
				{
					path: '/blogs',
					name: 'Blogs',
					component: BlogsView
				},
				{
					path: '/articles/:id',
					name: 'Article',
					component: ArticleView
				},
				{
					path: '/articles',
					name: 'Articles',
					component: ArticlesView
				},
				{
					path: "/publish",
					name: 'ArticleEditor',
					component: ArticleEditor
				}
			]
		},
		{
			path: '/signin',
			name: 'login',
			component: Login
		},
		{
			path: '/glogin',
			name: 'GLogin',
			component: GLogin
		},
		{
			path: '/registration',
			name: 'Registration',
			component: Registration
		}
	]
})

export default router

<template>
<div class="container">
	<div class="row">
		<div class="col-md-6 mx-auto">

	<div class="list-group list-group-flush">
		<div class="list-group-item text-muted text-center">
			<h3>Articles</h3>
<div class="card" v-if="edit">
	<div class="card-body" @submit.prevent="addArticle">
<form action="">
	<div class="form-control-group">

		<input required v-model="article.title" type="text" class="form-control" placeholder="Title">
	</div>
<div class="form-control-group mt-2">

	<textarea required v-model="article.body" class="form-control" placeholder="Body" cols="30" rows="10"></textarea>
	</div>
<button type="submit" class="btn btn-outline-warning">Publish</button> <button @click="toggleEdit" type="button" class="btn btn-outline-danger">Cancel</button>
</form>
	</div>
</div>

			<p class="text-center">
				<button  class="btn btn-warning btn-sm" @click="showAdd">New Article</button>
				<button v-show="pagination.links.first" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.first)">First Page</button>
				<button v-show="pagination.links.prev" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.prev)">Prev. Page</button>
				<button v-show="pagination.links.next" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.next)">Next Page</button>
				<button v-show="pagination.links.last" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.last)">Last Page</button> <br>

				<small>Page: <strong>{{pagination.meta.current_page}}</strong> Of <strong>{{pagination.meta.last_page}}</strong> </small>
			</p>
		</div>

<div v-for="article in articles" v-bind:key="article.id" class="list-group-item">
	<h4>{{article.title}}</h4>
	<small class="border-success p-1 text-success">{{article.created_at}}</small>
	<p class="class-muted text-justify">{{article.body}}</p>
	<button @click="deleteArticle(article.id)" class="btn text-danger btn-link btn-sm">Delete</button>
	<button @click="editArticle(article)" class="btn text-success btn-link btn-sm">Edit</button>

</div>
<div class="list-group-item">
<p class="text-center">
				<button v-show="pagination.links.first" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.first)">First Page</button>
				<button v-show="pagination.links.prev" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.prev)">Prev. Page</button>
				<button v-show="pagination.links.next" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.next)">Next Page</button>
				<button v-show="pagination.links.last" class="btn btn-outline-warning btn-sm" @click="getArticles(pagination.links.last)">Last Page</button> <br>
				<small>Page: <strong>{{pagination.meta.current_page}}</strong> Of <strong>{{pagination.meta.last_page}}</strong> </small>
			</p>
</div>


	</div>
		</div>


	</div>

	
</div>
</template>	
<script>
export default {
	mounted(){

	},
	data(){
		return{
			articles:[],
			article:{
				id:'',
				title:'',
				body:''
			},
			aticle_id:'',
			pagination:{
				links:{},
				meta:{}
			},
			edit:false,
			add:false

		}

	},
	created(){

		this.getArticles();
	},
	methods:{
		getArticles(page_url){
			page_url = page_url || '/api/articles';
				fetch(page_url)
			.then(res => res.json())
			.then(res=>{
				console.log(res.data);
				this.pagination.links = res.links;
				this.pagination.meta=res.meta;
			this.articles = res.data;
			});
		},
		deleteArticle(id){
			if(confirm("Do you want to delete?")){

				fetch(`/api/article/${id}`,{
					method:'delete'
				})
				.then(res=>res.json())
				.then(data=>{
					this.loadpage();

				});
			}

		},
		addArticle(){

			
			if(this.add){
		fetch('api/article/',{
			method:'post',
			body:JSON.stringify(this.article),
			headers:{
				'content-type':'application/json'
			}
		})
		.then(res =>res.json())
		.then(data =>{		
		this.articles.push(data.data);
		this.clearData;
		});
			}else{

				fetch('api/article',{
					method:'PUT',
					body:JSON.stringify(this.article),
					headers:{

						'content-type':'application/json'
					}
				})
				.then(res => json())
				.then(data=>{
					this.loadpage();

				});

			}

		},

		toggleEdit(){
			this.edit=false;

		},
		showAdd(){
		this.edit=true;
		this.add=true;
		this.clearData();
		},
		editArticle(article){
			this.edit=true;
			this.article.id=article.id;
			this.article.title=article.title;
			this.article.body=article.body;

},
loadpage(){
	let currentPage = this.pagination.meta.path +'?page=' + this.pagination.meta.current_page;					
	this.getArticles(currentPage);

},
clearData(){
this.article.title = '';
		this.article.body='';
		this.article.id='';

}
	}
}
</script>
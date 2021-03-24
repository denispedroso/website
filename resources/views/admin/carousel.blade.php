@extends('layouts.app')

@section('content')
    <div id="napp" class="container mt-5">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">Carousel</h1>
              <p class="lead">Formulario para cadastro de itens no Carousel</p>
            </div>
          </div>

        <form :id="formid" :name="formid" class="mt-0">
            <input type="hidden" id="id" name="id" v-model="form.id">
    
            <!-- Input Nome -->
            <div class="form-group">
                <label for="item_name">Nome</label>
                <input v-model="form.item_name" name="item_name" id="item_name" type="text" class="form-control" placeholder="Nome">
            </div>   
        
            <!-- Descrição -->
            <div class="form-group">
                <label for="item_description">Descrição</label>
                <textarea v-model="form.item_description" name="item_description" id="item_description" type="textarea" class="form-control" placeholder="Descrição" rows="3"></textarea>
            </div>
            
            <uploadfile id="item_image" v-bind:src.sync="form.item_image"></uploadfile>
            
            <div class="d-flex justify-content-between">
                <div class="p-2"><button name="save" @click="save()" type="button" class="btn btn-primary">Salvar</button></div>
                <div class="p-2"><button name="rreset" @click="reset()" type="button" class="btn btn-primary">Limpar</button></div>
                <div class="p-2"><button name="excluir" @click="excluir()" type="button" class="btn btn-primary">Deletar</button></div>
            </div>
        </form>
        <newmodal dusk="newmodal" v-bind:label.sync="modal.label" v-bind:title.sync="modal.title" v-bind:body.sync="modal.body"></newmodal>
        <div class="row justify-content-center mt-2">
            <ul class="list-group">
                <a v-for="(item, key) in carouselIndex" :key="`item-${key}`" @click="showItem(item)" href="#" class="list-group-item" v-bind:class="{ 'list-group-item-primary': key % 2 == 0 }">
                    Nome: @{{ item.item_name }} - Descrição: @{{ item.item_description }}
                </a>
            </ul>   
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        const napp = new Vue({
            el: '#napp',
            data: {
                formid: 'form1',
                carouselIndex : [],
                form: new Form({
                    id: '',
                    item_name: '',
                    item_description: '',
                    item_image: ''
                }),
                modal: {
                    label: 'modal1',
                    title: 'Sucesso',
                    body: ''
                },        
            },
            mounted: function () {
                    this.getCarouselIndex()
                },
            methods: {
                getCarouselIndex() { // requests the carousel's index 
                    axios.get('/carousel/nocachedindex')
                    .then(response => {
                        this.carouselIndex = response.data
                    })            
                },
                showItem(item) { // Shows the item on the screen
                    for (let field in item) {
                        this.form[field] = item[field];
                    }
                },
                save() { // * Save the form --> shows the response --> clears the form
                    this.submit('post', '/carousel/store')
                        .then(response => {  
                            this.modal.body = "Salvo com sucesso!";
                            $('#modal1').modal('show');
                            this.form.reset(this.formid);
                            this.getCarouselIndex();
                        })
                        .catch(error => {
                            console.log(error);
                        }); 
                }, // * End of Save()
                reset() {
                    this.form.reset(this.formid)
                },
                excluir() {
                    this.submit('post', '/carousel/destroy')
                        .then(response => {  
                            this.modal.body = "Excluído com sucesso!";
                            $('#modal1').modal('show');
                            this.form.reset(this.formid);
                            this.getCarouselIndex();
                        })
                        .catch(error => {
                            console.log(error);
                        });         
                },
                submit(requestType, url) {
                    var form = document.getElementById(this.formid);
                    var bodyFormData = new FormData(form);
                    return axios({
                        method: requestType,
                        url: url,
                        data: bodyFormData,
                        headers: {'Content-Type': 'multipart/form-data' }
                        })           
                },
            },
        })
    </script>
@endsection
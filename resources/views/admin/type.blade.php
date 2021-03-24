@extends('layouts.app')

@section('content')
    <div id="napp" class="container mt-5">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
              <h1 class="display-4">Tipo de produto</h1>
              <p class="lead">Formulario para cadastro de tipos de produto</p>
            </div>
          </div>

        <form :id="formid" :name="formid" class="mt-0">
            <input type="hidden" id="id" name="id" v-model="form.id">
    
            <!-- Input Nome -->
            <div class="form-group">
                <label for="name">Nome</label>
                <input v-model="form.name" name="name" id="name" type="text" class="form-control" placeholder="Nome">
            </div>   
            
            <div class="d-flex justify-content-between">
                <div class="p-2"><button name="save" @click="save()" type="button" class="btn btn-primary">Salvar</button></div>
                <div class="p-2"><button name="rreset" @click="reset()" type="button" class="btn btn-primary">Limpar</button></div>
                <div class="p-2"><button name="excluir" @click="excluir()" type="button" class="btn btn-primary">Deletar</button></div>
            </div>
        </form>
        <newmodal dusk="newmodal" v-bind:label.sync="modal.label" v-bind:title.sync="modal.title" v-bind:body.sync="modal.body"></newmodal>
        <div class="row justify-content-center mt-2">
            <ul class="list-group">
                <a v-for="(item, key) in typeIndex" :key="`item-${key}`" @click="showItem(item)" href="#" class="list-group-item" v-bind:class="{ 'list-group-item-primary': key % 2 == 0 }">
                    Nome: @{{ item.name }}
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
                typeIndex : [],
                form: new Form({
                    id: '',
                    item_name: '',
                }),
                modal: {
                    label: 'modal1',
                    title: 'Sucesso',
                    body: ''
                },
            },
            mounted: function () {
                    this.getTypeIndex()
                },
            methods: {
                getTypeIndex() { // requests the type's index 
                    axios.get('/type/index')
                    .then(response => {
                        this.typeIndex = response.data
                    })            
                },
                showItem(item) { // Shows the item on the screen
                    for (let field in item) {
                        this.form[field] = item[field];
                    }
                },
                save() { // * Save the form --> shows the response --> clears the form
                    this.submit('post', '/type/store')
                        .then(response => {  
                            this.modal.body = "Salvo com sucesso!";
                            $('#modal1').modal('show');
                            this.form.reset(this.formid);
                            this.getTypeIndex();
                        })
                        .catch(error => {
                            console.log(error);
                        }); 
                }, // * End of Save()
                reset() {
                    this.form.reset(this.formid)
                },
                excluir() {
                    this.submit('post', '/type/destroy')
                        .then(response => {  
                            this.modal.body = "Excluído com sucesso!";
                            $('#modal1').modal('show');
                            this.form.reset(this.formid);
                            this.getTypeIndex();
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
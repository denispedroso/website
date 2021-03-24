@extends('layouts.app')

@section('content')
    <div id="napp" class="container mt-5">
        <form :id="formid" :name="formid" class="mt-3">
            <div class="form-group">
                <label for="image" class="font-weight-bold">Imagem Produto</label>
                <input type="file" @change="onFileChange" id="image" name="image" accept="image/*;capture=camera">

                <div id="preview" class="my-2">
                  <img v-if="url" :src="url" />
                </div>
            </div> 
            
            <input type="hidden" id="id" name="id" v-model="form.id">
    
            <!-- Input Nome -->
            <div class="form-group">
                <label for="name">Nome</label>
                <input v-model="form.name" name="name" id="name" type="text" class="form-control" placeholder="Nome">
            </div>   
    
            <!-- code  -->
            <div class="form-group">
                <label for="code">Codigo</label>
                <input v-model="form.code" name="code" id="code" type="text" class="form-control" placeholder="Codigo">
            </div>
    
            <!-- Descrição Title -->
            <div class="form-group">
                <label for="description">Descrição</label>
                <textarea v-model="form.description" name="description" id="description" type="textarea" class="form-control" placeholder="Descrição" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <label for="type_id">Tipo de produto</label>
                <select class="custom-select" v-model="form.type_id" id="type_id" name="type_id" dusk="type_id">
                    <option selected>Tipo</option>
                    <option v-for="(type, key) in typeIndex" :key="`type-${key}`" :value="type.id">@{{ type.name }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="brand_id">Marca Produto</label>
                <select class="custom-select" v-model="form.brand_id" id="brand_id" name="brand_id" dusk="brand_id">
                    <option selected>Marca</option>
                    <option v-for="(brand, key) in brandIndex" :key="`brand-${key}`" :value="brand.id">@{{ brand.name }}</option>
                </select>
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
                <a v-for="(item, key) in productIndex" :key="`item-${key}`" @click="showItem(item)" href="#" class="list-group-item" v-bind:class="{ 'list-group-item-primary': key % 2 == 0 }">
                    Nome: @{{ item.name }} - Codigo: @{{ item.code }}
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
                productIndex : [],
                typeIndex: [],
                brandIndex: [],
                form: new Form({
                    id: '',
                    name: '',
                    code: '',
                    description: '',
                    type_id: '',
                    brand_id: '',
                    image: ''
                }),
                modal: {
                    label: 'modal1',
                    title: 'Sucesso',
                    body: ''
                },
                newuser : {},
                url : ''                 
            },
            mounted: function () {
                    this.getProductIndex()
                    this.getTypeIndex()
                    this.getBrandIndex()
                },
            methods: {
                getProductIndex() { // requests the product's index 
                    axios.get('/product/nocachedindex')
                    .then(response => {
                        this.productIndex = response.data
                    })            
                },
                getTypeIndex() { // requests types index
                    axios.get('/type/index')
                    .then(response => {
                        this.typeIndex = response.data
                    })
                },
                getBrandIndex() { // requests types index
                    axios.get('/brand/index')
                    .then(response => {
                        this.brandIndex = response.data
                    })
                },
                showItem(item) { // Shows the item on the screen
                    for (let field in item) {
                        this.form[field] = item[field]
                    }
                    this.url = this.form.image
                },
                save() { // * Save the form --> shows the response --> clears the form
                    this.submit('post', '/product/store')
                        .then(response => {  
                            this.modal.body = "Salvo com sucesso!";
                            $('#modal1').modal('show');
                            this.reset();
                            this.getProductIndex();
                        })
                        .catch(error => {
                            console.log(error);
                        }); 
                }, // * End of Save()
                reset() {
                    this.url = false
                    this.form.reset(this.formid)
                },
                excluir() {
                    this.submit('post', '/product/destroy')
                        .then(response => {  
                            this.modal.body = "Excluído com sucesso!";
                            $('#modal1').modal('show');
                            this.reset();
                            this.getProductIndex();
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
                onFileChange(e) {
                    const file = e.target.files[0];
                    this.url = URL.createObjectURL(file);
                }                
            },
        })
    </script>
    <style>
        #preview {
          display: flex;
          justify-content: center;
          align-items: center;
        }
        
        #preview img {
          max-width: 100%;
          max-height: 300px;
        }
    </style>
@endsection
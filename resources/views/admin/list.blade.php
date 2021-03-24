@extends('layouts.app')
@section('content')
    <div id="napp" class="container mt-1">
        <div class="row">
            <div class="col-sm-3">
                <div class="list-group">
                    @foreach ($brands as $item)
                        @isset($brand)
                        @if ($item['id'] == $brand['id'])
                            <a href="/list/{{ $type->id."/". $item->id }}" class="list-group-item list-group-item-action active">
                        @else
                            <a href="/list/{{ $type->id."/". $item->id }}" class="list-group-item list-group-item-action">
                        @endif
                        @else
                            <a href="/list/{{ $type->id."/". $item->id }}" class="list-group-item list-group-item-action">
                        @endisset
                            {{ $item->name }}
                            </a>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-9">
                @isset($products)
                    <div class="row">
                    @foreach ($products as $item)
                    <div class="card ml-2" style="width: 16rem;">
                        <img src="{{ asset($item->image) }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">{{ $item->description }}</p>
                            <a href="/product/{{ $item->id }}" class="btn btn-primary">Detalhes</a>
                        </div>
                    </div>
                    @endforeach
                    </div>
                @endisset
                @isset($product)
                <div class="card text-center">
                    <div class="card-header">
                        {{ $product->name }}
                    </div>
                    <div class="card-body justify-content-center">
                        <h5 class="card-title">{{ $product->type_name }}</h5>
                        <img src="{{ asset($product->image) }}" alt="" class="img-fluid">
                        <p class="card-text">{{ $product->description }}</p>
                        {{-- <a href="#" class="btn btn-primary">{{ $product->brand_name }}</a> --}}
                    </div>
                    <div class="card-footer text-muted">
                       Código do produto: {{ $product->code }}
                    </div>
                </div>
                @endisset

            </div>
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
                    brand_id: ''
                }),
                modal: {
                    label: 'modal1',
                    title: 'Sucesso',
                    body: ''
                },
                newuser : {}                   
            },
            mounted: function () {
                    this.getProductIndex()
                    this.getTypeIndex()
                    this.getBrandIndex()
                },
            methods: {
                getProductIndex() { // requests the product's index 
                    axios.get('/product/index')
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
                        this.form[field] = item[field];
                    }
                },
                save() { // * Save the form --> shows the response --> clears the form
                    this.submit('post', '/product/store')
                        .then(response => {  
                            this.modal.body = "Salvo com sucesso!";
                            $('#modal1').modal('show');
                            this.form.reset(this.formid);
                            this.getProductIndex();
                        })
                        .catch(error => {
                            console.log(error);
                        }); 
                }, // * End of Save()
                reset() {
                    this.form.reset(this.formid)
                },
                excluir() {
                    this.submit('post', '/product/destroy')
                        .then(response => {  
                            this.modal.body = "Excluído com sucesso!";
                            $('#modal1').modal('show');
                            this.form.reset(this.formid);
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
                getListClass(key) {
                    if (key % 2 == 0) {
                        return "list-group-item"
                    } 
                    return "list-group-item list-group-item-action list-group-item-primary"
                },
            },
        })
    </script>
@endsection
@extends('layouts.app')

@section('content')
<div id="napp" class="container mt-3">
<div class="container">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li v-for="(item, key) in carouselIndex" data-target="#myCarousel" :data-slide-to="key" :class="{ active: key == 0 }"></li>
        </ol>
        <div class="carousel-inner bg-dark">
            <div v-for="(item, key) in carouselIndex" class="carousel-item" v-bind:class="{ active: key == 0 }" data-interval="5000">
                <img :src="item.item_image"  class="mx-auto d-block w-auto h-100" alt="">
                <div class="carousel-caption text-warning">
                    <h5>@{{ item.item_description }}</h5>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Próximo</span>
        </a>
    </div>
</div>

<div class="container marketing">
    <!-- Columns of text below the carousel -->
    <div class="row">
        <div class="col-lg-4" v-for="(item, key) in productIndex">
            <div style="height: 140px;">
                <img class="bd-placeholder-img rounded-circle w-auto h-100" :src="item.image">
            </div>
            <h2>@{{ item.name }}</h2>
            <p>@{{ item.item_description }}</p>
            <p><a class="btn btn-secondary" :href=`http://${host}/product/${item.id}`  role="button">Veja os detalhes &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->
</div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    const napp = new Vue({
        
        el: '#napp',

        data: {
            carouselIndex: [],
            productIndex: [],
            modal: {
                label: 'modal1',
                title: 'Sucesso',
                body: ''
            },
            newuser : {},
            host : '',                   
        },
        mounted: function () {
                this.getCarouselIndex()
                this.getProductIndex()
                this.host = window.location.hostname
            },
        methods: {
            getCarouselIndex() { // requests carousel index
                axios.get('/carousel/index')
                .then(response => {
                    this.carouselIndex = response.data
                })
            },
            getProductIndex() { // requests types index
                axios.get('/product/index')
                .then(response => {
                    this.productIndex = response.data
                })
            },
        },
    })
</script>
@endsection
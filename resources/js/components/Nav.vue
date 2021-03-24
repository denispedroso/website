<template>
<div>
<nav class="navbar navbar-custom navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/">DTP Motoshop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <!-- Item do Menu -->
            <li class="nav-item active">
                <a class="nav-link text-warning" href="/">Home <span class="sr-only"></span></a>
            </li>

            <!-- Item do Menu -->
            <li class="nav-item">
                <a v-for="item in pageIndex" :key="`item-${item}`" class="nav-link text-warning" :href="item.link">Link</a>
            </li>
        </ul>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
    </nav>
</div>
</template>

<script>
export default {
    data() {
        return {
            pageIndex : []          
        }
    },
    mounted(){
        this.getPageIndex()
    },
    methods: {
        getPageIndex() {
            axios.get('/nav/index')
                .then(response => {
                    this.pageIndex = response.data
                })
        }
    }
}
</script>
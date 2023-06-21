<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="{{ url('/') }}">E-Shop</a>
        <div class="search-bar">
            <form action="{{ url('/search-product') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control" id="search_product" name="search_product" style="border-radius: 7px;" placeholder="Search..." aria-label="Search..." required>
                    <button type="submit" class="input-group-text p-3" ><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link font-weight-bold active" aria-current="page" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="{{ url('category') }}">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="{{ url('cart') }}">Cart
                        <span class="badge badge-pill bg-primary cart-count">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="{{ url('wishlist') }}">Wishlist
                        <span class="badge badge-pill bg-success wishlist-count">0</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-bold dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Options</a>
                    <ul class="dropdown-menu">
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold dropdown-item" href="{{ url('my-orders') }}">My Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold dropdown-item" href="#">My Profile</a>
                        </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link font-weight-bold dropdown-item">{{ __('Login') }}</a>
                                </li>
                            @elseif (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link font-weight-bold dropdown-item">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link font-weight-bold dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        @endguest
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<link rel="stylesheet" href="{{ asset('css/nav-style.css') }}">

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
      <a class="navbar-brand" href="/">Barbatos Shop</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse option" id="navbarNavDropdown">
        <ul class="navbar-nav leftNav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Category
            </a>
            <ul class="dropdown-menu">
                @foreach ($categories as $category)
                    <li><a class="dropdown-item" href="{{ route('product.category', ['category_id' => $category->id]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
          </li>
          @auth
            @if (auth()->user()->role === 'Admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.home') }}">Manage Product</a>
                </li>
            @endif
          @endauth
        </ul>
        <ul class="navbar-nav rightNav">
            @auth
                @if (auth()->user()->role === 'Customer')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.view') }}">
                        <img class="cart-logo" src="{{ asset('img/cart-logo.png') }}">
                    </a>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('auth.profile') }}">My Profile</a></li>
                      @if (auth()->user()->role === 'Customer')
                          <li><a class="dropdown-item" href="{{ route('transaction.history') }}">Transaction History</a></li>
                      @endif
                      <li><a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a></li>
                    </ul>
                </li>
            @endauth

            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('auth.register') }}">Register</a>
                </li>
            @endguest
        </ul>
      </div>
    </div>
</nav>
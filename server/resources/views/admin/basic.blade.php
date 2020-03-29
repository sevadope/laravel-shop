@extends('layouts.basic')

@section('header-right-nav')
	@auth
	    <li class="c-header-nav-item px-3">
	    	<a class="c-header-nav-link" href="#">Account</a>
	    </li>

	    <li class="c-header-nav-item px-3">
	    	<a class="c-header-nav-link" href="#" 
	    	onclick="
	    		event.preventDefault();
              	document.getElementById('logout-form').submit();
			">
				Logout
			</a>
			<form id="logout-form" method="post" class="d-none"
			action="{{ route('admin.logout') }}">
				@csrf
			</form>
	    </li>	
	@endauth
@endsection

@section('sidebar')
	<li class="c-sidebar-nav-item">
	    <a href="#" class="c-sidebar-nav-link">
	        <h5>Orders</h5>
	    </a>                
	</li>	
	<li class="c-sidebar-nav-item">
	    <a href="{{ route('admin.products.index') }}" class="c-sidebar-nav-link">
	        <h5>Products</h5>
	    </a>                
	</li>	
	<li class="c-sidebar-nav-item">
	    <a href="{{ route('admin.categories.index') }}" class="c-sidebar-nav-link">
	        <h5>Categories</h5>
	    </a>                
	</li>	
@endsection

@section('content')
	@yield('content')
@endsection
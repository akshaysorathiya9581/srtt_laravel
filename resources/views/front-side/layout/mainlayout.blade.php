<!DOCTYPE html>
<html lang="en">
	 <head>
	   @include('front-side.layout.partials.head')
	 </head>
	 <body>
		@include('front-side.layout.partials.nav')
		@include('front-side.layout.partials.header')
		<div class="wrapper">
            <div class="container">
				@yield('content')
				@include('front-side.layout.partials.footer')
		  	</div> <!-- end container -->
		</div><!-- end wrapper -->
		@include('front-side.layout.partials.footer-scripts')
	</body>
</html>

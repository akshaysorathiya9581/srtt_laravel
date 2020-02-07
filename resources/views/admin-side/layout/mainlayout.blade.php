<!DOCTYPE html>
<html lang="en">
	 <head>
	   @include('admin-side.layout.partials.head')
	 </head>
	 <body class="fixed-left">
		<div class="wrapper">
		@include('admin-side.layout.partials.nav')
		@include('admin-side.layout.partials.header')
		@include('admin-side.layout.partials.left-sidebar')
            <div class="content-page"><!-- Start content -->
                <div class="content">
                    <div class="container">
						@yield('content')
				 	</div> <!-- container -->
                </div> <!-- content -->
				@include('admin-side.layout.partials.footer')
			</div>
		</div><!-- end wrapper -->
		@include('admin-side.layout.partials.footer-scripts')
	</body>
</html>

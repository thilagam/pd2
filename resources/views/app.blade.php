<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
    
    @if(Auth::check()) 
	{{ $dictionary['brand_name'] }} : 
    @if($tn_breadcrumb['breadcrumb_page_title'])
	   {{ $dictionary[$tn_breadcrumb['breadcrumb_page_title']] }} 
    @endif
    @endif
	</title>
	<!-- Fonts -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
        <!-- style -->
        
        @include('blocks.style')
          

</head>
<body class="page-body">	
@if(Auth::check())
    @include('blocks.setting_pane_top')
    @include('blocks.top_nav')
    @include('blocks.sidebar_nav')
@endif

	<div style="" class="main-content">
		<div class="clearfix"></div>	
	    @include('blocks.breadcrumb')
		@include('blocks.page')
		<div class="clearfix"></div>
		
@if(Auth::check())
		@include('blocks.footer')
@endif
		
    </div>
@if(Auth::check())    
       @include('blocks.help')
@endif
	<!-- Scripts -->
	@include('blocks.script')
	
</body>
</html>

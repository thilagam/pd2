<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="tf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $dictionary['lg_page_title']  }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Arimo:400,700,400italic">
        <!-- style -->
        
        @include('blocks.style')
          

</head>
<body class="page-body login-page login-light">
        
       	<div class="login-container">
	
		<div class="row">
	
			<div class="col-sm-6">

			<script type="text/javascript">
					jQuery(document).ready(function($)
					{
						// Reveal Login form
						setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);
	
	
						// Validation and Ajax action
						$("form#login").validate({
							rules: {
								email: {
									required: true
								},
	
								password: {
									required: true
								}
							},
	
							messages: {
								email: {
									required: 'Please enter your email or username.'
								},
	
								password: {
									required: 'Please enter your password.'
								}
							},
	
	
						});
	
						// Set Form focus
						$("form#login .form-group:has(.form-control):first .form-control").focus();
					});
				</script>
                          @include('blocks.login_page')       
                 </div>    
	    </div>
                
        </div>

        <!-- Scripts -->
        @include('blocks.script')

</body>
</html>


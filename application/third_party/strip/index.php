<html>
<head>
	<title>Strip Demo</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
	<script src="customjs.js"></script>	
	<script src="https://js.stripe.com/v3/"></script>
	
</head>
	<body class="container">
		<div class="col-sm-8 col-sm-offset-2">		
			<form action="#" type="post">
				  <div class="form-group">
					<label for="email">Enter Full name:</label>
					<input type="email" class="form-control" id="email">
				  </div>
				  <div class="form-group">
					<label for="pwd">Enter Creadit Card:</label>
					<input type="" class="form-control" id="pwd">
				  </div>
				  
				  <div class="form-group">
					<label for="pwd">Enter Cvv:</label>
					<input type="text" class="form-control" id="cvv">
				  </div>
				  
				  <button type="button" class="btn btn-default add_creadit">Submit</button>
			</form>			
		</div>
	</body>
</html>

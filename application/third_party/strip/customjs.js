$(document).ready(function(){
		$('.add_creadit').click(function(){
			
			var stripe = Stripe('pk_test_3JCrWap9zUf9S3X8weXHA688');
			stripe.createToken('bank_account', {
			  country: 'us',
			  currency: 'usd',
			  routing_number: '110000000',
			  account_number: '000123456789',
			  account_holder_name: 'Jenny Rosen',
			  account_holder_type: 'individual',
			}).then(function(result) {				
				console.log(result.token.id);			  
			  create_charge(result.token.id);
			});
		});
		
		function create_charge(token){
			$.ajax({
				url:'charge.php',
				type:'POST',
				data:{'token':token},
				success:function(){
					
				},error(){
					
				}	
			});
		}		
});
var paymentmethod = document.getElementsByName("payment");
var cardpayment =  document.getElementById("creditcardpayment");
var cash = document.getElementById("cashpayment")


for(var i = 0; i < paymentmethod.length; i++) {
    paymentmethod[i].onclick = function() {
     var val = this.value;
     if(val == 'Cash On Delivery'){  
        cardpayment.style.display = 'none'; 
        cash.style.display = 'block';  
     }
     else if(val == 'Credit/Debit Card'){
         cardpayment.style.display = 'block';
         cash.style.display = 'none';
        
     }    

  }
}
function getComma(event) {

    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;
  
    // format number
    $(this).val(function(index, value) {
      return value
      .replace(/\D/g, "")
      .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      ;
    });
  };

  $('#amount,.amount, #balance, .supplier_balance, .customer_balance').on('keyup', function (event) {

    if(event.which >= 37 && event.which <= 40){
        event.preventDefault();
    }
    var newvalue=$(this).val().replace(/,/g, '');   
    var valuewithcomma=Number(newvalue).toLocaleString('en');   
    $(this).val(valuewithcomma); 

    });
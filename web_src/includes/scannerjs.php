<script>
    var barcode = '';
    var interval;
    var count = 0;
    var loggedIn = <?PHP if(!isset($_SESSION["LoginStatus"]) || $_SESSION["LoginStatus"] != "YES"){ echo "0";}else{ echo "1";} ?>;
    document.addEventListener("keydown", function(evt) {
        if(interval)
            clearInterval(interval);
        if(evt.key=="Enter"){
            if(barcode)
                handleBarcode(barcode);            
            barcode = '';
            return;
        }else if(evt.key != "Shift" ){
            //count++;
            //if(count%2==1)
                barcode += evt.key;
        }
            
        interval = setInterval(() => barcode = '',200); 
    });
    function handleBarcode(scannerBarcode){
        console.log(scannerBarcode);
       if(loggedIn)
        addItemFromScanner(scannerBarcode,1);
       else
        addIDNumFromScanner(scannerBarcode);
    }
    /*
document.addEventListener('textInput', function (e){
    var code = e.key;
    var t = 'textInput';
    
    //console.log(code);

    //console.log('textInput', e.data);
    addItem(code,1);
    

});
*/
/*
document.addEventListener('textInput', function (e){
    if(e.data.length >= 6){
        console.log('IR scan textInput', e.data);
        e.preventDefault();
    }
});
var UPC = '';
    document.addEventListener("keydown", function(e) {
        const textInput = e.key || String.fromCharCode(e.keyCode);
        const targetName = e.target.localName;
        var newUPC = '';
        if (textInput && textInput.length === 1 && targetName !== 'input'){
            newUPC = UPC+textInput;

          if (newUPC.length >= 6) {
            console.log('barcode scanned:  ', newUPC);
          } 
       }
    });*/

</script>
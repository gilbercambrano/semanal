
//Código para colocar
//los indicadores de miles mientras se escribe
//script por tunait!
function isNumberKey(evt)
    {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 46 || charCode > 57 )  )
    return false;
     
    return true;
    }

    $(function() {
			// jQuery formatCurrency plugin: http://plugins.jquery.com/project/formatCurrency

			// Format while typing & warn on decimals entered, 2 decimal places
			$('#formatWhileTypingAndWarnOnDecimalsEntered2').blur(function() {
				
				$('#formatWhileTypingAndWarnOnDecimalsEnteredNotification2').html(null);
				$(this).formatCurrency({ colorize: false, negativeFormat: '-%s%n', roundToDecimalPlace: 2 });
			})
			.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 17: break; // Ctrl
						case 18: break; // Alt
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ colorize:false, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
			})
			.bind('decimalsEntered', function(e, cents) {
				if (String(cents).length > 2) {
					var errorMsg = '<br> Solo dos digitos para los centavos (0.' + cents + ')';
					$('#formatWhileTypingAndWarnOnDecimalsEnteredNotification2').html(errorMsg);
					log('Event on decimals entered: ' + errorMsg);
				}
			});


			// Warn on decimals entered, 2 decimal places
			$('#warnOnDecimalsEntered2').blur(function() {
				$('#warnOnDecimalsEnteredNotification2').html(null);
				$(this).formatCurrency({ roundToDecimalPlace: 2, eventOnDecimalsEntered: true });
			})
			.bind('decimalsEntered', function(e, cents) {
				var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
				$('#warnOnDecimalsEnteredNotification2').html(errorMsg);
				log('Event on decimals entered: ' + errorMsg);
			});


			// Format while typing & warn on decimals entered, no cents
			$('#formatWhileTypingAndWarnOnDecimalsEntered').blur(function() {
				$('#formatWhileTypingAndWarnOnDecimalsEnteredNotification').html(null);
				$(this).formatCurrency({ colorize: false, negativeFormat: '-%s%n', roundToDecimalPlace: 0 });
			})
			.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ colorize: false, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
			})
			.bind('decimalsEntered', function(e, cents) {
				var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
				$('#formatWhileTypingAndWarnOnDecimalsEnteredNotification').html(errorMsg);
				log('Event on decimals entered: ' + errorMsg);
			});


			// Warn on decimals entered, no cents
			$('#warnOnDecimalsEntered').blur(function() {
				$('#warnOnDecimalsEnteredNotification').html(null);
				$(this).formatCurrency({ roundToDecimalPlace: 0, eventOnDecimalsEntered: true });
			})
			.bind('decimalsEntered', function(e, cents) {
				var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
				$('#warnOnDecimalsEnteredNotification').html(errorMsg);
				log('Event on decimals entered: ' + errorMsg);
			});


			function log(text) {
				$('#divLog').prepend('<div>' + text + '</div>');
			}
			
			$('#clearLog').click(function() {
				$('#divLog').empty();
			});

		});




/*carcter = new RegExp(caracter,"g")
valor = valor.replace(carcter,"")
donde.value = valor
crtr = false
}
else{
var nums = new Array()
cont = 0
for(m=0;m<largo;m++){
if(valor.charAt(m) == "," || valor.charAt(m) == " ")
{continue;}
else{
nums[cont] = valor.charAt(m)
if(valor.charAt(m) == "," )
{
	tres=0
}
cont++
}
}
}
var cad1="",cad2="",tres=0
if(largo > 3 && crtr == true){
for (k=nums.length-1;k>=0;k--){
cad1 = nums[k]
cad2 = cad1 + cad2
tres++
if((tres%3) == 0){
if(k!=0){
cad2 = "," + cad2
}
}
}
donde.value = cad2
}*/


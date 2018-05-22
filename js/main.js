/* Esconde o botão carregar mais */
function hideLoadMore(id) {
	document.getElementById('load-more-'+id).style.display = 'none';
}

/* Formata o placeholder de um campo */
function formatField(lbl, txt, ph) {
	var label = document.getElementById(lbl);
	var input = document.getElementById(txt);
	input.placeholder = ph;
	label.style.backgroundColor = "#000077";
}

/* Valida a senha */
function securePass() {
	var lblPw = document.getElementById('lblPw');
	var lblCpw = document.getElementById('lblCpw');
	var pw = document.getElementById('password').value;
	var strength = 0;
	if(pw.length < 4) {
		strength += 1;
	}
	else if(pw.length >= 4  &&  pw.length < 8) {
		strength += 3;
	}
	else if(pw.length >= 8  &&  pw.length < 10) {
		strength += 4;
	}
	else if(pw.length >= 10  &&  pw.length < 12) {
		strength += 5;
	}
	else if(pw.length >= 12) {
		strength += 6;
	}
	if(pw.match(/[a-z]+/)){
		strength += 1;
	}
	if(pw.match(/[A-Z]+/)){
		strength += 1;
	}
	if(pw.match(/[0-9]+/)){
		strength += 1;
	}
	if(pw.match(/[@!#$%&*+=?|-]/)){
		strength += 1;
	}
	if(strength <= 4) {
		lblPw.style.color = "#FF0000";
		lblCpw.style.color = "#FF0000";
	}
	else if((strength > 4) && (strength <= 6)) {
		lblPw.style.color = "#FF9900";
		lblCpw.style.color = "#FF9900";
	}
	else if((strength > 6) && (strength <= 8)) {
		lblPw.style.color = "#FFFF00";
		lblCpw.style.color = "#FFFF00";
	}
	else if(strength > 8) {
		lblPw.style.color = "#00FF00";
		lblCpw.style.color = "#00FF00";
	}
}

/* Verifica se os campos email e confirmar email são iguais */
function validateEmail() {
	var lblCEmail = document.getElementById('lblCEmail');
	var email = document.getElementById('email');
	var cEmail = document.getElementById('confirm-email');
	if(email.value != cEmail.value) {
		lblCEmail.style.backgroundColor = "#AA0000";
		cEmail.value = "";
		cEmail.placeholder = "Os emails não coincidem!";
	}
	else {
		email.value = email.value.toLowerCase();
		cEmail.value = cEmail.value.toLowerCase();
	}
}

/* Verifica se os campos senha e confirmar senha são iguais */
function validatePassword() {
	var lblCpw = document.getElementById('lblCpw');
	var pw = document.getElementById('password');
	var cpw = document.getElementById('confirm-password');
	if(pw.value != cpw.value) {
		lblCpw.style.backgroundColor = "#AA0000";
		cpw.value = "";
		cpw.placeholder = "As senhas não coincidem!";
	}
}

/* Valida o CPF */
function validateCPF() {
	var label = document.getElementById('lblCPF');
	var input = document.getElementById('cpf');
	var cpf = input.value;
	cpf = cpf.replace('.', '');
	cpf = cpf.replace('.', '');
	cpf = cpf.replace('.', '');
	cpf = cpf.replace('/', '');
	
	if(cpf.length < 11)
		return;
	
    var sum = 0;
    var rest;
	var invalid = [ "00000000000",
					"11111111111",
					"22222222222",
					"33333333333",
					"44444444444",
					"55555555555",
					"66666666666",
					"77777777777",
					"88888888888",
					"99999999999"];
					
	for(var k=0; k<10; k++) {
		if(cpf == invalid[k]) {
			label.style.backgroundColor = "#AA0000";
			input.value = "";
			input.placeholder = "C.P.F. inválido!";
			return;
		}
	}
    
	for (k=1; k<=9; k++) {
		sum += parseInt(cpf.substring(k-1, k)) * (11 - k);
	}
	rest = (sum * 10) % 11;
	
    if ((rest == 10) || (rest == 11)) {
		rest = 0;
	}
    if (rest != parseInt(cpf.substring(9, 10)) ) {
		label.style.backgroundColor = "#AA0000";
		input.value = "";
		input.placeholder = "C.P.F. inválido!";
	}
	
	sum = 0;
    for (k = 1; k <= 10; k++) {
		sum += parseInt(cpf.substring(k-1, k)) * (12 - k);
	}
    rest = (sum * 10) % 11;
	
    if ((rest == 10) || (rest == 11)) {
		rest = 0;
	}
    if (rest != parseInt(cpf.substring(10, 11) ) ) {
		label.style.backgroundColor = "#AA0000";
		input.value = "";
		input.placeholder = "C.P.F. inválido!";
	}
}

/* Valida a data de nascimento */
function validateBirthday() {
	var label = document.getElementById('lblBirthday');
	var input = document.getElementById('birthday');
	var birthday = input.value;
	birthday = birthday.replace('/', '');
	birthday = birthday.replace('/', '');
	
	if(birthday.length < 8)
		return;
	
	var today = new Date();
	var yyyy = today.getFullYear();
	var mm = today.getMonth()+1;	//Janeiro = 0
	var dd = today.getDate();
	var year = parseInt(birthday.substring(4, 8));
	var month = parseInt(birthday.substring(2, 4));
	var day = parseInt(birthday.substring(0, 2));
	
	if( (month > 12) ||
		(month == 2 && day > 29) || //29/02 em anos não bissextos
		((month == 4 || month == 6 || month == 9 || month == 11) && day > 30) ||
		((month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) && day > 31) ) {
		label.style.backgroundColor = "#AA0000";
		input.value = "";
		input.placeholder = "Data de nascimento inválida!";
	}
	else if(yyyy-year <= 18) {
		label.style.backgroundColor = "#AA0000";
		input.value = "";
		input.placeholder = "Você precisa ser maior de 18 anos!";
	}
	else if(yyyy-year <= 0) {
		label.style.backgroundColor = "#AA0000";
		input.value = "";
		input.placeholder = "Melhor você nascer primeiro :)";
	}
	else if(yyyy-year > 120) {
		label.style.backgroundColor = "#AA0000";
		input.value = "";
		input.placeholder = "Desculpe, não temos fretis grátis para pessoas mortas :(";
	}
	
}

/* Valida os estados */
function validadeState() {
	var label = document.getElementById('lblState');
	var input = document.getElementById('state');
	var state = input.value.toUpperCase();
	var states = Array(
			"AC",	 
			"AL",	 
			"AP",	 
			"AM",	 
			"BA",	 
			"CE",	 
			"DF",	 
			"ES",	 
			"GO",	 
			"MA",	 
			"MT",	 
			"MS",	 
			"MG",	 
			"PA",	 
			"PB",	 
			"PR",	 
			"PE",	 
			"PI",	 
			"RJ",	 
			"RN",	 
			"RS",	 
			"RO",	 
			"RR",	 
			"SC",	 
			"SP",	 
			"SE",	 
			"TO"
		);
	var flag = false;
		
	if(state == "") {
		return;
	}
	for(var k=0; k<27; k++) {
		if(state == states[k]) {
			flag = true;
		}
	}
	if(!flag) {
		label.style.backgroundColor = "#AA0000";
		input.value = "";
		input.placeholder = "XX";
	}
}

/* Obriga o uso de letra minúscula em um campo */
function txtToLowerCase(field) {
	document.getElementById(field).value = document.getElementById(field).value.toLowerCase();
}

function loadMoreProducts() {
	$.post( 'fetch-products.php', function(data) {
		$("#products").append(data);
	});
}

function loadMoreUsers() {
	$.post( 'fetch-users.php', function(data) {
		$("#users").append(data);
	});
}

function loadMoreSales() {
	$.post( 'fetch-sales.php', function(data) {
		$(".sales").append(data);
	});
}

function showDetails(sale) {
	var details = document.getElementsByClassName('details');
	for (var k = 0; k < details.length; k++) {
		details[k].style.display = "none";
	}
	document.getElementById(sale).style.display = "block";
}

$(document).ready(function() {
	
	/* Slider */
	$('#slider').cycle({			//Elementos com a classe "slider"
		fx: 'fade',					//Default: Rolar para a direita, ir para a próxima imagem
		next: '#next',				//Elementos com o id "next" passa para a próxima imagem
		prev: '#prev',				//Elementos com o id "prev" passa para a imagem anterior
		speed: 1000,				//Tempo de passagem entre uma imagem e outra
		timeout: 3000,				//Tempo que a imagem ficará na tela
		pause: 1					//Quando o mouse estiver emcima da imagem, a passagem de slides ficará pausada
	});
	
	/* Back to top */
	$(window).scroll(function() {
		if ( $(window).scrollTop()) {				//Se houver scroll na pagina
			$('a.back-to-top').fadeIn('slow');		//O botão back to top aparece
		} else {									//Se não
			$('a.back-to-top').fadeOut('slow');		//Ele desaparece
		}
	});
	$('a.back-to-top').click(function() {			//Quando o botão back to top for clicado
		$('html, body').animate({					//Uma animação
			scrollTop: 0							//ScrollTop posição 0
		}, 100);									//E velocidade 100 é chamada
		return false;
	});
		
});
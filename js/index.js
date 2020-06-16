function validate() {
	var valid = /^[0-9]{5}[\-]{0,1}[0-9]{3}$/;
	var cep = document.getElementById('cep').value.replace(/[^\d\-]/g, '');

	if ( ! valid.test(cep)) {
		document.getElementById('alert').innerHTML = 'Invalid CEP!';

		return false;
	}

	document.getElementById('alert').innerHTML = '';

	return true;
}

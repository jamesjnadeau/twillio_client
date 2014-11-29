addEventListener('template-bound', function(e) {

	var scope = e.target;

	//Firebase Login
	var fbLogin = document.querySelector("#login");
	var message = document.querySelector("#message");
	scope.login = function() {
		console.log('login');
		var params;
		try {
			params = JSON.parse(document.querySelector("#params").value);
		} catch (e) {
			params = null;
		}
		if (this.provider == 'password') {
			params = this.params || {};
			params.email = this.email;
			params.password = this.password;
		}
		fbLogin.login(params);
	};

	scope.logout = function() {
		fbLogin.logout();
	};
	scope.createUser = function() {
		fbLogin.createUser(this.email, this.password);
	};
	scope.removeUser = function() {
		fbLogin.removeUser(this.email, this.password);
	};
	scope.changePassword = function() {
		fbLogin.changePassword(this.email, this.password, this.newPassword);
	};
	scope.resetPassword = function() {
		fbLogin.sendPasswordResetEmail(this.email);
	};
	scope.error = function(e) {
		setMessage('Error: ' + e.detail.message, true);
	};

	scope.userSuccess = function(e) {
		setMessage(e.type + ' success!', false);
		console.log(scope.user);
		redirect_home();
	};
	
	if(scope.statusKnown && scope.user) { //already logged in
		redirect_home();
	}
	
	function redirect_home() {
		//window.location = '/index.html';
	}
	
	var msgTimeout;
	function setMessage(msg, error) {
		if (msgTimeout) {
			clearTimeout(msgTimeout);
		}
		message.innerText = msg;
		message.style.color = error ? 'red' : null;
		msgTimeout = setTimeout(function() {
			message.innerText = '';
		}, 3000);
	}

});
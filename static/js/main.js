addEventListener('template-bound', function(e) {

	var scope = e.target;
console.log('scope', scope.statusKnown);
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
	};
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

	//Firebase Main
	scope.resetLocal = function() {
		// direct setting of data is persisted automatically
		this.data = {
			name: 'anonymous',
			info: 'none',
			more: {
				color: "yellow"
			}
		};
	};

	scope.removeLocal = function() {
		this.data = null;
	};

	scope.resetRemote = function() {
		// Simulate other actor setting data to same remote location
		new Firebase('https://treedata-demo.firebaseio.com/demo').set({
			name: 'anonymous',
			info: 'none',
			more: {
				color: "yellow"
			}
		});
	};

	scope.removeRemote = function() {
		// Simulate other actor removing data from same remote location
		new Firebase('https://treedata-demo.firebaseio.com/demo').remove();
	};

	scope.commitMore = function() {
		this.$.base.commitProperty('more');
	};

	scope.dataChange = function() {
		this.json = JSON.stringify(this.data, null, '\t');
	};

	scope.selectAction = function(e, detail) {
		if (detail.isSelected) {
			var selectedItem = detail.item;
			console.log(selectedItem);
		}
	}
});
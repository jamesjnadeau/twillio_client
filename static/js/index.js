addEventListener('template-bound', function(e) {

	var scope = e.target;
console.log(scope.statusKnown, scope.user);
	if(!scope.statusKnown) { //not logged in
		//window.location = '/login.html';
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
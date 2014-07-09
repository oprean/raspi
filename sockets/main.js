(function($) {

	var Socket = Backbone.Model.extend({});

	var Sockets = Backbone.Collection.extend({
		model : Socket,
		url: '/raspi/sockets/ctrl.php'
	});

	var ListView = Backbone.View.extend({
		el : $('body'),
		events : {
			'click button#socket1' : 'toggleSocket',
			'click button#socket2' : 'toggleSocket'
		},
		initialize : function() {
			_.bindAll(this, 'render', 'toggleSocket');
			var sockets = new Sockets();
			sockets.fetch();
			sockets.bind('reset', function () { console.log(sockets); });
			this.render();
		},
		render : function() {
			$(this.el).append("<button id='socket1'>veioza</button>");
			$(this.el).append("<button id='socket2'>ventilator</button>");
			$(this.el).append("<div id='result'></div>");
		},

		toggleSocket : function(e) {
			socket = $(e.target).attr('id');
			$.get('/raspi/sockets/ctrl.php?socket=' + socket, function(data) {
				$('#result').html(data);
			});
		}
	});
	var listView = new ListView();
})(jQuery);

(function($) {

	var Socket = Backbone.Model.extend({
        urlRoot: '/ctrl.php',
        defaults: {
            name: '',
            pin: -1,
            id: -1,
            state: -1
        }
	});
	
    var Sockets = Backbone.Collection.extend({
        model : Socket,
        url: '/raspi/sockets/ctrl.php'
    });
    
    var SocketView = Backbone.View.extend({
        tagName: 'li',
        
        events: {
          'click span.toggle':  'toggle',
        },
        initialize: function(){
            _.bindAll(this, 'render', 'toggle');
            this.model.bind('change', this.render);
        },
        render: function(){
            $(this.el).html('<span style="color:black;">'+ this.model.get('name') + ' ' + this.model.get('state')+'</span> &nbsp; &nbsp; <span class="toggle" style="font-family:sans-serif; color:blue; cursor:pointer;">[toggle]</span>');
            return this; // for chainable calls, like .render().el
        },
        
        toggle: function(){
            var model = this.model; 
            $.getJSON('/raspi/sockets/ctrl.php?action=toggle&pin=' + this.model.get('pin'), function(data) {
                var serverData = {
                    id: data.id,
                    pin: data.pin,
                    name: data.name,
                    state: data.state
                };
                model.set(serverData);
            });    
        },
    });

	var SocketsView = Backbone.View.extend({
		el : $("#sockets"),
		
		initialize : function() {
			_.bindAll(this, 'render', 'appendSocket');
			this.sockets = new Sockets();
			this.sockets.fetch();
			this.sockets.bind('reset', function () {  });
			this.sockets.bind('add', this.appendSocket); // collection event binder
			this.render();
		},
		
		render : function() {
		     $(this.el).append("<ul></ul>");
            _(this.sockets.models).each(function(socket){
                console.log(socket); 
                self.appendSocket(socket);
            }, this);
		},
		
        appendSocket: function(item){
            var socketView = new SocketView({
                model: item
            });
            $('ul', this.el).append(socketView.render().el);
        }
	});
	
	// main starts here!
	var socketsView = new SocketsView();
})(jQuery);

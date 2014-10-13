(function($) {
    var ctrlUrl = '/raspi/iot/php/ctrl_sockets.php';
	var Socket = Backbone.Model.extend({
        urlRoot: ctrlUrl,
        defaults: {
            name: '',
            pin: -1,
            id: -1,
            state: -1
        }
	});
	
    var Sockets = Backbone.Collection.extend({
        model : Socket,
        url: ctrlUrl
    });
    
    var SocketView = Backbone.View.extend({
        tagName: 'li',
        
        events: {
          'click a.toggle':  'toggle',
        },
        initialize: function(){
            _.bindAll(this, 'render', 'toggle');
            this.model.bind('change', this.render);
        },
        render: function(){
            var cssBtnType = (this.model.get('state') == 1)?'btn-danger':'btn-primary';
            var btnText = (this.model.get('state') == 1)?' on':' off';
            $(this.el).html('<a class="btn btn-block btn-large toggle ' + cssBtnType + '">' + this.model.get('name') + btnText + '</a>');
            return this; // for chainable calls, like .render().el
        },
        
        toggle: function(){
            var model = this.model; 
            $.ajaxSetup ({ cache: false}); 
            $.ajax({
            	url: ctrlUrl + '?action=toggle&pin=' + this.model.get('pin'),
            	dataType: "json",
            	success: function(data) {
	                var serverData = {
	                    id: data.id,
	                    pin: data.pin,
	                    name: data.name,
	                    state: data.state
	                };
	                //alert(data.state);
	                model.set(serverData);
            	}
            })    
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

var ctrlUrl = '/raspi/iot/php/ctrl_leds.php';
var LedstripModel = Backbone.Model.extend({
	urlRoot: ctrlUrl,
	});

var LedstripView = Backbone.View.extend({
	el : $("#leds"),
		
	initialize : function() {
		_.bindAll(this, 'render', 'toggle', 'white', 'blue');
		this.render();
	},
	
	events: {
          'click #btnToggle': 'toggle',		
          'click #btnWhite': 'white',
          'click #btnBlue': 'blue',
        },
	
	template: _.template($('#ledstrip-template').html()),
	
	render: function() {
		 this.$el.html(this.template());
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
	
	white: function() {
		this.changeColor('FFFFFF');
	},
	
	blue: function() {
		this.changeColor('FFFFFF');
	},
	
	changeColor:function(color) {
        var url = ctrlUrl + '?action=cchange&color=' + color;
        $.ajax({
            url: url,
            dataType: "json",
            success: function(data) {
                var serverData = {
                    id: data.id,
                    pin: data.pin,
                    name: data.name,
                    state: data.state
                };
                console.log('ddd');
                console.log(model.get('color'));
                model.set(serverData);
                model.save();
            }
        })
	},
});


$.ajaxSetup({ cache: false});
// main starts here!
var ledstripModel = new LedstripModel();
//ledstripModel.fetch({async:false});
var ledstripView = new LedstripView(ledstripModel);


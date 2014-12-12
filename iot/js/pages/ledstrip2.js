var ctrlUrl = '/raspi/iot/php/ctrl_ledstrip.php';
var LedstripModel = Backbone.Model.extend({
	urlRoot: ctrlUrl,
	});

var LedstripView = Backbone.View.extend({
	el : $("#leds"),
		
	initialize : function() {
		_.bindAll(this, 'render', 'toggle', 'white', 'blue', 'green', 'red', 'ttyInit');
		this.model.bind('change', this.render);
		this.render();
	},
	
	events: {
          'click #btnToggle': 'toggle',		
          'click #btnWhite': 'white',
          'click #btnBlue': 'blue',
          'click #btnGreen': 'green',
          //'click #btnAzure': 'azure',
          //'click #btnOrange': 'orange',
          'click #btnRed': 'red',
          'click #btnTTY': 'ttyInit'
        },
	
	template: _.template($('#ledstrip-template').html()),
	
	render: function() {
		 this.$el.html(this.template({model:this.model}));
		 return this;
	},
	
	ttyInit: function() {
		$.post(ctrlUrl + '?action=ttyInit');
	},
	
    toggle: function(){
        var model = this.model; 
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
                model.set(serverData);
        	}
        })
    },
	
	white: function() {
		this.changeColor('white;');
	},

	red: function() {
		this.changeColor('red;');
	},
	
	blue: function() {
		this.changeColor('blue;');
	},
	
	green: function() {
		this.changeColor('green;');
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
ledstripModel.fetch({async:false});
var ledstripView = new LedstripView({model:ledstripModel});


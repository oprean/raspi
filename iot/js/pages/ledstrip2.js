var ctrlUrl = '/raspi/iot/php/ctrl_ledstrip.php';
var LedstripModel = Backbone.Model.extend({
	urlRoot: ctrlUrl,
	});

var LedstripView = Backbone.View.extend({
	el : $("#leds"),
		
	initialize : function() {
		_.bindAll(this, 'render', 'toggle',
			'darker', 'brighter', 'program', 'customColor', 
			'white', 'red', 'green', 'blue', 'azure', 'orange', 'ttyInit');
		this.model.bind('change', this.render);
		this.render();
	},
	
	events: {
          'click #btnToggle': 'toggle',
		  'click #btnDarker': 'darker',
          'click #btnBrighter': 'brighter',
          'change #program': 'program',
          'change #customColor': 'customColor',
          'click #btnWhite': 'white',
          'click #btnRed': 'red',
          'click #btnGreen': 'green',
          'click #btnBlue': 'blue',
          'click #btnAzure': 'azure',
          'click #btnOrange': 'orange',
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
	
	darker: function() {
		this.sendCommand('i!down');
	},
	
	brighter: function() {
		this.sendCommand('i!up');		
	},
	
	program: function() {
		this.sendCommand('p!' + $('#program').val());
	},
	
	customColor:  function() {
		this.changeColor($('#customColor').val());
	},
	
	white: function() {
		this.changeColor('FFFFFF');
	},

	red: function() {
		this.changeColor('FF0000');
	},

	green: function() {
		this.changeColor('00FF00');
	},
	
	blue: function() {
		this.changeColor('0000FF');
	},
	
	azure: function() {
		this.changeColor('00CCFF');
	},
	
	orange: function() {
		this.changeColor('FF6600');
		
	},
	
	sendCommand:function(cmd) {
        var url = ctrlUrl + '?action=sendCommand&cmd=' + cmd;
        $.ajax({
            url: url,
            dataType: "json",
            success: function(data) {
            }
        })		
	},
	
	changeColor:function(color) {
        this.sendCommand('c!' + color);
	},
	
	changeColorOld:function(color) {
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
console.log(ledstripModel);
var ledstripView = new LedstripView({model:ledstripModel});


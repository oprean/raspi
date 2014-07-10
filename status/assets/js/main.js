(function($) {

	var GPIO = Backbone.Model.extend({
        urlRoot: '/raspi/status/ctrl.php',
        defaults: {
            name: '',
            ppin: -1,
            bpin: -1,
            wpin: -1,
            mode: -1,
            state: -1
        }
	});
	
    var GPIOs = Backbone.Collection.extend({
        model : GPIO,
        url: '/raspi/status/ctrl.php'
    });
    
    var GPIOView = Backbone.View.extend({
        tagName: 'li',
        template: _.template($('#gpioPinTemplate').html()),
        
        events: {
          'click a.toggle':  'toggle',
        },
        initialize: function(){
            _.bindAll(this, 'render', 'toggle');
            this.model.bind('change', this.render);
        },
        render: function(){
/*            var html = '';
            var cssBtnType = (this.model.get('state') == 1)?'btn-danger':'btn-default';
            var btnText = (this.model.get('state') == 1)?' on':' off';
            html += '<div>'
             for(attrName in this.model.attributes) {
                 html += '<input type="text" name="'+attrName+'" value="'+this.model.attributes[attrName]+'"/>'
             }
            html += '<a class="pull-right btn btn-block btn-sm toggle ' + cssBtnType + '" style="width:80px;">' + this.model.get('name') + btnText + '</a>'
            html += '</div>'
            $(this.el).html(html);*/

            var html = this.template(this.model.toJSON());
            $(this.el).html(html);
            return this; // for chainable calls, like .render().el
        },
        
        toggle: function(){
            var model = this.model; 
            $.getJSON('/raspi/status/ctrl.php?action=toggle&pin=' + this.model.get('pin'), function(data) {
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

	var GPIOsView = Backbone.View.extend({
		el : $("#gpios"),
		
		initialize : function() {
			_.bindAll(this, 'render', 'appendGPIO');
			this.gpios = new GPIOs();
			this.gpios.fetch();
			this.gpios.bind('reset', function () {  });
			this.gpios.bind('add', this.appendGPIO); // collection event binder
			this.render();
		},
		
		render : function() {
		     $(this.el).append("<ul></ul>");
            _(this.gpios.models).each(function(gpio){
                console.log(gpio); 
                self.appendGPIO(gpio);
            }, this);
		},
		
        appendGPIO: function(item){
            var gpioView = new GPIOView({
                model: item
            });
            $('ul', this.el).append(gpioView.render().el);
        }
	});
	
	// main starts here!
	var gpiosView = new GPIOsView();
})(jQuery);

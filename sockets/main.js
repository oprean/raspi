(function($) {
    var ListView = Backbone.View.extend({
        el : $('body'),
        events: {
            'click button#socket1': 'toggleSocket',
            'click button#socket2': 'toggleSocket'
        },
        initialize : function() {
            _.bindAll(this, 'render', 'toggleSocket');
            this.render();
        },
        render : function() {
            $(this.el).append("<button id='socket1'>veioza1</button>");
            $(this.el).append("<button id='socket2'>ventilator</button>");
        },

        toggleSocket: function(e){
            socket = $(e.target).attr('id');
            $.get('/raspi/sockets/ctrl.php?socket=' + socket);
        }
    });
    var listView = new ListView();
})(jQuery); 
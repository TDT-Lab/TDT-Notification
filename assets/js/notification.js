(function($){
    const TDT_Notification_Queue = function(notification){

        const $elem = TDT_Notification_Add(notification);
    
        $("body").append($elem);
    
        setTimeout(function(){
            $elem.fadeIn();
            setTimeout(function(){
                $elem.fadeOut();
            }, 5000)
        }, notification[3]);
    }
    
    const TDT_Notification_Add = function(args){
        var $temp_elem = $("<div/>");
        $temp_elem.attr("class", "tdt-notification")
        $temp_elem.css("display", "none")
        $temp_elem.html(args[0] + " ở " + args[1] + " vừa đặt mua");

        return $temp_elem;
    }

    TDT_Notification_Content.forEach(element => {
        TDT_Notification_Queue(element);
    });
})(jQuery);
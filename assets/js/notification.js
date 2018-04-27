(function($){

    const tdt_notification_create_element = function(args){
        var $tempElement = $("<div/>");
        $tempElement.attr("class", "tdt-notification");
        $tempElement.css("display", "none");
        $tempElement.html(args[0] + " ở " + args[1] + " vừa đặt mua");
        return $tempElement;
    };

    const tdt_notification_queue = function(notification){

        const $elem = tdt_notification_create_element(notification);
        $("body").append($elem);

        setTimeout(function(){
            $elem.fadeIn();
            setTimeout(function(){
                $elem.fadeOut();
            }, 5000)
        }, notification[3]);
    };

    tdt_notification_content.forEach((element) => {
        tdt_notification_queue(element);
    });
})(jQuery);
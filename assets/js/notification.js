(function($){

    const tdt_notification_create_element = function(args){
        let $tempElement = $("<div/>");
        $tempElement.attr("class", "tdt-notification");
        $tempElement.css("display", "none");

        $tempElement.html('<div class="tdt-notification-image"></div>' + 
                            '<div class="tdt-notification-content"><strong>' + args[0] + "</strong> ở <strong>" + args[1] + "</strong> vừa đặt mua<time>" + args[2] + "</time></div>");

        return $tempElement;
    };

    const tdt_notification_queue = function(notification){

        const $elem = tdt_notification_create_element(notification);
        $("body").append($elem);

        setTimeout(function(){
            $elem.fadeIn();
            setTimeout(function(){
                $elem.fadeOut();
            }, 5000);
        }, notification[3]);
    };

    tdt_notification_content.forEach((element) => {
        tdt_notification_queue(element);
    });
}(jQuery));
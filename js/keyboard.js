/**
 * Created by zhecky on 13.12.14.
 */

var keyboard = {
    submitListener : function(event, mode) {
        var result = false;
        switch (mode) {
            case 1 : result = event.ctrlKey && (event.keyCode == 13 || event.keyCode == 10); break;
            case 2 : result = event.shiftKey && (event.keyCode == 13 || event.keyCode == 10); break;
            case 3 : result = !event.shiftKey && !event.ctrlKey && (event.keyCode == 13 || event.keyCode == 10); break;
        }
        return result;
    }
};
/**
 * Created by zhecky on 13.12.14.
 */


var vkProxy = {
    sendMsg : function(id) {
        var msg = $("#new-msg").val();
        $("#new-msg").val("");

        ajax.apiPost({msg: msg, id: id, act: 'message.send'}, function(){
            document.location.reload();
        }, function(){
            document.location.reload();
        });

        return false;
    },
    markMessageAsRead : function(id) {
        ajax.apiPost({id: id, act: 'message.markAsRead'}, function(){
            document.location.reload();
        }, function(){
            document.location.reload();
        });

        return false;
    },
    markChatAsRead : function(id) {
        ajax.apiPost({id: id, act: 'chat.markAsRead'}, function(){
            document.location.reload();
        }, function(){
            document.location.reload();
        });

        return false;
    },
    test : function() {

        var msg = $("#status-msg").val();
        $("#status-msg").val("");


        ajax.apiPost({msg:id, act: 'status.set'}, function(){
            document.location.reload();
        }, function(){
            document.location.reload();
        });

        return false;
    }
};
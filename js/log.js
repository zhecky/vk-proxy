/**
 * User: zhecky
 * Date: 13.01.13
 * Time: 14:23
 */

var log = {

    defaultLevel : 0,

    trace : function(msg) {
        if (this.defaultLevel <= 0) {
            console.debug('[trace] ' + msg);
        }
    },
    debug : function(msg) {
        if (this.defaultLevel <= 1) {
            console.debug('[debug] ' + msg);
        }
    },
    info : function(msg) {
        if (this.defaultLevel <= 2) {
            console.info('[info] ' + msg);
        }
    },
    warn : function(msg) {
        if (this.defaultLevel <= 3) {
            console.warn('[warn] ' + msg);
        }
    },
    error : function(msg) {
        if (this.defaultLevel <= 4) {
            console.error('[error] ' + msg);
        }
    },
    fatal : function(msg) {
        if (this.defaultLevel <= 5) {
            console.fatal('[fatal] ' + msg);
        }
    }
};
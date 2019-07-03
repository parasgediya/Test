var toastCount;
var getMessage;
$(function() {
    var i = -1;
    toastCount = 0;
    var $toastlast;
    getMessage = function() {
        var msgs = ['My name is Inigo Montoya. You killed my father. Prepare to die!',
            'Are you the six fingered man?',
            'Inconceivable!',
            'I do not think that means what you think it means.',
            'Have fun storming the castle!'
        ];
        i++;
        if (i === msgs.length) {
            i = 0;
        }
        return msgs[i];
    };
    var getMessageWithClearButton = function(msg) {
        msg = msg ? msg : 'Clear itself?';
        msg += '<br /><br /><button type="button" class="btn clear">Yes</button>';
        return msg;
    };
});

function test(title, message, type, closeButtonFlag, progressBarFlag) {
    var shortCutFunction = type;
    var msg = message;
    var title = title || '';
    var toastIndex = toastCount++;
    var addClear = false;
    toastr.options = {
        closeButton: closeButtonFlag,
        debug: true,
        newestOnTop: true,
        progressBar: progressBarFlag,
        positionClass: 'toast-top-right',
        preventDuplicates: true,
        onclick: null
    };
    toastr.options.showDuration = 300;
    toastr.options.hideDuration = 1000;
    toastr.options.timeOut = 5000;
    toastr.options.extendedTimeOut = 1000;
    toastr.options.showEasing = 'swing';
    toastr.options.hideEasing = 'linear';
    toastr.options.showMethod = 'fadeIn'
    toastr.options.hideMethod = 'fadeOut'
    if (!msg) {
        msg = getMessage();
    }
    var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
    $toastlast = $toast;
    if (typeof $toast === 'undefined') {
        return;
    }
}
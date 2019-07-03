/*
* @@ Get Base URL
*/
function getBaseURL() {
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
    return baseUrl;

}
/************************* */

/*
* @@Toast Notification
*/
function Tost(msg, type) {
    switch (type) {
        case 'info':
            toastr.info(msg);
            break;

        case 'warning':
            toastr.warning(msg);
            break;

        case 'success':
            toastr.success(msg);
            break;

        case 'error':
            toastr.error(msg);
            break;
    }
}
/**************************** */

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}
$('#btnPass').click(function(){
    var pass= randomPassword(8);
    $('#password').val(pass);
});

/**
 * Update user role
 */
function updateRole(obj) {
    var id = $(obj).attr("data-id");
    var role = $(obj).val();
    $.ajax({
      type: "POST",
      url: "updateRole",
      data: { id: id, role: role },
      dataType:'JSON',
      success: function(data) {
        $(obj).attr("data-status", status);
        toastr.success(data.msg, data.type);
      },
      error: function() {
        toastr.warning("Something went wrong!", "Warning");
      }
    });
  }
  
  function toCapitlize(str){
    str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
    return str;
  }
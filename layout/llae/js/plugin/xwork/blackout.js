/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$.blackout = function() {
          var visible = 0;
};

$.blackout.show = function(text, callback) {
          text || (text = ' Espere...');
          callback || (callback = function() {
          });
          $("#HandlerBlackOut .overlay_black .container_overlay .text_overlay").html(text);
          $("#HandlerBlackOut").fadeIn(400, callback);
          this.visible = 1;
};

$.blackout.hide = function(callback) {
          callback || (callback = function() {
          });
          $("#HandlerBlackOut").fadeOut(400, callback);
};

$.blackout.text = function(text) {
          $("#HandlerBlackOut .overlay_black .container_overlay .text_overlay").html(text);
};

$.blackout.checkmail = function(email) {
          expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if (!expr.test(email)) {
                    return false;
          } else {
                    return true;
          }
};


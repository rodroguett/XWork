/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$.daemon = function() {
};

$.daemon.minutes = 1;

$.daemon.run = function() {
//          if('localStorage' in window && window['localStorage'] !== null) {
//                    var storage = localStorage;
                    setInterval(function(){
                              var dir = BASE_URL_JS + "verify/verifyLogin";
                              $.ajax({
                                        type: "POST",
                                        url: dir
                              }).done(function(data) {
                                        if (data != 1) {
                                                  window.location.href = BASE_URL_JS + '../';
                                        }
                              });
                    }, $.daemon.time());
//          } else { 
//                    
//          }
};

$.daemon.time = function() {
          return ($.daemon.minutes * 1000 * 60);
};


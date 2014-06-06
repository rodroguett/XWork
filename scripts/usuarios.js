/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $('#form_usuario').submit(function(e){
     e.preventDefault();
     var data = $(this).serialize();
     //alert("hola");
     //alert('[:__BASE_URL:]');
     var email = $("[name=txtemail]").val();
     var pass  = $("[name=txtpass]").val();
     
//     console.log(pass);
     
     if(email == ""){       
      $("[name=txtemail]").focus();
      return  false; 
     }else if(pass = ""){          
       $("[name=txtpass]").focus(); 
       return false;
     }else{        
        $.ajax({             
          type: "POST",
          url:"[:__BASE_URL:]administrador/EnviarUsuarios",
          data:data 
            
        }).done(function(ev){
             $('#AllActividadesFromProyect').html(ev);
             alert(ev);
        }); 
         
     } 
         
     
//     console.log(email);
     
     
 });
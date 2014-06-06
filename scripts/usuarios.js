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
     
     console.log(pass);
     
     if(email == ""){       
      $("[name=txtemail]").focus().after('<p>Ingrese usuario</p>')  
      return  false; 
     }else if(pass = ""){          
       $("[name=txtpass]").focus().after('<p>Ingrese Clave</p>') 
       return false;
     }else{        
        $.ajax({             
          type: "POST",
          url:"[:__BASE_URL:]administrador/saveUsuarios",
          data:data 
            
        }).done(function(ev){
            console.log(ev);           
        }); 
         
     } 
         
     
     console.log(email);
     
     
 });
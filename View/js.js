document.addEventListener('DOMContentLoaded', function(){
    var btnDoar = document.querySelector('.btn_doar');
    var overlayD = document.querySelector('.overlay_doar');

    
    var btnTransportar = document.querySelector('.btn_transportar');
    var overlayT = document.querySelector('.overlay_transportar');

    var overlayDoacao = document.querySelector('.overlay_doacao');
    var overlayE= document.querySelector('.overlay_escolher');
 

    var closeBtnDoar = document.querySelector('.close_btn_D');
    var closeBtnTransportar = document.querySelector('.close_btn_t'); 
   

    var cancelarBtns = document.querySelectorAll('.btnNao');

    var escolherDivs = document.querySelectorAll('.escolher');



    cancelarBtns.forEach(function(btn){
        btn.addEventListener('click', function(){
        history.go(-0)
       
    });
});

  

    escolherDivs.forEach(function(escolherDiv){
        escolherDiv.addEventListener('click',function(){
            var formId = escolherDiv.getAttribute('data-form-id');
            var btnConfirmar = escolherDiv.querySelector('.btn_confirmar');
            btnConfirmar.style.display="block";

            btnConfirmar.addEventListener('click', function(){
                var form = document.getElementById(formId);
                form.submit();
            });

        });
    });


    btnDoar.addEventListener('click', function(){
        overlayD.style.display = 'block';
        
    });


    btnTransportar.addEventListener('click', function(){
        overlayT.style.display='block';

    });


    closeBtnTransportar.addEventListener('click', function(){
        overlayT.style.display = 'none';
   
    });

    closeBtnDoar.addEventListener('click', function(){
        overlayD.style.display = 'none';
    }); 

});

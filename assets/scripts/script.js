//alert("Js loaded");
// AJAX - ouverture fenêtres "contacts de chaque Caisse"
 
$('.footer-caisse').click(function(){   

    var id = $(this).data('id');
    
    // On fait disparaitre lentement les articles
    $('#modal-caisse').fadeOut(500, function(){
       
        // $('#modal-caisse').html('');
        var modal = '';
        
        $.getJSON('private/model/contact-caisse.php', function(caisses){  
            console.log(caisses);          
            
            $(caisses).each(function(index, caisse){

                var idCaisse   = caisse.nomCourt;   
                if(idCaisse == id) {

                    modal    = '<div class="modal-body"> ' + caisse.nomLong+ ' </h3></div>';
                    $('#modal-caisse .modal-body').html(modal);
                }             

                // $('#info-caisse').html(id);             
                
            });
            // $('#modal-caisse').fadeIn(500);
        });    
    });
});

// $(function(){
//     $.getJSON('contact-caisse.php', function(caisses){
//         $(caisses).each(function(i, caisse){
//             $('footer-caisse').append("<li data-id="+ caisse.id +" >" +caisse.lastName+ "</li>");    

            
//             // $(".footer-caisse").click(function(){

            //     var id_caisse = $(this).data('id');

            //         $('#info-caisse').empty();
            //         $.getJSON('https://jsonplaceholder.typicode.com/users/' + id_  + '/posts', function(articles){
                        
            //             $(articles).each(function(i, article){
            //                 $('#article').append('<article><h3>' + article.title + '</h3><p>' + article.body + '<hr></article>');   
            //             })
            //         })  
                
                
            // })
                    
//         })
//     })
// });

// Ajout pour Barre de recherche (cf http://codepen.io/nikhil/pen/qcyGF)
  // $(document).ready(function(){
  //           var submitIcon = $('.searchbox-icon');
  //           var inputBox = $('.searchbox-input');
  //           var searchBox = $('.searchbox');
  //           var isOpen = false;
  //           submitIcon.click(function(){
  //               if(isOpen == false){
  //                   searchBox.addClass('searchbox-open');
  //                   inputBox.focus();
  //                   isOpen = true;
  //               } else {
  //                   searchBox.removeClass('searchbox-open');
  //                   inputBox.focusout();
  //                   isOpen = false;
  //               }
  //           });  
  //            submitIcon.mouseup(function(){
  //                   return false;
  //               });
  //           searchBox.mouseup(function(){
  //                   return false;
  //               });
  //           $(document).mouseup(function(){
  //                   if(isOpen == true){
  //                       $('.searchbox-icon').css('display','block');
  //                       submitIcon.click();
  //                   }
  //               });
  //       });
  //           function buttonUp(){
  //               var inputVal = $('.searchbox-input').val();
  //               inputVal = $.trim(inputVal).length;
  //               if( inputVal !== 0){
  //                   $('.searchbox-icon').css('display','none');
  //               } else {
  //                   $('.searchbox-input').val('');
  //                   $('.searchbox-icon').css('display','block');
  //               }
  //           }
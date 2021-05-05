jQuery(document).ready(function() {

$('#search-user').bind("enterKey",function(e){
   confirm( $(this).val() );
   
   $('#form_search_user').submit();
 });

 $('#search-user').keyup(function(e){
     if(e.keyCode == 13)
     {
         //$(this).trigger("enterKey");
         confirm( $(this).val() );
         $('#form_search_user').submit();
     }
 });
 
})
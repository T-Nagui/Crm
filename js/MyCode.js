/**
 * Created by NAGUI on 14/11/2015.
 */
var url = "http://mtc-healthcare.com/clients/crm";
function MSg(msg, type) {
    console.log(msg);
    jQuery(".alert").addClass(type);

    jQuery(".alert").show();

    jQuery("#MsgAlert").html(msg);

    window.setTimeout(function () {

            jQuery(".alert").fadeOut('slow')

        },

        10000);


};
function GetLocation(Page) {


    var val = jQuery('#TypeClient').val();


    if (val != "") {

        var url = Page + '&idClient=' + val;

    }


    else url = Page;


    window.location = url;


}
function GetPage(Page) { 


    var val = jQuery('#TypeClient').val();


    if (val != "") {

        var url = Page + '&idDel=' + val;

    }


    else url = Page;


    window.location = url;


}
function FindDel(){
    var sect=$("#Secteur").val();
    if(sect!=""){
        // ajax rechercher les délégation associer : 
         $.ajax({
            url: url+"/ajax/FindDel.php",  
    type: "POST", 
    data: ({
        secteur:  sect 
    }),
    dataType : 'html', 
            success: function(result){
              $("#DelListe").html(result); 
              $("#delegationListe").select2();
              $("#EtablissementListe").select2();
    }
});
        
        
        
    } 
}
function FindDelSimple(){
    var sect=$("#Secteur").val();
    if(sect!=""){
        // ajax rechercher les délégation associer : 
         $.ajax({
            url: url+"/ajax/FindDel_1.php",  
    type: "POST", 
    data: ({
        secteur:  sect 
    }),
    dataType : 'html', 
            success: function(result){
              $("#DelListe").html(result);  
    }
});
        
        
        
    } 
}
function FindDelDemande(){
    var sect=$("#Secteur").val();
    if(sect!=""){
        // ajax rechercher les délégation associer : 
         $.ajax({
            url: url+"/ajax/FindDel_2.php",  
    type: "POST", 
    data: ({
        secteur:  sect 
    }),
    dataType : 'html', 
            success: function(result){
              $("#DelListe").html(result);  
                  $("#delegationListe").select2();
    }
});
        
        
        
    } 
}
function ShwoTable(){
    event.preventDefault();
    $("#Tdetail").show();
}
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
    $("#Tdetail").hide();
    $("#linkTable").click(function(){
        $("#Tdetail").show();
        console.log("cliked");
    });
    $('table.highchart').highchartTable();
    $(".select2").select2(); 
    $("#DivRes").hide();
//bootstrap WYSIHTML5 - text editor
   /* $(".textarea").wysihtml5({
        "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": false, //Button to insert a link. Default true
        "image": false, //Button to insert an image. Default true,
        "color": true //Button to change color of font
    });*/
    jQuery('#modal-from-dom').on('shown.bs.modal', function() {
        var id = jQuery(this).data('id');
        var name= jQuery(this).data('title');
        var  removeBtn = jQuery(this).find('.btn-danger');
        var pkliste=jQuery('textarea#pkliste').val();
        removeBtn.attr('href', removeBtn.attr('href').replace(/(&|\?)SuppID=\d*/, '$1SuppID=' + id));

        jQuery('#debug-url').html('Delete URL: <strong>' + removeBtn.attr('href') + '</strong>');
        jQuery('.TitD').html(name);

    });
    jQuery('.PkAdd').click(function(){
            var pkliste=jQuery('textarea#pkliste').val();
            var href =  jQuery('.PkAdd').attr('href');
            jQuery('a.PkAdd').attr('href', href + '&prk='+pkliste);

    });
    $('.confirm-delete').on('click', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var name= $(this).data('title');
        // jQuery('#debug-url').html(name);
       //  alert(id);
        $('#modal-from-dom').data('id', id).data('title',name).modal('show');
    });
    
    $.fn.bootstrapSwitch.defaults.onColor = 'success';
    $.fn.bootstrapSwitch.defaults.offColor = 'danger';
    $(".previlege").bootstrapSwitch();
    $('.switcher').bootstrapSwitch('state'); // true || false
   $('.switcher').bootstrapSwitch('toggleState');
    $('.switcher').bootstrapSwitch('setState', false); // true || false
    //filter
    $("#FilterPros").click(function(event) {
   //event.preventDefault();
       // ajax call 
       $("#ListeDiv").html('');
       var secteur=    $("#Secteur").val();
        var spec=$("#Spec").val();
        var del=$("#delegationListe").val();
        if(secteur!=="" || spec!=""){
            $("#MsgPRo").hide();
            $("#DivRes").show();
        $.ajax({
            url: url+"/ajax/AjaxProspects.php",  
    type: "POST", 
    data: ({
        secteur:    $("#Secteur").val(),
        spec: $("#Spec").val(),
        del: del
    }),
    dataType : 'html', 
            success: function(result){
                $("#ListeDiv").html(result);  
            }
                   
}) .done();
        
        }else{
            $("#MsgPRo").append("Merci de choisir le secteur et la spécialité").show();
        }
    });
    /*$("#ListeDiv").bind('change','#AllLink',function(ee){  
      $("INPUT[id*='PRosSel_']").attr('checked', $('#AllLink').is(':checked'));
     //  $(".checkbox1").prop('checked', $(this).prop("checked"));
   }); $('#AllLink').change(function() {  
    var checkboxes = $(this).closest('form').find(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.prop('checked', true);
    } else {
        checkboxes.prop('checked', false);
    }
});*/
    $('#ListeDiv').on('change','#AllLink',function(ee){ 
        console.log('dd'+$('#AllLink').is(':checked'));
   // var checkboxes = $(this).closest('form').find(':checkbox');
    if($('#AllLink').is(':checked')) {
        $(".checkbox1").prop('checked', true); 
    } else {
        $(".checkbox1").prop('checked', false); 
    }
    });
    $('#ListeDiv').on('change','.checkbox1',function(ee){  
    if($(this).is(':checked')) {
          console.log($('#AllLink').is(':checked'));
    } else {
        $("#AllLink").prop('checked', false); 
    }
    });
});
 
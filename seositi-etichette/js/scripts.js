/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/javascript.js to edit this template
 */

jQuery(document).ready(function($){   
    
    //AGGIUNGO VOCI
    $('.aggiungi-voce a').click(function(){
        
        var countVoci = $(this).parent('.aggiungi-voce').siblings('.container-voci').find('.voce').size();        
        var $element = $(this).parent('.aggiungi-voce').siblings('.container-voci').find('.voce:first-child').clone();
        
        
        console.log(countVoci);
        countVoci++;
        var nuovoCountVoce = 'count-voce-'+countVoci;
        var nuovoLabelVoce = labelVoce+'-'+countVoci;   
        var nuovoVisualizzaVoce = visualizzaVoce+'-'+countVoci;
        var nuovoTipoVoce = tipoVoce+'-'+countVoci;
        
        
        //cambio i valori
        $element.attr('data-num', countVoci);
        changeData($element, 'countvoce', nuovoCountVoce);
        $element.find('.countvoce input').val(countVoci);
        
        changeData($element, 'label', nuovoLabelVoce);
        changeData($element, 'visualizza', nuovoVisualizzaVoce);
        changeData($element, 'tipo', nuovoTipoVoce);
                
        //elimino id-voce
        $element.find('.id-voce').remove();
                
        console.log($(this));
        $element.appendTo($(this).parent('.aggiungi-voce').siblings('.container-voci'));        
    });
    
    //rimuovo voce
     $(document.body).on('click', '.rimuovi-voce a', function(){
        $(this).parent('.rimuovi-voce').parent('.voce').remove();       
    });
    
    function changeData($element, classe, variabile){
        $element.find('.'+classe+' input').attr('name', variabile);
        $element.find('.'+classe+' label').attr('for', variabile);
        $element.find('.'+classe+' input').attr('id', variabile);  
        $element.find('.'+classe+' input').attr('for', variabile);   
        $element.find('.'+classe+' input').val('');  
        
        $element.find('.'+classe+' textarea').attr('name', variabile);        
        $element.find('.'+classe+' textarea').attr('id', variabile);
        $element.find('.'+classe+' textarea').attr('for', variabile);       
        $element.find('.'+classe+' textarea').val('');  
        
        $element.find('.'+classe+' select').attr('name', variabile);        
        $element.find('.'+classe+' select').attr('id', variabile);
        $element.find('.'+classe+' select').attr('for', variabile);       
        $element.find('.'+classe+' select').val('');  
        
        $element.find('.'+classe+' select').attr('name', variabile);        
        $element.find('.'+classe+' select').attr('id', variabile);
        $element.find('.'+classe+' select').attr('for', variabile);       
        $element.find('.'+classe+' select').val('');  
        
    }
    
    // SORTING TABLE
    $('#sorting-table-etichetta, #sorting-table-categoria, #sorting-table-cliente').DataTable();
    $('.dataTables_length').addClass('bs-select');
    
});

$(function() {
	$('#download_link').click(function(){
		$.ajax({
			url: "ajax/tracking.php",
			type: "POST",
			async: true,			
			data: {
				down:1
			},
			success: function(data) {
				$('#luot_down').html(data);
			}
		});
	});   

    $('.content_tab').css('height', parseInt($(window).height()) - 50);
    
    $('#share_fb').click(function(){
        $.ajax({
            url: 'ajax/getlink.php',
            type: "POST",                         
            data:{                                                    
                    idSach:$(this).attr('idSach')                        
            },                       
            success: function(data){                     
                  window.open(
             'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(data),
             'facebook-share-dialog',
             'width=626,height=436');
           
            }       
        });  
        return false;
    });
    $('#mycarousel').jcarousel();
    $('.title_phapam').click(function() {
        $('#nut_hien_list').show();
        $('#hien_phap_am').load('ajax/get_phap_am.php?idPA=' + $(this).attr('idPA'));
        $('#hien_phap_am').show();
        $('#list_phap_am').hide();
    });
    $('#nut_hien_list').click(function() {
        $('#list_phap_am').show();
        $('#hien_phap_am').hide();
        $('#nut_hien_list').hide();
    });
});

$(document).ready(function() {
    $('#btnLoc').click(function() {       
        var ten_sach = $('#idSach_loc').find('option:selected').attr("ten_sach");
        var ten_muc_luc = $('#idML_loc').find('option:selected').attr("ten_muc_luc");
        var idML = $('#idML_loc').val();
        if($.trim(ten_sach)!='' && $.trim(ten_muc_luc)!=''){
            var href_return =ten_sach + '/' + ten_muc_luc + '-' + idML + '.html';
            if ($.trim($('#idTrang_loc').val())>0) href_return+='#content_' + $('#idTrang_loc').val();
            location.href= href_return;
        }
    });

    $('a.tabmenu').click(function() {
        var idML = $(this).attr('idML');
        $.post('ajax/getMenu.php', {idML: idML}, function(data) {
            $('#menuContainer').html(data);
            $('.baodanhmuc').hide();
            $('a.tabmenu').removeClass('active');
            $('a.tabmenu[idML=' + idML + ']').addClass('active');
        });
    });
    
    $('#idSach_loc').change(function() {
        $.ajax({
            url: 'ajax/loaddm.php',
            type: "POST",                         
            data:{                                                    
                    id: $(this).val()                      
            },                       
            success: function(data){                                                            
                $('#idML_loc').html(data);
                
            }       
        });        
    });  
    $('#idDM_loc').change(function() {
        $.ajax({
            url: 'ajax/book.php',
            type: "POST",                         
            data:{                                                    
                    id: $(this).val()                      
            },                       
            success: function(data){                                                            
                $('#idSach_loc').html(data);
                
            }       
        });         
    });
    $('#idML_loc').change(function() {
        $.ajax({
            url: 'ajax/page.php',
            type: "POST",                         
            data:{                                                    
                    id: $(this).val()                      
            },                       
            success: function(data){                                                            
                $('#idTrang_loc').html(data);
                
            }       
        });         
    });
    $('#btnFind').click(function() {
        if ($('#textKeyword').val() == '' || $('#textKeyword').val() == 'Nháº­p tá»« tĂ¬m kiáº¿m' || $('#textKeyword').val().length < 3) {
            alert('Vui lĂ²ng nháº­p tá»« khĂ³a tĂ¬m kiáº¿m nhiá»u hÆ¡n 2 kĂ­ tá»±!');
            return false;
        } else {
            $.ajax({
                url: 'blocks/ajax_find.php',
                type: "POST",                         
                data:{                                                    
                        keyword: $.trim($('#textKeyword').val()),
                        idML: $('#idML_Find').val()                     
                },         
                beforeSend: function() {
                    $('#result_find').html('<div style="float:left;width:100%;text-align:center;"><img src="img/icons/3.gif" style="margin-top:30px" /></div>');
                },              
                success: function(data){                                                            
                    $('#result_find').html(data);                                        
                }       
            });             
        }
    });  
});

// $(function() {
    // $('#btn_left').toggle(
    //     function() {
    //         $(this).parents('.float_item').animate({width: '25px'}, 500);
    //     },
    //     function() {
    //         $(this).parents('.float_item').stop(true, true).animate({width: '225px'}, 500);
    //         hidesearch();
    //         hidephapam();
    //     }
    // );
//     $('#btn_top').toggle(
//         function() {
//             $(this).parents('.float_top_item').stop(true, true).animate({height: '240px'}, 500);
//             hidemenu();
//             hidephapam();
//         }  ,
//         function() {
//             $(this).parents('.float_top_item').animate({height: '30px'}, 500);
//         }
//     );
//     $('#btn_bottom').toggle(
//         function() {
//             $(this).parents('.float_top_item').stop(true, true).animate({height: '240px'}, 500);
//             hidemenu();
//             hidesearch();
//         } ,
//         function() {
//             $(this).parents('.float_top_item').animate({height: '30px'}, 500);
//         }
//     );     

// });
// function hidemenu(){
//     $('.float_item .btn_control_float').parents('.float_item').animate({width: '25px'});
// }
// function hidesearch(){
//     $('#btn_top').parents('.float_top_item').animate({height: '30px'}, 500);
// }
// function hidephapam(){
//     $('#btn_bottom').parents('.float_top_item').animate({height: '30px'}, 500);
// }
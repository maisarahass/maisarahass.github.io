$(function () {
    
    
    'use strict';
    
    
    $('[placeholder]').focus(function(){
        
        
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
    
          
            $(this).attr('placeholder', $(this).attr('data-text'))
            
            });
    
    // add astrix == النجمة لبتظهر جمب او تحت الحقول الاجبارية
    
    $('input').each(function (){
        
        if ($(this).attr('required') === 'required')
        {
            $(this).after('<span class="asterisk">*</span>');  
            
         }
    });
    
    
    // الفنكشن الخاصة باظهار الباسورد لمن بعمل هفر على رمز العين
    
    var passFaild = $('.password');
    
    $('.show-pass').hover(function(){
        passFaild.attr('type','text');
        
        
    }, function(){
         passFaild.attr('type','password');
        
    }); 
    
    // هنا رسالة التاكيد عند الضغط على زر الحذف
    
    $('.confirm').click(function(){
        
        return confirm('Are You Sure You Want Delete This User');
    });
    
});
 
 
 
 
 
 
 
 
 
 
 
 
 

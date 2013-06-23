/**
 * @filename: commons.js
 * 
 * @date: 2013-06-22
 *
 * @version: 0.0.1
 *
 * @description: common javascript. 
 *
 */

$(function() {
   
  if ($('#jqPostImageList').length) {
      var container = $('#jqPostImageList');
      var id = container.attr('data-id');
      var data = container.attr('data-type');
      if (id) {
        $.ajax({
            url: '/admin/image/ajaxlist/'+id,
            dataType: 'html',
            type: 'GET',
            success: function(data) {
                container.html(data);
            },
            error: function() {
                container.html('Error');
            }
        });
      } else {
        $.ajax({
            url: '/admin/image/ajaxlist/',
            dataType: 'html',
            type: 'GET',
            data: {
                'newpost' : '1',
            },
            success: function(data) {
                container.html(data);
            },
            error: function() {
                container.html('Error');
            }
        });
      }
  }
  
  $(document).on('click', '.jqDetachImageFromPost', function(){
      $(this).closest('tr').remove();
      return false;
  });

  $(document).on('click', '.jqAttachImageToPost', function(){
      $(this).removeClass('jqAttachImageToPost');
      $(this).addClass('jqDetachImageFromPost');
      $(this).text('Detach');
      $(this).closest('tr').appendTo('#jqPostImageList table tbody');
      return false; 
  });

  $('.jqGetImages').on('click', function(){
      var id = $(this).attr('data-id');
      $.ajax({
        url: '/admin/image/ajaxlist/'+id,
        dataType: 'html',
        type: 'GET',
        data: {
            'opposite' : '1',
        },
        success: function(data) {
            $('<div />').html(data).dialog({
                title: 'Choose an image',
                width: 600,
            })
        },
        error: function() {
            $('<div />').html('Error').dialog({
                title: 'Choose an image',
            })
        },
      });
      return false;
  });

  
});

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
   
  if ($('#jqEditPostImageList').length) {
      var container = $('#jqEditPostImageList');
      var id = container.attr('data-id');
      $.ajax({
          url: '/admin/image/ajaxeditlist/'+id,
          dataType: 'html',
          type: 'GET',
          success: function(data) {
              container.html(data);
          },
          error: function() {
              container.html('Error');
          }
      });
  }

  if ($('#jqNewPostImageList').length) {
      var container = $('#jqNewPostImageList');
      $.ajax({
          url: '/admin/image/ajaxnewlist/',
          dataType: 'html',
          type: 'GET',
          success: function(data) {
              container.html(data);
          },
          error: function() {
              container.html('Error');
          }
      });
  }

  $('.jqEditGetImages').on('click', function(){
      var id = $(this).attr('data-id');
      $.ajax({
        url: '/admin/image/ajaxeditlist/'+id,
        dataType: 'html',
        type: 'GET',
        data: { 'opposite' : '1' },
        success: function(data) {
            $('<div />').html(data).dialog({
                title: 'Choose an image',
                width: 600,
            })
        },
        error: function() {
            $('<div />').html('Error').dialog({
                title: 'Error getting images',
            })
        },
      });
      return false;
  });

  $('.jqNewGetImages').on('click', function(){
      $.ajax({
          url: '/admin/image/ajaxnewlist/true',
          dataType: 'HTML',
          type: 'GET',
          success: function(data) {
              $('<div />').html(data).dialog({
                  title: 'Choose an image',
                  width: 600,
              })
          },
          error: function() {
              $('<div />').html('Error').dialog({
                  title: 'Error getting images',
              })
              
          }
      });
  })
  
  $(document).on('click', '.jqDetachImageFromPost', function(){
      $(this).closest('tr').remove();
      return false;
  });

  $(document).on('click', '.jqAttachImageToPost', function(){
      $(this).removeClass('jqAttachImageToPost');
      $(this).addClass('jqDetachImageFromPost');
      $(this).text('Detach');
      $(this).closest('tr').appendTo('.jqCommonImageList table tbody');
      return false; 
  });
  
});


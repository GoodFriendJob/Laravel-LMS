// Loaded after CoreUI app.js

//Message Notification
setInterval(function()
{

    $.ajax({
        type:"POST",
        url:messageNotificationRoute,
        data:{_token:$('meta[name="csrf-token"]').attr('content')},
        datatype:"html",
        success:function(data)
        {
          if(data.unreadMessageCount > 0){
              $('.unreadMessages').empty();
              $('.mob-notification').removeClass('d-none').html('!');
              $('.unreadMessageCounter').removeClass('d-none').html(data.unreadMessageCount)
              var html = "";
              var host = $(location).attr('protocol')+'//'+$(location).attr('hostname')+'/user/messages/?thread=';
              $(data.threads).each(function (key,value) {
                 html+= '<a class="dropdown-item" href="'+host+value.thread_id+'"> ' +
              '<p class="font-weight-bold mb-0">'+value.title+' <span class="badge badge-success">'+value.unreadMessagesCount+'</span></p>' +
              '<p class="mb-0">'+value.message+'</p>' +
              '</a>';

              });
              $('.unreadMessages').html(html);
          }else{
              $('.unreadMessageCounter').addClass('d-none');
              $('.mob-notification').addClass('d-none')
          }
        }
    });
}, 5000);
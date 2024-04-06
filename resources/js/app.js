import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

Echo.private(`notification.${userID}`)
  .notification(function (event) {
    let c = Number($('#unread-count').text())
    c++
    $('#unread-count').text(c)

    $('#n-list').prepend(`<a href="#" class="dropdown-item">
        <i class="fas fa-envelope mr-2"></i>
        ${event.title}
        <span class="float-right text-muted text-sm">now</span>
    </a>
    <div class="dropdown-divider"></div>`);

    $(document).Toasts('create',{
      title: event.title ,
      body: event.body ,
      animation: true , 
      autohide: true , 
      delay: 2000 ,
    });

  });
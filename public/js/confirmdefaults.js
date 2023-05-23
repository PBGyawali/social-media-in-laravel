jconfirm.defaults = {
    useBootstrap: true,
    dragWindowBorder: false,
    icon: 'fa fa-warning',
   // closeIcon: true, // explicitly show the close icon
    closeIcon: 'No',//defines what to do when close icon is clicked
    autoClose: 'No|150000',//defines what to do when autoclose is enabled and the time
    backgroundDismiss: true,
    backgroundDismissAnimation: 'glow',
    columnClass: 'col-md-4 col-md-offset-8 col-xs-4 col-xs-offset-8',
    containerFluid: true, // this will add 'container-fluid' instead of 'container'
    theme: 'dark',
    type: 'red',
    animation: 'scale',
    closeAnimation: 'scale',
    animationSpeed: 400,
    draggable: true,
    scrollToPreviousElement: false,//Scroll to element that was focused
    buttons: {
              Yes: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function () {
                    }
                  },
              No:  {
                text: 'No',
                btnClass: 'btn-green',
                keys: ['esc'],
                action: function(){
                  $(this).remove();
                }
      },
    },

};



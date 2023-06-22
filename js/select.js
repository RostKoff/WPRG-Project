$(document).ready(function () {
    $('select').selectize({
        sortField: 'text',
        hideSelected:true,
        onChange: function(value) {
            if (!value)
                this.setValue('none');
        }
    });

});
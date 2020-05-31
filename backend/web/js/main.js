//Object for reload PJAX
var pjax = {
    reload: function(container) {
        $.pjax.reload({container: container, async: false});
    }
};
//Post object
var post = {
    edit_button: '.btn-update',
    edit_modal_selector: '#post_edit_modal',
    update_form: '.post-update form',
    init: function() {
        this.edit_click();
        this.update();
    },
    edit_click: function() {
        var self = this;
        $('body').on('click', this.edit_button, function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $.get(url, {isAjax: true}, function(response) {
                self.edit_modal(response);
            });
        });
    },
    edit_modal: function(data) {
        let modal = $(this.edit_modal_selector);
        modal.find('.modal-body').html(data);
        modal.modal('show');
    },
    edit_modal_close: function() {
        $(this.edit_modal_selector).modal('hide');
    },
    update: function() {
        var self = this;
        $('body').on('submit', this.update_form, function(e) {
            e.preventDefault();
            $.ajax({
                url:  $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(response) {
                    if (response) {
                        self.edit_modal_close();
                        pjax.reload('#post-index-pjax');
                    }
                    else {
                        alert('Try again, something error!');
                    }
                }.bind(self)
            });
        });
    }
};
//On ready document
$(document).ready(function() {
    post.init();
});
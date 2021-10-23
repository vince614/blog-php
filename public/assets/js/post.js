const deletePostButton = $('#delete-post-button');
deletePostButton.click(function () {
    $.post(HOST_URL + '/blog', {
        type: 'delete',
        articleId: deletePostButton.data('id')
    }).done(function (data) {
        if (data.error) {
            return alert(data.error);
        } else if(data.success) {
            return alert(data.success);
        }
    });
});
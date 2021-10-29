import Form from '../module/Form.js';
class CommentForm extends Form {

    /**
     * Contructor
     */
    constructor() {
        super();
        this.commentInput = $('#comment');
        this.formTokenInput = $('#form-token');
    }

    /**
     * Get all values in selectors
     */
    getValues() {
        this.comment = this.commentInput.val();
        this.formToken = this.formTokenInput.val();
    }

    /**
     * Send data request
     */
    send() {
        $.post(HOST_URL + '/blog', {
            type: 'comment',
            comment: this.comment,
            postId: this.commentInput.data('post-id'),
            formToken: this.formToken
        }).done(function (data) {
            if (data.error) {
                return alert(data.error);
            } else if (data.success) {
                return success(data.success, null, true);
            }
        });
    }

    /**
     * Valide form brefore sending
     *
     * @return {boolean}
     */
    valideForm() {
        this.getValues();
        return this.checkLenght(this.comment);
    }

    /**
     * Submit form
     */
    submit() {
        this.valideForm() ?
            this.send() :
            alert(this.error); // @todo changer les alertes
    }

}

const sendPostButton = $('#send-post-button');
sendPostButton.click(function () {
    let commentObject = new CommentForm();
    commentObject.submit();
});
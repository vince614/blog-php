import Form from '../module/Form.js';
class postForm extends Form {

    /**
     * Contructor
     */
    constructor() {
        super();
        this.titleInput = $('#title');
        this.urlKeyInput = $('#url-key');
        this.contentInput = $('#content');
    }

    /**
     * Get all values in selectors
     */
    getValues() {
        this.title = this.titleInput.val();
        this.urlKey = this.urlKeyInput.val();
        this.content = this.contentInput.val();
    }

    /**
     * Send data request
     */
    send() {
        $.post(HOST_URL + '/blog', {
            type: 'create',
            title: this.title,
            urlKey: this.urlKey,
            content: this.content,
            editMode: editMode
        }).done(function (data) {
            if (data.error) {
                return alert(data.error);
            } else if(data.success) {
                return alert(data.success);
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
        return this.content &&
            this.urlKey &&
            this.title; // @todo Ajouter des conditions pour vérifié le formulaire
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
    let postObject = new postForm();
    postObject.submit();
});
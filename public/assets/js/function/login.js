import Form from '../module/Form.js';
class loginForm extends Form {

    /**
     * Contructor
     */
    constructor() {
        super();
        this.emailInput = $('#email');
        this.passwordInput = $('#password');
    }

    /**
     * Get all values in selectors
     */
    getValues() {
        this.email = this.emailInput.val();
        this.password = this.passwordInput.val();
    }

    /**
     * Send data request
     */
    send() {
        $.post(HOST_URL + '/login', {
            type: 'login',
            email: this.email,
            password: this.password
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
        return this.validateEmail(this.email);
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

const loginButton = $('#login-button');
loginButton.click(function () {
    let loginObject = new loginForm();
    loginObject.submit();
});
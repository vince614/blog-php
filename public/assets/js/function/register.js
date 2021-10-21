import Form from '/Core/Form/Form';
class registerForm extends Form {

    /**
     * Contructor
     */
    constructor() {
        super();
        this.usernameInput = $('#username');
        this.emailInput = $('#email');
        this.passwordInput = $('#password');
        this.comfirmPasswordInput = $('#comfirm-password');
    }

    /**
     * Get all values in selectors
     */
    getValues() {
        this.username = this.usernameInput.val();
        this.email = this.emailInput.val();
        this.password = this.passwordInput.val();
        this.comfirmPassword = this.comfirmPasswordInput.val();
    }

    /**
     * Send data request
     */
    send() {
        $.post(HOST_URL + '/register', {
            type: 'register',
            username: this.username,
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
     * @return {number}
     */
    valideForm() {
        this.getValues();
        return this.validateEmail(this.email) &
            this.validatePassword(this.password) &
            this.checkPasswords(this.password, this.comfirmPassword);
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

const registerButton = $('#register-button');
registerButton.click(function () {
    let registerObject = new registerForm();
    registerObject.submit();
});
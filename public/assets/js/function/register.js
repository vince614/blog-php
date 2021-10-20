class registerFrom {

    /**
     * Contructor
     */
    constructor() {
        this.passwordMinLength = 5;
        this.usernameInput = $('#username');
        this.emailInput = $('#email');
        this.passwordInput = $('#password');
        this.comfirmPasswordInput = $('#comfirm-password');
        this.error = null;
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
     * Validate email
     *
     * @param email
     * @return {boolean}
     */
    validateEmail(email) {
        let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        let isValidate = re.test(String(email).toLowerCase());
        if (isValidate) {
            return true;
        }
        this.error = "Merci de rentrez un email valide.";
        return false;
    }

    /**
     * Validate password
     *
     * @param password
     * @return {boolean}
     */
    validatePassword(password) {
        if (password.length >= this.passwordMinLength) {
            return true;
        }
        this.error = "Votre mot de passe dois contenir plus de " + this.passwordMinLength + " caractères.";
        return false;
    }

    /**
     * Check both passwords
     *
     * @return {boolean}
     */
    checkPasswords() {
        if (this.password === this.comfirmPassword) {
            return true;
        }
        this.error = "Vos mot de passes ne correspodent pas.";
        return false;
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
        }).done(function (datas) {
            let data = JSON.parse(datas);
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
            this.checkPasswords();
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
    let registerObject = new registerFrom();
    registerObject.submit();
});
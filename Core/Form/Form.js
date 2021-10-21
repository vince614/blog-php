class Form
{
    constructor() {
        this.error = null;
        this.passwordMinLength = 5;
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
     * @param password
     * @param comfirmPassword
     * @return {boolean}
     */
    checkPasswords(password, comfirmPassword) {
        if (password === comfirmPassword) {
            return true;
        }
        this.error = "Vos mot de passes ne correspodent pas.";
        return false;
    }

}
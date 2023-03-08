import {Controller} from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ["email", "password", "errorLogin"]

    onSubmit(event) {
        event.preventDefault();
        let data = {
            client_id: "administration",
            grant_type: "password",
            username: this.emailTarget.value,
            password: this.passwordTarget.value
        }
        fetch(this.element.action, {
            method: this.element.method,
            body: JSON.stringify(data),
            headers: {'Content-type': 'application/json'}
        })
            .then((response) => {
                console.log(response.status);
                if (response.status === 200) {
                    response.json().then((data) => {
                        localStorage.setItem('auth', JSON.stringify(data));
                        window.location.href = '/backend?Authorization=Bearer ' + data.access_token;
                    })
                } else {
                    this.errorLoginTarget.hidden = false;
                }
            })
    }
}
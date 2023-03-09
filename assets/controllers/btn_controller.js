import {Controller} from '@hotwired/stimulus';

const btnOverviewEl = document.getElementById('btn-overview');
const btnCreateEl = document.getElementById('btn-create');
const content = document.getElementById('admin-content');
const storage = JSON.parse(localStorage.getItem('auth'));

export default class extends Controller {
    static targets = ['isoCode', 'title', 'content', 'errorCreateUpdate', 'update', 'contentId'];

    connect() {
        if (storage.isAdmin === false) {
            btnCreateEl.hidden = true;
        }
        this.overview();
    }

    create() {
        btnCreateEl.classList.add('active');
        btnOverviewEl.classList.remove('active');

        if (storage.isAdmin === true) {
            fetch('/backend/create-update/0', {
                method: 'GET',
                headers: {
                    'Content-type': 'application/json',
                    'Authorization': 'Bearer ' + this.getAccessToken()
                }
            }).then((r) => r.text())
                .then((data) => {
                    content.innerHTML = data;
                }).catch((err) => {
                console.log(err);
                this.overview();
            });
        }
    }

    async edit(event) {
        if (storage.isAdmin === true) {
            await fetch('/api/content/' + event.params.id, {
                method: 'GET',
                headers: {
                    'Content-type': 'application/json',
                    'Authorization': 'Bearer ' + this.getAccessToken()
                }
            }).then((response) => {
                if (response.status !== 200) {
                    this.overview();
                }

                response.json().then((data) => {
                    fetch('/backend/create-update/1', {
                        method: 'GET',
                        headers: {
                            'Content-type': 'application/json',
                            'Authorization': 'Bearer ' + this.getAccessToken()
                        }
                    }).then((r) => r.text())
                        .then((d) => {
                            content.innerHTML = d;
                            this.contentIdTarget.value = data.data.id;
                            this.isoCodeTarget.value = data.data.isoCode;
                            this.titleTarget.value = data.data.title;
                            this.contentTarget.value = data.data.text;
                        }).catch(() => {
                            this.overview();
                    })
                })
            })
        }
    }

    async onSubmit(event) {
        event.preventDefault();

        let uri = '/api/content';
        let method = 'POST';

        if (this.updateTarget.value === '1') {
            uri = '/api/content/' + this.contentIdTarget.value;
            method = 'PATCH';
        }

        let data = {
            isoCode: this.isoCodeTarget.value,
            title: this.titleTarget.value,
            text: this.contentTarget.value
        };

        await fetch(uri, {
            method: method,
            body: JSON.stringify(data),
            headers: {
                'Content-type': 'application/json',
                'Authorization': 'Bearer ' + this.getAccessToken()
            }
        }).then((response) => {
            if (response.status === 201 || response.status === 200) {
                this.overview();
            } else {
                response.json().then((err) => {
                    this.errorCreateUpdateTarget.innerHTML = err.errors.detail;
                    this.errorCreateUpdateTarget.hidden = false;
                })
            }
        })
    }

    async delete(event) {
        if (storage.isAdmin === true) {
            await fetch('/api/content/'+event.params.id, {
                method: 'DELETE',
                headers: {
                    'Content-type': 'application/json',
                    'Authorization': 'Bearer ' + this.getAccessToken()
                }
            }).catch((err) => {
                console.log(err);
            })
        }

        this.overview();
    }

    overview() {
        btnCreateEl.classList.remove('active');
        btnOverviewEl.classList.add('active');

        fetch('/api/content', {
            method: 'GET',
            headers: {
                'Content-type': 'application/json',
                'Authorization': 'Bearer ' + this.getAccessToken()
            }
        })
            .then((r) => r.json())
            .then((data) => {
                fetch('/backend/overview', {
                    method: 'POST',
                    body: JSON.stringify(data.data),
                    headers: {
                        'Content-type': 'application/json',
                        'Authorization': 'Bearer ' + this.getAccessToken()
                    }
                })
                    .then((response) => response.text())
                    .then((data) => {
                        content.innerHTML = data;
                        this.disableActions();
                    });
            })
    }

    cancel() {
        this.overview();
    }

    disableActions() {
        let btnEditEl = document.getElementsByClassName('edit-btn');
        let btnDeleteEl = document.getElementsByClassName('delete-btn');
        if (storage.isAdmin === false) {
            for (let i = 0; i < btnEditEl.length; i++) {
                btnEditEl[i].hidden = true;
            }

            for (let i = 0; i < btnDeleteEl.length; i++) {
                btnDeleteEl[i].hidden = true;
            }
        }
    }

    getAccessToken() {
        return storage.access_token;
    }
}
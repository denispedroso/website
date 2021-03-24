import Errors from './Errors';

class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }


    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }


    /**
     * Reset the form fields.
     * 
     * @param {string} formId
     * 
     */
    reset(formId) {
        document.getElementById(formId).reset();
        for (let field in this.originalData) {
            this[field] = '';
        }
        this.errors.clear();

    }


    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url);
    }

    /**
     * Send a GET request to the given URL.
     * .
     * @param {string} url
     */
    get(url) {
        return new Promise((resolve, reject) => {
            axios.get(url)
                .then(response => {  
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response);
                });
        });
    }

    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url);
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    excluir(url) {
        return this.submit('post', url);
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        var form = document.getElementById("form1");
        var bodyFormData = new FormData(form);
    
        return new Promise((resolve, reject) => {
            axios({
                method: requestType,
                url: url,
                data: bodyFormData,
                headers: {'Content-Type': 'multipart/form-data' }
                })
                .then(response => {  
                    resolve(response.data);
                })
                .catch(error => {
                    reject(error.response);
                });
        });
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data, url) {
        switch (url) {
            case '/cards/store':
                this.modal.title = "Sucesso";
                this.modal.body = "Salvo com sucesso!";
                this.reset('form1');
                break;
            case '/cards/destroy':
                this.modal.title = "Sucesso";
                this.modal.body = "Excluído com sucesso!";
                this.reset('form1');
                break;
        }
        this.modal.label = "modal1";

        $('#modal1').modal('show');
        
        
    }
    
    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}
export default Form;
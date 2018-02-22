<script>
    import Resource from '../helpers/resource';
    import $ from 'jquery';
    import addEditModal from '../modal/addEditTransaction.vue';
    import viewTransactionModal from '../modal/viewTransaction.vue';
    import Vue from 'vue';
    import Modal from '../services/modal';
    import AlertModal from '../modal/alert.vue';

    export default {
    	data(){
    		return {
                date: null,
                add_title: '',
                add_entry: 'credit',
                add_amount: '',
                add_description: '',
                addErrorMessage: null,
                transactions: []
            }
    	},
        methods:  {
            
            getTrialBalance(){
                let requirements = {

                    url: `/api/trial-balance`,
                    method: 'GET',
                    params: {
                        date: this.date
                    }

                };
                Resource.send(requirements).then((response) => {
                    this.transactions = response.transactions;
                    console.log(response);
                    this.date = response.dateChosen;
                });     
            },

            reCompute() {
                let requirements = {

                    url: `/api/trial-balance/recompute`,
                    method: 'POST',
                    params: {
                        date: this.date
                    }

                };
                Resource.send(requirements).then((response) => {
                    if (response.success) {
                        this.openModal('Success', 'Refreshed Successfully')
                    } else {
                        this.openModal('Error!', 'Something went wrong, Try refreshing the page. If the problem persist please contact the tech guy.');
                    }

                    this.getTrialBalance();
                });       
            },

            openAddEditModal (transaction) {
                let modalContainer = $('<div>').appendTo('#app');    
                transaction = transaction !== undefined ? transaction : {};
                const Component = Vue.extend(addEditModal);
                const vm = new Component({
                    data: {
                        transaction: transaction
                    }
                }).$mount(modalContainer[0]);

                vm.$on('reload', () => {
                    this.getTrialBalance();
                })
            },

            viewTransaction (transaction) {
                let modalContainer = $('<div>').appendTo('#app');    
                transaction = transaction !== undefined ? transaction : {};
                const Component = Vue.extend(viewTransactionModal);
                const vm = new Component({
                    data: {
                        transaction: transaction
                    }
                }).$mount(modalContainer[0]);
            }, 

            openModal (title, message) {
                let config = {
                    modal: AlertModal,
                    data: {
                        title: title, 
                        body: message,
                    }
                }

                Modal.openModal(config);
            },

            deleteTransaction (transaction){
                let config = {
                    modal: AlertModal,
                    data: {
                        title: 'Confirm', 
                        body: 'Are you sure you want to delete this transaction?',
                        hasConfirm: true
                    }
                }

                Modal.openModal(config).then((response) => {
                    if(response == 'ok'){
                        let requirements = {
                            url: `/api/trial-balance/` + transaction.id + '/delete',
                            method: 'POST',
                            params: {}
                        };
                        Resource.send(requirements).then((response) => {
                            if (response.success) {
                                this.getTrialBalance();
                            } else {
                                this.openModal('Error!', 'Something went wrong, Try refreshing the page. If the problem persist please contact the tech guy.');
                            }
                        });                             
                    }
                })

            }
        },
        mounted() {
            this.getTrialBalance();
        },
        watch: {
            'date' : function(){
                this.getTrialBalance();
            }
        },
    }
</script>
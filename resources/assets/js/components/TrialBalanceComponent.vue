<script>
    import Resource from '../helpers/resource';
    import $ from 'jquery';
    import trialBalance from '../modal/trialBalance.vue';

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

            addTrialBalance(){
                let requirements = {

                    url: `/api/trial-balance`,
                    method: 'POST',
                    params: {
                        title: this.add_title,
                        amount: this.add_amount,
                        entry: this.add_entry,
                        description: this.add_description,
                    }

                };
                Resource.send(requirements).then((response) => {
                    if(response.success){
                        this.getTrialBalance();
                        $('#add-trial-balance').modal('hide')
                    }
                });     
            },
            openModal () {
                let $mount = jQuery('<div>').appendTo('#app');
                const Component = Vue.extend(trialBalance);
                const vm = new Component({
                }).$mount($mount[0]);
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
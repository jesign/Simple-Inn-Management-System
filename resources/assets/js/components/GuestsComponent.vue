<script>
    import Resource from '../helpers/resource';
    import Modal from '../services/modal';
    import AlertModal from '../modal/alert.vue';

    export default {
    	data(){
    		return {
                date: null,
                guests: []
            }
    	},
        methods:  {
            addZero(i) {
                if (i < 10) {
                    i = "0" + i;
                }
                return i;
            },
            getTime() {
               let d = new Date();
               let h = this.addZero(d.getHours());
               let m = this.addZero(d.getMinutes());
               let s = this.addZero(d.getSeconds());

               console.log(h + ":" + m + ":" + s); 
            },
            getGuests(){
                let requirements = {

                    url: `/api/guest`,
                    method: 'GET',
                    params: {
                        date: this.date
                    }

                };
                Resource.send(requirements).then((response) => {
                    if(response.success){
                        this.guests = response.guests;
                        this.date = response.dateChosen;    
                    }
                });
            },

            isTimeout(checkout){

                let dateNow = new Date();
                let checkoutDate = new Date(checkout);
                
                return checkoutDate < dateNow;
                // return false;
            },

            isCheckout(status) {
                return status == 'Check Out';
            },

            checkout(guestId){
                let requirements = {

                    url: `/api/guest/checkout/` + guestId,
                    method: 'POST',
                    params: {
                    }

                };
                Resource.send(requirements).then((response) => {
                    if(response.success){
                        let body = 'Room ' + response.guest.room_number + ' has checked out.';
                        this.getGuests();    
                        this.openModal('Success:', body)
                    } else {
                        this.openModal('Error!', response.error.body);
                    }
                });
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
            }

        },
        mounted() {
            

            this.getGuests();
        },
        watch: {
            'date' : function(){
                this.getGuests();
            }
        }
    }
</script>
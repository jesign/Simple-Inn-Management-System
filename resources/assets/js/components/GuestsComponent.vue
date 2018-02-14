<script>
    import Resource from '../helpers/resource';

    export default {
    	data(){
    		return {
                date: null,
                guests: []
            }
    	},
    	// props: ['checkOutTime'], 
    	computed: {
    		'isTimeOut': function(){
                return false;
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
                    this.guests = response.guests;
                    console.log(response);
                    this.date = response.dateChosen;
                });     
            },
            isTimeout(checkout){
                var minute = 1000 * 60;  
                var hour = minute * 60;  
                var day = hour * 24;  

                let date = new Date;
                let currentTime = date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
                console.log(checkout, currentTime);
                return checkout < currentTime;
                // return false;
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
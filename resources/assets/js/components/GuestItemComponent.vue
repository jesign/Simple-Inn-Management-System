<script>
    export default {
    	// props: ['checkOutTime'], 
    	computed: {
    		'isTimeOut': function(){
                return false;
            }
    	},
        replace: false,
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
            }
        },
        mounted() {
            setInterval( this.getTime(), 1000);
        }
    }
</script>

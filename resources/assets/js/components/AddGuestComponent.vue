<script>
	import _find from 'lodash/find';

    export default {
    	data(){
    		return {
    			'roomTypes': [], 
    			'roomType' : null,
    			'roomRate' : null
    		}
    	},
    	props: ['roomTypesJson'], 
    	computed: {
    		'roomRates' : function(){
    			let roomType = _find(this.roomTypes, { 'id': this.roomType })
    			if(roomType){
    				if(roomType.room_rates){
    					this.roomRate = roomType.room_rates[0].id;
    					return roomType.room_rates;
    				}else {
    					return [];
    				}
    			}else {
    				return [];
    			}
    		}
    	},
        mounted() {
            console.log('Add Guest Component Mounted.')
            console.log(JSON.parse(this.roomTypesJson));
            this.roomTypes = JSON.parse(this.roomTypesJson);
            this.roomType = this.roomTypes[0].id;
        }
    }
</script>

import $ from 'jquery';
import Vue from 'vue';
import VueResource from 'vue-resource';


Vue.use(VueResource);

let Resource = {

    send (requirements) {

    	// inject X-CSRF-TOKEN. this fix tokenMismatch error on laravel
    	requirements.headers = {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    };

      	return Vue.http(requirements).then( (response) => {
        	return response.data;
        	
      	}, (error) => {
        	
          	return {
             	success: false,
             	error: error,
              	message: 'Sorry, error while processing your request, please try again. If issue still persist, please contact administrator.'
            };

        });
    }
}

export default Resource;
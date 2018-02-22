import Vue from 'vue';
import $ from 'jquery';

let ModalService = {
	openModal (config) {

	    let modalContainer = $('<div>').appendTo('#app');    
	    const Component = Vue.extend(config.modal);
	    const vm = new Component({
	        data: config.data
	    }).$mount(modalContainer[0]);

	    const promise = new Promise((resolve, reject) => {
	    	vm.$on('confirm', () => {
	    		resolve('ok')
	    	});

	    	vm.$on('cancel', () => {
	    		resolve('cancel');
	    	});
	    });
	    return promise;
	}
}

export default ModalService;
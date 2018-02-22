<template>
	<modal :value="showModal">
		<div slot="title">{{title}}</div>
		<div>
			<p>{{body}}</p>
		</div>
		<div slot="modal-footer" class="modal-footer">
		    <button type="button" class="btn btn-default" @click="showModal = false">Close</button>
		    <button v-if="hasConfirm" type="button" class="btn btn-success" @click="confirm()">{{confirmText}}</button>
	  	</div>
	</modal>
</template>
<script>
	import Resource from '../helpers/resource';

	export default {
		data : function() {
			return {
				showModal : true,
				title: '',
				body: '',
				hasConfirm: false,
				confirmText: 'Confirm'
			}
		}, 
		methods: {
			confirm () {
				this.$emit('confirm');
				this.showModal = false;
			}
		}
	}
</script>
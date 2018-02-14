<template>
	<modal :value="showModal">
		<div slot="modal-header" class="modal-header">
			<h4 class="modal-title">Modal title</h4>
		</div>
		<div slot="modal-body" class="modal-body">
			<h2>Example modal</h2>
		</div>
	</modal>
</template>
<script>
	export default {
		data : function() {
			return {
				transaction: {},
				showModal : true
			}
		}, 
		methods: {
			close() {
				this.showModal = false;
			}
		},
		mounted () {
			
		}
	}
</script>
<template>
	<modal :value="showModal">
		<div slot="title">{{transaction.title}}</div>
		<div>
		    <div class="row">
		    	<div class="col-md-3">
		    		<label>Title:</label>	
		    	</div>
		    	<div class="col-md-9">
		    		<p>{{transaction.title}}</p>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="col-md-3">
		    		<label for="entry">Entry:</label>	
		    	</div>
		    	<div class="col-md-9">
		    		<p v-if="transaction.credit > 0">Credit</p>
		    		<p v-if="transaction.debit > 0">Debit</p>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="col-md-3">
		    		<label>Amount:</label>	
		    	</div>
		    	<div class="col-md-9">
		    		<p v-if="transaction.credit > 0">{{transaction.credit}}</p>
		    		<p v-if="transaction.debit > 0">{{transaction.debit}} </p>
		    	</div>
		    </div>
		    <div class="row">
		    	<div class="col-md-3">
		    		<label>Description:</label>	
		    	</div>
		    	<div class="col-md-9">
		    		<p>{{transaction.description}}</p>
		    	</div>
		    </div>
		</div>
		<div slot="modal-footer" class="modal-footer">
		    <button type="button" class="btn btn-default" @click="showModal = false">Close</button>
	  	</div>
	</modal>
</template>
<script>
	export default {
		data : function() {
			return {
				transaction: {},
				showModal : true,
			}
		}, 
		mounted () {
		}
	}
</script>
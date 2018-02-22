<template>
	<modal :value="showModal">
		<div slot="title">{{transaction.id ? 'Update' : 'Add'}} Transaction</div>
		<div>
			<form @submit.prevent="addEditTransaction()">
			    <div class="form-group" v-if="addErrorMessage">
			        <div class="error" >
			            @{{addErrorMessage}}
			        </div>    
			    </div>
			    <div class="form-group">
			        <label>Title:</label>
			        <input type="text" class="form-control" name="title" required v-model="transaction.title">
			    </div>

			    <div class="form-group">
			        <label for="entry">Entry:</label>
			        <select class="form-control" id="entry" name="entry" v-model="entry">
			            <option value="credit">Credit</option>
			            <option value="debit">Debit</option>
			        </select>
			    </div>
			    <div class="form-group">
			        <label>Amount:</label>
			        <input type="number" class="form-control" name="amount" required v-model="amount">
			    </div>
			    <div class="form-group">
			        <label>Description (optional):</label>
			        <textarea class="form-control" name="description" v-model="transaction.description"></textarea>
			    </div>
			</form>
		</div>
		<div slot="modal-footer" class="modal-footer">
		    <button type="button" class="btn btn-default" @click="showModal = false">Cancel</button>
		    <button type="button" class="btn btn-success" @click="save()">Save</button>
	  	</div>
	</modal>
</template>
<script>
	import Resource from '../helpers/resource';

	export default {
		data : function() {
			return {
				transaction: {},
				showModal : true,
				entry: 'credit',
				amount: 0,
				addErrorMessage: null
			}
		}, 
		methods: {
			save () {
				this.showModal = false;
				if (this.transaction.id) {
					this.editTransaction();
				} else {
					this.addTransaction();
				}
			},
			editTransaction() {
				let requirements = {
				    url: "/api/trial-balance/" + this.transaction.id + "/update",
				    method: 'POST',
				    params: {
				        title: this.transaction.title,
				        amount: this.amount,
				        entry: this.entry,
				        description: this.transaction.description
				    }
				};
				Resource.send(requirements).then((response) => {
				    if(response.success){
				        this.$emit('reload');
				    }
				});     
			},
			addTransaction(){
			    let requirements = {
			        url: `/api/trial-balance`,
			        method: 'POST',
			        params: {
			            title: this.transaction.title,
			            amount: this.amount,
			            entry: this.entry,
			            description: this.transaction.description
			        }
			    };
			    Resource.send(requirements).then((response) => {
			        if(response.success){
			            this.$emit('reload');
			        }
			    });     
			},

			updateAmount () {
				if(this.entry == 'credit'){
					this.transaction.credit = this.amount;
				} else {
					this.transaction.debit = this.amount;
				}
			}
		},
		watch : {
			entry : function(){
				this.updateAmount();
			}, 
			amount : function(){
				this.updateAmount();
			}
		},
		mounted () {
			if(this.transaction.id){
				if(this.transaction.debit != 0){
					this.entry = 'debit';
					this.amount = this.transaction.debit;
				}else {
					this.entry = 'credit';
					this.amount = this.transaction.credit;
				}
			}
		}
	}
</script>
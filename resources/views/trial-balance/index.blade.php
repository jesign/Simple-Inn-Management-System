@extends('layouts.app')

@section('content')
<trial-balance-component inline-template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-trial-balance">Add Transaction</button>
                <!-- Modal -->
                <div id="add-trial-balance" class="modal fade" role="dialog" >
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add Guest</h4>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="addTrialBalance()">
                                    <div class="form-group" v-if="addErrorMessage">
                                        <div class="error" >
                                            @{{addErrorMessage}}
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <label>Title:</label>
                                        <input type="text" class="form-control" name="title" required v-model="add_title">
                                    </div>

                                    <div class="form-group">
                                        <label for="entry">Entry:</label>
                                        <select class="form-control" id="entry" name="entry" v-model="add_entry">
                                            <option value="credit">Credit</option>
                                            <option value="debit">Debit</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Amount:</label>
                                        <input type="number" class="form-control" name="amount" required v-model="add_amount">
                                    </div>
                                    <div class="form-group">
                                        <label>Description (optional):</label>
                                        <textarea class="form-control" name="description" v-model="add_description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-default pull-right">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <h4 class="inline">Date:</h4>
                <input name="date" type="date" class="short-date-field form-control inline-important" v-model="date">
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">    
                @if(session()->has('message'))
                    <div class="alert alert-info">
                        <strong>{{session('message')}}</strong>
                    </div>
                @endif
            
                <div class="panel panel-default">
                    <div class="panel-heading">Trial Balance</div>

                    <div class="panel-body">
                        <table class="table table-responsive table-striped trial-balance">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Cash In</th>
                                    <th>Cash Out</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="transaction in transactions">
                                    <td>@{{ transaction.title }}</td>
                                    <td>@{{ transaction.debit }}</td>
                                    <td>@{{ transaction.credit }}</td>
                                    <td>@{{ transaction.current_total }}</td>
                                    <td>
                                        <a href="">view</a> | <a @click.prevent="openModal()">edits</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</trial-balance-component>
@endsection

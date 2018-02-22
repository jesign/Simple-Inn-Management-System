@extends('layouts.app')

@section('content')
<trial-balance-component inline-template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" @click="openAddEditModal()">Add Transaction</button>
                <button type="button" class="btn btn-primary" @click="reCompute()">Refresh</button>
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
                                    <td><a href="#" @click.prevent="viewTransaction(transaction)">@{{ transaction.title }}</a></td>
                                    <td>@{{ transaction.debit }}</td>
                                    <td>@{{ transaction.credit }}</td>
                                    <td>@{{ transaction.current_total }}</td>
                                    <td>
                                        <a href="#" @click.prevent="viewTransaction(transaction)" class="pointer">view</a> | <a href="# " class="pointer" @click.prevent="openAddEditModal(transaction)">edits</a> | <a href="#" @click.prevent="deleteTransaction(transaction)" class="pointer">delete</a> 
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

@extends('layouts.app')

@section('content')
    <!-- <example-component></example-component> -->
    <div id="vue-crud-wrapper">
        <div class="container">
            <div class="form-group row justify-content-left">
                <div class="col-md-8">
                    <div class="card">
                        <!-- <form action="#" class="form newtopic"> -->
                        <div class="card-header">
                            Add Developer
                            <span style="float:right;">
                                <button class="btn btn-primary btn-sm" @click.prevent="createDeveloper()">
                                    <span class="fa fa-plus"></span>&nbsp;ADD
                                </button>
                            </span>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fname">First Name:</label>
                                    <input type="text" class="form-control" id="fname" name="fname" v-model="newDeveloper.fname">
                                </div>
                                <div class="col-md-6">
                                    <label for="lname">Last Name:</label>
                                    <input type="text" class="form-control" id="lname" name="lname" v-model="newDeveloper.lname">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" v-model="newDeveloper.email">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Phone Number:</label>
                                    <input type="text" class="form-control" id="phone" name="phone" v-model="newDeveloper.phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="address">Address:</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" v-model="newDeveloper.address" 
                                        ></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="avatar">Avatar:</label>
                                    <input type="file" class="form-control-file" id="avatar" name="avatar" @change="onFileChange" >
                                    </br>
                                    <p class="text-center alert alert-danger" v-bind:class="{ hidden: hasError }">Please fill all fields!</p>
                                </div>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('images/POSablePAY-logo.png') }}" class="rounded mx-auto d-block" alt="posable-logo">
                    </br>We are a company infused with culture. Our values are what unite us, but our differences are what inspires us. Our mission is to empower retailers to provide exceptional customer experiences throughout the entire shopping journey. We get to do the best work of our lives and we celebrate our successes every chance we get.
                </div>
            </div>
            <div class="form-group row justify-content-left">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            List of Developers
                            <!-- <span style="float:right">
                                <p class="text-center alert alert-success"
                    v-bind:class="{ hidden: hasDeleted }">Deleted Successfully!</p>
                            </span> -->
                        </div>

                        <div class="card-body">
                            <div style="padding: 5px">
                                <button class="btn btn-danger" @click="deleteUser()">
                                    Delete All Selected
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" @click="select_all_via_check_box()" v-model="all_select" class='checkbox'>&nbsp;
                                                <span> @{{ all_select == true ? 'Uncheck All' : "Select All" }} </span> 
                                            </th>
                                            <th scope="col">#</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Avatar</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="dev in developers" :key="dev.id">
                                            <td><input type="checkbox" v-model="deleteItems" :value="dev.id" > </td>
                                            <th scope="row">@{{ dev.id }}</th>
                                            <td>@{{ dev.first_name }}</td>
                                            <td>@{{ dev.last_name }}</td>
                                            <td>@{{ dev.email }}</td>
                                            <td>@{{ dev.phone_num }}</td>
                                            <td>@{{ dev.address }}</td>
                                            <td>@{{ dev.avatar }}</td>
                                            <td>
                                                <span data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <button @click="setVal(dev.id, dev.first_name, dev.last_name, dev.email, dev.phone_num, dev.address, dev.avatar)" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                                        <i style="color:white" class="fa fa-pencil"></i>
                                                    </button>
                                                </span>
                                                <span data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <button @click.prevent="deleteDeveloper(dev)" class="btn btn-danger">
                                                        <i style="color:white" class="fa fa-trash"></i>
                                                    </button>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- show edit modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Developer</h5>
                            <!-- button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button> -->
                        </div>
                        <div class="modal-body">
                            <input type="hidden" disabled class="form-control" id="e_id" name="id" required :value="this.e_id">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="fname">First Name:</label>
                                    <input type="text" class="form-control" id="e_fname" name="fname" required :value="this.e_fname">
                                </div>
                                <div class="col-md-6">
                                    <label for="lname">Last Name:</label>
                                    <input type="text" class="form-control" id="e_lname" name="lname" required :value="this.e_lname">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="e_email" name="email" required :value="this.e_email">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Phone Number:</label>
                                    <input type="text" class="form-control" id="e_phone" name="phone" required :value="this.e_phone">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="address">Address:</label>
                                    <textarea class="form-control" id="e_address" name="address" rows="3" required :value="this.e_address" 
                                        ></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="avatar">Avatar:</label>
                                    <input type="file" class="form-control-file" id="e_avatar" name="avatar" @change="onFileChange" >
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" @click="editDeveloper()">Update</button>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- show delete modal -->
            <!-- <div id="delModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Developer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <p>Do you want delete this developer? <br/><strong>ID: </strong> @{{ this.e_id }} <br/><strong>Name: </strong> @{{ this.e_fname }}&nbsp;@{{ this.e_lname }} </p> 
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" v-on:click="delDeveloper(this.e_id)">Delete</button>
                        </div>
                    </div>
            </div> -->
        </div>
    </div>
@endsection
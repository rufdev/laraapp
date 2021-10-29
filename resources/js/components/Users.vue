<template>
    <div class="container">
       <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isSupport()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                    <button class="btn btn-success" data-toggle="modal" @click="newUser" data-target="#addNewUser">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registered At</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.role.name | upText}}</td>
                    <td>{{user.created_at | dateFormat}}</td>
                    <td>
                        <a href="#" @click="editUser(user)">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fas fa-trash text-red"></i>
                        </a>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div v-if="!($gate.isAdmin() || $gate.isSupport())">
            <not-found></not-found>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewUserLabel">New User</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewUserLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateUser() : createUser()">
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                            placeholder="Email Address"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                     <div class="form-group">
                        <textarea v-model="form.bio" name="bio" id="bio"
                        placeholder="Short bio for user (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>


                    <div class="form-group">
                        <select name="role_id" v-model="form.role_id" id="role_id" class="form-control" :class="{ 'is-invalid': form.errors.has('role_id') } " >
                            <option v-for="role in roles" v-bind:key="role.id" v-bind:value="role.id">
                                {{ role.name }}
                            </option>
                            <!-- <option value="">Select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="skadmin">SK Admin</option>
                            <option value="skmember">SK Member</option> -->
                        </select>
                        <has-error :form="form" field="role_id"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password" id="password"
                        placeholder="Password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Ceate</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode : false,
                users : {},
                roles : [],
                form: new Form({
                    id:'',
                    name : '',
                    email : '',
                    password : '',
                    // bio : '',
                    photo : '',
                    role_id : 3
                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                .then(response => {
                    this.users = response.data;
                });
            },
            newUser(){
                this.editmode = false;
                this.form.reset();
                $("#addNewUser").css("z-index", "1500");

            },
            editUser(user){
                this.editmode = true;
                this.form.reset();
                $('#addNewUser').modal('show');
                $("#addNewUser").css("z-index", "1500");

                this.form.fill(user);
            },
            loadUsers(){
                if(this.$gate.isAdmin() || this.$gate.isSupport()){
                    axios.get('api/user').then(({data}) => (this.users = data));
                    axios.get('api/role').then(({data}) => (this.roles = data.data));
                }

            },
            updateUser(){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                .then(() => {
                    $('#addNewUser').modal('hide');
                    swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                    );
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    this.$Progress.fail();
                });

            },
            deleteUser(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/user/'+id).then(()=>{
                                    swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    );
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal.fire("Failed!", "There was something wrong.", "warning");
                                });
                         }
                    })
            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
                    $('#addNewUser').modal('hide');
                    Fire.$emit('AfterCreate');
                    toast.fire({
                        type: 'success',
                        title: 'User Created in successfully'
                    })
                    this.$Progress.finish();

                })
                .catch(()=>{
                    this.$Progress.fail();
                });
            }
        },
        created() {
            Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findUser?q=' + query)
                .then((data) => {
                    this.users = data.data
                })
                .catch(() => {

                });
            });
            this.loadUsers();
            Fire.$on('AfterCreate',() => {
                this.loadUsers();
            });
        }
    }
</script>

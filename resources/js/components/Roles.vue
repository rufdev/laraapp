<template>
    <div class="container">
       <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isSupport()">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Roles</h3>

                <div class="card-tools">
                    <button class="btn btn-success" data-toggle="modal" @click="newRole" data-target="#addNewRole">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="role in roles.data" :key="role.id">
                    <td>{{role.id}}</td>
                    <td>{{role.name}}</td>
                    <td>{{role.code | upText}}</td>
                    <td>{{role.description }}</td>
                    <td>
                        <a href="#" @click="editRole(role)">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" @click="deleteRole(role.id)">
                            <i class="fas fa-trash text-red"></i>
                        </a>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="roles" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div v-if="!($gate.isAdmin() || $gate.isSupport())">
            <not-found></not-found>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNewRole" tabindex="-1" role="dialog" aria-labelledby="addNewRoleLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewRoleLabel">New Role</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewRoleLabel">Update Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateRole() : createRole()">
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.code" type="text" name="code"
                            placeholder="Code"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                        <has-error :form="form" field="code"></has-error>
                    </div>

                    <div class="form-group">
                        <textarea v-model="form.description" name="description" id="description"
                        placeholder="Short description for role (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                        <has-error :form="form" field="description"></has-error>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
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
                roles : {},
                form: new Form({
                    id:'',
                    name : '',
                    code : '',
                    description : '',
                })
            }
        },
        methods:{
            getResults(page = 1) {
                axios.get('api/role?page=' + page)
                .then(response => {
                    this.roles = response.data;
                });
            },
            newRole(){
                this.editmode = false;
                this.form.reset();
                $("#addNewRole").css("z-index", "1500");

            },
            editRole(role){
                this.editmode = true;
                this.form.reset();
                $('#addNewRole').modal('show');
                $("#addNewRole").css("z-index", "1500");
                this.form.fill(role);
            },
            loadRoles(){
                if(this.$gate.isAdmin() || this.$gate.isSupport()){
                    axios.get('api/role').then(({data}) => (this.roles = data));
                }

            },
            updateRole(){
                this.$Progress.start();
                this.form.put('api/role/'+this.form.id)
                .then(() => {
                    $('#addNewRole').modal('hide');
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
            deleteRole(id){
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
                                this.form.delete('api/role/'+id).then(()=>{
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
            createRole(){
                this.$Progress.start();
                this.form.post('api/role')
                .then(()=>{
                    $('#addNewRole').modal('hide');
                    Fire.$emit('AfterCreate');
                    toast.fire({
                        type: 'success',
                        title: 'Role Created in successfully'
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
                axios.get('api/findRole?q=' + query)
                .then((data) => {
                    this.roles = data.data
                })
                .catch(() => {

                });
            });
            this.loadRoles();
            Fire.$on('AfterCreate',() => {
                this.loadRoles();
            });
        }
    }
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-3">
                    <!-- Widget: user widget style 1 -->
                    <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background: url('/img/photo1.png') center center;">
                        <h3 class="widget-user-username">{{ form.name }}</h3>
                        <h5 class="widget-user-desc">{{ form.role.name }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>

                    </div>
                    <!-- /.widget-user -->
            </div>
            <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Profile</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active show" id="settings">
                    <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-12">
                                <input type="" v-model="form.name" class="form-control" id="inputName" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-12">
                                <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                <div class="col-sm-12">
                                <textarea  v-model="form.bio" class="form-control" id="inputExperience" placeholder="Experience" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                    <has-error :form="form" field="bio"></has-error>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                                <div class="col-sm-12">
                                    <input type="file" @change="updateProfile" name="photo" class="form-input">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-12 control-label">Passport (leave empty if not changing)</label>

                                <div class="col-sm-12">
                                <input type="password"
                                    v-model="form.password"
                                    class="form-control"
                                    id="password"
                                    placeholder="Password"
                                    :class="{ 'is-invalid': form.errors.has('password') }"
                                >
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-12">
                                <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                 form: new Form({
                    id:'',
                    name : '',
                    email : '',
                    password : '',
                    // type : '',
                    // bio : '',
                    photo : '',
                    role: []
                })
            }
        },
        methods:{

            getProfilePhoto(){

                let photo = this.form.photo ? "img/"+ this.form.photo : "img/logo.png";
                return photo;
            },

            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('api/profile')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    this.$Progress.finish();
                    swal.fire(
                        "Success!",
                        "Profile Updated.",
                        "success"
                    );
                    $("#username").text(this.form.name);
                })
                .catch(() => {
                    this.$Progress.fail();
                    swal.fire("Failed!", "There was something wrong.", "warning");
                });
            },
            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();

                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
                    return false;
                }

                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            }
        },
        created() {
            axios.get('api/profile').then(({data})=>
            (this.form.fill(data)));
        }
    }
</script>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <section class="content-header bg-lime">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Simple CRUD Page</h1>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div
                    class="row mt-3"
                    v-if="$gate.isAdmin() || $gate.isSupport()"
                >
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Person</h3>

                                <div class="card-tools">
                                    <button
                                        class="btn btn-success"
                                        data-toggle="modal"
                                        @click="newItem"
                                        data-target="#addNewItem"
                                    >
                                        Add New Item
                                        <i class="fas fa-plus fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>ID</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Modify</th>
                                        </tr>
                                        <tr
                                            v-for="item in items.data"
                                            :key="item.id"
                                        >
                                            <td>{{ item.id }}</td>
                                            <td>{{ item.fname | upText }}</td>
                                            <td>{{ item.lname | upText }}</td>
                                            <td>
                                                <a
                                                    href="#"
                                                    @click="editItem(item)"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a
                                                    href="#"
                                                    @click="deleteItem(item.id)"
                                                >
                                                    <i
                                                        class="fas fa-trash text-red"
                                                    ></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <!-- <div class="card-footer">
                                <pagination
                                    :data="items"
                                    @pagination-change-page="getResults"
                                ></pagination>
                            </div> -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div v-if="!($gate.isAdmin() || $gate.isSupport())">
                    <not-found></not-found>
                </div>
                <!-- Modal -->
                <div
                    class="modal fade"
                    id="addNewItem"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby=""
                    aria-hidden="true"
                >
                    <div
                        class="modal-dialog modal-dialog-centered"
                        role="document"
                    >
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 v-show="!editmode" class="modal-title">
                                    New Item
                                </h5>
                                <h5 v-show="editmode" class="modal-title">
                                    Update Item
                                </h5>
                                <button
                                    type="button"
                                    class="close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                >
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form
                                @submit.prevent="
                                    editmode ? updateItem() : createItem()
                                "
                            >
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input
                                            v-model="form.fname"
                                            type="text"
                                            name="fname"
                                            placeholder="First Name"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'fname'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="fname"
                                        ></has-error>
                                    </div>

                                    <div class="form-group">
                                        <input
                                            v-model="form.lname"
                                            type="text"
                                            name="lname"
                                            placeholder="Last Name"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'lname'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="lname"
                                        ></has-error>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        data-dismiss="modal"
                                    >
                                        Close
                                    </button>
                                    <button
                                        v-show="!editmode"
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Create
                                    </button>
                                    <button
                                        v-show="editmode"
                                        type="submit"
                                        class="btn btn-success"
                                    >
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            editmode: false,
            items: {},
            form: new Form({
                id: "",
                fname: "",
                lname: ""
            })
        };
    },
    methods: {
        // getResults(page = 1) {
        //     axios.get("api/role?page=" + page).then(response => {
        //         this.roles = response.data;
        //     });
        // },
        newItem() {
            this.editmode = false;
            this.form.reset();
            // $("#addNewItem").css("z-index", "1500");
        },
        // editItem(role) {
        //     this.editmode = true;
        //     this.form.reset();
        //     $("#addNewRole").modal("show");
        //     $("#addNewRole").css("z-index", "1500");
        //     this.form.fill(role);
        // },
        // loadItems() {
        //     if (this.$gate.isAdmin() || this.$gate.isSupport()) {
        //         axios.get("api/role").then(({ data }) => (this.roles = data));
        //     }
        // },
        // updateItems() {
        //     this.$Progress.start();
        //     this.form
        //         .put("api/role/" + this.form.id)
        //         .then(() => {
        //             $("#addNewRole").modal("hide");
        //             swal.fire(
        //                 "Updated!",
        //                 "Information has been updated.",
        //                 "success"
        //             );
        //             this.$Progress.finish();
        //             Fire.$emit("AfterCreate");
        //         })
        //         .catch(() => {
        //             this.$Progress.fail();
        //         });
        // },
        // deleteItems(id) {
        //     swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         type: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then(result => {
        //         // Send request to the server
        //         if (result.value) {
        //             this.form
        //                 .delete("api/role/" + id)
        //                 .then(() => {
        //                     swal.fire(
        //                         "Deleted!",
        //                         "Your file has been deleted.",
        //                         "success"
        //                     );
        //                     Fire.$emit("AfterCreate");
        //                 })
        //                 .catch(() => {
        //                     swal.fire(
        //                         "Failed!",
        //                         "There was something wrong.",
        //                         "warning"
        //                     );
        //                 });
        //         }
        //     });
        // },
        createItem() {
          console.log("createing item");
          console.log(this.form.lname);
            // this.$Progress.start();
            // this.form
            //     .post("api/role")
            //     .then(() => {
            //         $("#addNewRole").modal("hide");
            //         Fire.$emit("AfterCreate");
            //         toast.fire({
            //             type: "success",
            //             title: "Role Created in successfully"
            //         });
            //         this.$Progress.finish();
            //     })
            //     .catch(() => {
            //         this.$Progress.fail();
            //     });
        }
    },
    created() {
        // Fire.$on("searching", () => {
        //     let query = this.$parent.search;
        //     axios
        //         .get("api/findRole?q=" + query)
        //         .then(data => {
        //             this.roles = data.data;
        //         })
        //         .catch(() => {});
        // });
        // this.loadItems();
        // Fire.$on("AfterCreate", () => {
        //     this.loadItems();
        // });
    }
};
</script>

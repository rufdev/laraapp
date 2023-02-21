<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">School Management</h1>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Schools
                                </h3>
                                <div class="card-tools">
                                    <button
                                        type="button"
                                        @click="newSchool"
                                        class="btn btn-success"
                                        data-target="#addNewSchool"
                                    >
                                        Add New
                                        <i class="fas fa-user-plus fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table
                                    id="school_table"
                                    class="table table-bordered table-striped"
                                >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>
                                                Description
                                            </th>
                                            <th>
                                                Municipality
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal" tabindex="-1" role="dialog" id="addNewSchool">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            v-show="!editmode"
                            class="modal-title"
                            id="addNewSchoolLabel"
                        >
                            New School
                        </h5>
                        <h5
                            v-show="editmode"
                            class="modal-title"
                            id="addNewSchoolLabel"
                        >
                            Update School
                        </h5>
                        <button
                            type="button"
                            @click="closeModal"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        @submit.prevent="
                            editmode ? updateSchool() : createSchool()
                        "
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    placeholder="Name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="name"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <input
                                    v-model="form.code"
                                    type="text"
                                    name="code"
                                    placeholder="Code"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('code')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="code"
                                ></has-error>
                            </div>

                            <div class="form-group">
                                <textarea
                                    v-model="form.description"
                                    name="description"
                                    id="description"
                                    placeholder="Short description for School (Optional)"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has(
                                            'description'
                                        )
                                    }"
                                ></textarea>
                                <has-error
                                    :form="form"
                                    field="description"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Select</label>
                                <select
                                    class="form-control"
                                    v-model="form.municipalityid"
                                >
                                    <template
                                        v-for="purchase_order in purchase_orders"
                                    >
                                        <option
                                            v-bind:key="purchase_order.number"
                                        >
                                            @{{ purchase_order.number }}
                                        </option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                                @click="closeModal"
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
</template>

<script>
export default {
    data() {
        return {
            editmode: false,
            schools: {},
            form: new Form({
                id: "",
                name: "",
                code: "",
                description: "",
                municipalityid: ""
            }),
            municipalities: {}
        };
    },
    methods: {
        getMunicipalities() {
            axios.get("api/municipality").then(({ data }) => {
                this.Municipalities = data;
            });
        },
        // getResults(page = 1) {
        //     axios.get("api/School?page=" + page).then(response => {
        //         this.Schools = response.data;
        //     });
        // },
        newSchool() {
            this.editmode = false;
            this.form.reset();
            $("#addNewSchool").modal("show");
            $("#addNewSchool").css("z-index", "1500");
        },
        closeModal() {
            this.editmode = false;
            this.form.reset();
            $("#addNewSchool").modal("hide");
            $("#addNewSchool").css("z-index", "1500");
        }
        // editSchool(School) {
        //     this.editmode = true;
        //     this.form.reset();
        //     $("#addNewSchool").modal("show");
        //     $("#addNewSchool").css("z-index", "1500");
        //     this.form.fill(School);
        // },
        // loadSchools() {
        //     if (this.$gate.isAdmin() || this.$gate.isSupport()) {
        //         axios.get("api/school").then(({ data }) => (this.Schools = data));
        //     }
        // },
        // updateSchool() {
        //     this.$Progress.start();
        //     this.form
        //         .put("api/School/" + this.form.id)
        //         .then(() => {
        //             $("#addNewSchool").modal("hide");
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
        // deleteSchool(id) {
        //     swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes, delete it!"
        //     }).then(result => {
        //         // Send request to the server
        //         if (result.value) {
        //             this.form
        //                 .delete("api/School/" + id)
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
        // createSchool() {
        //     this.$Progress.start();
        //     this.form
        //         .post("api/School")
        //         .then(() => {
        //             $("#addNewSchool").modal("hide");
        //             Fire.$emit("AfterCreate");
        //             toast.fire({
        //                 title: "School Created in successfully"
        //             });
        //             this.$Progress.finish();
        //         })
        //         .catch(() => {
        //             this.$Progress.fail();
        //         });
        // }
    },
    created() {
        // Fire.$on("searching", () => {
        //     let query = this.$parent.search;
        //     axios
        //         .get("api/school?q=" + query)
        //         .then(data => {
        //             console.log(data);
        //             this.Schools = data.data;
        //         })
        //         .catch(() => {});
        // });
        // this.loadSchools();
        // Fire.$on("AfterCreate", () => {
        //     this.loadSchools();
        // });

        this.getMunicipalities();
        $(function() {
            var table = $("#school_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "api/schools/list",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    }
                },
                columns: [
                    { data: "id", name: "id" },
                    { data: "name", name: "name" },
                    { data: "code", name: "code" },
                    { data: "description", name: "description" },
                    { data: "municipalityid", name: "municipalityid" },
                    {
                        data: "action",
                        name: "action",
                        orderable: true,
                        searchable: true
                    }
                ]
            });
        });
    }
};
</script>

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
                                    class="table table-bordered table-hover table-striped"
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
                                    <option
                                        v-for="municipality in municipalities"
                                        v-bind:key="municipality.id"
                                        v-bind:value="municipality.id"
                                    >
                                        {{ municipality.name }}
                                    </option>
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
            municipalities: [],
            table: null
        };
    },
    methods: {
        getMunicipalities() {
            axios.get("api/municipality").then(({ data }) => {
                this.municipalities = data;
            });
        },
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
        },
        editSchool(School) {
            this.editmode = true;
            this.form.reset();
            $("#addNewSchool").modal("show");
            $("#addNewSchool").css("z-index", "1500");
            this.form.fill(School);
        },
        updateSchool() {
            this.$Progress.start();
            this.form
                .put("api/schools/" + this.form.id)
                .then(() => {
                    
                    this.table.ajax.reload();
                    $("#addNewSchool").modal("hide");
               
                    swal.fire(
                        "Updated!",
                        "Information has been updated.",
                        "success"
                    );
                    this.$Progress.finish();
                    // Fire.$emit("AfterCreate");
                })
                .catch((e) => {
                    console.log(e);
                    this.$Progress.fail();
                });
        },
        deleteSchool(id) {
            swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                // Send request to the server
                if (result.value) {
                    this.form
                        .delete("api/schools/" + id)
                        .then(() => {
                            swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            this.table.ajax.reload();
                            // Fire.$emit("AfterCreate");
                        })
                        .catch((e) => {
                            console.log(e);
                            swal.fire(
                                "Failed!",
                                "There was something wrong.",
                                "warning"
                            );
                        });
                }
            });
        },
        createSchool() {
            this.$Progress.start();
            this.form
                .post("api/schools")
                .then(() => {
                    $("#addNewSchool").modal("hide");
                    // Fire.$emit("AfterCreate");
                    this.table.ajax.reload();
                    toast.fire({
                        title: "School Created in successfully"
                    });
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
        }
    },
    mounted() {
        let self = this;
        this.getMunicipalities();
        $("body").on("click", ".edit", function() {
            let row = $(this).parents('tr')[0];
            let rowdata = self.table.row(row).data();
            self.editSchool(rowdata);
        });
        $("body").on("click", ".delete", function() {
            let row = $(this).parents('tr')[0];
            let rowdata = self.table.row(row).data();
            self.deleteSchool(rowdata.id);
        });
       this.table = $("#school_table").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            responsive: true,
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
    },
};
</script>

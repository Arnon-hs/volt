<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="el-icon-user"></i> Users
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <el-table
                            :data="users.filter(data => !search || data.email.toLowerCase().includes(search.toLowerCase()) || data.name.toLowerCase().includes(search.toLowerCase()))"
                            style="width: 100%">
                        <el-table-column
                                label="ID"
                                prop="id"
                                width="100">
                        </el-table-column>
                        <el-table-column
                                label="Name"
                                prop="name">
                        </el-table-column>
                        <el-table-column
                                label="Email"
                                prop="email">
                        </el-table-column>
                        <el-table-column
                                label="Balance EUR"
                                prop="balance_eur"
                                width="150">
                        </el-table-column>
                        <!--<el-table-column-->
                                <!--label="Balance kW"-->
                                <!--prop="balance_kv"-->
                                <!--width="150">-->
                        <!--</el-table-column>-->
                        <el-table-column
                                align="right">
                            <template #header>
                                <div class="inline-flex">
                                    <el-button size="mini" type="success" @click="dialogFormCreateVisible = true" style="margin-right: 1em">
                                        Create
                                    </el-button>
                                    <el-input
                                            v-model="search"
                                            size="mini"
                                            placeholder="Type to search">
                                    </el-input>
                                </div>
                            </template>
                            <template #default="scope">
                                <el-button
                                        size="mini"
                                        @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
                                <el-button
                                        size="mini"
                                        type="danger"
                                        @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                    <el-dialog title="Update user" v-model="dialogFormUpdateVisible" @close="selectedUser = {}">
                        <el-form>
                            <el-form-item label="ID">
                                <el-input v-model="selectedUser.id" autocomplete="off" :disabled="true"></el-input>
                            </el-form-item>
                            <el-form-item label="Name">
                                <el-input v-model="selectedUser.name" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Email">
                                <el-input v-model="selectedUser.email" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Balance EUR">
                                <el-input v-model="selectedUser.balance_eur" autocomplete="off"></el-input>
                            </el-form-item>
                            <!--<el-form-item label="Balance kW">-->
                                <!--<el-input v-model="selectedUser.balance_kv" autocomplete="off"></el-input>-->
                            <!--</el-form-item>-->
                        </el-form>
                        <template #footer>
                            <span class="dialog-footer">
                              <el-button @click="dialogFormUpdateVisible = false">Cancel</el-button>
                              <el-button type="primary" @click="edit">Edit</el-button>
                            </span>
                        </template>
                    </el-dialog>
                    <el-dialog title="Create user" v-model="dialogFormCreateVisible" @close="selectedUser = {}">
                        <el-form>
                            <el-form-item label="Name">
                                <el-input v-model="selectedUser.name" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Email">
                                <el-input v-model="selectedUser.email" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Password">
                                <el-input v-model="selectedUser.password" autocomplete="off" show-password></el-input>
                            </el-form-item>
                            <el-form-item label="Balance EUR">
                                <el-input v-model="selectedUser.balance_eur" autocomplete="off"></el-input>
                            </el-form-item>
                        </el-form>
                        <template #footer>
                            <span class="dialog-footer">
                              <el-button @click="dialogFormCreateVisible = false">Cancel</el-button>
                              <el-button type="primary" @click="save">Save</el-button>
                            </span>
                        </template>
                    </el-dialog>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        data: () => {
            return {
                search: '',
                selectedUser: {},
                dialogFormUpdateVisible: false,
                dialogFormCreateVisible: false,
                formLabelWidth: '120px',
                form: {}
            }
        },
        props: [
            'users'
        ],
        components: {
            AppLayout
        },
        methods:{
            handleEdit(index, row) {
                this.dialogFormUpdateVisible = true
                this.selectedUser = this.users[index]
                console.log(index, row);
            },
            handleDelete(index, row) {
                console.log(index, row);
                if(confirm('Are you sure, you want to delete the user?'))
                    this.delete(this.users[index].id, index)
            },
            edit(){
                axios.put(route('api.users.update'), {
                    id: this.selectedUser.id,
                    email: this.selectedUser.email,
                    name: this.selectedUser.name,
                    balance_eur: this.selectedUser.balance_eur,
                    balance_kv: this.selectedUser.balance_kv
                }).then(response => {
                    if(response.status === 200){
                        this.$notify({
                            title: 'Success',
                            message: 'User data has been changed!',
                            type: 'success'
                        });
                        this.dialogFormUpdateVisible = false
                        this.selectedUser = {}
                    }
                    console.log(response)
                }).catch( error => {
                    let e = { ...error}
                    if(e.response.data){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.error
                        });
                    }
                    console.log(error, e.response, e, e.response.data)
                })
            },
            save(){
                axios.post(route('api.users.store'), {
                    email: this.selectedUser.email,
                    name: this.selectedUser.name,
                    balance_eur: this.selectedUser.balance_eur,
                    password: this.selectedUser.password
                }).then(response => {
                    if(response.status === 200){
                        const user = response.data.data;
                        this.users.push(user);
                        this.$notify({
                            title: 'Success',
                            message: 'User has been created!',
                            type: 'success'
                        });
                        this.dialogFormCreateVisible = false
                        this.selectedUser = {}
                    }
                    console.log(response)
                }).catch(error => {
                    let e = { ...error}
                    if(e.response.data){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.error
                        });
                    }
                })
            },
            delete(id, index){
                axios.delete(route('api.users.delete',id)).then(response => {
                    if(response.status === 201){
                        this.users.splice(index, 1);
                        this.$notify({
                            title: 'Warning',
                            message: 'User has been deleted!',
                            type: 'warning'
                        });
                    }
                    console.log(response)
                }).catch(error => {
                    let e = { ...error }
                    if(e.response.data){
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.error
                        });
                    }
                })
            }
        }
    }
</script>
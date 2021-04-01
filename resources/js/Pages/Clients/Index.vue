<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="el-icon-location-information"></i> Clients (Electric filling stations)
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <el-table
                            :data="clients.filter(data => !search || data.country.toLowerCase().includes(search.toLowerCase()) || data.id.toLowerCase().includes(search.toLowerCase()))"
                            style="width: 100%">
                        <el-table-column
                                label="ID"
                                prop="id">
                        </el-table-column>
                        <el-table-column
                                label="Address"
                                prop="address">
                        </el-table-column>
                        <el-table-column
                                label="Country"
                                prop="country">
                        </el-table-column>
                        <el-table-column
                                label="Price for 1 kW"
                                prop="price"
                                width="150">
                        </el-table-column>
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
                    <el-dialog title="Update client" v-model="dialogFormUpdateVisible" @close="selectedClient = {}">
                        <el-form>
                            <el-form-item label="ID">
                                <el-input v-model="selectedClient.id" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Address">
                                <el-input v-model="selectedClient.address" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Country">
                                <el-input v-model="selectedClient.country" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Price for 1 kW">
                                <el-input v-model="selectedClient.price" autocomplete="off"></el-input>
                            </el-form-item>
                        </el-form>
                        <template #footer>
                            <span class="dialog-footer">
                              <el-button @click="dialogFormUpdateVisible = false">Cancel</el-button>
                              <el-button type="primary" @click="edit">Edit</el-button>
                            </span>
                        </template>
                    </el-dialog>
                    <el-dialog title="Create client" v-model="dialogFormCreateVisible" @close="selectedClient = {}">
                        <el-form>
                            <el-form-item label="ID">
                                <el-input v-model="selectedClient.id" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Address">
                                <el-input v-model="selectedClient.address" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Country">
                                <el-input v-model="selectedClient.country" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Price for 1 kW">
                                <el-input v-model="selectedClient.price" autocomplete="off"></el-input>
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
                selectedClient: {},
                dialogFormUpdateVisible: false,
                dialogFormCreateVisible: false,
                formLabelWidth: '120px',
                form: {}
            }
        },
        props: [
            'clients'
        ],
        components: {
            AppLayout
        },
        methods:{
            handleEdit(index, row) {
                this.dialogFormUpdateVisible = true
                this.selectedClient = this.clients[index]
                console.log(index, row);
            },
            handleDelete(index, row) {
                console.log(index, row);
                if(confirm('Are you sure, you want to delete the client?'))
                    this.delete(this.clients[index].id, index)
            },
            edit(){
                axios.put(route('api.clients.update'), {
                    address: this.selectedClient.address,
                    id: this.selectedClient.id,
                    price: this.selectedClient.price,
                    country: this.selectedClient.country
                }).then(response => {
                    if(response.status === 200){
                        this.$notify({
                            title: 'Success',
                            message: 'Client data has been changed!',
                            type: 'success'
                        });
                        this.dialogFormUpdateVisible = false
                        this.selectedClient = {}
                    }
                    console.log(response)
                }).catch( error => {
                    let e = { ...error }
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
                axios.post(route('api.clients.store'), {
                    address: this.selectedClient.address,
                    id: this.selectedClient.id,
                    price: this.selectedClient.price,
                    country: this.selectedClient.country
                }).then(response => {
                    if(response.status === 200){
                        const client = response.data.data;
                        this.clients.push(client);
                        this.$notify({
                            title: 'Success',
                            message: 'Client has been created!',
                            type: 'success'
                        });
                        this.dialogFormCreateVisible = false
                        this.selectedClient = {}
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
                axios.delete(route('api.clients.delete',id)).then(response => {
                    if(response.status === 201){
                        this.clients.splice(index, 1);
                        this.$notify({
                            title: 'Warning',
                            message: 'Client has been deleted!',
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
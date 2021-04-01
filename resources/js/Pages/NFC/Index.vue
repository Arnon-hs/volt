<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <i class="el-icon-bank-card"></i>
                NFC Cards
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <el-table
                            :data="nfc_cards.filter(data => !search || data.uid.toLowerCase().includes(search.toLowerCase()) || data.sak.toLowerCase().includes(search.toLowerCase()))"
                            style="width: 100%">
                        <el-table-column
                                label="ID"
                                prop="id">
                        </el-table-column>
                        <el-table-column
                                label="UID NFC"
                                prop="uid">
                        </el-table-column>
                        <el-table-column
                                label="SAK NFC"
                                prop="sak">
                        </el-table-column>
                        <el-table-column
                                label="User ID"
                                prop="user_id">
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
                    <el-dialog title="Update NFC Card" v-model="dialogFormUpdateVisible" @close="selectedNFC = {}">
                        <el-form>
                            <el-form-item label="ID">
                                <el-input v-model="selectedNFC.id" autocomplete="off" readonly></el-input>
                            </el-form-item>
                            <el-form-item label="UID NFC">
                                <el-input v-model="selectedNFC.uid" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="SAK NFC">
                                <el-input v-model="selectedNFC.sak" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-select v-model="selectedNFC.user_id" placeholder="User">
                                <el-option
                                        v-for="item in users"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                    <span style="float: left">{{ item.name }}</span>
                                    <span style="float: right; color: #8492a6; font-size: 13px">{{ item.email }}</span>
                                </el-option>
                            </el-select>
                        </el-form>
                        <template #footer>
                            <span class="dialog-footer">
                              <el-button @click="dialogFormUpdateVisible = false">Cancel</el-button>
                              <el-button type="primary" @click="edit">Edit</el-button>
                            </span>
                        </template>
                    </el-dialog>
                    <el-dialog title="Create NFC Card" v-model="dialogFormCreateVisible" @close="selectedNFC = {}">
                        <el-form>
                            <!--<el-form-item label="ID">-->
                                <!--<el-input v-model="selectedNFC.id" autocomplete="off"></el-input>-->
                            <!--</el-form-item>-->
                            <el-form-item label="UID NFC">
                                <el-input v-model="selectedNFC.uid" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="SAK NFC">
                                <el-input v-model="selectedNFC.sak" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-select v-model="selectedNFC.user_id" placeholder="User">
                                <el-option
                                        v-for="item in users"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                    <span style="float: left">{{ item.name }}</span>
                                    <span style="float: right; color: #8492a6; font-size: 13px">{{ item.email }}</span>
                                </el-option>
                            </el-select>
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
                selectedNFC: {},
                dialogFormUpdateVisible: false,
                dialogFormCreateVisible: false,
                formLabelWidth: '120px',
                form: {}
            }
        },
        props: [
            'users',
            'nfc_cards'
        ],
        components: {
            AppLayout
        },
        methods:{
            handleEdit(index, row) {
                this.dialogFormUpdateVisible = true
                this.selectedNFC = this.nfc_cards[index]
                console.log(index, row);
            },
            handleDelete(index, row) {
                console.log(index, row);
                if(confirm('Are you sure, you want to delete the NFC Card?'))
                    this.delete(this.nfc_cards[index].id, index)
            },
            edit(){
                axios.put(route('api.nfc_cards.update'), {
                    user_id: this.selectedNFC.user_id,
                    id: this.selectedNFC.id,
                    uid: this.selectedNFC.uid,
                    sak: this.selectedNFC.sak
                }).then(response => {
                    if(response.status === 200){
                        this.$notify({
                            title: 'Success',
                            message: 'NFC Card data has been changed!',
                            type: 'success'
                        });
                        this.dialogFormUpdateVisible = false
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
                axios.post(route('api.nfc_cards.store'), {
                    user_id: this.selectedNFC.user_id,
                    uid: this.selectedNFC.uid,
                    sak: this.selectedNFC.sak
                }).then(response => {
                    if(response.status === 200){
                        const client = response.data.data;
                        this.nfc_cards.push(client);
                        this.$notify({
                            title: 'Success',
                            message: 'NFC Card has been created!',
                            type: 'success'
                        });
                        this.dialogFormCreateVisible = false
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
            },
            delete(id, index){
                axios.delete(route('api.nfc_cards.delete',id)).then(response => {
                    if(response.status === 201){
                        this.nfc_cards.splice(index, 1);
                        this.$notify({
                            title: 'Warning',
                            message: 'NFC Card has been deleted!',
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
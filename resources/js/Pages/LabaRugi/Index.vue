<template>
    <Head title="Laba Rugi"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laba Rugi
            </h2>
        </template>

        <!-- Tabel Buku Besar -->
        <CardBody>

            <template v-slot:content>

                <table ref="dataTable" id="dataTable" class=" whitespace-nowrap" style="width: 1000px">
                    <thead>
                        <tr class="">
                            <th></th>
                            <th class="px-4 py-2">Kode Rekening</th>
                            <th class="px-4 py-2">Uraian</th>
                            <th class="px-4 py-2">Debit</th>
                            <th class="px-4 py-2">Kredit</th>
                        </tr>
                    </thead>
                </table>
            </template>

        </CardBody>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import CardBody from '@/Components/CardBody.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TahunFilter from "@/Components/TahunFilter.vue";
import BulanFilter from "@/Components/BulanFilter.vue";
import moment from "moment";
import $ from "jquery";
import DataTable from 'datatables.net-dt'

export default {
    components: {
        BulanFilter,
        TahunFilter,
        AuthenticatedLayout, Head, Link, Table, CardBody, PrimaryButton
    },

    props: {
        laba_rugi : Array
    },
    mounted() {

       try {
        const data = this.laba_rugi.map((item) => {
            return item
        })

        var childEditors = {};  // Globally track created chid editors
        var childTable;
        var childTable2;

        function format(rowData) {
                var childTable = '<table id="cl' + rowData.id + '" class="min-w-full table-auto rounded-lg" width="100%">' +
                    '<thead style="display:none"></thead >' +
                    '</table>';
                return $(childTable).toArray();
        }

        function format2(rowData) {
            var childTable = '<table id="mt' + rowData.id + '" class="min-w-full table-auto rounded-lg" width="100%">' +
                '<thead style="display:none"></thead >' +
                '</table>';
            return $(childTable).toArray();
        }


        const table = new DataTable('#dataTable',{
            pageLength:10,
            autoWidth: false,
            data: data,
            columns: [
                {
                    className: 'details-control bg-white border-b  border-gray-200 py-3',
                    orderable: false,
                    defaultContent: '',
                },
                { className: 'bg-white border-b  border-gray-200 py-3', data: 'level_one' },
                { className: 'bg-white border-b  border-gray-200 py-3', data: 'uraian_level' },
                {
                    className: 'bg-white border-b border-gray-200 py-3',
                    data: 'total_this_month',
                    defaultContent: '0',
                    render: (data, type, row)  => {
                        if (type === 'display' || type === 'filter') {
                            return this.formatRupiah(data);
                        }
                        return data; // Return raw data for ordering and searching
                    },
                },
                {
                    className: 'bg-white border-b border-gray-200 py-3',
                    data: 'total_till_this_month',
                    defaultContent: '0',
                    render: (data, type, row)  => {
                        if (type === 'display' || type === 'filter') {
                            return this.formatRupiah(data);
                        }
                        return data; // Return raw data for ordering and searching
                    },
                },
            ],
            order: [[1, 'asc']],
        })

        $('#dataTable tbody').on('click', 'td.details-control', function() {
            const tr = $(this).closest('tr');
            const row = table.row(tr);
            const rowData2 = row.data();
            
            const level2Data = rowData2.level_2

            if(level2Data){

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
    
                    // Destroy the Child Datatable
                    $('#cl' + rowData2.id).DataTable().destroy();
                }
                else {
                    // Open this row
                    row.child(format(rowData2)).show();
                    var id = rowData2.id;

                    childTable = $('#cl' + id).DataTable({
                            dom: "t",
                            data: level2Data,
                            columns: [
                                {
                                    className: 'details-control1 bg-white border-b  border-gray-200 py-3',
                                    orderable: false,
                                    data: null,
                                    defaultContent: ''
                                },
                                { className:'bg-white border-b  border-gray-200 py-3', data: 'level_two', defaultContent: '' },
                                { className:'bg-white border-b  border-gray-200 py-3', data: 'uraian_level', defaultContent: '' },
                                {
                                    className: 'bg-white border-b border-gray-200 py-3',
                                    data: 'total_this_month',
                                    defaultContent: '0',
                                    render: (data, type, row)  => {
                                        if (type === 'display' || type === 'filter') {
                                            if (!data) return 'Rp0';
                                            return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                        }
                                        return data; // Return raw data for ordering and searching
                                    },
                                },
                                {
                                    className: 'bg-white border-b border-gray-200 py-3',
                                    data: 'total_till_this_month',
                                    defaultContent: '0',
                                    render: (data, type, row)  => {
                                        if (type === 'display' || type === 'filter') {
                                            if (!data) return 'Rp0';
                                            return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                        }
                                        return data; // Return raw data for ordering and searching
                                    },
                                },
                            ],
                            columnDefs: [
                            
                            ],
                            select: false,
                        });
    
                        tr.addClass('shown');
    
                    
                }
            }

        });


        $('#dataTable tbody').on('click', 'td.details-control1', function() {
            const tr2 = $(this).closest('tr');
            const row3 = childTable.row(tr2);
            const rowData3 = row3.data();

            const level3Data = rowData3?.level_3??null
           
            if(level3Data){

                if (row3.child.isShown()) {
                    // This row is already open - close it
                    row3.child.hide();
                    tr2.removeClass('shown');
    
                    // Destroy the Child Datatable
                    $('#mt' + rowData3.id).DataTable().destroy();
                }
                else {
                    // Open this row
                    row3.child(format2(rowData3)).show();
                    var id = rowData3.id;
    
    
                    childTable2 = $('#mt' + id).DataTable({
                        dom: "t",
                        data: level3Data,
                        columns: [
                            {
                                orderable: false,
                                data: null,
                                defaultContent: '-'
                            },
                            { className:'bg-white border-b  border-gray-200 py-3', data: 'level_three', defaultContent: '' },
                            { className:'bg-white border-b  border-gray-200 py-3', data: 'uraian_level', 'defaultContent': 'Uraian tidak didefinisikan' },
                            {
                                className: 'bg-white border-b border-gray-200 py-3',
                                data: 'total_this_month',
                                defaultContent: '0',
                                render: (data, type, row)  => {
                                    if (type === 'display' || type === 'filter') {
                                        if (!data) return 'Rp0';
                                        return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                    }
                                    return data; // Return raw data for ordering and searching
                                },
                            },
                            {
                                className: 'bg-white border-b border-gray-200 py-3',
                                data: 'total_till_this_month',
                                defaultContent: '0',
                                render: (data, type, row)  => {
                                    if (type === 'display' || type === 'filter') {
                                        if (!data) return 'Rp0';
                                        return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                    }
                                    return data; // Return raw data for ordering and searching
                                },
                            },
                        ],
                        columnDefs: [
                        
                        ],
                        select: false,
                    });

                    tr2.addClass('shown');
    
                    
                }
            }

        });


        
       } catch (error) {
            throw error
       }
    },
    data() {
        return {
            bulan_ini: moment(moment()).endOf('month').format('DD MMMM YYYY'),
            sampai_bulan: moment(moment()).endOf('month').format('MMMM YYYY'),
            table: null
        }
    },
    methods: {
        formatRupiah(angka) {
            if (!angka) return 'Rp0';
            return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

    }
};
</script> -->

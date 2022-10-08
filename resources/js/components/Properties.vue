<template>
    <div class="col-12">
        <div class="card">
        <div class="card-body">
            <div class="row align-items-center mb-4">
            <div class="col-md-6">
                
            </div>
            <div class="col-md-6">
                <div class="all-tabs">
                <div class="d-flex align-items-center">
                    <svg
                    class="svg-inline--fa fa-table mx-2"
                    height="16px"
                    width="16px"
                    aria-hidden="true"
                    focusable="false"
                    data-prefix="fa"
                    data-icon="table"
                    role="img"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    data-fa-i2svg=""
                    >
                    <path
                        fill="currentColor"
                        d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM224 416H64v-96h160v96zm0-160H64v-96h160v96zm224 160H288v-96h160v96zm0-160H288v-96h160v96z"
                    ></path>
                    </svg>
                    <router-link
                    :to="{ name: 'add-property' }"
                    class="opt"
                    >Add Property
                    </router-link>
                </div>
                </div>
            </div>
            </div>
            <div class="table-responsive mb-0">
            <b-table
                striped
                bordered
                :items="tableData.data"
                :fields="fields"
                :per-page="0"
                :current-page="currentPage"
                :filter-included-fields="filterOn"
                @filtered="onFiltered"
                responsive="sm"
                class="table-bordered table-hover"
                :key="key"
            >
                <template v-slot:cell(image)="row">
                    <a target="_blank" :href="row.item.image"><img :src="row.item.image" width="100" class="thumbnail_img" alt="" /></a>
                </template>
                <template v-slot:cell(thumbnail)="row">
                    <a target="_blank" :href="row.item.thumbnail"><img :src="row.item.thumbnail" width="50" class="thumbnail_img" alt="" /></a>
                </template>
                <template v-slot:cell(edit)="row">
                <router-link
                    :to="{ name: 'edit-property', params: { id: row.item.id } }"
                >
                    Edit
                </router-link>
                </template>
                <template v-slot:cell(delete)="row">
                <div
                    @click.prevent="deleteProperty(row.item.id)" style="cursor: pointer;"
                >
                    Delete
                </div>
                </template>
            </b-table>
            </div>
            <div class="row">
            <div class="col">
                <div
                class="dataTables_paginate paging_simple_numbers d-flex justify-content-end"
                >
                <ul class="pagination pagination-rounded mb-0">
                    <b-pagination
                        v-model="currentPage"
                        :total-rows="tableData.total"
                        :total-pages="tableData.total_pages"
                        :per-page="tableData.per_page"
                    ></b-pagination>
                </ul>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
import property from "../mixins/property";

export default {
    name: "Properties",
    mixins: [property]
}
</script>
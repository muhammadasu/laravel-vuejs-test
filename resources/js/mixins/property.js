import { required } from "vuelidate/lib/validators";
import axios from "axios";

export default {
    data() {
        return {
            submitted: false,
            fields: [
                {
                key: "id",
                label: "ID",
                sortable: true,
                },
                {
                label: "Country",
                key: "country",
                },
                {
                label: "County",
                key: "county",
                },
                {
                label: "Town",
                key: "town",
                },
                {
                key: "description",
                label: "Description",
                },
                {
                key: "address",
                label: "Address",
                },
                {
                key: "image",
                label: "Image URL",
                },
                {
                key: "thumbnail",
                label: "Thumbnail URL",
                },
                {
                key: "bedrooms",
                label: "Bedrooms",
                },
                {
                key: "bathrooms",
                label: "Bathrooms",
                },
                {
                key: "price",
                label: "Price",
                },
                {
                key: "property_type_title",
                label: "Property Type",
                },
                {
                key: "type",
                label: "Type",
                },
                {
                key: "edit",
                },
                {
                key: "delete",
                },
            ],
            form: {
                county: '',
                country: '',
                town: '',
                postcode: '',
                description: '',
                address: '',
                image: '',
                bedrooms: '',
                bathrooms: '',
                price: 0,
                property_type: '',
                type: '',
                source: 'web',
            },
            filterOn: [],
            tableData: [],
            sortBy: "id",
            sortDesc: true,
            key: 0,
            currentPage: 1,
            bedrooms: [
                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15
            ],
            bathrooms: [
                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15
            ],
            property_type: []
        }
    },
    validations: {
        form: {
            county: { required },
            country: { required },
            town: { required },
            postcode: { required },
            description: { required },
            address: { required },
            image: { required },
            bedrooms: { required },
            bathrooms: { required },
            price: { required },
            property_type: { required },
            type: { required },
        },
    },
    methods: {
        makeToast(variant = null, body = 'Something Went Wrong.') {
            this.$bvToast.toast(body, {
                title: `Variant ${variant || 'default'}`,
                variant: variant,
                solid: true
            })
        },
        onFiltered(filteredItems) {
          this.totalRows = filteredItems.length;
          this.currentPage = 1;
        },
        readFile(e) {
            if (e.target.files[0].size > 2 * 1000 * 1000) {
                this.makeToast("danger","Uploaded File is More than 2MB");
                this.$refs.image.reset();
            } else {
                this.form.image = e.target.files[0];
            }
        },
        async fetchProperty(page = null) {
            let url = '/properties';
            if (this.$route.name == "edit-property") {
                url = '/properties/'+this.$route.params.id;
            } else if(page != null && page != ''){
                url = '/properties?page='+page;
            }

            await axios.get(url).then((response) => {
                if (this.$route.name == "edit-property") {
                    this.form.county = response.data.data.county;
                    this.form.country = response.data.data.country;
                    this.form.town = response.data.data.town;
                    this.form.postcode = response.data.data.postcode;
                    this.form.description = response.data.data.description;
                    this.form.address = response.data.data.address;
                    this.form.image = response.data.data.image;
                    this.form.bedrooms = response.data.data.bedrooms;
                    this.form.bathrooms = response.data.data.bathrooms;
                    this.form.price = response.data.data.price;
                    this.form.property_type = response.data.data.property_type;
                    this.form.type = response.data.data.type;
                    this.form.source = response.data.data.source;
                } else {
                    this.tableData = response.data.data;
                }
            }).catch((err) => {
                this.makeToast("danger",err.response.data.message);
            })
        },
        async Property() {
            try {
                this.submitted = true;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    this.makeToast("danger","Please Fill The Required Fields");
                    return false;
                }
                
                let formData = new FormData();
                let url = '/properties';
                
                if (this.$route.name == "edit-property") {
                    url = '/properties/'+this.$route.params.id;
                    formData.append('_method', 'PUT');
                }

                if (this.$refs.image.files.length > 0) {
                    formData.append('image', this.form.image); 
                }

                for (var key in this.form) {
                    if(key != 'image') {
                        formData.append(key, this.form[key]);
                    }
                }

                await axios.post(url, formData).then((response) => {
                    if (response.data.status) {
                        this.makeToast("success",response.data.message);
                        this.$router.push("/");
                    }
                }).catch((err) => {
                    if (err.response.status == "422") {
                        let error = err.response.data.response;
                        if(!err.response.data.response) {
                          error = JSON.parse(err.response.data.message);
                        }
                        for (let [key, value] of Object.entries(
                            error
                        )) {
                          this.makeToast("danger",value);
                        }
                    } else {
                        this.makeToast("danger",err.response.data.message);
                    }
                })
            } catch (err) {
                this.makeToast("danger","Please try again!");
            }
        },
        async deleteProperty(id) {
            if(confirm("Do you really want to delete?")){
                let url = '/properties/'+id;
                let formData = new FormData();
                formData.append('_method', 'DELETE');

                await axios.post(url,formData).then((response) => {
                    this.makeToast("success",response.data.message);
                    let index = this.tableData.data.findIndex((e) => e.id === id);
                    this.tableData.data.splice(index, 1);
                }).catch((err) => {
                    this.makeToast("danger",err.response.data.message);
                })
            }
        },
        async fetchPropertyTypes() {
            await axios.get('/property-types').then((response) => {
                this.property_type = response.data.data.data;
            }).catch((err) => {
                this.makeToast("danger",err.response.data.message);
            })
        }
    },
    watch: {
        currentPage: {
          handler: function (value) {
            this.fetchProperty(value);
          },
        },
    },
    mounted() {
        Promise.all([this.fetchProperty(), this.fetchPropertyTypes()]);
        // this.fetchProperty();
        // this.fetchPropertyTypes();
    },
};
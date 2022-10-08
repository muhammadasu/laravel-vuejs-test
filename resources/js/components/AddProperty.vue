<template>
  <div class="row">
    <div class="col-12">
        <div class="card">
          <div class="card-body">
            <b-form
              enctype="multipart/form-data"
            >
              <b-form-group>
                <label for="input-1">County <span style="color: red">*</span></label>
                <b-form-input
                  id="input-1"
                  v-model="form.county"
                  placeholder="Enter County"
                  :class="{
                    'is-invalid': submitted && $v.form.county.$error,
                  }"
                ></b-form-input>
                <div v-if="submitted && !$v.form.county.required" class="invalid-feedback">
                  County is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label for="input-1">Country <span style="color: red">*</span></label>
                <b-form-input
                  id="input-1"
                  v-model="form.country"
                  placeholder="Enter Country"
                  :class="{
                    'is-invalid': submitted && $v.form.country.$error,
                  }"
                ></b-form-input>
                <div v-if="submitted && !$v.form.country.required" class="invalid-feedback">
                  Country is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label for="input-2">Town <span style="color: red">*</span></label>
                <b-form-input
                  id="input-2"
                  v-model="form.town"
                  placeholder="Enter Town"
                  :class="{
                    'is-invalid': submitted && $v.form.town.$error,
                  }"
                ></b-form-input>
                <div v-if="submitted && !$v.form.town.required" class="invalid-feedback">
                  Town is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label for="input-3">Post Code <span style="color: red">*</span></label>
                <b-form-input
                  id="input-3"
                  v-model="form.postcode"
                  placeholder="Enter Post Code"
                  :class="{
                    'is-invalid': submitted && $v.form.postcode.$error,
                  }"
                ></b-form-input>
                <div v-if="submitted && !$v.form.postcode.required" class="invalid-feedback">
                  Post Code is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label for="textarea">Description <span style="color: red">*</span></label>
                <b-form-textarea
                  id="textarea"
                  v-model="form.description"
                  placeholder="Enter Description"
                  :class="{
                    'is-invalid': submitted && $v.form.description.$error,
                  }"
                ></b-form-textarea>
                <div v-if="submitted && !$v.form.description.required" class="invalid-feedback">
                  Description is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label for="input-4">Address <span style="color: red">*</span></label>
                <b-form-input
                  id="input-4"
                  v-model="form.address"
                  placeholder="Enter Address"
                  :class="{
                    'is-invalid': submitted && $v.form.address.$error,
                  }"
                ></b-form-input>
                <!-- <vue-google-autocomplete
                  ref="address"
                  id="map"
                  classname="form-control"
                  placeholder="Please type your address"
                  v-on:placechanged="getAddressData"
                  v-model="form.address"
                  :class="{
                    'is-invalid': submitted && $v.form.address.$error,
                  }"
                >
                </vue-google-autocomplete> -->
                <div v-if="submitted && !$v.form.address.required" class="invalid-feedback">
                  Address is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label>Image <span style="color: red">*</span></label>
                <b-form-file
                  id="image"
                  ref="image"
                  accept="image/*"
                  :class="{
                  'is-invalid': submitted && $v.form.image.$error,
                }"
                  placeholder="Choose a file or drop it here..."
                  @change="readFile($event)">
                </b-form-file>
                <div v-if="submitted && !$v.form.image.required" class="invalid-feedback">
                  Image is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label>Number of bedrooms <span style="color: red">*</span></label>
                <b-form-select 
                v-model="form.bedrooms" 
                :options="bedrooms"
                :class="{
                  'is-invalid': submitted && $v.form.bedrooms.$error,
                }"
                ></b-form-select>
                <div v-if="submitted && !$v.form.bedrooms.required" class="invalid-feedback">
                  Number of bedrooms is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label>Number of bathrooms <span style="color: red">*</span></label>
                <b-form-select 
                v-model="form.bathrooms" 
                :options="bathrooms"
                :class="{
                  'is-invalid': submitted && $v.form.bathrooms.$error,
                }"
                ></b-form-select>
                <div v-if="submitted && !$v.form.bathrooms.required" class="invalid-feedback">
                  Number of bathrooms is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label for="input-4">Price <span style="color: red">*</span></label>
                <b-form-input
                  type="number"
                  min="1"
                  id="input-4"
                  v-model="form.price"
                  placeholder="Enter Price"
                  :class="{
                    'is-invalid': submitted && $v.form.price.$error,
                  }"
                ></b-form-input>
                <div v-if="submitted && !$v.form.price.required" class="invalid-feedback">
                  Price is required.
                </div>
              </b-form-group>

              <b-form-group>
                <label>Property Type <span style="color: red">*</span></label>
                <b-form-select 
                v-model="form.property_type" 
                :options="property_type"
                :class="{
                  'is-invalid': submitted && $v.form.property_type.$error,
                }"
                ></b-form-select>
                <div v-if="submitted && !$v.form.property_type.required" class="invalid-feedback">
                  Property Type is required.
                </div>
              </b-form-group>
              
              <b-form-group class="col-md-12">
                <label>Type <span style="color: red">*</span></label>
                <b-form-radio
                  id="checkbox-1"
                  v-model="form.type"
                  name="checkbox-1"
                  value="sale"
                  :class="{
                    'is-invalid': submitted && $v.form.type.$error,
                  }"
                >
                For Sale
                </b-form-radio>

                <b-form-radio
                  id="checkbox-2"
                  v-model="form.type"
                  name="checkbox-1"
                  value="rent"
                  :class="{
                    'is-invalid': submitted && $v.form.type.$error,
                  }"
                >
                For Rent
                </b-form-radio>
                <div v-if="submitted && !$v.form.type.required" class="invalid-feedback">
                  Type is required.
                </div>
              </b-form-group>
              
              <b-button
                type="submit"
                variant="primary"
                class="mr-2"
                @click.prevent="Property"
                >{{ $route.name == 'edit-property' ? 'Update Property' : 'Add Property' }}
                </b-button>  
            </b-form>
          </div>
        </div>
    </div>
  </div>
</template>

<script>

import property from "../mixins/property";

export default {
  name:"Add-Property",
  mixins: [property]
}
</script>
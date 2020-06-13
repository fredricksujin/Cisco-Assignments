<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sapId'), 'has-success': fields.sapId && fields.sapId.valid }">
    <label for="sapId" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.router.columns.sapId') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sapId" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sapId'), 'form-control-success': fields.sapId && fields.sapId.valid}" id="sapId" name="sapId" placeholder="{{ trans('admin.router.columns.sapId') }}" maxlength = 16>
        <div v-if="errors.has('sapId')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sapId') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('hostname'), 'has-success': fields.hostname && fields.hostname.valid }">
    <label for="hostname" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.router.columns.hostname') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.hostname" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('hostname'), 'form-control-success': fields.hostname && fields.hostname.valid}" id="hostname" name="hostname" placeholder="{{ trans('admin.router.columns.hostname') }}">
        <div v-if="errors.has('hostname')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('hostname') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('loopback'), 'has-success': fields.loopback && fields.loopback.valid }">
    <label for="loopback" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.router.columns.loopback') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.loopback" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('loopback'), 'form-control-success': fields.loopback && fields.loopback.valid}" id="loopback" name="loopback" placeholder="{{ trans('admin.router.columns.loopback') }}">
        <div v-if="errors.has('loopback')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('loopback') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('mac_address'), 'has-success': fields.mac_address && fields.mac_address.valid }">
    <label for="mac_address" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.router.columns.mac_address') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.mac_address" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('mac_address'), 'form-control-success': fields.mac_address && fields.mac_address.valid}" id="mac_address" name="mac_address" placeholder="{{ trans('admin.router.columns.mac_address') }}">
        <div v-if="errors.has('mac_address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('mac_address') }}</div>
    </div>
</div>



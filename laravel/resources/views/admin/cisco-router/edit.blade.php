@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.cisco-router.actions.edit', ['name' => $ciscoRouter->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <cisco-router-form
                :action="'{{ $ciscoRouter->resource_url }}'"
                :data="{{ $ciscoRouter->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.cisco-router.actions.edit', ['name' => $ciscoRouter->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.cisco-router.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </cisco-router-form>

        </div>
    
</div>

@endsection
import AppForm from '../app-components/Form/AppForm';

Vue.component('router-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                sapId:  '' ,
                hostname:  '' ,
                loopback:  '' ,
                mac_address:  '' ,
                
            }
        }
    }

});
import AppForm from '../app-components/Form/AppForm';

Vue.component('cisco-router-form', {
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
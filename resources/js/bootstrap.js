import axios from 'axios';
import jQuery from 'jquery';
import Sweetalert2 from 'sweetalert2';
import _ from 'lodash';

window.axios = axios;
window._= _;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



//import "admin-lte/plugins/jquery/jquery";
window.Swal = Sweetalert2;
window.$ = jQuery;
import "admin-lte/plugins/bootstrap/js/bootstrap.bundle";
import "admin-lte/dist/js/adminlte";
import "admin-lte/plugins/select2/js/select2.full"

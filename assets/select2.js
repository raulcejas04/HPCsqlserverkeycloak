const $ = require('jquery');

import './styles/select2.scss';

//import select2 from 'select2/dist/js/select2';
require('select2');

console.log('select2');

$(document).ready(function () {
  $(".select2-single").select2();
  $(".select2-responsive").select2({
    width: 'resolve' // need to override the changed default
  });

});





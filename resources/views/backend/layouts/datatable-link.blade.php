@push('style')
  <link rel="stylesheet" href="{{url('backend')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="{{ url('backend/plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('script')
<script src="{{url('backend')}}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{url('backend')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
{{-- <script src="{{ asset('backend/dist/js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('backend/dist/js/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/dist/js/datatables/buttons.html5.min.js') }}"></script> --}}
<script type="text/javascript" src="{{ url('backend/dist/js/sweetalert.min.js') }}"></script>
<script type="text/javascript" src="{{ url('backend/dist/js/datatable.base.js') }}"></script>
@endpush
@extends('admin.layouts.app')
@section('title','Manajemen Penarikan Dana')
@section('plugincss')
	<link rel="stylesheet" type="text/css" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
	<div class="row">
		<div class="col">
	    <div class="card">
	    	<div class="card-block">	
	    		<div class="row">
	    			<div class="col-md-12 mb-4 ">
	    				<h4 class="float-left">Manajemen Penarikan Dana</h4>
	    				
	    			</div>
	    		</div>    	
						<table class="table table-striped table-bordered" id="withdraw-table" style="width: 100% !important">
						<thead class="thead-inverse">
							<tr >
								<th>ID</th>
								<th>Judul Campaign</th>
                <th>Item</th>
                <th>Jumlah</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
	    	</div>
			</div>
		</div>
	</div>
  @include('admin.components.withdraw.modal')
  @include('admin.components.withdraw.modal-action')
@endsection
@section('pluginjs')
	<script type="text/javascript" src="{{asset('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
@endsection
@section('viewjs')

	<script type="text/javascript">
		//Handling Datatbles
    
    $('#withdraw-table').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": {
        'url': '{{ route("admin.getWithdrawFinances") }}',
        'type': 'GET',
        'headers': {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
      },
      "columns": [
          { data: 'id', name: 'id' },
          { data: 'campaign_title', name: 'campaign_title' },
          { data: 'item', name: 'item' },
          { data: 'amount', name: 'amount' },
          { data: 'action', name: 'action', orderable: false, searchable: false}
      ],
      "language": {
          "decimal":        "",
          "emptyTable":     "Tidak ada data",
          "info":           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
          "infoEmpty":      "Tidak ada data",
          "infoFiltered":   "(Disaring dari _MAX_ data)",
          "infoPostFix":    "",
          "thousands":      ",",
          "lengthMenu":     "Tampilkan _MENU_ data",
          "loadingRecords": "Loading...",
          "processing":     "Loading...",
          "search":         "Cari:",
          "zeroRecords":    "Tidak ada data yang sesuai",
          "paginate": {
              "first":      "First",
              "last":       "Last",
              "next":       "Next",
              "previous":   "Previous"
          }
      }
    });
	</script>
  <script type="text/javascript">
  $(document).ready(function(){

  $('#infoWithdraw').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      console.log(id);
      
    $.ajax(
      {
          url: '{{ route("admin.index")}}/withdraw/finance/'+id+'/show/',
          type: "GET",
          beforeSend: function()
          {
              $('#detailWithdraw').html('<h1 class="text-center"><i class="fa fa-spinner fa-pulse"></i>&nbsp; Memuat...</h1>');
          }
      })
      .done(function(data)
      {
        console.log(data);
          console.log(data);
          $("#detailWithdraw").html(data.html);
      })
      .fail(function(ajaxOptions, thrownError)
      {
        // console.log(jqXHR.status);
       console.log(thrownError);
          $("#detailWithdraw").html('<h2 class="text-center text-muted"><span class="icon-ghost mb-3"></span><br>Gagal Mengambil Data</h2>');
      });



     
  });   
  });
  
  </script>
   <script type="text/javascript">
  $(document).ready(function(){

    $('#actionWithdraw').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var typeRequest = button.data('action');
      console.log(id);
      if(typeRequest == "accept"){
        $('#btnAccept').show();
        $('#btnReject').hide();
        $('#detailAction').html('<center>Yakin ingin konfirmasi permintaan penarikan ini?</center>');
      }else if (typeRequest == "reject"){
        $('#btnReject').show();
        $('#btnAccept').hide();
        $('#detailAction').html('<center>Yakin ingin menolak permintaan penarikan ini?</center>');
      }
      
      

       $('.confirm').click(function(){
        $('.confirm').hide();
        var request = {
          'id': id,
          'type': typeRequest,
          'addition' : $('textarea#inputAddition').val()
        };

        console.log(request);

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        
        $.ajax(
        {
          url: '{{ route("admin.confirmWithdrawFinance")}}',
          data: request,
          type: "POST",
          beforeSend: function()
            {
              $('#detailAction').html('<h5 class="text-center"><i class="fa fa-spinner fa-pulse"></i>&nbsp; Mohon Menunggu...</h5>');
              $('#inputAddition').hide();
            }
        })
        .done(function(data)
        {
          console.log(data);
          $("#detailAction").html('<h5 class="text-center text-success"><span class="icon-check mb-3"></span><br> Permintaan penarikan berhasil '+data.message+'</h5>');
          $('#withdraw-table').DataTable().ajax.reload();
        })
        .fail(function(ajaxOptions, thrownError)
        {
         console.log(thrownError);
          $("#detailAction").html('<h5 class="text-center text-muted"><span class="icon-ghost mb-3"></span><br> Proses Gagal</h5>');
        });

       });


      
      
      });   
    });
    
  </script>
@endsection
<div class="jumbotron jumbotron-fluid mb-0 bg-white">
  <div class="container">
  <div class="row">
    <div class="col-md-12 col-sm-12">
      
      <h1 class="display-5 mb-3">Beasiswa untuk NTT</h1>
    </div>
    <div class="col-md-9 col-sm-12">
      <div class="media mb-3">
          <img class="d-flex align-self-center mr-3 rounded-circle" style="max-width: 48px; " @if( $campaign->user->profile_img !=null) src="{{ asset('img/avatars/')}}/{{ $campaign->user->profile_img }}" @else src="{{ asset('img/primary.png' )}}" @endif alt="Generic placeholder image" >
          <div class="media-body">
            <p class="h6 text-bold mt-2">
                {{ $campaign->user->name }} @if ($campaign->user->isVerified(true)) 
                <i class="icon-check text-primary"></i> 
                @endif<br>
              <small class="text-muted text-uppercase">campaigner</small>
              </p>
          </div>
        </div>
      <p class="lead">{{ $campaign->subtitle }}</p>

    </div>
    <div class="col-md-3 col-sm-12">
      <h3 class="mb-3">Membutuhkan</h3>

      <table class="table table-sm table-bordered" >
          <tbody>
               @foreach($campaign->supportType as $st)
              <tr>
                  <td class="bg-inverse">{{ $st->pivot->item }}</td>
                  <td>@if($st->pivot->item == "Dana") Rp. @endif {{ $st->pivot->amount }}</td>
              </tr>            
              @endforeach
          </tbody>
      </table>
      
      <h6 class="mt-3 mb-3">Progress Finansial</h6>
      @include('components.progress')
      <h6 class="mt-3">
        <i class="icon-calendar"></i>&nbsp; Deadline 
          <span class="text-bold text-danger"><?php echo date('d M Y', strtotime($campaign->deadline)); ?></span>
        </h6>
    </p>
    </div>
  </div>
    
  </div>
</div>
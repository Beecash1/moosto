@extends('backend.layouts.app')

@section('content')

    <div class="">
        <div class="row ">
            <div class="col-md-6">
              
            </div>
            <div class="col-md-6 mt-3 mt-sm-0 text-center text-md-right">
                <a href="{{ route('addons.create')}}" class="btn btn-primary">{{ translate('Install/Update Addon')}}</a>
            </div>
        </div>
    </div>
    <br>
    <div class="tab-content">
        <div class="tab-pane fade in active show" id="installed">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse(\App\Addon::all() as $key => $addon)
                                    <li class="list-group-item">
                                        
                                    </li>
                                @empty
                                    <li class="list-group-item">
                                        <div class="text-center">
                                            <img class="mw-100 h-200px" src="{{ static_asset('assets/img/nothing.svg') }}" alt="Image">
                                            <h5 class="mb-0 h5 mt-3">{{ translate('No Addon Installed')}}</h5>
                                        </div>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="available">
            <div class="row" id="available-addons-content">

            </div>
        </div>
    </div>




@endsection

@section('script')
    <script type="text/javascript">
        function updateStatus(el, id){
            if($(el).is(':checked')){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('addons.activation') }}', {_token:'{{ csrf_token() }}', id:id, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        $(document).ready(function(){
            $.post('https://activeitzone.com/addons/public/addons', {item: 'ecommerce'}, function(data){
                //console.log(data);
                html = '';
                data.forEach((item, i) => {
                    if(item.link != null){
                        html += `<div class="col-lg-4 col-md-6 ">
                                    <div class="card addon-card">
                                        <div class="card-body">
                                            <a href="${item.link}" target="_blank"><img class="img-fluid" src="${item.image}"></a>
                                            <div class="pt-4">
                                                <a class="fs-16 fw-600 text-reset" href="${item.link}" target="_blank">${item.name}</a>
                                                <div class="rating mb-2"><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i></div>
                                                <p class="mar-no text-truncate-3">${item.short_description}</p>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-danger fs-22 fw-600">$${item.price}</div>
                                            <div class=""><a href="${item.link}" target="_blank" class="btn btn-sm btn-secondary">Preview</a> <a href="${item.purchase}" target="_blank" class="btn btn-sm btn-primary">Purchase</a></div>
                                        </div>
                                    </div>
                                </div>`;
                    }
                    else {
                        html += `<div class="col-lg-4 col-md-6 ">
                                    <div class="card addon-card">
                                        <div class="card-body">
                                            <a><img class="img-fluid" src="${item.image}"></a>
                                            <div class="pt-4">
                                                <a class="fs-16 fw-600 text-reset" >${item.name}</a>
                                                <div class="rating mb-2"><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i><i class="la la-star active"></i></div>
                                                <p class="mar-no text-truncate-3">${item.short_description}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-center"><div class="btn btn-outline btn-primary">Coming Soon</div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                    }

                });
                $('#available-addons-content').html(html);
            });
        })
    </script>
@endsection

@extends('user.layouts.app')

@section('content')
  <!-- Content Wrapper Starts -->
        <div class="content-wrapper">
            <div class="container">
                <div class="tracking p-30">
                    <!-- Tracking Top Starts -->
                    <div class="tracking-top">
                        <div class="" id="my_map" style="width: 100%; height: 400px;"></div>
                         <form  action="{{url('restaurants')}}" id="my_map_form_current" >
                                <input type="hidden" id="pac-input_cur" class="form-control search-loc-form" placeholder="Search for area,street name..." name="search_loc" value="{{ old('latitude') }}" >
                                <input type="hidden" id="latitude" name="latitude" value="{{$Order->shop->latitude}}" readonly >
                                <input type="hidden" id="longitude" name="longitude" value="{{$Order->shop->longitude}}" readonly >
                                
                            </form>
                        <!-- Tracking Details Starts -->
                        <div class="tracking-details">
                            <!-- Tracking Box Starts -->
                            <div class="tracking-box">
                                <p class="track-txt">@lang('user.create.order') #{{$Order->id}}</p>
                                <h6 class="track-tit">{{$Order->shop->name}}</h6>
                                <p class="track-txt">{{date('h:i A')}} | {{count($Order->items)}} Items | {{currencydecimal($Order->invoice->payable)}}</p>
                            </div>
                            <!-- Tracking Box Ends -->
                            <!-- Tracking Box Starts -->
                             <div class="tracking-box ORDERED @if($Order->status == 'ORDERED') active @endif ">
                                <h6 class="track-tit m-0 " >@lang('user.create.order_created')</h6>
                            </div>
                            <div class="tracking-box RECEIVED @if($Order->status == 'RECEIVED') active @endif ">
                                <h6 class="track-tit m-0 " >@lang('user.create.order_received')</h6>
                            </div>
                            <!-- Tracking Box Ends -->
                            <!-- Tracking Box Starts -->
                            <div class="tracking-box PROCESSING @if($Order->status == 'PROCESSING') active @endif ">
                                <h6 class="track-tit  ">@lang('user.create.order_confirmed')</h6>
                               
                            </div>
                            <!-- Tracking Box Ends -->
                            <!-- Tracking Box Starts -->
                            <div class="tracking-box COMPLETED @if($Order->status == 'COMPLETED') active @endif ">
                                <h6 class="track-tit ">@lang('user.create.order_delivered')</h6>
                            </div>
                            <!-- Tracking Box Ends -->
                        </div>
                        <!-- Tracking Details Ends -->
                    </div>
                    <!-- Tracking Top Ends -->
                    <!-- Tracking Bottom Starts -->
                    <div class="tracking-btm">
                        <h5>@lang('user.create.order_details')</h5>
                        <div class="row">
                            <!-- Tracking Left Starts -->
                            <div class="tracking-btm-left col-md-6">
                                <!-- Invoice Location Starts -->
                                <div class="tracking-location">
                                    <!-- Tracking Box Starts -->
                                    <div class="tracking-sec-box row m-0">
                                        <div class="tracking-sec-box-left icon-left pull-left">
                                            <i class="ion-ios-location-outline"></i>
                                        </div>
                                        <div class="tracking-sec-box-right icon-right">
                                            <span>@lang('user.create.from')</span>
                                            <h6 class="icon-tit">{{$Order->shop->name}}</h6>
                                            <p class="icon-txt">{{$Order->shop->maps_address}}</p>
                                        </div>
                                    </div>
                                    <!-- Tracking Box Ends -->
                                    <!-- Tracking Box Starts -->
                                    <div class="tracking-sec-box row m-0">
                                        <div class="tracking-sec-box-left icon-left pull-left">
                                            <i class="ion-ios-location-outline"></i>
                                        </div>
                                        <div class="tracking-sec-box-right icon-right">
                                            <span>@lang('user.create.deliverd_to')</span>
                                            <h6 class="icon-tit">{{$Order->address->type}}</h6>
                                            <p class="icon-txt">{{$Order->address->building}} {{$Order->address->landmark}}{{$Order->address->map_address}}</p>
                                        </div>
                                    </div>
                                    <!-- Tracking Box Ends -->
                                </div>
                                <!-- Tracking Location Ends -->
                            </div>
                            <!-- Tracking Left Ends -->
                            <!-- Tracking Right Starts -->
                            <div class="tracking-btm-right col-md-6">
                                <!-- Invoice Order Items Starts -->
                                <div class="tracking-order-items">
                                    <h6 class="invoice-table-tit">{{count($Order->items)}} @lang('user.create.items')<</h6>
                                    <table class="table table-responsive track-table">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        <?php $tot_gross=0;?>
                                            @forelse($Order->items as $item)
                                             <?php $tot_gross += $item->quantity*$item->product->prices->orignal_price;  ?>
                                            <tr>
                                                <th scope="row">
                                                    <div class="row m-0">
                                                        @if($item->product->food_type=='veg')
                                                        <img src="{{asset('assets/user/img/veg.jpg')}}" class="veg-icon">
                                                        @else
                                                        <img src="{{asset('assets/user/img/non-veg.jpg')}}" class="veg-icon">
                                                        @endif
                                                        <div class="food-menu-details">
                                                            <h5>{{$item->quantity}}X{{$item->product->name}}</h5>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td class="text-right">
                                                    <p>{{currencydecimal($item->quantity*$item->product->prices->orignal_price)}}</p>
                                                </td>
                                            </tr>
                                            @empty
                                            @endforelse
                                           
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>@lang('user.create.item_total')</td>
                                                <td class="text-right">{{currencydecimal($tot_gross)}}</td>
                                            </tr>
                                            
                                             <tr>
                                                <td>@lang('user.create.discount')</td>
                                                <td class="text-right">{{currencydecimal($Order->invoice->discount)}}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('user.create.tax') ({{Setting::get('tax')}}%)</td>
                                                <td class="text-right">{{currencydecimal($Order->invoice->tax)}}</td>
                                            </tr>
                                            <tr>
                                                <td>@lang('user.create.delivery_charges') </td>
                                                <td class="text-right">{{currencydecimal(Setting::get('delivery_charge'))}}</td>
                                            </tr>
                                            @if($Order->invoice->promocode_id)
                                            <tr>
                                                <td>@lang('user.create.promocode_discount')</td>
                                                <td class="text-right">{{currencydecimal($Order->invoice->promocode_amount)}}</td>
                                            </tr>
                                            @endif
                                            @if($Order->invoice->wallet_amount)
                                            <tr>
                                                <td>@lang('user.create.wallet_amount')</td>
                                                <td class="text-right">{{currencydecimal($Order->invoice->wallet_amount)}}</td>
                                            </tr>
                                            @endif
                                            <tr class="final-pay">
                                                <th>@lang('user.create.to_pay')</th>
                                                <th class="text-right">{{currencydecimal($Order->invoice->payable)}}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- Invoice Order Items Ends -->
                            </div>
                            <!-- Tracking Right Ends -->
                        </div>
                    </div>
                    <!-- Tracking Bottom Ends -->
                </div>
            </div>
        </div>
        <!-- Content Wrapper Ends -->
        <div id="container"></div>
         <input type="button" id="routebtn" value="route" style="display:none"  />
@endsection
@section('styles')
<style type="text/css">
    .active{
        background-color: Pink;: 
    }
</style>
@endsection
@section('scripts')

@if($Order->status == 'CANCELLED' || $Order->status == 'COMPLETED')
        <script type="text/javascript">
            window.onload = function() {
                setTimeout(function() {
                    $('#routebtn').trigger('click');
                }, 3000);
                
             };
        </script>
    @else

    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>

    <script type="text/jsx">
    var order = '';  var curstatus = '';
        var MainComponent = React.createClass({
            getInitialState: function () {
                    return {data: [], currency : "{{Setting::get('currency')}}"};
                },
            componentDidMount: function(){
                $.ajax({
                  url: "{{url('track/order/'.Request::segment(2))}}",
                  type: "GET"})
                  .done(function(response){

                        this.setState({
                            data:response.data
                        });

                    }.bind(this));

                    setInterval(this.checkRequest, 5000);
            },
            checkRequest : function(){
                $.ajax({
                  url: "{{url('track/order/'.Request::segment(2))}}",
                  type: "GET"})
                  .done(function(response){
                  
                        this.setState({
                            data:response
                        });

                    }.bind(this));
            },
            render: function(){
                return (
                    <div>
                        <SwitchState checkState={this.state.data} currency={this.state.currency} />
                    </div>
                );
            }
        });

        

        var SwitchState = React.createClass({

            componentDidMount: function() {
                this.changeLabel;
            },

            changeLabel : function(){
                if(this.props.checkState == undefined){
                   // window.location.reload();
                }else if(this.props.checkState != ""){ 
                    order = this.props.checkState;
                    if(curstatus != this.props.checkState.status){
                     $('#routebtn').trigger('click');
                     curstatus = this.props.checkState.status;
                    }
                    $('.tracking-box').removeClass('active');
                    $("."+this.props.checkState.status).addClass("active");
                    if(this.props.checkState.status=='COMPLETED'){
                        $('#rating_review').show();
                    }else{
                        $('#rating_review').hide();
                    }
                    setTimeout(function(){
                        //$('.rating').rating();
                    },400);

                }else{
                    $("#ride_status").text('Text will appear here');
                }
            },
            render: function(){

               

                    this.changeLabel();
                   
                    return ( 
                        <p></p>
                     );
                
            }
        });
        React.render(<MainComponent/>,document.getElementById("container"));

    @endif
    </script>


@endsection
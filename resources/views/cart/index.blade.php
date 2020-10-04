@extends('layouts.master')

@section('extra-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    @if (Cart::count()>0)

<div class="px-4 px-lg-0">


    <div class="pb-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

            <!-- Shopping cart table -->
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="border-0 bg-light">
                      <div class="p-2 px-3 text-uppercase">Product</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Price</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Quantity</div>
                    </th>
                    <th scope="col" class="border-0 bg-light">
                      <div class="py-2 text-uppercase">Remove</div>
                    </th>
                  </tr>
                </thead>
                <tbody>

                    @foreach (Cart::content() as $product)
                    <tr>
                        <th scope="row" class="border-0">
                          <div class="p-2">
                            <img src="{{ asset('storage/'.$product->model->image) }}" alt="" width="70" class="img-fluid rounded shadow-sm">
                            <div class="ml-3 d-inline-block align-middle">
                              <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">{{ $product->model->title }}</a></h5><span class="text-muted font-weight-normal font-italic d-block">Category:

                                @foreach ($product->model->categories as $category)
                                    {{ $category->name }}
                                 @endforeach
                              </span>
                            </div>
                          </div>
                        </th>
                        <td class="border-0 align-middle"><strong>{{ getPrice($product->subtotal()) }}</strong></td>
                        <td class="border-0 align-middle"><strong>
                            <select name="qty" id="qty" data-id="{{ $product->rowId }}" data-stock="{{ $product->model->stock }}" class="custom-select">
                                @for ($i = 1; $i <=  6; $i++)
                                    <option value="{{ $i }}"  {{ $i== $product->qty ? 'selected' :'' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </strong></td>
                        <td class="border-0 align-middle">

                            <form action="{{ route("cart.destroy",$product->rowId) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn text-red"><i class="fa fa-trash"></i></button>
                            </form>

                        </td>
                      </tr>
                    @endforeach


                </tbody>
              </table>
            </div>
            <!-- End -->
          </div>
        </div>

        <div class="row py-5 p-4 bg-white rounded shadow-sm">
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
            @if (!request()->session()->has('coupon'))
            <div class="p-4">
                <p class="font-italic mb-4">If you have a coupon code, please enter it in the box below</p>
                <form action="{{ route('cart.store.coupon') }}" method="POST">
                <div class="input-group mb-4 border rounded-pill p-2">
                      @csrf
                      <input type="text" placeholder="Entrez votre code ici" name="code" aria-describedby="button-addon3" class="form-control border-0">
                      <div class="input-group-append border-0">
                        <button id="button-addon3" type="submit" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Apply coupon</button>
                      </div>
                  </div>
              </form>
              </div>
            @else
              <div class="p-4">
                <p class="font-italic mb-4">Un coupon est deja applique</p>

              </div>

            @endif
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Instructions pour le vendeur</div>
            <div class="p-4">
              <p class="font-italic mb-4">Si vous souhaitez ajouter des précisions à votre commande, merci de les rentrer dans le champ ci-dessous</p>
              <textarea name="" cols="30" rows="2" class="form-control"></textarea>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Details de la commande </div>
            <div class="p-4">
              <p class="font-italic mb-4">Les frais éventuels de livraison seront calculés suivant les informations que vous avez transmises.</p>
              <ul class="list-unstyled mb-4">
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Sous-total </strong><strong>{{ getPrice(Cart::subtotal()) }}</strong></li>
                @if (request()->session()->has('coupon'))
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Coupon {{ request()->session()->get('coupon')['code'] }}</strong>
                    <form action="{{ route('cart.destroy.coupon') }}" class="d-inline-block" method="POST">
                    @csrf
                    @method("DELETE")

                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                    </form>
                    <strong>{{ getPrice(request()->session()->get('coupon')['remise']) }}</strong></li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Nouveau Sous Total</strong>

                        <strong>{{ getPrice(Cart::subtotal()-request()->session()->get('coupon')['remise']) }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong>
                        <strong>
                            {{ getPrice((Cart::subtotal()-request()->session()->get('coupon')['remise'])*(config('cart.tax')/100))  }}
                        </strong>

                    </li>
                    <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                        <h5 class="font-weight-bold">{{ getPrice((Cart::subtotal()-request()->session()->get('coupon')['remise'])*(config('cart.tax')/100)+(Cart::subtotal()-request()->session()->get('coupon')['remise']) )  }}</h5>
                      </li>
                    @else
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Tax</strong><strong>{{ getPrice(Cart::tax()) }}</strong></li>
                <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Total</strong>
                  <h5 class="font-weight-bold">{{ getPrice(Cart::total()) }}</h5>
                </li>
                @endif

              </ul><a href=" {{ route('checkout.index') }}" class="btn btn-dark rounded-pill py-2 btn-block">Procceed to checkout</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
    @else
    <div class="col-md-12">
        <h5>Votre panier est vide pour le moment.</h5>
        <p>Mais vous pouvez visiter la <a href="{{ route('products.index') }}">boutique</a> pour faire votre shopping.
        </p>
    </div>

    @endif


@endsection


@section('extra-js')
    <script>
           var selects =  document.querySelectorAll('#qty');
           Array.from(selects).forEach((element)=>{
                element.addEventListener('change',function(){
                    var rowId = this.getAttribute('data-id');
                    var stock = this.getAttribute('data-stock');
                    var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(
                        `panier/${rowId}`,
                        {
                            headers:{
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": token
                            },
                            method:'PATCH',
                            body:JSON.stringify({
                                qty:this.value,
                                stock:stock
                            }),
                        })
                        .then((data)=>{
                            console.log(data);
                            location.reload();
                        }).catch((error)=>{
                            console.log(error)
                        });
                });
           });


    </script>
@endsection

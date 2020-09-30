@extends('layouts.master')

@section('content')
@foreach ($products as $product)
<div class="col-md-6">
    <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
      <div class="col p-4 d-flex flex-column position-static">
        <strong class="d-inline-block mb-2 text-primary">Categorie 1</strong>
        <h5 class="mb-0">{{ $product->title }}</h5>
        <div class="mb-1 text-muted">{{ $product->created_at->format('d/m/Y') }}</div>
        <p class="card-text mb-auto">{{ $product->subtitle }}</p>
        <strong class="card-text mb-auto">{{ $product->getFrenchPrice() }}</strong>
        <a href="{{ route('products.show',$product->slug) }}" class="btn btn-info stretched-link">Voir l'article</a>
      </div>
      <div class="col-auto d-none d-lg-block">
        <img src="{{ $product->image }}" alt="{{ $product->title }}">
    </div>
    </div>
  </div>
@endforeach

@endsection

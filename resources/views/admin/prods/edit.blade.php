<x-dashboard-layout title="Edit Product">

    <form action="{{ route('admin.prods.update', $prod->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('admin.prods._form',[
            'button_lable' => 'Update'
            ])
    </form>
</x-dashboard-layout>
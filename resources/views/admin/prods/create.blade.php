<x-dashboard-layout title="Create New Product">

    <form action="{{ route('admin.prods.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('admin.prods._form',[
        'button_lable' => 'Add'
        ])

    </form>
</x-dashboard-layout>